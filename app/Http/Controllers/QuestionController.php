<?php

namespace App\Http\Controllers;

use App\Models\Answer;
use App\Models\Question;
use Illuminate\Http\Request;

class QuestionController extends Controller
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
        //  return $request->all();

        $count = count($request->answer);

        $question = new Question([
            'question' => $request->question
        ]);
        $question->save();

        for($idx=0; $idx < $count; $idx++){
            $answer = new Answer;
            $answer->question_id = $question->id;
            $answer->answer = $request->answer[$idx];
            $answer->is_correct = $request->is_correct[$idx] ? $request->is_correct[$idx] : '0';
            $answer->save();
        }

        return response()->json([
            'isSuccess' => true,
            'message'   => 'Question Created Successfully!',
            'data'      => null
        ], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $quesion = Question::with('answer')->find($id);
        return response()->json([
            'isSuccess' => true,
            'data'      => $quesion
        ], 200);
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
    public function update(Request $request, $id)
    {
        //  return $request->all();
        $count = count($request->answer);

        $question = Question::find($id);
        $question->question = $request->question;
        $question->save();

        for($idx=0; $idx < $count; $idx++){
            $answer = Answer::where('id', $request->ans_id[$idx])
                            ->where('question_id', $question->id)
                            ->update([
                                    'answer' => $request->answer[$idx],
                                    'is_correct' => $request->is_correct[$idx] ? 
                                                    $request->is_correct[$idx] : '0'
                                ]);
        }

        return response()->json([
            'isSuccess' => true,
            'message'   => 'Question update Successfully!',
            'data'      => $question
        ], 200);
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
        if(!is_null($question)){
            $question->delete();
            Answer::where('question_id',$id)->delete();
        }
    }
}
