<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tutorial;
use App\Models\TutorialDetail;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Storage;

class TutorialDetailController extends Controller
{
    public function index($tutorialId)
    {
        if (!session('refresh_token')) return redirect()->route('login');
        $tutorial = Tutorial::findOrFail($tutorialId);
        return view('tutorial-details.index', compact('tutorial'));
    }

    public function getData($tutorialId)
    {
        $details = TutorialDetail::where('tutorial_id', $tutorialId)
            ->select(['id','tutorial_id','text','gambar','code','url','order','status','created_at','updated_at']);

        return DataTables::of($details)
            ->addColumn('gambar_preview', function ($row) {
                if ($row->gambar) {
                    return '<img src="'.asset('storage/'.$row->gambar).'" class="h-12 rounded">';
                }
                return '-';
            })
            ->addColumn('action', function ($row) {
                return '
                    <a href="'.route('tutorial-details.edit', [$row->tutorial_id, $row->id]).'"
                        class="bg-yellow-500 hover:bg-yellow-600 text-white text-xs px-3 py-1 rounded">Edit</a>
                    <form method="POST" action="'.route('tutorial-details.destroy', [$row->tutorial_id, $row->id]).'"
                        class="inline" onsubmit="return confirm(\'Yakin hapus?\')">
                        '.csrf_field().'
                        '.method_field('DELETE').'
                        <button class="bg-red-500 hover:bg-red-600 text-white text-xs px-3 py-1 rounded">Hapus</button>
                    </form>
                ';
            })
            ->rawColumns(['gambar_preview', 'action'])
            ->make(true);
    }

    public function create($tutorialId)
    {
        if (!session('refresh_token')) return redirect()->route('login');
        $tutorial = Tutorial::findOrFail($tutorialId);
        return view('tutorial-details.create', compact('tutorial'));
    }

    public function store(Request $request, $tutorialId)
    {
        $request->validate([
            'order'  => 'required|integer',
            'status' => 'required|in:show,hide',
            'gambar' => 'nullable|image|max:2048',
        ]);

        $gambarPath = null;
        if ($request->hasFile('gambar')) {
            $gambarPath = $request->file('gambar')->store('tutorial-images', 'public');
        }

        TutorialDetail::create([
            'tutorial_id' => $tutorialId,
            'text'        => $request->text,
            'gambar'      => $gambarPath,
            'code'        => $request->code,
            'url'         => $request->url,
            'order'       => $request->order,
            'status'      => $request->status,
        ]);

        return redirect()->route('tutorial-details.index', $tutorialId)
            ->with('success', 'Detail berhasil ditambahkan!');
    }

    public function edit($tutorialId, $id)
    {
        if (!session('refresh_token')) return redirect()->route('login');
        $tutorial = Tutorial::findOrFail($tutorialId);
        $detail   = TutorialDetail::findOrFail($id);
        return view('tutorial-details.edit', compact('tutorial', 'detail'));
    }

    public function update(Request $request, $tutorialId, $id)
    {
        $detail = TutorialDetail::findOrFail($id);

        $request->validate([
            'order'  => 'required|integer',
            'status' => 'required|in:show,hide',
            'gambar' => 'nullable|image|max:2048',
        ]);

        $gambarPath = $detail->gambar;
        if ($request->hasFile('gambar')) {
            if ($gambarPath) Storage::disk('public')->delete($gambarPath);
            $gambarPath = $request->file('gambar')->store('tutorial-images', 'public');
        }

        $detail->update([
            'text'   => $request->text,
            'gambar' => $gambarPath,
            'code'   => $request->code,
            'url'    => $request->url,
            'order'  => $request->order,
            'status' => $request->status,
        ]);

        return redirect()->route('tutorial-details.index', $tutorialId)
            ->with('success', 'Detail berhasil diupdate!');
    }

    public function destroy($tutorialId, $id)
    {
        $detail = TutorialDetail::findOrFail($id);
        if ($detail->gambar) Storage::disk('public')->delete($detail->gambar);
        $detail->delete();

        return redirect()->route('tutorial-details.index', $tutorialId)
            ->with('success', 'Detail berhasil dihapus!');
    }
}