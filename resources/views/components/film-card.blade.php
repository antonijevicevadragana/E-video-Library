@props(['film'])
{{-- <div class="col">
    <div class="card">
      <div class="card-body">
        <img src="{{ $datas->imgSrc }}" alt="{{ $datas->name }}" class="mb-2"
        style="width: 100px;" />

        <h4 class="card-title"><a href="{{ route('film.show', $datas) }}">{{ $datas->name }}</a></h4>
 
        <p class="m-0"><strong>{{ __('Directors') }}:</strong>
            @foreach ($datas->directors as $p)
                {{ $p->full_name }}
            @endforeach
        </p>

        <p class="m-0"><strong>{{ __('Writers') }}:</strong>
            @foreach ($datas->writers as $p)
                {{ $p->full_name }}
            @endforeach
        </p>

        <p class="m-0"><strong>{{ __('Stars') }}:</strong>
            @foreach ($datas->stars as $p)
                {{ $p->full_name }}
            @endforeach
        </p>

        <p>{{ $datas->running_time }}</p>
        <p>{{ $datas->year }}</p>
        <p>{{ $datas->rating }}</p>
        <p>
            @foreach ($datas->genres as $g)
                {{ $g->name }}
            @endforeach
        </p>
      </div>
    </div>
   
</div> --}}
<div class="col">
    <div class="card">
      <div class="card-body">
        <img src="{{ $film->imgSrc }}" alt="{{ $film->name }}" class="mb-2"
        style="width: 100px;" />

        <h4 class="card-title"><a href="{{ route('film.show', $film) }}">{{ $film->name }}</a></h4>
 
        <p class="m-0"><strong>{{ __('Directors') }}:</strong>
            @foreach ($film->directors as $p)
                {{ $p->full_name }}
            @endforeach
        </p>

        <p class="m-0"><strong>{{ __('Writers') }}:</strong>
            @foreach ($film->writers as $p)
                {{ $p->full_name }}
            @endforeach
        </p>

        <p class="m-0"><strong>{{ __('Stars') }}:</strong>
            @foreach ($film->stars as $p)
                {{ $p->full_name }}
            @endforeach
        </p>

        <p>{{ $film->running_time }}</p>
        <p>{{ $film->year }}</p>
        <p>{{ $film->rating }}</p>
        <p>
            @foreach ($film->genres as $g)
                {{ $g->name }}
            @endforeach
        </p>
      </div>
    </div>
   
</div>