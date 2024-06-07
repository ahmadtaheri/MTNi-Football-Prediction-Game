<?php
/**
 * Created by PhpStorm.
 * User: ahmad.ta
 * Date: 6/13/2021
 * Time: 8:19 PM
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class MatchUser extends Pivot
{
    public $incrementing = true;

    public function storePrediction($request, $user_id, $match_id)
    {
        $this->user_id = $user_id;
        $this->match_id = $match_id;
        $this->teamA_Score_prediction = $request->teamA_Score_prediction;
        $this->teamB_Score_prediction = $request->teamB_Score_prediction;
        return $this->save();

    }

    public function updatePrediction()
    {
        return 'ok';


    }

    public function createOrUpdatePrediction($request, $user_id, $match_id)
    {
        if (static::where('user_id', $user_id)->where('match_id', $match_id)->get()->isEmpty()) {
            $this->user_id = $user_id;
            $this->match_id = $match_id;
            $this->teamA_Score_prediction = $request->teamA_Score_prediction;
            $this->teamB_Score_prediction = $request->teamB_Score_prediction;

            return $this->save() ? "Creating Prediction was Successful" : "Creating Prediction was not Successful";
        }

        $savedMachUser = static::where('user_id', $user_id)->where('match_id', $match_id)->first();
        $savedMachUser->teamA_Score_prediction = $request->teamA_Score_prediction;
        $savedMachUser->teamB_Score_prediction = $request->teamB_Score_prediction;
        return $savedMachUser->save() ? "Updating Prediction was Successful" : "Updating Prediction was not Successful";


    }


}