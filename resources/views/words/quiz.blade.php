@extends('layouts.app')

@section('content')

@if($currentSection)
<div class="breadcrumb">
    <a href="{{ url('/books') }}">ブック一覧</a> &rsaquo;
    <a href="{{ url('/books/' . $currentSection->book_id . '/sections') }}">{{ $currentSection->book->name }}</a> &rsaquo;
    {{ $currentSection->name }}
</div>
@endif

<div class="section-tabs">
    <a href="{{ url('/quiz') }}" @class(['section-tab', 'active' => !$selectedSection])>すべて</a>
    @foreach($sections as $s)
        <a href="{{ url('/quiz') }}?section={{ $s->id }}" @class(['section-tab', 'active' => $selectedSection == $s->id])>
            {{ $s->name }}
        </a>
    @endforeach
</div>

<div class="card" style="margin-top:16px; text-align:center">
    <div class="quiz-section-label">
        {{ $word->section->book->name ?? '' }} &rsaquo; {{ $word->section->name }}
    </div>
    <div class="quiz-word">{{ $word->english }}</div>

    <form method="POST" action="{{ url('/quiz/check') }}" style="max-width:360px; margin:0 auto">
        @csrf
        <input type="hidden" name="word_id" value="{{ $word->id }}">
        <input type="hidden" name="section" value="{{ $selectedSection }}">
        <div class="form-row" style="margin-bottom:20px">
            <label>日本語訳を入力</label>
            <input type="text" name="answer" required autofocus placeholder="答えを入力...">
        </div>
        <div style="display:flex; gap:10px; justify-content:center; flex-wrap:wrap">
            <button type="submit" class="btn btn-pink">チェック ✓</button>
            <a href="{{ url('/quiz') }}{{ $selectedSection ? '?section=' . $selectedSection : '' }}" class="btn btn-blue">次の問題 →</a>
            <a href="{{ url('/words') }}{{ $selectedSection ? '?section=' . $selectedSection : '' }}" class="btn btn-outline">単語一覧</a>
        </div>
    </form>
</div>

@endsection
