<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Log;

class TriviaController extends Controller
{
    public function index()
    {
       // try {
            $question = $this->getQuestion();
            $correctAnswer = $this->getCorrectAnswer($question);
            $answers = $this->getAnswers($correctAnswer);
            $this->formatQuestion($question);
//        } catch (\Exception $e) {
//            return view('error');
//        }
        session(['correctAnswer' => $correctAnswer]);
        Log::debug($correctAnswer);

        return view("question",
            [
                'answers' => $answers,
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
        if ($answer > 0 && $answer < 1000000) {
            return $quizQuestion;
        } else {
            return $this->getQuestion();
        }
    }

    private function getCorrectAnswer(string $question): int
    {
        return intval(explode(' ', $question)[0]);
    }

    private function getAnswers(int $correctAnswer): array
    {
        $answers = [];
        while (count($answers) < 3) {
            $max = $correctAnswer * 2;
            $randomNumber = rand(0, $max);
            if (!in_array($randomNumber, $answers) && $randomNumber !== $correctAnswer) {
                $answers[] = $randomNumber;
            }
        }
        $answers[] = $correctAnswer;
        shuffle($answers);
        return $answers;
    }
}
