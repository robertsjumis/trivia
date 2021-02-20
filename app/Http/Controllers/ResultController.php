<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ResultController extends Controller
{
    public function index(Request $request)
    {
        $questionCount = intval($request->session()->get('questionCount'));
        $correctAnswer = $questionCount == 20 ?
            null : $request->session()->get('correctAnswer');
        $request->session()->flush();
        return view("results",
            [
                'questionCount' => $questionCount,
                'correctAnswer' => $correctAnswer
            ]);
    }
}
