<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Question;
use App\Choice;
use App\Course;
use App\Answer;
use Auth;


class ExamController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $question = new Question;
        $question->question_name = $request->question_name;
        $question->course_id = $request->course_id;
        $question->save();
        return back();
    }

    public function storeChoice(Request $request)
    {
        $choice = new Choice;
        $choice->choice_name = $request->choice_name;
        $choice->question_id = $request->question_id;
        if (isset($request->correct_choice)) {
            $choice->correct_choice = $request->correct_choice;
        }
        $choice->save();
        return back();
    }

    public function destroyChoice($id){
        $choice =Choice::find($id);
        $choice->delete();
        return back();
    }
    public function updateChoice(Request $request,$id){
        $choice =Choice::find($id);
        $choice->choice_name = $request->choice_name;
        $choice->correct_choice = $request->correct_choice;
        $choice->save();
        return back();
    }

    public function answers(){
        $course = Course::where('user_id', Auth::id())->first()->answers->all();
        return array_unique($course->user_id);

        $courses = Course::where('user_id', Auth::id())->get();
        return view('prof.answer', ['courses' => $courses]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $course = Course::find($id);
        $questions = Question::all()->where('course_id', $id);
        $choices = Choice::all();
        return view('courses.exam', ['questions' => $questions, 'course' => $course, 'choices' => $choices]);    
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $question = Question::find($request->id);
        $question->question_name = $request->question_name;
        $question->save();
        return back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $question = Question::find($id);
        $question->delete();
        $choices = Choice::where('question_id', $id);
        $choices->delete();
        return back();
    }
}
