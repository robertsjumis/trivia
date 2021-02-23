<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ResultController extends Controller
{
    public function index(Request $request)
    {
        $questionCount = intval($request->session()->get('questionCount'));
        $answeredCorrectly = $request->session()->get('answeredCorrectly');

        $correctAnswer = $answeredCorrectly ?
            null : $request->session()->get('correctAnswer');
        $request->session()->flush();
        return view("results",
            [
                'maxQuestions' => config('trivia.maxQuestions'),
                'questionCount' => $questionCount,
                'correctAnswer' => $correctAnswer
            ]);
    }
}
