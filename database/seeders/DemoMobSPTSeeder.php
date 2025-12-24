<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class DemoMobSPTSeeder extends Seeder
{
    public function run(): void
    {
        $driverId = DB::table('drivers')->value('id');
        $transportirId = DB::table('transportirs')->value('id');

        if (!$driverId || !$transportirId) {
            $this->command?->warn("Seed dibatalkan: pastikan tabel drivers & transportirs sudah punya data (minimal 1 row).");
            return;
        }

        // 1) Insert data ke mob_s_pts
        DB::table('mob_s_pts')->insert([
            [
                'spt_no' => 100001,
                'spt_date' => now()->subDays(2),
                'spt_expired_date' => now()->addDays(5),
                'sppb_no' => 'SPPB-2025-0001',
                'sppb_key' => 'KEY-0001',
                'cust_code' => 'CUST-001',
                'cust_name' => 'PT Contoh Abadi',
                'address_ship_to' => 'Jl. Raya Industri No. 1, Surabaya',
                'address_ship_from' => 'Gudang A, Sidoarjo',
                'transportir_code' => 'TRP-001',
                'transportir_name' => 'PT Angkut Jaya',
                'item_code' => 'ITEM-001',
                'item_name' => 'Semen 40kg',
                'qty_sppb' => '100',
                'vehicle_type' => 'TRUCK',
                'vehicle_no' => 'L 1234 AB',
                'driver_id' => $driverId,
                'phone' => '081234567890',
                'qty' => '80',
                'container_no' => 'CONT-001',
                'sj_no' => 200001,
                'weight_netto' => '8000',
                'weight_bruto' => '8200',
                'ktp_picture' => 'uploads/ktp/ktp_demo_1.jpg',
                'take_assignment_latitude' => '-7.257472',
                'take_assignment_longitude' => '112.752090',
                'take_assignment_by' => 'system',
                'take_assignment_date' => now()->subDays(1),
                'status' => true,
                'is_transit' => false,
                'reference_code' => 'REF-0001',
                'created_by' => 'seed',
                'modified_by' => null,
                'ship_from' => 'Sidoarjo',
                'transportir_id' => $transportirId,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'spt_no' => 100002,
                'spt_date' => now()->subDays(1),
                'spt_expired_date' => now()->addDays(7),
                'sppb_no' => 'SPPB-2025-0002',
                'sppb_key' => 'KEY-0002',
                'cust_code' => 'CUST-002',
                'cust_name' => 'CV Makmur Sentosa',
                'address_ship_to' => 'Jl. Perak Barat No. 10, Surabaya',
                'address_ship_from' => 'Gudang B, Gresik',
                'transportir_code' => 'TRP-001',
                'transportir_name' => 'PT Angkut Jaya',
                'item_code' => 'ITEM-002',
                'item_name' => 'Besi Batang',
                'qty_sppb' => '50',
                'vehicle_type' => 'TRONTON',
                'vehicle_no' => 'W 8899 CD',
                'driver_id' => $driverId,
                'phone' => '082233445566',
                'qty' => '50',
                'container_no' => 'CONT-002',
                'sj_no' => 200002,
                'weight_netto' => '12000',
                'weight_bruto' => '12300',
                'ktp_picture' => 'uploads/ktp/ktp_demo_2.jpg',
                'take_assignment_latitude' => '-7.275600',
                'take_assignment_longitude' => '112.725000',
                'take_assignment_by' => 'seed',
                'take_assignment_date' => now(),
                'status' => true,
                'is_transit' => true,
                'reference_code' => 'REF-0002',
                'created_by' => 'seed',
                'modified_by' => 'seed',
                'ship_from' => 'Gresik',
                'transportir_id' => $transportirId,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'spt_no' => 100003,
                'spt_date' => now()->subDays(5),
                'spt_expired_date' => now()->subDays(1),
                'sppb_no' => 'SPPB-2025-0003',
                'sppb_key' => 'KEY-0003',
                'cust_code' => 'CUST-003',
                'cust_name' => 'PT Sumber Rezeki',
                'address_ship_to' => 'Jl. Tidar No. 5, Malang',
                'address_ship_from' => 'Gudang C, Pasuruan',
                'transportir_code' => 'TRP-001',
                'transportir_name' => 'PT Angkut Jaya',
                'item_code' => 'ITEM-003',
                'item_name' => 'Pupuk',
                'qty_sppb' => '30',
                'vehicle_type' => 'PICKUP',
                'vehicle_no' => 'N 7788 EF',
                'driver_id' => $driverId,
                'phone' => '081355566677',
                'qty' => '30',
                'container_no' => null,
                'sj_no' => 200003,
                'weight_netto' => '3000',
                'weight_bruto' => '3100',
                'ktp_picture' => 'uploads/ktp/ktp_demo_3.jpg',
                'take_assignment_latitude' => null,
                'take_assignment_longitude' => null,
                'take_assignment_by' => null,
                'take_assignment_date' => null,
                'status' => false,
                'is_transit' => false,
                'reference_code' => 'REF-0003',
                'created_by' => 'seed',
                'modified_by' => null,
                'ship_from' => 'Pasuruan',
                'transportir_id' => $transportirId,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);

        // 2) Update users.transportir_id (ambil beberapa user pertama biar cepat)
        $userIds = DB::table('users')->orderBy('id')->limit(3)->pluck('id')->toArray();

        if (!empty($userIds)) {
            DB::table('users')
                ->whereIn('id', $userIds)
                ->update([
                    'transportir_id' => $transportirId,
                    'updated_at' => now(),
                ]);
        }

        $this->command?->info("Seed selesai: mob_s_pts diinsert, users.transportir_id di-set untuk user IDs: " . implode(', ', $userIds));
    }
}
