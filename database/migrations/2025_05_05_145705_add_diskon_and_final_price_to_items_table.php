<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {

    public function up()
    {
        Schema::table('items', function (Blueprint $table) {
            $table->integer('diskon')->default(0);
            $table->decimal('final_price', 8, 2)->default(0);
        });
    }


    public function down(): void
    {
        Schema::table('items', function (Blueprint $table) {

        });
    }
};
