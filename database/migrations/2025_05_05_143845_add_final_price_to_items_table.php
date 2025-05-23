<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('items', function (Blueprint $table) {
            $table->decimal('final_price', 8, 2)->after('price');
            $table->integer('diskon')->default(0)->after('stock');
        });
    }

    public function down(): void
    {
        Schema::table('items', function (Blueprint $table) {
            $table->dropColumn(['final_price', 'diskon']);
        });
    }

};
