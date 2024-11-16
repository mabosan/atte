@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/index.css') }}">
@endsection

@section('content')
<div class="attendance__alert">
  <p>{{ Auth::user()->name }}さんお疲れ様です！</p>
</div>

<div class="attendance__content">
  <div class="attendance__panel">
    <form action="{{ route('work.start') }}" method="POST">
        @csrf
        <button type="submit">勤怠開始</button>
    </form>

    <form action="{{ route('work.end') }}" method="POST">
        @csrf
        <button type="submit">勤怠終了</button>
    </form>

    <form action="{{ route('rest.start') }}" method="POST">
        @csrf
        <button type="submit">休憩開始</button>
    </form>

    <form action="{{ route('rest.end') }}" method="POST">
        @csrf
        <button type="submit">休憩終了</button>
    </form>

  </div>
  <div class="attendance-table"></div>
</div>
@endsection