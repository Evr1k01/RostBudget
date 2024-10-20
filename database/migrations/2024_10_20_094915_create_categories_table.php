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
        Schema::create('categories', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('category_name', 256);
            $table->timestamps();
            $table->softDeletes();
        });

        if (Schema::hasTable('categories')) {
            DB::table('categories')->insert(array(
                array('id' => 'b15fe401-437c-4046-bc94-8fee16f402b3', 'category_name' => 'Продукты'),
                array('id' => '35f3d5b5-b749-4b0e-b2e3-8e9928332089', 'category_name' => 'Бытовая химия'),
                array('id' => 'fde6b785-d000-4fc2-a545-f0e07151ef70', 'category_name' => 'Развлечения'),
                array('id' => 'a44c1b92-4089-4cf6-a089-8eee1a928345', 'category_name' => 'Образование'),
                array('id' => 'b6f784c9-ca9b-446b-acb5-5d9807ea530c', 'category_name' => 'Техника'),
            ));
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('categories');
    }
};
