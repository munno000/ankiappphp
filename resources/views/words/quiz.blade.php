@extends('layouts.app')

@section('content')

<div class="card">
    <h2>訳を答えてください</h2>
    <p>English: <strong>{{ $word->english }}</strong></p>
    <form method="POST" action="{{ url('/quiz/check') }}">
        @csrf
        <input type="hidden" name="word_id" value="{{ $word->id }}">
        <div>
            <label>Japanese:</label>
            <input type="text" name="answer" required>
        </div>
        <div style="margin-top:8px">
            <button type="submit">チェック</button>
            <a href="{{ url('/quiz') }}" style="margin-left:8px">次の問題</a>
            <a href="{{ url('/words') }}" style="margin-left:8px">単語一覧へ</a>
        </div>
    </form>
</div>

@endsection
