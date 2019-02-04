<?php

namespace App\Http\Controllers;

use App\User;
use App\Training;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Services\TrainingService;
use Illuminate\Support\Facades\Auth;

class TrainingController extends Controller
{
    private $trainingService;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(TrainingService $trainingService)
    {
        $this->middleware('auth', ['except' => ['index', 'show']]);
        $this->trainingService = $trainingService;
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $trainings = getEvents();
        return view('training.index', compact('trainings'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('training.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $starts_at = Carbon::createFromFormat('d/m/Y H:i', $request['start']);
        $ends_at = Carbon::createFromFormat('d/m/Y H:i', $request['end']);
        $name = $request['name'];
        if($request->hasFile('image')) {
            $image = $request->file('image')->store('public/trainings');
        }
        $description = $request['description'];

        $training = new Training();
        $training->name = $name;
        $training->description = $description;
        $image = str_replace('public', 'storage', $image);
        $author = Auth::user()->name;
        $training->author = $author;
        $training->image = $image;
        $training->starts_at = $starts_at;
        $training->ends_at = $ends_at;
        $training->save();

        return redirect()->route('welcome')->with('status', 'Une nouvelle formation a été créée.');
    }

    public function addUser($training_id, $user_id)
    {
        $training = Training::findOrFail($training_id);
        $user = User::findOrFail($user_id);

        try {
            $user = $this->trainingService->checkIfUserIsAuthor($training, $user);
        } catch(UserIsAuthorException $exception) {
            report($exception);
            return redirect()->route('welcome')->with('status', $exception->getMessage());
        }

        try {
            $user = $this->trainingService->checkIfUserAlreadySubscribed($training, $user);
        } catch(UserIsAlreadySubscribedException $exception) {
            report($exception);
            return redirect()->route('welcome')->with('status', $exception->getMessage());
        }

        $training->users()->attach($user);

        return redirect()->route('welcome')->with('status', 'Votre inscription a bien été prise en compte.');
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
