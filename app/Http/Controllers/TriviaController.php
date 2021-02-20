<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Log;

class TriviaController extends Controller
{
    public function index()
    {
        try {
            $question = $this->getQuestion();
            $correctAnswer = $this->getCorrectAnswer($question);
            $wrongAnswers = $this->getWrongAnswers($correctAnswer);
        } catch (\Exception $e) {
            return view('error');
        }
        Log::debug($correctAnswer);
        $this->formatQuestion($question);
        return view("question",
            [
                'wrongAnswers' => $wrongAnswers,
                'correctAnswer' => $correctAnswer,
                'question' => $question
            ]);
    }

    private function formatQuestion(string &$question): void
    {
        $question = substr(strstr($question," "), 1);
        $question = str_replace(".", "?", $question);
        $question = 'What ' . $question;
    }

    private function getQuestion(): string
    {
        $quizQuestion = file_get_contents('http://numbersapi.com/random');
        $answer = $this->getCorrectAnswer($quizQuestion);
        if (is_numeric($answer)) {
            return $quizQuestion;
        } else {
            return $this->getQuestion();
        }
    }

    private function getCorrectAnswer(string $question): int
    {
        return (int) explode(' ', $question)[0];
    }

    private function getWrongAnswers(int $correctAnswer): array
    {
        $wrongAnswers = [];
        while (count($wrongAnswers) < 3) {
            $max = $correctAnswer * 2;
            $randomNumber = rand(0, $max);
            if (!in_array($randomNumber, $wrongAnswers) && $randomNumber !== $correctAnswer) {
                $wrongAnswers[] = $randomNumber;
            }
        }
        return $wrongAnswers;
    }
}
