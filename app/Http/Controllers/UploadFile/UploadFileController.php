<?php

namespace App\Http\Controllers\UploadFile;

use App\Models\UploadFile;
use Illuminate\Http\Request;

class UploadFileController
{
    public function index(Request $request)
    {
        $limit = $request->input('limit', 10);
        $page = $request->input('page', 1);

        $shipToName = $request->input(UploadFile::COLUMN_SHIP_TO_NAME);
        $customerEmail = $request->input(UploadFile::COLUMN_CUSTOMER_EMAIL);
        $status = $request->input(UploadFIle::COLUMN_STATUS);

        $query = UploadFile::query();
        if ($shipToName) {
            $query->where(UploadFile::COLUMN_SHIP_TO_NAME, 'LIKE', "%$shipToName%");
        }

        if ($customerEmail) {
            $query->where(UploadFile::COLUMN_CUSTOMER_EMAIL, 'LIKE', "%$customerEmail%");
        }

        if ($status) {
            $query->where(UploadFIle::COLUMN_STATUS, $status);
        }

        $data = $query->paginate($limit, ['*'], 'page', $page);
        return response()->json($data);
    }
}
