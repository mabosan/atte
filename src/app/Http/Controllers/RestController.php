<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Work;
use App\Models\Rest;
use Illuminate\Support\Facades\Auth;

class RestController extends Controller
{
    // 休憩開始処理
    public function startRest(Request $request)
    {
        $today = now()->format('Y-m-d'); // 今日の日付を取得

        $work = Work::where('user_id', Auth::id())
            ->whereNull('work_finish')
            ->whereDate('work_start', $today) // 今日の日付の勤務データをフィルタリング
            ->latest()
            ->first();

        if (!$work) {
            return redirect()->back()->with('error', '勤務が開始されていません。');
        }

        $rest = new Rest();
        $rest->work_id = $work->id;
        $rest->rest_start = now();
        $rest->save();

        return redirect()->route('work.attendance');
    }

    // 休憩終了処理
    public function endRest(Request $request)
    {
        // 現在のユーザーの最新の勤務データを取得
        $work = Work::where('user_id', Auth::id())
            ->whereNull('work_finish')
            ->whereDate('work_start', now()->format('Y-m-d'))
            ->latest()
            ->first();

        if (!$work) {
            return redirect()->back()->with('error', '勤務が開始されていません。');
        }

        // 最新の勤務データから関連する休憩データを取得
        $rest = Rest::where('work_id', $work->id)
            ->whereNull('rest_finish')
            ->latest()
            ->first();

        if ($rest) {
            $rest->rest_finish = now();
            $rest->save();
        }

        return redirect()->route('work.attendance');
    }

    // 休憩時間を計算するメソッド
    public function calculateRestTime($rests)
    {
        $totalRestTime = 0;

        foreach ($rests as $rest) {
            if ($rest->rest_finish) {
                $restStart = \Carbon\Carbon::parse($rest->rest_start);
                $restFinish = \Carbon\Carbon::parse($rest->rest_finish);
                $totalRestTime += $restFinish->diffInSeconds($restStart); // 秒数で計算
            }
        }

        return gmdate('H:i:s', $totalRestTime); // 秒数を時:分:秒に変換
    }

    // 勤務データを表示するメソッド
    public function attendance()
    {
        $works = Work::with('rests') // 休憩データも取得
            ->where('user_id', Auth::id())
            ->get();

        // 各勤務に対して休憩時間を計算
        foreach ($works as $work) {
            $work->total_rest_time = $this->calculateRestTime($work->rests);
        }

        return view('attendance', compact('works'));
    }
}
