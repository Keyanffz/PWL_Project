<?php
namespace App\Http\Controllers;

use App\Models\Tutorial;
use App\Models\TutorialDetail;
use Illuminate\Support\Facades\Storage;
use Barryvdh\DomPDF\Facade\Pdf;

class PublicController extends Controller
{
    public function presentation($slug)
    {
        // Cari tutorial berdasarkan url_presentation yang mengandung slug
        $tutorial = Tutorial::where('url_presentation', 'like', '%'.$slug)->firstOrFail();

        // Hanya tampilkan detail yang statusnya show
        $details = TutorialDetail::where('tutorial_id', $tutorial->id)
            ->where('status', 'show')
            ->orderBy('order')
            ->get();

        return view('public.presentation', compact('tutorial', 'details'));
    }

    public function finished($slug)
    {
        // Cari tutorial berdasarkan url_finished yang mengandung slug
        $tutorial = Tutorial::where('url_finished', 'like', '%'.$slug)->firstOrFail();

        // Tampilkan SEMUA detail (show & hide) untuk PDF
        $details = TutorialDetail::where('tutorial_id', $tutorial->id)
            ->orderBy('order')
            ->get();

        $pdf = Pdf::loadView('public.finished-pdf', compact('tutorial', 'details'));
        return $pdf->download($tutorial->judul . '.pdf');
    }
}