<?php

namespace App\Console\Commands\UploadFile;

use Illuminate\Console\Command;
use App\Jobs\ProcessingFile\ProcessingFileJob;

class UploadFIleCommand extends Command
{
    public const RESULT_FILE_PATH = 'resultFilePath';

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'upload-file';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'File processing';

    public function __construct()
    {
        $this->signature = sprintf(
            "upload-file {%s}",
            self::RESULT_FILE_PATH
        );
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle(): void
    {
        ProcessingFileJob::dispatch(
            filePath: $this->argument(self::RESULT_FILE_PATH)
        )
            ->onQueue(ProcessingFileJob::QUEUE_NAME)
            ->onConnection('sync');
    }
}
