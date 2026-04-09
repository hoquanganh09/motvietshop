<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->decimal('sale_price', 15, 0)->nullable()->after('old_price');
            $table->timestamp('sale_start')->nullable()->after('sale_price');
            $table->timestamp('sale_end')->nullable()->after('sale_start');
        });
    }

    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn(['sale_price', 'sale_start', 'sale_end']);
        });
    }
};
