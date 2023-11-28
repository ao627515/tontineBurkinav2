<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Participant extends Model
{
    use HasFactory, HasUuids;

    protected $guarded = [];

    public function tontines(){
        return $this->belongsToMany(Tontine::class, 'tontine_participants');
    }
}
