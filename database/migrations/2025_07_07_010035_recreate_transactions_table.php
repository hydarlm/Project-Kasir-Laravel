<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up()
    {
        // Untuk SQLite, kita perlu pendekatan khusus
        if (DB::getDriverName() === 'sqlite') {
            DB::statement('PRAGMA foreign_keys=off;');

            // Buat tabel baru dengan struktur yang benar
            Schema::create('new_transactions', function (Blueprint $table) {
                $table->id();
                $table->string('transaction_id')->unique();
                $table->foreignId('product_id')->constrained()->onDelete('cascade');
                $table->date('date');
                $table->integer('quantity');
                $table->decimal('price', 12, 2);
                $table->timestamps();
            });

            // Pindahkan data jika ada
            DB::statement('
                INSERT INTO new_transactions (id, transaction_id, date, quantity, price, created_at, updated_at, product_id)
                SELECT id, transaction_id, date, quantity, price, created_at, updated_at, NULL FROM transactions
            ');

            // Hapus tabel lama dan rename yang baru
            Schema::dropIfExists('transactions');
            Schema::rename('new_transactions', 'transactions');

            DB::statement('PRAGMA foreign_keys=on;');
        } else {
            // Untuk database selain SQLite
            Schema::table('transactions', function (Blueprint $table) {
                $table->dropColumn(['product_name', 'category']);
                $table->foreignId('product_id')->constrained()->onDelete('cascade');
            });
        }
    }

    public function down()
    {
        // Untuk rollback, buat kembali struktur lama
        if (DB::getDriverName() === 'sqlite') {
            DB::statement('PRAGMA foreign_keys=off;');

            Schema::create('old_transactions', function (Blueprint $table) {
                $table->id();
                $table->string('transaction_id')->unique();
                $table->date('date');
                $table->string('product_name');
                $table->string('category');
                $table->integer('quantity');
                $table->decimal('price', 12, 2);
                $table->timestamps();
            });

            DB::statement('
                INSERT INTO old_transactions (id, transaction_id, date, product_name, category, quantity, price, created_at, updated_at)
                SELECT id, transaction_id, date,
                       (SELECT name FROM products WHERE products.id = transactions.product_id) as product_name,
                       (SELECT categories.name FROM products JOIN categories ON products.category_id = categories.id WHERE products.id = transactions.product_id) as category,
                       quantity, price, created_at, updated_at
                FROM transactions
            ');

            Schema::dropIfExists('transactions');
            Schema::rename('old_transactions', 'transactions');

            DB::statement('PRAGMA foreign_keys=on;');
        } else {
            Schema::table('transactions', function (Blueprint $table) {
                $table->dropForeign(['product_id']);
                $table->dropColumn('product_id');
                $table->string('product_name');
                $table->string('category');
            });
        }
    }
};
