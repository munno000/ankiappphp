<?php

namespace App\Http\Controllers;

use App\Models\Section;
use App\Models\Word;
use Illuminate\Http\Request;

class WordController extends Controller
{
    public function index(Request $request)
    {
        $sections = Section::orderBy('name')->get();
        $selectedSection = $request->query('section');
        $words = $selectedSection
            ? Word::with('section')->where('section_id', $selectedSection)->get()
            : Word::with('section')->get();
        return view('words.index', compact('words', 'sections', 'selectedSection'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'english'    => 'required|string|max:255',
            'japanese'   => 'required|string|max:255',
            'section_id' => 'required|exists:sections,id',
        ]);

        Word::create($request->only('english', 'japanese', 'section_id'));

        return redirect(url('/words') . '?section=' . $request->input('section_id'))
            ->with('success', '単語を追加しました');
    }

    public function edit(int $id)
    {
        $word = Word::findOrFail($id);
        $sections = Section::orderBy('name')->get();
        return view('words.edit', compact('word', 'sections'));
    }

    public function update(Request $request, int $id)
    {
        $request->validate([
            'english'    => 'required|string|max:255',
            'japanese'   => 'required|string|max:255',
            'section_id' => 'required|exists:sections,id',
        ]);

        $word = Word::findOrFail($id);
        $word->update($request->only('english', 'japanese', 'section_id'));

        return redirect(url('/words') . '?section=' . $word->section_id)
            ->with('success', '単語を更新しました');
    }

    public function destroy(int $id)
    {
        $word = Word::findOrFail($id);
        $sectionId = $word->section_id;
        $word->delete();

        return redirect(url('/words') . '?section=' . $sectionId)
            ->with('success', '単語を削除しました');
    }

    public function quiz(Request $request)
    {
        $sections = Section::orderBy('name')->get();
        $selectedSection = $request->query('section');

        $word = $selectedSection
            ? Word::where('section_id', $selectedSection)->inRandomOrder()->first()
            : Word::inRandomOrder()->first();

        if (!$word) {
            return redirect(url('/words'))->with('error', 'まずは単語を追加してください');
        }

        $word->load('section');
        return view('words.quiz', compact('word', 'sections', 'selectedSection'));
    }

    public function check(Request $request)
    {
        $request->validate([
            'word_id' => 'required|integer',
            'answer'  => 'required|string',
            'section' => 'nullable|string',
        ]);

        $word = Word::findOrFail($request->input('word_id'));
        $correct = trim($word->japanese) === trim($request->input('answer'));
        $message = $correct ? '正解！' : '不正解: 正しい訳は「' . $word->japanese . '」です';

        $quizUrl = url('/quiz');
        if ($request->input('section')) {
            $quizUrl .= '?section=' . $request->input('section');
        }

        return redirect($quizUrl)->with('result', $message);
    }
}
