@extends('layouts.app')

@section('content')

<div class="card">
    <h2>単語を編集</h2>
    <form method="POST" action="{{ url('/words/' . $word->id) }}">
        @csrf
        @method('PUT')
        <div>
            <label>セクション:</label>
            <select name="section_id" required>
                @foreach($sections as $s)
                    <option value="{{ $s->id }}" {{ $word->section_id == $s->id ? 'selected' : '' }}>{{ $s->name }}</option>
                @endforeach
            </select>
        </div>
        <div>
            <label>English:</label>
            <input type="text" name="english" value="{{ $word->english }}" required>
        </div>
        <div>
            <label>Japanese:</label>
            <input type="text" name="japanese" value="{{ $word->japanese }}" required>
        </div>
        <div style="margin-top:8px">
            <button type="submit">更新</button>
            <a href="{{ url('/words') }}?section={{ $word->section_id }}" style="margin-left:8px">キャンセル</a>
        </div>
    </form>
</div>

@endsection
