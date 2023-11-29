@extends('layouts.app')
@section('content')
    <form action="{{ route('genre.index') }}">
        @include('partials._search')
    </form>
    <x-card>

        <div class="row mb-2">
            <div class="col-12">
                <a href="{{ route('genre.create') }}" class="btn btn-primary float-end">{{ __('Add new genre') }}</a>
            </div>
        </div>
        <div class="card">
            <div class="card-header">{{ __('Genres') }}</div>
            <div class="card-body text-center">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th scope="col">{{ __('No.') }}</th>
                            <th scope="col">{{ __('Name EN') }}</th>
                            <th scope="col">{{ __('Name SR') }}</th>
                            <th scope="col"></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($data as $g)
                            <tr>
                                <td>{{ ($data->currentPage() - 1) * $data->perPage() + $loop->iteration }}</td>
                                <td>{{ $g->name_en }}</td>
                                <td>{{ $g->name_sr }}</td>
                                <td>
                                    <div class="btn-group" role="group">
                                        <form method="POST" action="{{ route('genre.destroy', ['genre' => $g->id]) }}">
                                            @method('delete')
                                            @csrf
                                            <a href="{{ route('genre.edit', ['genre' => $g->id]) }}" type="button"
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
                {{ $data->links() }}

            </div>
        </div>
    </x-card>
@endsection
