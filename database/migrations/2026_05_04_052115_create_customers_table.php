<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('customers', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->string('email')->unique();
            $table->string('no_hp');
            $table->enum('jenis_makeup', [
                'Graduation',
                'Wedding',
                'Party',
                'Engagement',
                'Daily',
            ]);
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->decimal('harga', 10, 2)->default(0);
            $table->date('tanggal_booking');
            $table->boolean('aktif')->default(true);
            $table->string('foto')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('customers');
    }
};


