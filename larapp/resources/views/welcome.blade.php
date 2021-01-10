@extends('layouts.app') 
@section('title', 'LARAPP - Página de Bienvenida')

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-12">
            <h3> <i class="fas fa-tag"></i> Juegos Importantes</h3>
            <hr>
            <div class="owl-carousel owl-theme">
                @foreach ($sliders as $slider)
                    <div class="slider" style="background-image: url({{ asset($slider->image) }})">
                        <p>
                            {{ $slider->description }}
                        </p>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
    {{--  --}}
    <div class="row mt-4">
        <div class="col-md-12">
             <h3> <i class="fas fa-filter"></i> Filtrar Juegos por Categoría</h3>
            <hr>
        </div>
    </div>
    <div class="row">
        <div class="col-md-4 offset-md-4">
            <div class="form-group">
                <select name="categoria" id="categoria" class="form-control">                    
                    <option value="-2">Seleccione...</option>
                    <option value="-1">Todos</option>
                    @foreach ($cats as $cat)
                        <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                    @endforeach
                </select>
            </div>
        </div>
    </div>
    <br>
    <div class="loader d-none text-center mt-5">
        <img src="{{ asset('imgs/loader.gif')}}" width="100px">
    </div>
    <br><br>
    {{--  --}}
    <div class="row justify-content-center" id="list-filter">
        <div class="col-md-12">
            @foreach ($cats as $cat)
                <h3 class="mt-5"> <img src="{{ asset($cat->image) }}" width="80px"> </h3>
                <hr>
                <div class="row" id="list-games">
                @foreach ($games as $game)
                    @if ($game->category_id == $cat->id)
                    <div class="col-md-4 mb-4">
                        <div class="card mb-3" style="max-width: 540px; min-height: 194px;">
                          <div class="row no-gutters">
                            <div class="col-md-4">
                              {{-- <img src="{{ asset($game->image) }}" class="card-img"> --}}
                              <figure class="img-fcard" style="background-image: url({{ asset($game->image)  }});"></figure>
                            </div>
                            <div class="col-md-8">
                              <div class="card-body">
                                <h5 class="card-title">{{ $game->name }}</h5>
                                <p class="card-text">
                                    {{ $game->description }}
                                </p>
                                <p class="card-text">
                                    @php
                                        $td = \Carbon\Carbon::now();
                                        $dt = \Carbon\Carbon::parse($game->created_at);
                                    @endphp
                                    <small class="text-muted">
                                        <strong>Creado hace:</strong> {{ $td->diffForHumans($dt, 1) }}
                                    </small>
                                </p>
                                <a href="javascript:;" class="btn btn-larapp btn-block">
                                    <i class="fas fa-search-plus"></i>
                                </a>
                              </div>
                            </div>
                          </div>
                        </div>
                    </div>
                    @endif
                @endforeach
                </div>
            @endforeach
        </div>
    </div>
@endsection