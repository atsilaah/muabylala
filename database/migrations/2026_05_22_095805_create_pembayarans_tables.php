<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('pembayarans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('booking_id')->constrained()->onDelete('cascade');
            $table->enum('metode', ['BRI','BNI','Mandiri','BCA','Bank Jatim','GoPay','OVO','DANA']);
            $table->string('bukti_foto')->nullable();
            $table->enum('status', ['pending','confirmed'])->default('pending');
            $table->timestamp('confirmed_at')->nullable();
            $table->timestamps();
        });
    }
    public function down(): void { Schema::dropIfExists('pembayaran'); }
};
