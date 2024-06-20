<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DateTimeZone;
use Morilog\Jalali\Jalalian;
use App\Models\Match;
use Illuminate\Support\Facades\Auth;
use App\Events\MatchResultRegistered;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;

class registerResultController extends Controller
{
    public function view()
    {
        Gate::authorize('admin_authority');

        $now = Jalalian::forge('now', new DateTimeZone('Asia/Tehran'));
        $matches = Match::where('matchTime','<',$now)->get();
        return view('registerResult', ['matches' => $matches]);
    }

    public function store(Request $request, $matchId)

    {
        Gate::authorize('admin_authority');

        $match = Match::find($matchId);
        if ($match->storeResult($request)) {
            $i = 0;
            foreach ($match->users as $user) {
                $matchPoint=$this->calculateMatchPoint($user, $match);
                $user->matches()->updateExistingPivot($matchId, ['match_point' => $matchPoint]);
                $i += 1;
            }
            return $i == count($match->users);
        }

        return ["msg" => "Match Result not Saved"];
    }

    public function calculateMatchPoint($user, $match)
    {
        $teamA_Score_prediction = $user->pivot->teamA_Score_prediction;
        $teamB_Score_prediction = $user->pivot->teamB_Score_prediction;
        if ($match->teamA_score == $teamA_Score_prediction && $match->teamB_score == $teamB_Score_prediction) {
            return 10;
        }
        if ($match->teamA_score - $match->teamB_score == $teamA_Score_prediction - $teamB_Score_prediction) {
            return 7;
        }


        if ($match->teamA_score > $match->teamB_score && $teamA_Score_prediction > $teamB_Score_prediction) {

            return 5;

        }

        if ($match->teamA_score < $match->teamB_score && $teamA_Score_prediction < $teamB_Score_prediction) {
            return 5;

        }
        
        // if ($match->teamA_score == $teamA_Score_prediction || $match->teamB_score == $teamB_Score_prediction) {
        //     return 2;
        // }

        return 1;

    }
    

}
