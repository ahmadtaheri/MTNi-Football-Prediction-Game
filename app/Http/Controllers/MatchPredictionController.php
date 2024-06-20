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
    
       public function sendTelegramMessageRankingTable()
    {
        
        $botApiToken = '7447333705:AAFKW0TK52x6SXMErQF7sCA2dbgDbOz-z5Y';
        $channelId ='@newbotchanneltest';
        $ranks = $this->calculateRanking() ;
        $table='';
        $i=1;
        foreach ($ranks as $key => $value){
            $table.=$i.'-'.$key.' ➡️ '.'<b>'.$value.'</b>'.'pts'."\n";
            $i++;
        }
        $query = http_build_query([
          'chat_id' => $channelId,
          'text' =>"******"."\n".'<b>'.'#Ranking_Table'.'</b>'."\n"."\n".$table ,
          'parse_mode'=>'html'
        ]);
       $url = "https://api.telegram.org/bot{$botApiToken}/sendMessage?{$query}";
       $curl = curl_init();
       curl_setopt_array($curl, array(
       CURLOPT_URL => $url,
       CURLOPT_RETURNTRANSFER => true,
       CURLOPT_CUSTOMREQUEST => 'GET',
        ));
     dd(curl_exec($curl));
     curl_close($curl);
    }
    
      public function sendTelegramMessagePredictions($match_id)
    {
        
        $botApiToken = '7447333705:AAFKW0TK52x6SXMErQF7sCA2dbgDbOz-z5Y';
        $channelId ='@newbotchanneltest';
        Gate::authorize('admin_authority');
        $match = Match::find($match_id);
        $predictedUsers =$match->users->sortBy('firstName');
        $table='';
        foreach ($predictedUsers as $user){
            $name=$user->firstName;
            $lastName=$user->lastName;
            $teamA=$user->getOriginal('pivot_teamA_Score_prediction');
            $teamB=$user->getOriginal('pivot_teamB_Score_prediction');
            $table.=$name.' '.$lastName.': '.'<b>'.$teamA.'</b>'.'|'.'<b>'.$teamB.'</b>'."\n";
        }
        
        $header="******"."\n".'<b>'.'#Prediction'.'</b>'."\n"."\n";
        $header1='Name'.':'.'⚽'.'<b>'.$match->teamA.'</b>'.'|'.'⚽'.'<b>'.$match->teamB.'</b>'."\n"."\n";
        $query = http_build_query([
          'chat_id' => $channelId,
          'text' =>$header.$header1.$table,
          'parse_mode'=>'html'
        ]);
       $url = "https://api.telegram.org/bot{$botApiToken}/sendMessage?{$query}";
       $curl = curl_init();
       curl_setopt_array($curl, array(
       CURLOPT_URL => $url,
       CURLOPT_RETURNTRANSFER => true,
       CURLOPT_CUSTOMREQUEST => 'GET',
        ));
     dd(curl_exec($curl));
     curl_close($curl);
    }
    
       public function sendTelegramMessagePredictionsWithPoints($match_id)
    {
        
        $botApiToken = '7447333705:AAFKW0TK52x6SXMErQF7sCA2dbgDbOz-z5Y';
        $channelId ='@newbotchanneltest';
        Gate::authorize('admin_authority');
        $match = Match::find($match_id);
        $predictedUsers =$match->users->sortBy('firstName');
        $table='';
        foreach ($predictedUsers as $user){
            // dd($user);
            $name=$user->firstName;
            $lastName=$user->lastName;
            $teamA=$user->getOriginal('pivot_teamA_Score_prediction');
            $teamB=$user->getOriginal('pivot_teamB_Score_prediction');
            $point=$user->getOriginal('pivot_match_point');
            $table.=$name.' '.$lastName.': '.'<b>'.$teamA.'</b>'.'|'.'<b>'.$teamB.'</b>'.'  =  '.'<b>'.$point.'</b>'."\n";
        }
        
        $header="******"."\n".'<b>'.'#Match_Point'.'</b>'."\n"."\n";
        $header1='Name'.':'.'⚽'.'<b>'.$match->teamA.'</b>'.'|'.'⚽'.'<b>'.$match->teamB.'</b>'.'  =  '.'Match Point'."\n"."\n";
        $query = http_build_query([
          'chat_id' => $channelId,
          'text' =>$header.$header1.$table,
          'parse_mode'=>'html'
        ]);
       $url = "https://api.telegram.org/bot{$botApiToken}/sendMessage?{$query}";
       $curl = curl_init();
       curl_setopt_array($curl, array(
       CURLOPT_URL => $url,
       CURLOPT_RETURNTRANSFER => true,
       CURLOPT_CUSTOMREQUEST => 'GET',
        ));
     dd(curl_exec($curl));
     curl_close($curl);
    }
    
       public function sendTelegramMessageUnpredictedUsers($match_id)
    {
        
        $botApiToken = '7447333705:AAFKW0TK52x6SXMErQF7sCA2dbgDbOz-z5Y';
        $channelId ='@newbotchanneltest';
        Gate::authorize('admin_authority');
        $match = Match::find($match_id);
        $usersId = array_column(User::all()->map->only('id')->toArray(), 'id');
        $predictedIds = array_column($match->users->map->only('id')->toArray(), 'id');
        $unpredictedUsers = array_diff($usersId, $predictedIds);
        $table='';
        $i=1;
        foreach($unpredictedUsers as $key => $id){
            $user=User::find($id);
            $table.=$i.'-'.'<b>'.$user->firstName.' '.$user->lastName.'</b>'."\n";
            $i++;
        }
        $query = http_build_query([
          'chat_id' => $channelId,
           'text' =>'⚽'.'<b>'.$match->teamA.'</b>'.'|'.'⚽'.'<b>'.$match->teamB.'</b>'."\n"."\n"."❌".'<b>'.'Whom Not Predicted Yet'.'</b>'."❌"."\n"."\n".$table ,
          'parse_mode'=>'html'
        ]);
       $url = "https://api.telegram.org/bot{$botApiToken}/sendMessage?{$query}";
       $curl = curl_init();
       curl_setopt_array($curl, array(
       CURLOPT_URL => $url,
       CURLOPT_RETURNTRANSFER => true,
       CURLOPT_CUSTOMREQUEST => 'GET',
        ));
     dd(curl_exec($curl));
     curl_close($curl);
    }
}









