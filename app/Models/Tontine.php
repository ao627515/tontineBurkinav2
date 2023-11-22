<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tontine extends Model
{
    use HasFactory, HasUuids;
    protected $guarded = [];

    public function isNotStarted(){
        return $this->status == "creating";
    }

    public function cotisation(){
        //
    }
}
