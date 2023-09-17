<?php

namespace App\Services\UploadFile;

use App\Models\UploadFile;
use App\Helpers\ArrayHelper;
use Illuminate\Support\Collection;
use App\DTO\UploadFile\UploadFileItem;

class UploadFileService
{
    /**
     * @param UploadFileItem $uploadFileItem
     *
     * @return array
     */
    private function formDataArray(UploadFileItem $uploadFileItem): array
    {
        return ArrayHelper::filterEmpty([
            UploadFile::COLUMN_ID_FILE => $uploadFileItem->getIdFile(),
            UploadFile::COLUMN_PURCHASE_DATE => $uploadFileItem->getPurchaseDate(),
            UploadFile::COLUMN_SHIP_TO_NAME => $uploadFileItem->getShipToName(),
            UploadFile::COLUMN_CUSTOMER_EMAIL => $uploadFileItem->getCustomerEmail(),
            UploadFile::COLUMN_GRANT_TOTAL_PURCHASED => $uploadFileItem->getGrantTotal(),
            UploadFile::COLUMN_STATUS => $uploadFileItem->getStatus(),
            UploadFile::CREATED_AT => $uploadFileItem->getCreatedAt(),
            UploadFile::UPDATED_AT => $uploadFileItem->getUpdatedAt()
        ]);
    }

    /**
     * @param Collection $collection
     *
     * @return int
     */
    public function updateMultiple(Collection $collection)
    {
        $updatesArray = [];
        /** @var UploadFileItem $item */
        foreach ($collection as $item) {
            $updatesArray[] = array_merge(
                [UploadFile::COLUMN_ID_FILE => $item->getIdFile()],
                $this->formDataArray($item)
            );

        }

        return UploadFile::query()->upsert(
            $updatesArray,
            UploadFile::COLUMN_ID_FILE,
            [
                UploadFile::COLUMN_PURCHASE_DATE,
                UploadFile::COLUMN_SHIP_TO_NAME,
                UploadFile::COLUMN_CUSTOMER_EMAIL,
                UploadFile::COLUMN_GRANT_TOTAL_PURCHASED,
                UploadFile::COLUMN_STATUS,
            ]
        );
    }
}
