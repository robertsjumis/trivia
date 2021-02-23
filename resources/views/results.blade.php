<p>
    Trivia has ended!
</p>
<p>
    You successfully answered {{$questionCount}}/{{$maxQuestions}} questions!
</p>
@if ($correctAnswer)
    <p>
        Correct answer was {{$correctAnswer}}!
    </p>
@endif
<a href="/trivia">Try again!</a>
