<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Models\Tutorial;
use Yajra\DataTables\Facades\DataTables;

class TutorialController extends Controller
{
    // Ambil data mata kuliah dari webservice
private function getMatkul()
{
    $fallback = [
        ['kdmk' => 'A11.64404', 'name' => 'Pemrograman Web Lanjut'],
        ['kdmk' => 'A11.54314', 'name' => 'Pemrograman Berorientasi Objek'],
        ['kdmk' => 'A11.54216', 'name' => 'Sistem Basis Data'],
    ];

    $token = session('refresh_token');
    if (!$token) return $fallback;

    $response = Http::withToken($token)
        ->get('https://jwt-auth-eight-neon.vercel.app/getMakul');

    if ($response->successful()) {
        $data = $response->json();
        // Kalau API return Forbidden atau tidak ada data, pakai fallback
        if (isset($data['msg']) || empty($data['data'])) return $fallback;
        return $data['data'] ?? $fallback;
    }

    return $fallback;
}

    public function index()
    {
        if (!session('refresh_token')) return redirect()->route('login');
        return view('tutorials.index');
    }

    public function getData()
    {
        $tutorials = Tutorial::select(['id','judul','kode_matkul','nama_matkul',
            'url_presentation','url_finished','creator_email','created_at','updated_at']);

        return DataTables::of($tutorials)
            ->addColumn('action', function ($row) {
    return '
        <div style="display:flex;gap:4px;align-items:center;">
            <a href="'.route('tutorials.edit', $row->id).'"
                style="background:#f59e0b;color:white;font-size:11px;padding:4px 10px;border-radius:6px;text-decoration:none;font-weight:600;">Edit</a>
            <form method="POST" action="'.route('tutorials.destroy', $row->id).'" style="margin:0"
                onsubmit="return confirm(\'Yakin hapus?\')">
                '.csrf_field().'
                '.method_field('DELETE').'
                <button style="background:#ef4444;color:white;font-size:11px;padding:4px 10px;border-radius:6px;border:none;cursor:pointer;font-weight:600;">Hapus</button>
            </form>
            <a href="'.route('tutorial-details.index', $row->id).'"
                style="background:#3b82f6;color:white;font-size:11px;padding:4px 10px;border-radius:6px;text-decoration:none;font-weight:600;">Detail</a>
        </div>
    ';
})
            ->rawColumns(['action'])
            ->make(true);
    }

    public function create()
    {
        if (!session('refresh_token')) return redirect()->route('login');
        $matkul = $this->getMatkul();
        return view('tutorials.create', compact('matkul'));
    }

    public function store(Request $request)
{
    $request->validate([
        'judul'       => 'required',
        'kode_matkul' => 'required',
    ]);

    $matkul = $this->getMatkul();
    $namaMatkul = 'Tidak Diketahui'; 
    
    foreach ($matkul as $m) {
        // Sesuaikan 'kode_matkul' dan 'nama_matkul' dengan key yang ada di hasil dd() kamu
        $kdmk_api = $m['kode_matkul'] ?? $m['kdmk'] ?? null;
        
        if ($kdmk_api == $request->kode_matkul) {
            $namaMatkul = $m['nama_matkul'] ?? 'Tidak Diketahui';
            break;
        }
    }

    // URL dibuat otomatis dari judul, tidak perlu diisi manual
    $slug = \Str::slug($request->judul) . '-' . time();
    $baseUrl = url('');

    Tutorial::create([
        'judul'            => $request->judul,
        'kode_matkul'      => $request->kode_matkul,
        'nama_matkul'      => $namaMatkul,
        'url_presentation' => $baseUrl . '/presentation/' . $slug,
        'url_finished'     => $baseUrl . '/finished/' . $slug,
        'creator_email'    => session('email'),
    ]);

    return redirect()->route('tutorials.index')->with('success', 'Tutorial berhasil ditambahkan!');
}

    public function edit($id)
    {
        if (!session('refresh_token')) return redirect()->route('login');
        $tutorial = Tutorial::findOrFail($id);
        $matkul   = $this->getMatkul();
        return view('tutorials.edit', compact('tutorial', 'matkul'));
    }

    public function update(Request $request, $id)
    {
        $tutorial = Tutorial::findOrFail($id);

        $request->validate([
            'judul'            => 'required',
            'kode_matkul'      => 'required',
            'url_presentation' => 'required|url|unique:tutorials,url_presentation,'.$id,
            'url_finished'     => 'required|url|unique:tutorials,url_finished,'.$id,
        ]);

        $matkul = $this->getMatkul();
        $namaMatkul = $tutorial->nama_matkul;
        foreach ($matkul as $m) {
            if ($m['kdmk'] == $request->kode_matkul) {
                $namaMatkul = $m['name'];
                break;
            }
        }

        $tutorial->update([
            'judul'            => $request->judul,
            'kode_matkul'      => $request->kode_matkul,
            'nama_matkul'      => $namaMatkul,
            'url_presentation' => $request->url_presentation,
            'url_finished'     => $request->url_finished,
        ]);

        return redirect()->route('tutorials.index')->with('success', 'Tutorial berhasil diupdate!');
    }

    public function destroy($id)
    {
        Tutorial::findOrFail($id)->delete();
        return redirect()->route('tutorials.index')->with('success', 'Tutorial berhasil dihapus!');
    }
}