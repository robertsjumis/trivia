<p>{{ $question }} </p>
<p>
    <form method="post">
        @csrf
        @foreach($answers as $key => $answer)
            <div>
                <input type="radio" id="answer{{$key}}" name="answer" value="{{$answer}}">
                <label for="answer{{$key}}">{{$answer}}</label>
            </div>
        @endforeach
        <input type="submit" value="Submit">
    </form>
</p>
