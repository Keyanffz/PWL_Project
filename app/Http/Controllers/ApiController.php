<?php

namespace App\Http\Controllers;

use App\Models\Tutorial;

class ApiController extends Controller
{
    public function tutorialByMatkul($kode_matkul)
    {
        $tutorials = Tutorial::where('kode_matkul', $kode_matkul)
            ->select([
                'kode_matkul', 'nama_matkul', 'judul',
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

        return response()->json([
            'results' => $tutorials,
            'status'  => ['code' => 200, 'description' => 'OK']
        ]);
    }
}