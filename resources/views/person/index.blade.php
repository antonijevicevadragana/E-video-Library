<!-- @php
    var_dump($data);
@endphp -->

@extends('layouts.app') <!-- ukljucen layaouts-->
@section('content')
    <form action="{{ route('person.index') }}">
        @include('partials._search')
    </form>
    <x-card>
        <div class="row mb-2">
            <div class="col-12">
                <a href="{{ route('person.create') }}" class="btn btn-primary float-end">{{ __('Add new person') }}</a>
            </div>
        </div>



        <div class="card">
            <div class="card-header">{{ __('Directors') }} {{', '}} {{ __('Writers') }} {{__('or/and')}} {{ __('Stars') }}</div>

            <div class="card-body text-center">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th scope="col">{{ __('No.') }}</th>
                            <th scope="col">{{ __('Name') }}</th>
                            <th scope="col">{{ __('Surname') }}</th>
                            <th scope="col">{{ __('Date of birth') }}</th>
                            <th scope="col"></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($data as $person)
                            <!-- $data iz person controlers -->
                            <tr>
                                <td>{{ ($data->currentPage() - 1) * $data->perPage() + $loop->iteration }}</td>
                                <!-- redni broj-->
                                <td>{{ $person->name }}</td>
                                <td>{{ $person->surname }}</td>
                                <td>{{ $person->b_date }}</td>

                                <td>
                                    <div class="btn-group" role="group">
                                        <form method="POST"
                                            action="{{ route('person.destroy', ['person' => $person->id]) }}">
                                            @method('delete')
                                            @csrf

                                            <a href="{{ route('person.show', ['person' => $person->id]) }}" type="button"
                                                class="btn btn-warning btn-sm"><i class="fa fa-eye" aria-hidden="true"></i>
                                                {{ __('Show') }}</a>
                                            <a href="{{ route('person.edit', ['person' => $person->id]) }}" type="button"
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
                {{ $data->links() }} <!-- link za paginaciju -->
            </div>
        </div>
    </x-card>
@endsection
