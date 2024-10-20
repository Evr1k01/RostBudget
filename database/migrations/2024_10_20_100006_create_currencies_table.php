<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('currencies', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('currency_code');
            $table->timestamps();
            $table->softDeletes();
        });

        if (Schema::hasTable('currencies')) {
            DB::table('currencies')->insert(array(
                array('id' => 'e319aab9-e446-408b-8713-06b35d6c1942', 'currency_code' => 'USD'),
                array('id' => 'a8e00538-f6f8-44a4-8300-8174794d01dd', 'currency_code' => 'RUB'),
                array('id' => 'bc97371a-1a39-4dc0-ac0b-466e648f9816', 'currency_code' => 'EUR'),
            ));
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('currencies');
    }
};
