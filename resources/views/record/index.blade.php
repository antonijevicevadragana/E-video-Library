@extends('layouts.app')

@section('content')
{{-- <div class="bg-image p-5 text-center shadow-1-strong rounded mb-5 text-light backcontent"
    style="background-image: url('{{ asset('img/ImgBg.jpg') }}');"> --}}

    <form action="{{ route('record.index') }}">
        @include('partials._search')
       
        
    </form>

    
    <x-card>
        <div class="row mb-2">
            <div class="col-12">
                <a type="button" class="btn btn-primary float-end" href="{{ route('copy.index') }}">
                    {{ __('Go to copy to add new record') }}
                </a>
            </div>
        </div>

        <div class="col-12">
            <div class="card">
                <div class="table-responsive">
                    <table class="table table-bordered mb-0">
                        <thead class="">
                            <tr>
                                <th>{{__('No.')}}</th>
                                <th>{{ __('Copy code') }}</th>
                                 <th>{{ __('Film') }}</th>
                                <th>{{ __('Member') }}</th>
                                <th>{{ __('Date of rent') }}</th>
                                <th>{{ __('Ecpected day to return') }}</th>
                                <th>{{ __('Returned') }}</th>
                                <th>{{ __('Return date') }}</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ( $dataRecord as $data)
                                <tr>
                                    {{-- <th scope="row">{{ $loop->iteration }}</th> --}}
                                    <th>{{ ($dataRecord->currentPage() - 1) * $dataRecord->perPage() + $loop->iteration }}</th>

                                 <td><a href="{{ route('copy.show', ['copy' => $data->copy->id]) }}">{{ $data->copy->code }}</a></td>
                                 {{-- records preko copies prisupa imenu filma --}}
                                 <td><a href="{{ route('film.show', ['film' => $data->copy->film->id]) }}">{{ $data->copy->film->name }}</a></td> 
                                    <td><a href="{{ route('member.show', ['member' => $data->member_id]) }}">{{ $data->member->FullNameMemeber }}</a></td> 
                                    <td>{{ $data->date_take }}</td>
                                    <td>{{ $data->date_expect_return }}</td>
                                    <td>{{ $data->returned }}</td>
                                    <td>{{ $data->returnDate }}</td>
                                    
                                    <td>
                                        <div class="btn-group" role="group">
                                            <form method="post" action="
                                            {{route('record.destroy', $data)}}
                                            ">
                                                @method('delete')
                                                @csrf
                                                <a href=" {{route('record.show', $data)}} " type="button"
                                                class="btn btn-warning btn-sm"><i class="fa fa-eye" aria-hidden="true"></i> {{ __('Show') }}</a>

                                                <a href="{{route('record.edit', $data)}}" type="button"
                                                    class="btn btn-info btn-sm"><i class="fa-solid fa-pencil"></i> {{ __('Edit') }}</a>
                                                <button type="submit"
                                                    class="btn btn-danger btn-sm delete-button"><i class="fa-solid fa-trash"></i> {{ __('Delete') }}</button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    {{ $dataRecord->links() }}

                </div>
            </div>
    </x-card>

  <br>
{{-- </div> --}}
@endsection