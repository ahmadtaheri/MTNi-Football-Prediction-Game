<?php

namespace App\Http\Controllers;

use App\Models\MatchUser;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Models\Match;
use \Morilog\Jalali\Jalalian;
use \DateTimeZone;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;


class MatchPredictionController extends Controller
{
    public function view($msg = null)
    {
        $now = Jalalian::forge('now', new DateTimeZone('Asia/Tehran'));
        $matches = Match::where('matchTime', '>', $now)->get();
        $championPrediction = $this->getFinalTeams();
        $ranks = $this->calculateRanking();
        $predictionHistory = Auth::user()->matches->sortByDesc('updated_at')->all();
        return view('dashboard', ['matches' => $matches, 'ranks' => $ranks, 'msg' => $msg, 'predictionHistory' => $predictionHistory, 'championPrediction' => $championPrediction]);
    }

    public function store(Request $request, $matchId)
    {
        $now = Jalalian::forge('now', new DateTimeZone('Asia/Tehran'));
        $matches = Match::where('matchTime', '>', $now)->get();
        $ranks = $this->calculateRanking();
        if (Match::find($matchId)->matchTime > $now) {
            $match_user = new MatchUser();
            $msg = $match_user->createOrUpdatePrediction($request, Auth::id(), $matchId);
            return $this->view($msg);
        }
        $msg = "the match time passed and you can predict it!";
        return $this->view($msg);
    }

    private function calculateRanking()
    {
        $users = User::all();
        $ranks = [];
        foreach ($users as $user) {
            $points = 0;
            $points += $user->matches->sum('pivot.match_point');
            // $ranks[$user->firstName . " " . $user->lastName] = $points + $user->excelPoint+$user->cupWinner->champion_point;
            $ranks[$user->firstName . " " . $user->lastName] = $points + $user->excelPoint;
            // $ranks[$user->firstName . " " . $user->lastName] = $points;
        }
        arsort($ranks);
        return $ranks;
    }

    public function showMatchesForPredictions()
    {
        Gate::authorize('admin_authority');
        $matches = Match::all()->sortByDesc('matchTime')->take(8);
        return view('showMatchesForPredictionTable', ['matches' => $matches]);
    }

    public function showAllPredictions($match_id)
    {
        Gate::authorize('admin_authority');
        $match = Match::find($match_id);
        $usersId = array_column(User::all()->map->only('id')->toArray(), 'id');
//        dd($t1->toArray());
        $predictedIds = array_column($match->users->map->only('id')->toArray(), 'id');

        $unpredictedUsers = array_diff($usersId, $predictedIds);

        return view('showAllUsersPrediction', ['match' => $match, 'unpredictedUsers' => $unpredictedUsers]);
    }

    public function showSumOfLastMatchesPerUser()
    {
        Gate::authorize('admin_authority');
//        $yesterday = Jalalian::forge('yesterday', new DateTimeZone('Asia/Tehran'));
        $numberOfMatches = 12;
        $users = User::all();
        $ranks = [];
        foreach ($users as $user) {
            $points = 0;
            $points += $user->matches->whereNotNull('pivot.match_point', null)->sortByDesc('matchTime')->take($numberOfMatches)->sum('pivot.match_point');
            $ranks[$user->firstName . " " . $user->lastName] = $points;
        }
        arsort($ranks);
        return view('showSumOfLastMatchesPerUser', ['sumOfLastMatchesPoints' => $ranks]);

    }

    public function getFinalTeams()
    {

        $now = Jalalian::forge('now', new DateTimeZone('Asia/Tehran'));
        $deadLine = Jalalian::fromFormat('Y-m-d H:i:s', '1402-11-08 15:00:00');
        if ($now < $deadLine) {
            return [
                'Jordan',
'Indonesia', 
'Japan', 
'Bahrain',
'Qatar ',
'Syria', 
'Tajikistan', 
'Australia', 
'Saudi Arabia', 
'Thailand', 
'Iran', 
'Palestine',
'Uzbekistan', 
'UAE',
'South Korea',
'Iraq'
            ];
        }
        return null;
    }

    public function storeCupWinner(Request $request)
    {
        $now = Jalalian::forge('now', new DateTimeZone('Asia/Tehran'));
        $deadLine = Jalalian::fromFormat('Y-m-d H:i:s', '1402-11-08 15:00:00');
        if ($now < $deadLine) {
            $updatedOrInserted = DB::table('champion_user')->updateOrInsert(['user_id' => Auth::id()], ['champion_team' => $request->cupWinner]);
        } else {
            return $this->view("Time passed and you cant predict Cup Winner");
        }
        if ($updatedOrInserted) {
            return $this->view($request->cupWinner . " was Saved as Cup winner");
        }
        return $this->view($request->cupWinner . " was already Saved as Cup winner");
    }

    public function reportCupWinnerPredictions()
    {
        Gate::authorize('admin_authority');
        $users=User::all();
        $predictions=[];
        foreach ($users as $user) {
          $predictions[$user->firstName." ".$user->lastName]=isset($user->cupWinner->champion_team)?$user->cupWinner->champion_team:null;
        }
        return view('showCupWinnerPredictions',['cupWinnerPredictions'=>$predictions]);
    }

    public function reportExactPrediction()
    {
        Gate::authorize('admin_authority');
        $users=User::all();
        $exactPrediction=[];
        foreach ($users as $user){
//            dd($user->matches()->wherePivot('match_point', 10)->count());
           $exactPrediction[$user->firstName." ".$user->lastName]=$user->matches()->wherePivot('match_point',10)->count();
        }
        arsort($exactPrediction);
        return view('showExactPredictions',['exactPrediction'=>$exactPrediction]);
    }

    public function storeCupWinnerPoint()
    {
        $users=User::all();
        $champion="";

        foreach ($users as $user){
           if($user->cupWinner->champion_team==$champion){
//               dd($user->cupWinner->champion_point=20);
               $user->cupWinner()->update(['champion_point'=>20]);

           }
           else{
               $user->cupWinner()->update(['champion_point'=>0]);
           }

        }
        return "Done";
    }
}









