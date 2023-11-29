@extends('layouts.app')
@section('content')
        <form action="{{ route('copy.index') }}" method="GET">
            @include('partials._search')
        </form>
        <x-card>
            <div class="row mb-2">
                <div class="col-12">
                    <a type="button" class="btn btn-primary float-end" href="{{ route('copy.create') }}">
                        {{ __('Add new copy') }}
                    </a>
                </div>
            </div>

        <div class="card">
            <div class="card-header">{{ __('Copy of Films') }}</div>
            <div class="card-body text-center">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th scope="col">{{ __('No.') }}</th>
                            {{-- <th>{{ __('ID') }}</th> --}}
                            <th scope="col">{{ __('Film') }}</th>
                            <th scope="col">{{ __('Code') }}</th>
                            <th scope="col">{{ __('Active') }}</th>
                            <th scope="col">{{ __('Status') }}</th>
                            <th scope="col"></th>
                        </tr>
                    </thead>
                    <tbody>

                        @foreach ($copyData as $copy)
                            <tr>
                                <td>{{ ($copyData->currentPage() - 1) * $copyData->perPage() + $loop->iteration }}</td>
                                {{-- <td>{{ $copy->id }}</td> --}}
                                <td>
                                    <a href="{{ route('film.show', ['film' => $copy->film->id]) }}">{{ $copy->film->name}}</a>
                                </td>

                                <td>{{ $copy->code }}</td>
                                <td>{{ $copy->active }}</td>
                                <td>{{ $copy->status }}</td>
                                <td>
                                    <div class="btn-group" role="group">
                                        <form method="POST" action="{{ route('copy.destroy', $copy) }}">
                                            @method('delete')
                                            @csrf
                                           
                                            <a href="{{ route('copy.show', $copy) }}" type="button" class="btn btn-warning btn-sm"><i
                                                    class="fa fa-eye" aria-hidden="true"></i> {{ __('Show') }}</a>
                                            <a href="{{ route('copy.edit', $copy) }}" type="button" class="btn btn-info btn-sm"><i
                                                    class="fa-solid fa-pencil"></i>
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
                {{ $copyData->links() }}

            </div>
        </div>
    </x-card>
@endsection
