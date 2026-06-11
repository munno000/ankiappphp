<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Word extends Model
{
    protected $fillable = ['english', 'japanese', 'section_id'];

    public function section()
    {
        return $this->belongsTo(Section::class);
    }
}
