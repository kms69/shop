<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProcessPipe extends Model
{
    use HasFactory;
    protected $guarded = [];
    public $timestamps = false;

    public function files()
    {
        return $this->morphToMany(Document::class, 'uploadable');
    }
}
