<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use App\Http\Requests\UserRequest;
use App\Exports\UserExport;
use App\Imports\UserImport;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
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
        //$users = User::all();
        $users = User::paginate(10);
        return view('users.index')->with('users', $users);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('users.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(UserRequest $request)
    {
        //dd($request->all());
        $user = new User;
        $user->fullname  = $request->fullname;
        $user->email     = $request->email;
        $user->phone     = $request->phone;
        $user->birthdate = $request->birthdate;
        $user->gender    = $request->gender;
        $user->address   = $request->address;
        if ($request->hasFile('photo')) {
            $file = time().'.'.$request->photo->extension();
            $request->photo->move(public_path('imgs'), $file);
            $user->photo = 'imgs/'.$file;
        }
        $user->password  = bcrypt($request->password);

        if($user->save()) {
            return redirect('users')->with('message', 'El Usuario: '.$user->fullname.' fue Adicionado con Exito!');
        } 

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        //dd($user);
        return view('users.show')->with('user', $user);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        //dd($user);
        return view('users.edit')->with('user', $user);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(UserRequest $request, User $user)
    {
        //dd($request->all());
        $user->fullname  = $request->fullname;
        $user->email     = $request->email;
        $user->phone     = $request->phone;
        $user->birthdate = $request->birthdate;
        $user->gender    = $request->gender;
        $user->address   = $request->address;
        if ($request->hasFile('photo')) {
            $file = time().'.'.$request->photo->extension();
            $request->photo->move(public_path('imgs'), $file);
            $user->photo = 'imgs/'.$file;
        }

        if($user->save()) {
            return redirect('users')->with('message', 'El Usuario: '.$user->fullname.' fue Modificado con Exito!');
        } 
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        if($user->delete()) {
            return redirect('users')->with('message', 'El Usuario: '.$user->fullname.' fue Eliminado con Exito!');
        } 
    }

    public function pdf() {
        $users = User::all();
        $pdf = \PDF::loadView('users.pdf', compact('users'));
        return $pdf->download('allusers.pdf');
    }

    public function excel() {
        return \Excel::download(new UserExport, 'allusers.xlsx');
    }
    
    public function import(Request $request) {
        $file = $request->file('file');
        \Excel::import(new UserImport, $file);
        return redirect()->back()->with('message', 'Usuarios importados con exito!');
    }

    public function search(Request $request) {
        
        $users = User::names($request->q)->orderBy('id','ASC')->paginate(10);
        return view('users.search')->with('users', $users);
    }

    public function customerupd(User $user) {
        return ('hola');
    }
    
    public function editorinfo(){
                        
        $user = User::find(Auth::user()->id);
        return view('users.editor')->with('user',$user);
                 
    }

    public function editorupd(Request $request, $id)    
    {
        Validator::make($request->all(), [
            'fullname'  => 'required',
            'email'     => 'required|email|unique:users,email,'.$request->id,
            'phone'     => 'required|numeric',
            'birthdate' => 'required|date',
            'gender'    => 'required',
            'address'   => 'required',
            'photo'     => 'max:1000',
            // 'password'  => ['min:6', 'confirmed'],
        ],)->validate();

                
                $user = User::find($id);
                $user->fullname  = $request->fullname;
                $user->email     = $request->email;
                $user->phone     = $request->phone;
                $user->birthdate = $request->birthdate;
                $user->gender    = $request->gender;
                $user->address   = $request->address;
                if ($request->hasFile('photo')) {
                    $file = time().'.'.$request->photo->extension();
                    $request->photo->move(public_path('imgs'), $file);
                    $user->photo = 'imgs/'.$file;
                }
        
                if($request->password){
                    $user->password   = $request->password;
                }
        
                if($user->save()) {                    
                    return redirect('home')->with('message', 'Tu Usuario: '.$user->fullname.' fue Modificado con Exito!');
                } 
    }

}