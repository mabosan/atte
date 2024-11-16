@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/index.css') }}">
@endsection

@section('content')

<div class="attendance__content">
    <table>
        <tr>
            <th>名前</th>
            <th>勤務開始</th>
            <th>勤怠終了</th>
            <th>休憩時間</th>
            <th>勤務時間</th>
        </tr>
        @foreach ($works as $work)
        <tr>
        <td>{{ Auth::user()->name }}</td>
        <td>{{ \Carbon\Carbon::parse($work->work_start)->format('H:i:s') }}</td>
        <td>{{ $work->work_finish ? \Carbon\Carbon::parse($work->work_finish)->format('H:i:s') : '未終了' }}</td>
        <td>{{ $work->total_rest_time }}</td> <!-- 計算された休憩時間を表示 -->
        <td>{{ $work->total_work_time !== '未終了' ? $work->total_work_time : '未終了' }}</td> <!-- 計算された勤務時間を表示 -->
        </tr>
        @endforeach
    </table>

    <!-- ページネーションリンク -->
    {{ $works->links('vendor.pagination.custom-pagination') }}
</div>
@endsection
