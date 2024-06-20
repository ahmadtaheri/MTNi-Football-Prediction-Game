<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TeamRegisterController;
use App\Http\Controllers\MatchRegisterController;
use App\Http\Controllers\MatchPredictionController;
use App\Http\Controllers\registerResultController;
use App\Http\Controllers\registerExcelPointsController;
use Illuminate\Support\Facades\Artisan;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return redirect('login');
});


//Match registering routes
Route::get('/registerMatch', [MatchRegisterController::class, 'view'])->middleware(['auth']);
Route::post('/registerMatch', [MatchRegisterController::class, 'store'])->middleware(['auth']);

//Match prediction
Route::get('/matchPrediction', [MatchPredictionController::class, 'view'])->middleware(['auth']);
Route::post('/matchPrediction/{matchId}', [MatchPredictionController::class, 'store'])->middleware(['auth']);

//Match prediction
Route::get('/registerResult', [registerResultController::class, 'view'])->middleware(['auth']);
Route::post('/registerResult/{matchId}', [registerResultController::class, 'store'])->middleware(['auth']);

//Excel Point
Route::get('/registerExcelPoints', [registerExcelPointsController::class, 'view'])->middleware(['auth']);
Route::post('/registerExcelPoints/{userId}', [registerExcelPointsController::class, 'store'])->middleware(['auth']);

// report all user predictions
Route::get('/showMatchesForPredictions', [MatchPredictionController::class, 'showMatchesForPredictions'])->middleware(['auth']);
Route::post('/showMatchPredictions/{match_id}', [MatchPredictionController::class, 'showAllPredictions'])->middleware(['auth']);

//storing Cup Winner
Route::post('/registerCupWinner', [MatchPredictionController::class, 'storeCupWinner'])->middleware(['auth']);
Route::get('/showSumOfLastMatchesPerUser', [MatchPredictionController::class, 'showSumOfLastMatchesPerUser'])->middleware(['auth']);

//Dashboard Route
Route::get('/dashboard', [MatchPredictionController::class, 'view'])->middleware(['auth'])->name('dashboard');


//Report Cup Winner predictions
Route::get('/reportCupWinnerPredictions', [MatchPredictionController::class, 'reportCupWinnerPredictions'])->middleware(['auth'])->name('reportCupWinner');
Route::get('/storeCupWinnerPoint', [MatchPredictionController::class, 'storeCupWinnerPoint'])->middleware(['auth']);
Route::get('/reportExactPrediction', [MatchPredictionController::class, 'reportExactPrediction'])->middleware(['auth']);


//Report Cup Winner predictions
Route::get('/sendTelegramMessageRankingTable', [MatchPredictionController::class, 'sendTelegramMessageRankingTable'])->middleware(['auth']);
Route::get('/sendTelegramMessagePredictions/{matchId}', [MatchPredictionController::class, 'sendTelegramMessagePredictions'])->middleware(['auth']);
Route::get('/sendTelegramMessagePredictionsWithPoints/{matchId}', [MatchPredictionController::class, 'sendTelegramMessagePredictionsWithPoints'])->middleware(['auth']);
Route::get('/sendTelegramMessageUnpredictedUsers/{matchId}', [MatchPredictionController::class, 'sendTelegramMessageUnpredictedUsers'])->middleware(['auth']);


// Route::get('/migrateTable', function () {
// //   return Artisan::call('migrate:refresh');});
//     // return Artisan::call('migrate');
//     return Artisan::call('optimize:clear');
// });



//Route::get('/dashboard', function () {
//    return view('dashboard');
//})->middleware(['auth'])->name('dashboard');

require __DIR__.'/auth.php';
