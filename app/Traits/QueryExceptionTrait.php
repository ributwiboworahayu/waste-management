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
        return $units->isEmpty() ? "Unit belum tersedia, silahkan tambahkan unit terlebih dahulu. <a href='" . route('waste.units.create', array_merge(request()->query(), ['new' => 1])) .
            "' class='btn btn-sm btn-secondary'><i class='bi bi-plus'></i> Tambah Unit</a>" : null;
    }

    protected static function listEmpty($liquids): ?string
    {
        return $liquids->isEmpty() ? "Cairan belum tersedia, silahkan tambahkan limbah terlebih dahulu. <a href='" . route('waste.list.create', array_merge(request()->query(), ['new' => 1])) .
            "' class='btn btn-sm btn-secondary'><i class='bi bi-plus'></i> Tambah Limbah</a>" : null;
    }

    /**
     * @param $units
     * @param $liquids
     * @return string|null
     */
    protected static function unitOrLiquidEmpty($units, $liquids): ?string
    {
        return self::unitEmpty($units) !== null ? self::unitEmpty($units) : self::listEmpty($liquids);
    }
}
