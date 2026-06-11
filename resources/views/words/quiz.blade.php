@extends('layouts.app')

@section('content')

<div class="card">
    <div style="margin-bottom:12px">
        <strong>セクション：</strong>
        <a href="{{ url('/quiz') }}" @class(['active' => !$selectedSection])>すべて</a>
        @foreach($sections as $s)
            <a href="{{ url('/quiz') }}?section={{ $s->id }}"
               style="margin-left:8px" @class(['active' => $selectedSection == $s->id])>{{ $s->name }}</a>
        @endforeach
    </div>

    <h2>訳を答えてください</h2>
    <p style="color:#666; font-size:0.9em">セクション: {{ $word->section->name }}</p>
    <p>English: <strong>{{ $word->english }}</strong></p>
    <form method="POST" action="{{ url('/quiz/check') }}">
        @csrf
        <input type="hidden" name="word_id" value="{{ $word->id }}">
        <input type="hidden" name="section" value="{{ $selectedSection }}">
        <div>
            <label>Japanese:</label>
            <input type="text" name="answer" required autofocus>
        </div>
        <div style="margin-top:8px">
            <button type="submit">チェック</button>
            <a href="{{ url('/quiz') }}{{ $selectedSection ? '?section=' . $selectedSection : '' }}" style="margin-left:8px">次の問題</a>
            <a href="{{ url('/words') }}{{ $selectedSection ? '?section=' . $selectedSection : '' }}" style="margin-left:8px">単語一覧へ</a>
        </div>
    </form>
</div>

@endsection
