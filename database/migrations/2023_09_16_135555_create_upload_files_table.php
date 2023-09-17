<?php

use App\Models\UploadFile;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Enums\UploadFile\UploadFileStatusEnum;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create(UploadFile::TABLE_NAME, function (Blueprint $table) {
            $table->id();
            $table->string(UploadFile::COLUMN_ID_FILE)->unique();
            $table->string(UploadFile::COLUMN_PURCHASE_DATE);
            $table->string(UploadFile::COLUMN_SHIP_TO_NAME);
            $table->string(UploadFile::COLUMN_CUSTOMER_EMAIL);
            $table->float(UploadFile::COLUMN_GRANT_TOTAL_PURCHASED, 8, 4);
            $table->enum(UploadFile::COLUMN_STATUS, array_column(UploadFileStatusEnum::cases(), 'value'));
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists(UploadFile::TABLE_NAME);
    }
};
