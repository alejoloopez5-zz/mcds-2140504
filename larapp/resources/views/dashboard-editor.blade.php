@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-md-10 offset-md-1">
            <div class="card">
                <img src="{{ asset('imgs/bg-dashboard.svg') }}" width="300px" class="my-2 img-top-card">
                <div class="card-header text-center">
                    <h4>
                        <i class="fa fa-clipboard-list"></i>
                        @lang('general.title-dashboard') 
                        | 
                        <small>
                            <i class="fas fa-user-edit"></i> Editor
                        </small>
                    </h4>
                </div>

                <div class="card-body row">
                    <div class="col-md-2"></div>
                    {{--  --}}
                        <div class="col-md-4 mt-5">
                        <div class="card">
                                <img src="{{ asset('imgs/bg-users.svg') }}" width="240px" class="my-2 img-top-card" height="154px">
                                <div class="card-body">
                                    <a href="{{ url('editor/info') }}" class="btn btn-block btn-larapp">
                                        <i class="fas fa-user"></i>
                                        Mis Datos
                                    </a>
                                </div>
                            </div>
                        </div>
                        {{--  --}}
                        <div class="col-md-4 mt-5">
                        <div class="card">
                                <img src="{{ asset('imgs/bg-games.svg') }}" width="240px" class="my-2 img-top-card" height="154px">
                                <div class="card-body">
                                    <a href="{{ url('editor/games') }}" class="btn btn-block btn-larapp">
                                        <i class="fas fa-gamepad"></i>
                                        Mis Juegos
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-2"></div>
                        {{--  --}}
                </div>
            </div>
        </div>
    </div>
@endsection
