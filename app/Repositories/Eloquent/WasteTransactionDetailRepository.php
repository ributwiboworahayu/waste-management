<?php

namespace App\Repositories\Eloquent;

use App\Models\WasteTransactionDetail;
use App\Repositories\Interfaces\WasteTransactionDetailRepositoryInterface;
use LaravelEasyRepository\Implementations\Eloquent;

class WasteTransactionDetailRepository extends Eloquent implements WasteTransactionDetailRepositoryInterface
{

    /**
     * Model class to be used in this repository for the common methods inside Eloquent
     * Don't remove or change $this->model variable name
     * @property Model|mixed $model;
     */
    protected WasteTransactionDetail $model;

    public function __construct(WasteTransactionDetail $model)
    {
        $this->model = $model;
    }

    public function store(array $data)
    {
        return $this->model->create([
            'unit_id' => $data['unit_id'],
            'unit_conversion_id' => $data['unit_conversion_id'],
            'liquid_waste_id' => $data['liquid_waste_id'],
            'quantity' => $data['quantity'],
            'conversion_value' => $data['conversion_value'],
            'photo' => $data['photo'],
            'document' => $data['document'],
            'shipper_name' => $data['shipper_name'],
            'input_by' => $data['input_by'],
            'input_at' => $data['input_at'],
            'description' => $data['description'],
        ]);
    }
}
