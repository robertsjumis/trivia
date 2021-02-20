<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class AnswerController extends Controller
{
    public function save(Request $request)
    {
        $answer = $request->input('answer');
        $correctAnswer = $request->session()->get('correctAnswer');
        if ($answer == $correctAnswer) {
            return redirect ('/trivia');
        }
        return redirect('/');
    }
}
