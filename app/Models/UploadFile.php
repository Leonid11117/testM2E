<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property string $id_file
 * @property string $purchase_date
 * @property string $ship_to_name
 * @property string $customer_email
 * @property int $grant_total_purchased
 * @property string $status
 */
class UploadFile extends Model
{
    use HasFactory;

    public const TABLE_NAME = 'upload_files',
        COLUMN_ID = 'id',
        COLUMN_ID_FILE = 'id_file',
        COLUMN_PURCHASE_DATE = 'purchase_date',
        COLUMN_SHIP_TO_NAME = 'ship_to_name',
        COLUMN_CUSTOMER_EMAIL = 'customer_email',
        COLUMN_GRANT_TOTAL_PURCHASED = 'grant_total_purchased',
        COLUMN_STATUS = 'status';

    protected $table = self::TABLE_NAME;
    protected $fillable = [
        self::COLUMN_ID_FILE,
        self::COLUMN_PURCHASE_DATE,
        self::COLUMN_SHIP_TO_NAME,
        self::COLUMN_CUSTOMER_EMAIL,
        self::COLUMN_GRANT_TOTAL_PURCHASED,
        self::COLUMN_STATUS
    ];
}
