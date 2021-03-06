<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TriviaController extends Controller
{
    public function index(Request $request)
    {
        $allQuestions = (array) $request->session()->get('allQuestions');
        if ($request->session()->has('question') && $request->session()->has('answers')) {
            $question = $request->session()->get('question');
            $answers = $request->session()->get('answers');
        } else {
            $question = $this->getQuestion($allQuestions);
            $correctAnswer = $this->getCorrectAnswer($question);
            $answers = $this->getAnswers($correctAnswer);
            $this->formatQuestion($question);
            session([
                'correctAnswer' => $correctAnswer,
                'question' => $question,
                'answers' => $answers,
                'allQuestions' => $allQuestions
            ]);
        }
        return view("question",
            [
                'answers' => $answers,
                'question' => $question
            ]);
    }

    public function save(Request $request)
    {
        $answer = $request->input('answer');
        if (!$answer) {
            return $this->index($request);
        }
        $correctAnswer = $request->session()->get('correctAnswer');
        $questionCount = intval($request->session()->get('questionCount'));
        session([
            'question' => null,
            'answer' => null
        ]);
        $maxQuestions = config('trivia.maxQuestions');

        if ($answer == $correctAnswer) {
            $questionCount += 1;
            session([
                'answeredCorrectly' => true,
                'questionCount' => $questionCount
            ]);
            return $questionCount < $maxQuestions ?
                $this->index($request) : redirect('/results');
        } else {
            session([
                'answeredCorrectly' => false
            ]);
            return redirect('/results');
        }
    }

    private function formatQuestion(string &$question): void
    {
        $question = substr(strstr($question," "), 1);
        $question = substr($question, 0, -1);
        $question = 'What ' . $question . '?';
    }

    private function getQuestion(array &$allQuestions): string
    {
        $quizQuestion = file_get_contents('http://numbersapi.com/random');
        $answer = $this->getCorrectAnswer($quizQuestion);
        if ($answer > 0 && $answer < 1000000 && !in_array($quizQuestion, $allQuestions)) {
            $allQuestions[] = $quizQuestion;
            return $quizQuestion;
        } else {
            return $this->getQuestion($allQuestions);
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
