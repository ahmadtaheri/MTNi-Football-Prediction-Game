<?php

namespace App\Http\Controllers;

use App\Models\Match;
use App\Models\Team;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class MatchRegisterController extends Controller
{
    public function view()
    {
//        if (! Gate::allows('admin_authority')) {
//            abort(403);
//        }

        Gate::authorize('admin_authority');

        return view('matches', ['teams' => $this->teams()]);
    }

    public function store(Request $request)
    {
        Gate::authorize('admin_authority');

        $saving=(new Match())->store($request);
//        return view('matches', ['isSaved' => $saving]);
        return redirect('/registerMatch');

    }

    private function teams()
    {
        return [
           'Jordan',
'India', 
'Indonesia', 
'Japan', 
'Bahrain',
'Qatar ',
'Malesiya', 
'Syria', 
'Tajikistan', 
'Australia', 
'Kyrgyz Republic', 
'Saudi Arabia', 
'Thailand', 
'Iran', 
'Hong Kong',
'Palestine',
'China',
'Uzbekistan', 
'UAE',
'Vietnam', 
'Oman',
'South Korea',
'Lebnan',
'Iraq'
        ];
    }
}
