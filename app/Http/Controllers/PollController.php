<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Poll;
use Illuminate\Support\Facades\Validator;

class PollController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $polls = Poll::all();

        $opinions = DB::select("SELECT p.polloptions_id, po.name, count(*) as PollCount FROM polls p LEFT JOIN polloptions po on po.id = p.polloptions_id GROUP BY p.polloptions_id");

        return view('poll.index', compact('polls','opinions'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $polloptions = DB::table('polloptions')->select('id','name')->get();
        return view('poll.create',compact('polloptions','user_ip'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(),[
                'email'=>'required|email|unique:polls,email',
                'polloptions_id'=> 'required|integer'
            ],
            [
                'email.unique'      => 'Sorry, this email address is already used by another user. Please try with different email',
                'polloptions_id.required' => 'Please select an option',
            ]);

        if ($validator->fails()) {
            $failedRules = $validator->failed();
            if(isset($failedRules['email']['Unique'])) {
                $message = $request->get('email'). " tried to submit again from IP ". $_SERVER['REMOTE_ADDR'];
                $this->logDetail($message);
            }
            return redirect('poll/create')
                ->withErrors($validator)
                ->withInput();
        }

        $poll = new Poll([
            'email' => $request->get('email'),
            'polloptions_id'=> $request->get('polloptions_id')
        ]);
        $poll->save();

        $opinions = DB::select("SELECT po.name FROM polloptions po WHERE po.id =".$request->get('polloptions_id'));
        if(count($opinions) > 0){
            $message = $request->get('email'). " submitted opinion '".$opinions[0]->name."' from IP ". $_SERVER['REMOTE_ADDR'];
            $this->logDetail($message);
        }

        return redirect('/poll')->with('success', 'Thanks for your opinion');
    }

    public function logDetail($message){

        DB::table('logs')->insert(
            array(
                array('description' => $message,'created_at'=>now(),'updated_at'=>now())
            )
        );
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
