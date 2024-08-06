<?php

namespace App\Traits;

use Illuminate\Database\QueryException;

trait QueryExceptionTrait
{

    /**
     * @param $e
     * @return array
     */
    protected function alreadyExists($e): array
    {
        if ($e instanceof QueryException) {
            if (str_contains($e->getMessage(), 'already exists')) {
                $errorString = $e->getMessage();
                $startPos = strpos($errorString, 'values (') + strlen('values (');
                $endPos = strpos($errorString, ',', $startPos); // Get the position of the first comma

                $name = '';
                if ($endPos !== false) {
                    // Mengambil substring
                    $name = substr($errorString, $startPos, $endPos - $startPos);
                }

                return ['status' => false, 'message' => "item $name sudah ada."];
            }
        }
        return ['status' => false, 'message' => ($e->getMessage() ?? 'Terjadi kesalahan')];
    }
}
