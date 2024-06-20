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
    
     public function sendTelegramMessage()
    {
        
        $botApiToken = '7447333705:AAFKW0TK52x6SXMErQF7sCA2dbgDbOz-z5Y';
        $channelId ='@newbotchanneltest';
        $text = 'Hello, I am from PHP!';

        $query = http_build_query([
          'chat_id' => $channelId,
          'text' => $text,
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
