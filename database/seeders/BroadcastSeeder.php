<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Broadcast;

class BroadcastSeeder extends Seeder
{
    public function run(): void
    {
        $user = User::first(); 
        if (!$user) return; 

        Broadcast::create([
            'user_id' => $user->id,
            'title' => 'Flash Sale 5.5 Ekosistem Partlyfe!',
            'message' => 'Nikmati diskon hingga 50% untuk semua oli mesin dan kampas rem khusus hari ini. Jangan sampai kehabisan, klaim vouchermu sekarang!',
            'type' => 'promo',
            'is_read' => false
        ]);

        Broadcast::create([
            'user_id' => $user->id,
            'title' => 'Pembaruan Sistem AI Chatbot & Prediksi Stok',
            'message' => 'Mekanik AI kami kini lebih pintar! Model terbaru ARIMA telah diintegrasikan untuk prediksi stok yang lebih akurat.',
            'type' => 'system',
            'is_read' => true
        ]);

        Broadcast::create([
            'user_id' => $user->id,
            'title' => 'Jadwal Pengiriman Libur Nasional',
            'message' => 'Harap diperhatikan bahwa seluruh operasi gudang akan diliburkan pada tanggal merah minggu depan.',
            'type' => 'info',
            'is_read' => false
        ]);
    }
}