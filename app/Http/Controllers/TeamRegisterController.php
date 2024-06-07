<?php

namespace App\Http\Controllers;

use App\Models\Team;
use Illuminate\Http\Request;

class TeamRegisterController extends Controller
{
    public function store(Request $request)
    {
//dd($request);
       dd((new Team())->store($request));

    }
}
