<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Work;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class WorkController extends Controller
{
    // 勤怠開始処理
    public function startWork(Request $request)
    {
        $work = new Work();
        $work->user_id = Auth::id();
        $work->work_start = Carbon::now();
        $work->work_date = Carbon::today();
        $work->save();

        return redirect()->route('work.attendance');
    }

    // 勤怠終了処理
    public function endWork(Request $request)
    {
        $work = Work::where('user_id', Auth::id())
                    ->whereNull('work_finish')
                    ->latest()
                    ->first();

        if ($work) {
            $work->work_finish = Carbon::now();
            $work->save();
        }

        return redirect()->route('work.attendance');
    }

    public function attendance()
{
    // ユーザーの勤務データを取得（1ページに5件表示）
    $works = Work::where('user_id', Auth::id())->paginate(5);

    foreach ($works as $work) {
        // 休憩データを取得
        $rests = DB::table('rests')
            ->where('work_id', $work->id)
            ->whereNotNull('rest_start')  // 休憩開始が記録されている
            ->whereNotNull('rest_finish') // 休憩終了が記録されている
            ->get();

        // 休憩時間の合計を計算
        $total_rest_time = 0;
        if ($rests->isNotEmpty()) {
            foreach ($rests as $rest) {
                $rest_start = \Carbon\Carbon::parse($rest->rest_start);
                $rest_finish = \Carbon\Carbon::parse($rest->rest_finish);
                $total_rest_time += $rest_finish->diffInMinutes($rest_start); // 休憩時間を分単位で加算
            }

            // 分から「時間:分」に変換
            $hours = floor($total_rest_time / 60);
            $minutes = $total_rest_time % 60;
            $work->total_rest_time = sprintf('%02d:%02d', $hours, $minutes); // 休憩時間を「HH:mm」で表示
        } else {
            $work->total_rest_time = '休憩なし'; // 休憩がない場合
        }

        // 勤務時間の計算（休憩時間を引いた勤務時間）
        if ($work->work_finish) {
            $work_start = \Carbon\Carbon::parse($work->work_start);
            $work_finish = \Carbon\Carbon::parse($work->work_finish);
            $total_work_time_in_minutes = $work_finish->diffInMinutes($work_start) - $total_rest_time;

            // 勤務時間を「時間:分」に変換
            $work_hours = floor($total_work_time_in_minutes / 60);
            $work_minutes = $total_work_time_in_minutes % 60;
            $work->total_work_time = sprintf('%02d:%02d', $work_hours, $work_minutes);
        } else {
            $work->total_work_time = '未終了';
        }
    }

    return view('date', ['works' => $works]);
}

}


