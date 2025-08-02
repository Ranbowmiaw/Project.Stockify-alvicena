<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('stock_opnames', function (Blueprint $table) {
        $table->unsignedBigInteger('stock_transaction_id')->nullable();
        $table->foreign('stock_transaction_id')->references('id')->on('stock_transactions')->onDelete('set null');
    });
    }

    public function down()
    {
        Schema::table('stock_opnames', function (Blueprint $table) {
            $table->dropForeign(['stock_transaction_id']);
            $table->dropColumn('stock_transaction_id');
        });
    }

};
