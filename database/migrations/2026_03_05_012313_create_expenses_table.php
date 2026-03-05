<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('expenses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('category_id')->constrained()->onDelete('cascade'); // Kaitkan dengan table categories
            $table->string('title'); // Contoh: Nasi Lemak
            $table->decimal('amount', 10, 2); // Contoh: 10.50
            $table->text('description')->nullable(); // Nota tambahan (Web)
            $table->string('attachment')->nullable(); // Simpan nama fail resit
            $table->date('spent_at'); // Tarikh belanja
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('expenses');
    }
};
