<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class HasTriviaEnded
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $answeredCorrectly = $request->session()->get('answeredCorrectly');
        $questionCount = $request->session()->get('questionCount');
        $maxQuestions = config('trivia.maxQuestions');
        if (
            !$request->session()->has('answeredCorrectly') ||
            ($answeredCorrectly && $questionCount < $maxQuestions)
        ) {
            return redirect ('/trivia');
        }
        return $next($request);
    }
}
