<p>
    Trivia has ended!
</p>
<p>
    You successfully answered {{$questionCount}}/20 questions!
</p>
@if ($correctAnswer)
    <p>
        Correct answer was {{$correctAnswer}}!
    </p>
@endif
<a href="/trivia">Try again!</a>
