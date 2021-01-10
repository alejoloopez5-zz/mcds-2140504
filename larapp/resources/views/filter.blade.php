<div class="col-md-12">
    @foreach ($categories as $category)
        <h3 class="mt-5"> <img src="{{ asset($category->image) }}" width="80px"> </h3>
        <hr>
        <div class="row">
            @forelse ($games as $game)
            @if ($game->category_id == $category->id)
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
                                {{-- {{ $game->description }} --}}
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
            @empty
            <hr>
            <br>
            <div class="alert alert-secondary col-12"> No hay juegos en la categoría seleccionada</div>
            <br>
            @endforelse
        </div>
    @endforeach
</div>
