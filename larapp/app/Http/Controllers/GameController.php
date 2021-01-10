<?php

namespace App\Http\Controllers;

use App\Game;
use App\User;
use App\Category;
use Illuminate\Http\Request;
use App\Http\Requests\GameRequest;
use App\Exports\GameExport;
use App\Imports\GameImport;
use Illuminate\Support\Facades\Auth;

class GameController extends Controller
{

    public function __construct() 
    {
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $games = Game::paginate(10);
        return view('games.index')->with('games', $games);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $users = User::where('role','Admin')                       
                       ->orWhere('role','Editor')
                       ->get();
        $cats  = Category::all();
        return view('games.create')->with('users', $users)
                                   ->with('cats', $cats);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(GameRequest $request)
    {
        //dd($request->all());
        $game = new Game;
        $game->name        = $request->name;
        $game->description = $request->description;
        if ($request->hasFile('image')) {
            $file = time().'.'.$request->image->extension();
            $request->image->move(public_path('imgs'), $file);
            $game->image = 'imgs/'.$file;
        }
        $game->user_id      = $request->user_id;
       
        $game->category_id  = $request->category_id;
        if($game->slider == 2) {
            $game->slider = 0;
        } else {
            $game->slider = $request->slider;
        }
        $game->price      = $request->price;

        if($game->save()) {
            return redirect('games')->with('message', 'El Juego: '.$game->name.' fue Adicionado con Exito!');
        } 
    }
    /**
     * Display the specified resource.
     *
     * @param  \App\Game  $game
     * @return \Illuminate\Http\Response
     */
    public function show(Game $game)
    {
        return view('games.show')->with('game',$game);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Game  $game
     * @return \Illuminate\Http\Response
     */
    public function edit(Game $game)
    {
        $users = User::where('role', 'Admin')->get();
        $cats  = Category::all();
        return view('games.edit')->with('users', $users)
                                 ->with('cats', $cats)
                                 ->with('game', $game);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Game  $game
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Game $game)
    {        
        $game->name        = $request->name;
        $game->description = $request->description;
        if ($request->hasFile('image')) {
            $file = time().'.'.$request->image->extension();
            $request->image->move(public_path('imgs'), $file);
            $game->image = 'imgs/'.$file;
        }
        $game->user_id      = $request->user_id;
       
        $game->category_id  = $request->category_id;
        if($game->slider == 2) {
            $game->slider = 0;
        } else {
            $game->slider = $request->slider;
        }
        $game->price      = $request->price;

        if($game->save()) {
            return redirect('games')->with('message', 'El Juego: '.$game->name.' fue Adicionado con Exito!');
        } 
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Game  $game
     * @return \Illuminate\Http\Response
     */
    public function destroy(Game $game)
    {
        if($game->delete()) {
            return redirect('games')->with('message', 'El Juego: '.$game->name.' fue Eliminado con Exito!');
        } 
    }

    public function pdf() {
        $games = Game::all();
        $pdf = \PDF::loadView('games.pdf', compact('games'));
        return $pdf->download('allgames.pdf');
    }

    public function excel() {
        return \Excel::download(new GameExport, 'allgames.xlsx');
    }

    public function import(Request $request) {
        $file = $request->file('file');
        \Excel::import(new GameImport, $file);
        return redirect()->back()->with('message', 'juegos importados con exito!');
    }

    public function search(Request $request) {
        
        $games = Game::names($request->q)->orderBy('id','ASC')->paginate(10);
        return view('games.search')->with('games', $games);
    }

    public function editorgames(){
        $games = Game::where('user_id',Auth::user()->id)->paginate(10);
        return view('games.indexEditor')->with('games', $games);
    }
}
