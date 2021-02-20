<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AnswerController extends Controller
{
    public function save(Request $request)
    {
        $answer = $request->input('answer');
        if (!$answer) {
            return redirect('/trivia');
        }
        $correctAnswer = $request->session()->get('correctAnswer');
        $questionCount = intval($request->session()->get('questionCount'));
        session([
            'question' => null,
            'answer' => null
        ]);

        if ($answer == $correctAnswer && $questionCount < 19) {
            session([
                'questionCount' => $questionCount + 1
            ]);
            return redirect ('/trivia');
        }
        if ($answer == $correctAnswer) {
            session([
                'questionCount' => $questionCount + 1
            ]);
        }
        return redirect('/results');
    }
}
