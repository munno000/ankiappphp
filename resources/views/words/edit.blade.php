@extends('layouts.app')

@section('content')

<div class="breadcrumb">
    <a href="{{ url('/words') }}?section={{ $word->section_id }}">← 単語一覧</a>
</div>

<div class="card">
    <h2>単語を編集</h2>
    <form method="POST" action="{{ url('/words/' . $word->id) }}">
        @csrf
        @method('PUT')
        <div class="form-row">
            <label>セクション</label>
            <select name="section_id" required>
                @foreach($sections as $s)
                    <option value="{{ $s->id }}" {{ $word->section_id == $s->id ? 'selected' : '' }}>{{ $s->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="form-row">
            <label>English</label>
            <input type="text" name="english" value="{{ $word->english }}" required>
        </div>
        <div class="form-row">
            <label>Japanese</label>
            <input type="text" name="japanese" value="{{ $word->japanese }}" required>
        </div>
        <div style="display:flex; gap:10px; margin-top:8px">
            <button type="submit" class="btn btn-blue">更新する</button>
            <a href="{{ url('/words') }}?section={{ $word->section_id }}" class="btn btn-outline">キャンセル</a>
        </div>
    </form>
</div>

@endsection
