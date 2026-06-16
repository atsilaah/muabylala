<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Customer;

class CustomerSeeder extends Seeder
{
    public function run(): void
    {
        $customers = [
            ['nama'=>'Bela Safitri','email'=>'bela@example.com','no_hp'=>'081234567002','jenis_makeup'=>'Graduation','harga'=>200000,'tanggal_booking'=>'2026-05-11','aktif'=>true,'foto'=>null],
            ['nama'=>'Citra Dewi','email'=>'citra@example.com','no_hp'=>'081234567003','jenis_makeup'=>'Party','harga'=>300000,'tanggal_booking'=>'2026-05-12','aktif'=>true,'foto'=>null],
            ['nama'=>'Dina Marlina','email'=>'dina@example.com','no_hp'=>'081234567004','jenis_makeup'=>'Engagement','harga'=>400000,'tanggal_booking'=>'2026-05-13','aktif'=>true,'foto'=>null],
            ['nama'=>'Eka Putri','email'=>'eka@example.com','no_hp'=>'081234567005','jenis_makeup'=>'Daily','harga'=>150000,'tanggal_booking'=>'2026-05-14','aktif'=>false,'foto'=>null],
            ['nama'=>'Fitri Handayani','email'=>'fitri@example.com','no_hp'=>'081234567006','jenis_makeup'=>'Wedding','harga'=>500000,'tanggal_booking'=>'2026-05-15','aktif'=>true,'foto'=>null],
            ['nama'=>'Gita Maharani','email'=>'gita@example.com','no_hp'=>'081234567007','jenis_makeup'=>'Graduation','harga'=>200000,'tanggal_booking'=>'2026-05-16','aktif'=>true,'foto'=>null],
            ['nama'=>'Hana Pertiwi','email'=>'hana@example.com','no_hp'=>'081234567008','jenis_makeup'=>'Party','harga'=>300000,'tanggal_booking'=>'2026-05-17','aktif'=>false,'foto'=>null],
            ['nama'=>'Indah Sari','email'=>'indah@example.com','no_hp'=>'081234567009','jenis_makeup'=>'Engagement','harga'=>400000,'tanggal_booking'=>'2026-05-18','aktif'=>true,'foto'=>null],
            ['nama'=>'Julia Wati','email'=>'julia@example.com','no_hp'=>'081234567010','jenis_makeup'=>'Wedding','harga'=>500000,'tanggal_booking'=>'2026-05-19','aktif'=>true,'foto'=>null],
        ];

        foreach ($customers as $data) {
            Customer::create($data);
        }
    }
}

