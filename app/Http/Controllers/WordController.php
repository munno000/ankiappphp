<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class WordController extends Controller
{
    private function storagePath()
    {
        return storage_path('app/words.json');
    }

    private function loadWords()
    {
        $path = $this->storagePath();
        if (!file_exists($path)) {
            return [];
        }
        $json = file_get_contents($path);
        $data = json_decode($json, true);
        return is_array($data) ? $data : [];
    }

    private function saveWords(array $words)
    {
        $path = $this->storagePath();
        if (!is_dir(dirname($path))) {
            mkdir(dirname($path), 0755, true);
        }
        file_put_contents($path, json_encode(array_values($words), JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
    }

    public function index()
    {
        $words = $this->loadWords();
        return view('words.index', ['words' => $words]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'english' => 'required|string|max:255',
            'japanese' => 'required|string|max:255',
        ]);

        $words = $this->loadWords();
        $words[] = [
            'english' => $request->input('english'),
            'japanese' => $request->input('japanese'),
        ];
        $this->saveWords($words);

        return redirect()->back()->with('success', '単語を追加しました');
    }

    public function quiz()
    {
        $words = $this->loadWords();
        if (empty($words)) {
            return redirect('/words')->with('error', 'まずは単語を追加してください');
        }
        $idx = array_rand($words);
        $word = $words[$idx];
        return view('words.quiz', ['word' => $word]);
    }

    public function check(Request $request)
    {
        $request->validate([
            'english' => 'required|string',
            'answer' => 'required|string',
        ]);

        $english = $request->input('english');
        $answer = trim($request->input('answer'));
        $words = $this->loadWords();
        $found = null;
        foreach ($words as $w) {
            if (isset($w['english']) && $w['english'] === $english) {
                $found = $w;
                break;
            }
        }

        if (!$found) {
            return redirect('/quiz')->with('error', '単語が見つかりませんでした');
        }

        $correct = trim($found['japanese']) === $answer;
        return redirect('/quiz')->with('result', $correct ? '正解！' : '不正解: 正しい訳は「' . $found['japanese'] . '」です');
    }
}
