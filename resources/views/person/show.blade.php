@extends('layouts.app')

@section('content')
    <x-card>

        <div class="container p-2">
            <div class="row mb-2">
                <div class="col-12">
                    <a class="btn btn-secondary float-end" href="{{ back()->getTargetUrl() }}">
                        {{ __('Back') }}
                    </a>
                </div>
            </div>
            <div class="row mb-2">
                <div class="card">
                    <div class="row">
                        <div class="col-4 text-center my-5">
                            <p><strong>{{__('Name')}}: </strong> {{ $person->name }}</p>
                            <p><strong>{{__('Surname')}}:</strong> {{ $person->surname }}</p>
                            <p><strong>{{__('Date of birth')}}: </strong> {{ $person->b_date }}</p>
                            <a href="{{ route('person.edit', $person) }}" type="button"
                                class="btn btn-info btn-sm">{{ __('Edit') }}</a>
                        </div>
                        <div class="col-8">
                            <div class="card-body">
                                <h5>{{ __('Information') }}</h5>
                                <hr class="mt-0 mb-4">
                            </div>
                            {{-- Director section --}}
                            <h5 class="mb-0">{{ __('Directors') }}</h5>


                            @if (count($person->directors) == 0)
                                <p>{{ __('No data') }} </p>
                            @else
                                <div class="table-responsive p-2">
                                    <table class="table table-bordered mb-0">
                                        <thead class="">
                                            <tr>
                                                <th>{{ __('Name(Year)') }}</th>
                                                <th>{{ __('Rating') }}</th>
                                                <th></th>

                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($person->directors->sortByDesc('FilmRating') as $w)
                                                <tr>
                                                    <td> <a href="{{ route('film.show', $w) }}">{{ $w->NameYearFilm }}</a>
                                                    </td>
                                                    <td>{{ $w->FilmRating }}</td>
                                                    <td><a href="{{ route('film.show', $w) }}" type="button"
                                                            class="btn btn-warning btn-sm"><i class="fa fa-eye"
                                                                aria-hidden="true"></i> {{ __('Show') }}</a>
                                                    </td>
                                                </tr>
                                               
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            @endif

                            {{-- Writer section --}}
                            <h5 class="mb-0 ">{{ __('Writers') }}</h5>


                            @if (count($person->writers) == 0)
                                <p>{{ __('No data') }} </p>
                            @else
                                <div class="table-responsive p-2">
                                    <table class="table table-bordered mb-0">
                                        <thead class="">
                                            <tr>
                                                <th>{{ __('Name(Year)') }}</th>
                                                <th>{{ __('Rating') }}</th>
                                                <th></th>

                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($person->writers->sortByDesc('FilmRating') as $w)
                                                <tr>
                                                    <td> <a href="{{ route('film.show', $w) }}">{{ $w->NameYearFilm }}</a>
                                                    </td>
                                                    <td>{{ $w->FilmRating }}</td>
                                                    <td><a href="{{ route('film.show', $w) }}" type="button"
                                                            class="btn btn-warning btn-sm"><i class="fa fa-eye"
                                                                aria-hidden="true"></i> {{ __('Show') }}</a>
                                                    </td>
                                                </tr>
                                               
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            @endif

                            {{-- Stars section --}}
                            <h5 class="mb-0">{{ __('Stars') }}</h5>


                            @if (count($person->stars) == 0)
                                <p>{{ __('No data') }} </p>
                            @else
                                <div class="table-responsive p-2">
                                    <table class="table table-bordered mb-0">
                                        <thead class="">
                                            <tr>
                                                <th>{{ __('Name(Year)') }}</th>
                                                <th>{{ __('Rating') }}</th>
                                                <th></th>

                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($person->stars->sortByDesc('FilmRating') as $w)
                                                <tr>
                                                    <td> <a href="{{ route('film.show', $w) }}">{{ $w->NameYearFilm }}</a>
                                                    </td>
                                                    <td>{{ $w->FilmRating }}</td>
                                                    <td><a href="{{ route('film.show', $w) }}" type="button"
                                                            class="btn btn-warning btn-sm"><i class="fa fa-eye"
                                                                aria-hidden="true"></i> {{ __('Show') }}</a>
                                                    </td>
                                                </tr>
                                                
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            @endif



                        </div>
                    </div>
                </div>
            </div>
        </div>
    </x-card>
@endsection
