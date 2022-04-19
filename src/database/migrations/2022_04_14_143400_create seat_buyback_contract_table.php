<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSeatBuybackContractTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('buyback_contracts', function (Blueprint $table) {
            $table->string('contractId')->primary();
            $table->string('contractIssuer');
            $table->text('contractData');
            $table->tinyInteger('contractStatus')->default(0);
            $table->timestamps();

            $table->index(['contractId']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('buyback_contracts');
    }
}
