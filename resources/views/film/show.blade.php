@extends('layouts.app')

@section('content')
    <x-card>
        <div class="container">
            <div class="row mb-2">
                <div class="col-12">
                    <a class="btn btn-secondary float-end" href= "{{ route('film.index') }}">
                        {{ __('Back') }}
                    </a>
                </div>
            </div>
            <div class="row mb-2">
                <div class="card">
                    <div class="row">
                        <div class="col-4 text-center my-5">
                            <img src="{{ $film->imgSrc }}" alt="{{ $film->name }}" class="mb-2" style="width: 100px;" />
                            <h5>{{ $film->name }}</h5>
                            <p class="text-muted">{{ $film->year }}</p>
                            <p>

                                @php
                                    $count = $copy->where('film_id', $film->id)->count();
                                @endphp
                                {{ __('Total copy') . ': ' . $count }}
                            </p>
                            <p>

                                @php
                                    $statusYes = $copy
                                        ->where('film_id', $film->id)
                                        ->where('active', 'Yes')
                                        ->count();
                                    $statusNo = $copy
                                        ->where('film_id', $film->id)
                                        ->where('active', 'No')
                                        ->count();
                                    $Available = $copy
                                        ->where('film_id', $film->id)
                                        ->where('status', 'Available')
                                        ->count();
                                    $st = $copy
                                        ->where('film_id', $film->id)
                                        ->where('status', 'Available')
                                        ->first();
                                    // $status= $copy->where('film_id', $film->id)->where('status', 'Available')->get();
                                @endphp
                                {{ __('Active(Yes)') . ': ' . $statusYes . ' | ' . __('Active(No)') . ': ' . $statusNo }}
                            </p>

                            {{-- <p>{{__('Number of rented copies')}}</p> --}}
                            <p>{{ __('Number of Available copies to rent') . ':' }} {{ $Available }}</p>

                            <a href="{{ route('film.edit', $film) }}" type="button"
                                class="btn btn-info btn-sm">{{ __('Edit') }}</a>
                        </div>
                        <div class="col-8">
                            <div class="card-body">
                                <h5>{{ __('Information') }}</h5>
                                <hr class="mt-0 mb-4">
                                <div class="row">
                                    <div class="col-6 mb-3">
                                        <h6>{{ __('Rating') }}</h6>
                                        <p class="text-muted">{{ $film->rating }}</p>

                                    </div>
                                    <div class="col-6 mb-3">
                                        <h6>{{ __('Running time') }}</h6>
                                        <p class="text-muted">{{ $film->running_time }}</p>

                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-6 mb-3">
                                        <p class="mb-0">{{ __('Directors') }}</p>
                                        <p class="text-muted">
                                            @foreach ($film->directors as $w)
                                                <a href="{{ route('person.show', $w) }}">{{ $w->full_name }}</a><br>
                                            @endforeach
                                        </p>

                                        <p class="mb-0">{{ __('Writers') }}</p>
                                        <p class="text-muted">
                                            @foreach ($film->writers as $w)
                                                <a href="{{ route('person.show', $w) }}">{{ $w->full_name }}</a><br>
                                            @endforeach
                                        </p>

                                        <p class="mb-0">{{ __('Stars') }}</p>
                                        <p class="text-muted">
                                            @foreach ($film->stars as $w)
                                                {{-- {{  $w->full_name}} --}}
                                                <a href="{{ route('person.show', $w) }}">{{ $w->full_name }}</a><br>
                                            @endforeach
                                        </p>
                                    </div>

                                    <div class="col-6 mb-3">
                                        <p>{{ __('Available copy code') }}</p>
                                        {{-- status je prosledjen preko kontrolera u show f-ji --}}
                                        @foreach ($status as $st)
                                            <p>{{ __('Code: ') }} <a
                                                    href="{{ route('copy.show', $st) }}">{{ $st->code }}</a></p>
                                        @endforeach
                                        {{-- iz film pristupa copies preko modela i ovako dobijamo sve kopije
                                         {{-- @foreach ($film->copies as $copy) 
                                            <p>{{ __('Code: ') }} <a
                                                    href="{{ route('copy.show', $copy) }}">{{ $copy->code }}</a></p>
                                        @endforeach --}}

                                    </div>

                                    <h5>{{ __('Genres') }}</h5>
                                    <hr class="mt-0 mb-4">
                                    <div class="row">
                                        <div class="col-12 mb-3">
                                            <p class="text-muted">
                                                @foreach ($film->genres->sortBy('name') as $g)
                                                    {{ $g->name }}
                                                @endforeach
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </x-card>
@endsection
