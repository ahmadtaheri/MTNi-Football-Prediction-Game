<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class Team extends Model
{
    use HasFactory;

    public function store(Request $request) {
        $this->englishName=$request->englishName;
        $this->persianName=$request->persianName;
      return  $this->save();
    }
}
