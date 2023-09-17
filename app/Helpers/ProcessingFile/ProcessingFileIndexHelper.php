<?php

namespace App\Helpers\ProcessingFile;

/**
 * Хелпер для проверки индекса
 */
class ProcessingFileIndexHelper
{
    /**
     * @param array $indexFile
     * @param string $indexId
     * @param string $indexOne
     * @param string $indexTwo
     * @param string $indexThree
     * @param string $indexFour
     * @param string $indexFive
     *
     * @return bool
     */
    public static function processingFileIndex(
        array $indexFile,
        string $indexId,
        string $indexOne,
        string $indexTwo,
        string $indexThree,
        string $indexFour,
        string $indexFive
    ): bool {
        $arrayIdIndex = in_array($indexId, $indexFile, true);
        $arrayPurchaseDateIndex = in_array($indexOne, $indexFile, true);
        $arrayShipToNameIndex = in_array($indexTwo, $indexFile, true);
        $arrayCustomerEmailIndex = in_array($indexThree, $indexFile, true);
        $arrayGrantTotalIndex = in_array($indexFour, $indexFile, true);
        $arrayStatusIndex = in_array($indexFive, $indexFile, true);

        if ($arrayIdIndex === false ||
            $arrayPurchaseDateIndex === false ||
            $arrayShipToNameIndex === false ||
            $arrayCustomerEmailIndex === false ||
            $arrayGrantTotalIndex === false ||
            $arrayStatusIndex === false
        ) {
            return false;
        }

        return true;
    }
}
