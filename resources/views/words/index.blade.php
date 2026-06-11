@extends('layouts.app')

@section('content')

<div class="card">
    <h2>単語を追加</h2>
    <form method="POST" action="{{ url('/words') }}">
        @csrf
        <div>
            <label>English:</label>
            <input type="text" name="english" required>
        </div>
        <div>
            <label>Japanese:</label>
            <input type="text" name="japanese" required>
        </div>
        <div style="margin-top:8px">
            <button type="submit">追加</button>
        </div>
    </form>
</div>

<div class="card">
    <h2>単語一覧</h2>
    @if($words->isEmpty())
        <p>まだ単語が登録されていません。</p>
    @else
        <table>
            <thead><tr><th>English</th><th>Japanese</th></tr></thead>
            <tbody>
            @foreach($words as $w)
                <tr><td>{{ $w->english }}</td><td>{{ $w->japanese }}</td></tr>
            @endforeach
            </tbody>
        </table>
    @endif
    <p style="margin-top:12px"><a href="{{ url('/quiz') }}">クイズを始める</a></p>
</div>

@endsection
