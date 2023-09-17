<?php

namespace App\Jobs\ProcessingFile;

use SimpleXMLElement;
use App\Helpers\DateHelper;
use Illuminate\Bus\Queueable;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;
use Illuminate\Queue\SerializesModels;
use App\DTO\UploadFile\UploadFileItem;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use App\Services\UploadFile\UploadFileService;
use App\Helpers\ProcessingFile\ProcessingFileIndexHelper;

class ProcessingFileJob implements ShouldQueue
{
    use Queueable;
    use Dispatchable;
    use SerializesModels;
    use InteractsWithQueue;

    public const QUEUE_NAME = 'uploadFile';
    private const ID = 'id',
        PURCHASE_DATE = 'purchase date',
        SHIP_TO_NAME = 'ship-to name',
        CUSTOMER_EMAIL = 'customer email',
        GRANT_TOTAL = 'grant total (purchased)',
        STATUS = 'status';

    /**
     * Create a new job instance.
     *
     * @param string $filePath
     */
    public function __construct(private string $filePath)
    {
        $this->onQueue(self::QUEUE_NAME);
    }

    /**
     * @throws \Exception
     */
    public function handle(UploadFileService $uploadFileService)
    {
        $fileFormat = pathinfo($this->filePath, PATHINFO_EXTENSION);
        if ($fileFormat === 'csv') {
            $collection = $this->processCsvFile();
        } elseif ($fileFormat === 'xml') {
            $collection = $this->processXmlFile();
        } else {
            Log::info('Unsupported file format', ['file_path' => $this->filePath]);
        }

        if ($collection->isNotEmpty()) {
            $uploadFileService->updateMultiple($collection);
            unlink($this->filePath);
        }
    }


    private function processCsvFile(): Collection
    {
        $collection = collect();
        if (($file = fopen($this->filePath, 'r')) !== false) {
            $header = array_map('trim', fgetcsv($file));
            if ($this->checkIndex($header)) {
                while (($data = fgetcsv($file)) !== false) {
                    $rowData = array_combine($header, $data);
                    $cleanedRowData = array_map('trim', $rowData);
                    $item = new UploadFileItem(
                        idFile: $cleanedRowData[self::ID],
                        purchaseDate: $cleanedRowData[self::PURCHASE_DATE],
                        shipToName: $cleanedRowData[self::SHIP_TO_NAME],
                        customerEmail: $cleanedRowData[self::CUSTOMER_EMAIL],
                        grantTotal: $cleanedRowData[self::GRANT_TOTAL],
                        status: $cleanedRowData[self::STATUS],
                        createdAt  : DateHelper::mysqlTimestampNow(),
                        updatedAt  : DateHelper::mysqlTimestampNow()
                    );
                    $collection->push($item);
                }
            }

            fclose($file);
        }

        return $collection;
    }

    /**
     * @throws \Exception
     */
    private function processXmlFile(): Collection
    {
        $collection = collect();
        $xmlContent = file_get_contents($this->filePath);
        $xml = new SimpleXMLElement($xmlContent);
        $header = [];
        foreach ($xml->Worksheet->Table->Row[0]->Cell as $cell) {
            $header[] = trim((string) $cell->Data);
        }

        if ($this->checkIndex($header)) {
            for ($i = 1; $i < count($xml->Worksheet->Table->Row); $i++) {
                $row = $xml->Worksheet->Table->Row[$i];
                $rowData = [];

                foreach ($row->Cell as $cell) {
                    $rowData[] = trim((string) $cell->Data);
                }

                $rowAssoc = array_combine($header, $rowData);
                $item = new UploadFileItem(
                    idFile: $rowAssoc[self::ID],
                    purchaseDate: $rowAssoc[self::PURCHASE_DATE],
                    shipToName: $rowAssoc[self::SHIP_TO_NAME],
                    customerEmail: $rowAssoc[self::CUSTOMER_EMAIL],
                    grantTotal: $rowAssoc[self::GRANT_TOTAL],
                    status: $rowAssoc[self::STATUS],
                    createdAt  : DateHelper::mysqlTimestampNow(),
                    updatedAt  : DateHelper::mysqlTimestampNow()
                );
                $collection->push($item);
            }
        }

        return $collection;
    }

    private function checkIndex(array $header): bool
    {
        $uploadFileIndex = ProcessingFileIndexHelper::processingFileIndex(
            indexFile: $header,
            indexId: self::ID,
            indexOne: self::PURCHASE_DATE,
            indexTwo: self::GRANT_TOTAL,
            indexThree: self::CUSTOMER_EMAIL,
            indexFour: self::SHIP_TO_NAME,
            indexFive: self::STATUS
        );

        if (!$uploadFileIndex) {
            Log::info('There is not enough data to process the file', ['file_path' => $this->filePath]);

            return false;
        }

        return true;
    }


}
