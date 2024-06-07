<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
class registerExcelPointsController extends Controller
{
    public function view()
    {
        $users=User::all();

       return view('ExcelPoints',['users'=>$users]);
    }

    public function store(Request $request,$userId)
    {
        $user=User::find($userId);
        $user->excelPoint=$request->excelPoint;
        $user->save();
        $users=User::all();
        return view('ExcelPoints',['users'=>$users]);
    }
}
