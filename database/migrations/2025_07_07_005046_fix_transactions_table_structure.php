<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('transactions', function (Blueprint $table) {
            // Hapus kolom product_name jika ada
            if (Schema::hasColumn('transactions', 'product_name')) {
                $table->dropColumn('product_name');
            }

            // Pastikan product_id ada dan tidak nullable
            if (!Schema::hasColumn('transactions', 'product_id')) {
                $table->foreignId('product_id')->constrained()->onDelete('cascade');
            }
        });
    }

    public function down()
    {
        Schema::table('transactions', function (Blueprint $table) {
            // Untuk rollback, kembalikan kolom product_name jika perlu
            $table->string('product_name')->nullable();
        });
    }
};
