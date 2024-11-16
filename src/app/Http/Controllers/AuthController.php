<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;  // Userモデルをインポート
use App\Models\Work;
use App\Models\Rest;

class AuthController extends Controller
{
    public function index()
    {
        // 全てのユーザーを取得し、各ユーザーのワークとそれに関連するレストも取得
        $users = User::with('works.rests')->paginate(5);

        // データをビューに渡す
        return view('index', ['users' => $users]);
    }

    public function date()
    {
        $users = User::paginate(10); // 10件ごとにページネーション
        return view('date', ['users' => $users]); // 変数 'users' をビューに渡す

        $works = Work::where('user_id', Auth::id())->get(); // ログインユーザーの勤務データを取得
        return view('date', ['works' => $works]);
    }

    // public function get_user()
    // {
        
    //     $user = Auth::user(); 
    //     // ログインしたユーザーを取得
    //     return view('index', ['user' => $user]);
        
    // }

    // public function __construct()
    // {
    //     $this->middleware('auth');
    // }
}
