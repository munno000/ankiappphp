<?php

namespace App\Http\Controllers;

use App\Models\Word;
use Illuminate\Http\Request;

class WordController extends Controller
{
    public function index()
    {
        $words = Word::all();
        return view('words.index', ['words' => $words]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'english' => 'required|string|max:255',
            'japanese' => 'required|string|max:255',
        ]);

        Word::create($request->only('english', 'japanese'));

        return redirect(url('/words'))->with('success', '単語を追加しました');
    }

    public function quiz()
    {
        $word = Word::inRandomOrder()->first();
        if (!$word) {
            return redirect(url('/words'))->with('error', 'まずは単語を追加してください');
        }
        return view('words.quiz', ['word' => $word]);
    }

    public function check(Request $request)
    {
        $request->validate([
            'word_id' => 'required|integer',
            'answer' => 'required|string',
        ]);

        $word = Word::find($request->input('word_id'));
        if (!$word) {
            return redirect(url('/quiz'))->with('error', '単語が見つかりませんでした');
        }

        $correct = trim($word->japanese) === trim($request->input('answer'));
        $message = $correct ? '正解！' : '不正解: 正しい訳は「' . $word->japanese . '」です';

        return redirect(url('/quiz'))->with('result', $message);
    }
}
