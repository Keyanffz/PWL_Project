<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TutorialDetail extends Model
{
    protected $fillable = [
        'tutorial_id', 'text', 'gambar',
        'code', 'url', 'order', 'status'
    ];

    public function tutorial()
    {
        return $this->belongsTo(Tutorial::class);
    }
}