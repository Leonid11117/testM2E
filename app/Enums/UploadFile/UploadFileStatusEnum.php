<?php

namespace App\Enums\UploadFile;

enum UploadFileStatusEnum: string
{
    case NEW = 'new';
    case PROCESSING = 'processing';
    case COMPLETED = 'completed';
}
