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
    $token = session('refresh_token');
    $response = Http::withToken($token)
        ->get('https://jwt-auth-eight-neon.vercel.app/getMakul');

    if ($response->successful()) {
        $data = $response->json();
        // Coba semua kemungkinan key
        return $data['data'] ?? $data['results'] ?? $data ?? [];
    }
    return [];
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
                    <a href="'.route('tutorials.edit', $row->id).'"
                        class="bg-yellow-500 hover:bg-yellow-600 text-white text-xs px-3 py-1 rounded">Edit</a>
                    <form method="POST" action="'.route('tutorials.destroy', $row->id).'" class="inline"
                        onsubmit="return confirm(\'Yakin hapus?\')">
                        '.csrf_field().'
                        '.method_field('DELETE').'
                        <button class="bg-red-500 hover:bg-red-600 text-white text-xs px-3 py-1 rounded">Hapus</button>
                    </form>
                    <a href="'.route('tutorial-details.index', $row->id).'"
                        class="bg-blue-500 hover:bg-blue-600 text-white text-xs px-3 py-1 rounded">Detail</a>
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
    $namaMatkul = '';
    foreach ($matkul as $m) {
        if ($m['kdmk'] == $request->kode_matkul) {
            $namaMatkul = $m['name'];
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