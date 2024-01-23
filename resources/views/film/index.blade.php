@extends('layouts.app')

@section('content')
    {{-- <div class="bg-image p-5 text-center shadow-1-strong rounded mb-5 text-light backcontent"
    style="background-image: url('{{ asset('img/ImgBg.jpg') }}');"> --}}

    <form action="{{ route('film.index') }}">
        @include('partials._search')
    </form>

    <x-card>
        <div class="row mb-2">
            <div class="col-12">
                <a type="button" class="btn btn-primary float-end" href="{{ route('film.create') }}">
                    {{ __('Add new film') }}
                </a>
            </div>
        </div>
        <div>
            <p class="red large">{{ $msg }}</p>
        </div>
        <div class="col-12">
            <div class="card">
                <div class="table-responsive">
                    <table class="table table-bordered mb-0">
                        <thead class="">
                            <tr>
                                <th>{{ __('No.') }}</th>
                                <th>{{ __('Image') }}</th>
                                <th>{{ __('Name') }}</th>
                                <th>{{ __('Running time') }}</th>
                                <th>{{ __('Year') }}</th>
                                <th>{{ __('Rating') }}</th>
                                <th>{{ __('Genres') }}</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($datas as $film)
                                <tr>
                                    {{-- <th scope="row">{{ $loop->iteration }}</th> --}}
                                    <th>{{ ($datas->currentPage() - 1) * $datas->perPage() + $loop->iteration }}</th>
                                    <td><img src="{{ $film->imgSrc }}" alt="{{ $film->name }}" class="mb-2"
                                            style="width: 100px;" /></td>
                                    <td><a href="{{ route('film.show', $film) }}">{{ $film->name }}</a>

                                        <p class="m-0"><strong>{{ __('Directors') }}:</strong>
                                            @foreach ($film->directors as $p)
                                                <a href="{{ route('person.show', $p) }}">{{ $p->full_name }}</a>
                                            @endforeach
                                        </p>

                                        <p class="m-0"><strong>{{ __('Writers') }}:</strong>
                                            @foreach ($film->writers as $p)
                                                <a href="{{ route('person.show', $p) }}">{{ $p->full_name }}</a>
                                            @endforeach
                                        </p>

                                        <p class="m-0"><strong>{{ __('Stars') }}:</strong>
                                            @foreach ($film->stars as $p)
                                                <a href="{{ route('person.show', $p) }}">{{ $p->full_name }}</a>
                                            @endforeach
                                        </p>

                                    </td>
                                    <td>{{ $film->running_time }}</td>
                                    <td>{{ $film->year }}</td>
                                    <td>{{ $film->rating }}</td>
                                    <td>
                                        @foreach ($film->genres as $g)
                                            {{ $g->name }}
                                        @endforeach
                                    </td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            <form method="post" action="{{ route('film.destroy', $film) }}">
                                                @method('delete')
                                                @csrf
                                                <a href="{{ route('film.show', $film) }}" type="button"
                                                    class="btn btn-warning btn-sm"><i class="fa fa-eye"
                                                        aria-hidden="true"></i> {{ __('Show') }}</a>

                                                <a href="{{ route('film.edit', $film) }}" type="button"
                                                    class="btn btn-info btn-sm"><i class="fa-solid fa-pencil"></i>
                                                    {{ __('Edit') }}</a>
                                                <button type="submit" class="btn btn-danger btn-sm delete-button"><i
                                                        class="fa-solid fa-trash"></i> {{ __('Delete') }}</button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    {{ $datas->links() }}

                </div>
            </div>
    </x-card>
    <br>
@endsection
