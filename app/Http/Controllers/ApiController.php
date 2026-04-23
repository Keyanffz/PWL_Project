<?php

namespace App\Http\Controllers;

use App\Models\Tutorial;
use Illuminate\Support\Facades\Http;

class ApiController extends Controller
{
    public function tutorialByMatkul($kode_matkul)
    {
        // 1. Ambil data dari database lokal (TANPA 'nama_matkul')
        $tutorials = Tutorial::where('kode_matkul', $kode_matkul)
            ->select([
                'kode_matkul', 'judul',
                'url_presentation', 'url_finished',
                'creator_email', 'created_at', 'updated_at'
            ])
            ->get();

        if ($tutorials->isEmpty()) {
            return response()->json([
                'results' => [],
                'status'  => ['code' => 404, 'description' => 'Not Found data ' . $kode_matkul]
            ], 404);
        }

        // 2. Ambil data dari webservice (Pastikan otorisasi tokennya sudah benar jika webservice memintanya)
        // Jika endpoint tidak butuh token, hapus "withToken(...)->"
        $apiResponse = Http::withToken('ACCESS_TOKEN_YANG_VALID')
            ->get('https://jwt-auth-eight-neon.vercel.app/getMakul');

        $namaMatkul = "Tidak Diketahui"; // Nilai default (fallback)

        if ($apiResponse->successful()) {
            $makulData = $apiResponse->json();
            
            // Asumsi webservice mengembalikan array of object/array
            // Lakukan perulangan untuk mencari nama mata kuliah yang kodenya cocok
            foreach ($makulData as $makul) {
                if ($makul['kode_matkul'] === $kode_matkul) {
                    $namaMatkul = $makul['nama_matkul'];
                    break;
                }
            }
        }

        // 3. Sisipkan 'nama_matkul' ke dalam setiap item tutorial yang akan di-return
        $tutorials->transform(function ($item) use ($namaMatkul) {
            $item->nama_matkul = $namaMatkul;
            return $item;
        });

        return response()->json([
            'results' => $tutorials,
            'status'  => ['code' => 200, 'description' => 'OK']
        ]);
    }
}