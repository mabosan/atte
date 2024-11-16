<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
   // ユーザー一覧を表示するメソッド
    public function date()
    {
        // ユーザーを5件ずつページネーション
        $users = User::with('works.rests')->paginate(5);

        // ビューに変数を渡す
        return view('date', ['users' => $users]);
    }
}
