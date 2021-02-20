<p>{{ $question }} </p>
<p>
    <form method="post">
        @foreach($answers as $key => $answer)
            <div>
                <input type="radio" id="answer{{$key}}" name="answer" value="{{$key}}">
                <label for="answer{{$key}}">{{$answer}}</label>
            </div>
        @endforeach
        <input type="submit" value="Submit">
    </form>
</p>
