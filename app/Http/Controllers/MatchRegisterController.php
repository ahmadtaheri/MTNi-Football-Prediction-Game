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
           'Germany', 'Scotland', 'Hungary', 'Switzerland',
'Spain', 'Croatia', 'Italy', 'Albania',
'Slovenia', 'Denmark', 'Serbia', 'England',
'Poland', 'Netherlands', 'Austria', 'France',
'Belgium', 'Slovakia', 'Romania', 'Ukraine',
'Turkey', 'Georgia', 'Portugal', 'Czech Republic'
        ];
    }
}
