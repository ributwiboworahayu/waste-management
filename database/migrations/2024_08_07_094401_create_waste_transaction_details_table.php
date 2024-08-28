<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWasteTransactionDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('waste_transaction_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('unit_id')->constrained('units');
            $table->foreignId('unit_conversion_id')->nullable()->constrained('unit_conversions')->nullOnDelete();
            $table->foreignId('liquid_waste_id')->constrained('liquid_wastes');
            $table->float('quantity', 16, 8);
            $table->float('conversion_value', 16, 8);
            $table->string('photo');
            $table->string('document')->nullable();
            $table->string('shipper_name');
            $table->string('input_by');
            $table->timestamp('input_at');
            $table->text('description')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('waste_transaction_details');
    }
}
