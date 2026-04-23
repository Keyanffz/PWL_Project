<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tutorial extends Model
{
    protected $fillable = [
        'judul', 'kode_matkul', 'nama_matkul',
        'url_presentation', 'url_finished', 'creator_email'
    ];

    public function details()
    {
        return $this->hasMany(TutorialDetail::class);
    }
}