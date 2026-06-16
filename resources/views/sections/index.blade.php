@extends('layouts.app')

@section('content')

<div class="breadcrumb">
    <a href="{{ url('/books') }}">ブック一覧</a> &rsaquo; {{ $book->name }}
</div>

<div class="card">
    <h2>セクションを追加</h2>
    <form method="POST" action="{{ url('/books/' . $book->id . '/sections') }}">
        @csrf
        <div class="form-row">
            <label>セクション名</label>
            <div style="display:flex; gap:10px">
                <input type="text" name="name" required placeholder="例: Section 1, Unit 1">
                <button type="submit" class="btn btn-blue" style="white-space:nowrap">追加</button>
            </div>
        </div>
        @error('name')
            <p style="color:#c0435a; font-size:0.85rem; margin-top:6px">{{ $message }}</p>
        @enderror
    </form>
</div>

<div class="card">
    <h2>セクション一覧</h2>
    @if($sections->isEmpty())
        <p style="color:#b0b8d0; text-align:center; padding:24px 0">セクションがまだありません</p>
    @else
        <table>
            <thead>
                <tr><th>セクション名</th><th>単語数</th><th>操作</th></tr>
            </thead>
            <tbody>
            @foreach($sections as $section)
                <tr>
                    <td>
                        <form method="POST" action="{{ url('/books/' . $book->id . '/sections/' . $section->id) }}" class="section-edit-form">
                            @csrf
                            @method('PUT')
                            <input type="text" name="name" value="{{ $section->name }}" required>
                            <button type="submit" class="btn btn-blue btn-sm">更新</button>
                        </form>
                    </td>
                    <td>
                        <a href="{{ url('/words') }}?section={{ $section->id }}" class="section-tab" style="padding:4px 12px">
                            {{ $section->words_count }}語
                        </a>
                    </td>
                    <td>
                        <div class="actions">
                            <a href="{{ url('/words') }}?section={{ $section->id }}" class="btn btn-outline btn-sm">単語</a>
                            <a href="{{ url('/quiz') }}?section={{ $section->id }}" class="btn btn-pink btn-sm">クイズ</a>
                            <a href="{{ url('/sections/' . $section->id . '/export') }}" class="btn btn-export btn-sm">エクスポート</a>
                            <button type="button" class="btn btn-import btn-sm"
                                onclick="document.getElementById('import-{{ $section->id }}').style.display='block'; this.style.display='none'">
                                インポート
                            </button>
                            <form method="POST" action="{{ url('/books/' . $book->id . '/sections/' . $section->id) }}">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm"
                                    onclick="return confirm('「{{ $section->name }}」を削除しますか？')">削除</button>
                            </form>
                        </div>
                        {{-- インポートフォーム（初期非表示） --}}
                        <div id="import-{{ $section->id }}" class="import-form" style="display:none; margin-top:10px">
                            <form method="POST" action="{{ url('/sections/' . $section->id . '/import') }}"
                                enctype="multipart/form-data" style="display:flex; gap:8px; align-items:center; flex-wrap:wrap">
                                @csrf
                                <input type="file" name="file" accept=".xlsx,.xls,.csv" required class="file-input">
                                <button type="submit" class="btn btn-import btn-sm">アップロード</button>
                                <button type="button" class="btn btn-outline btn-sm"
                                    onclick="document.getElementById('import-{{ $section->id }}').style.display='none';
                                             document.querySelectorAll('.btn-import')[{{ $loop->index * 2 }}].style.display='inline-block'">
                                    キャンセル
                                </button>
                            </form>
                            <p class="import-hint">※ 1行目をヘッダー（English / Japanese）とするExcelファイル</p>
                        </div>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    @endif
</div>

<style>
    .btn-export {
        background: linear-gradient(135deg, #6abf88, #8dd4a8);
        color: #fff;
        box-shadow: 0 3px 10px rgba(106,191,136,0.35);
    }
    .btn-import {
        background: linear-gradient(135deg, #c39be8, #d8b4f8);
        color: #fff;
        box-shadow: 0 3px 10px rgba(195,155,232,0.35);
    }
    .import-form {
        background: rgba(216,180,248,0.1);
        border: 1.5px dashed #d8b4f8;
        border-radius: 10px;
        padding: 12px 14px;
    }
    .file-input {
        font-size: 0.82rem;
        padding: 6px 8px;
        border: 1.5px solid #daeeff;
        border-radius: 8px;
        background: #fff;
        cursor: pointer;
        width: auto;
    }
    .import-hint {
        font-size: 0.78rem;
        color: #b0b8d0;
        margin-top: 6px;
    }
</style>

@endsection
