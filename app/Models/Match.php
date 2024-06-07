<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Match extends Model
{
    use HasFactory;

    public function store($request)
    {
        $this->teamA=$request->teamA;
        $this->teamB=$request->teamB;
//        $this->matchYear=$request->year;
//        $this->matchMonth=$request->month;
//        $this->matchDay=$request->day;
//        $this->matchHour=$request->hour;
//        $this->matchMinute=$request->minute;
//        $this->matchSecond=0;
        $this->matchTime=$request->year."-".$request->month."-".$request->day." ".$request->hour.":".$request->minute.":"."00";

        return $this->save();

    }

//    public function returnTodayMatches($today)
//    {
//        return
//    }

    public function users()
    {
        return $this->belongsToMany(User::class)->using(MatchUser::class)->withTimestamps()->withPivot('teamA_Score_prediction','teamB_Score_prediction','match_point');
    }

    public function storeResult($request)
    {
        $this->teamA_score=$request->teamA_Score_Final;
        $this->teamB_score=$request->teamB_Score_Final;
        return $this->save();
    }
}
