<?php

namespace App\Traits;

use Illuminate\Database\QueryException;

trait QueryExceptionTrait
{

    /**
     * @param $e
     * @return array
     */
    protected static function alreadyExists($e): array
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

    /**
     * @param $units
     * @return string|null
     */
    protected static function unitEmpty($units): ?string
    {
        return $units->isEmpty() ? "Unit belum tersedia, silahkan tambahkan unit terlebih dahulu. <a href='" . route('waste.units.create') . "' class='btn btn-sm btn-secondary'><i class='bi bi-plus'></i> Tambah Unit</a>" : null;
    }

    protected static function liquidEmpty($liquids): ?string
    {
        return $liquids->isEmpty() ? "Cairan belum tersedia, silahkan tambahkan cairan terlebih dahulu. <a href='" . route('waste.liquid.create') . "' class='btn btn-sm btn-secondary'><i class='bi bi-plus'></i> Tambah Cairan</a>" : null;
    }

    /**
     * @param $units
     * @param $liquids
     * @return string|null
     */
    protected static function unitOrLiquidEmpty($units, $liquids): ?string
    {
        return self::unitEmpty($units) !== null ? self::unitEmpty($units) : self::liquidEmpty($liquids);
    }
}
