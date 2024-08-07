<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWasteTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('waste_transactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('liquid_waste_id')->constrained('liquid_wastes');
            $table->float('quantity', 16, 8);
            $table->foreignId('unit_id')->constrained('units');
            $table->string('description')->nullable();
            $table->enum('type', ['in', 'out'])->comment('in for input, out for output');
            $table->string('photo_path');
            $table->string('document_path')->nullable();
            $table->string('input_by');
            $table->unsignedBigInteger('approved_by')->nullable();
            $table->timestamp('approved_at')->nullable();
            $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending');
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
        Schema::dropIfExists('waste_transactions');
    }
}
