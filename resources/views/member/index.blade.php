@extends('layouts.app')
@section('content')
   
       
        <form action="{{ route('member.index') }}">
            @include('partials._search')
    
        </form>
        <x-card>
            <div class="row mb-2">
                <div class="col-12">
                    <a type="button" class="btn btn-primary float-end" href="{{ route('member.create') }}">
                        {{ __('Add new member') }}
                    </a>
                </div>
            </div>

        <div class="card">
            <div class="card-header">{{ __('Members') }}</div>
            <div class="card-body text-center">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th scope="col">{{ __('No.') }}</th>
                            <th>{{ __('Gender') }}</th>
                            <th scope="col">{{ __('Full name') }}</th>
                            <th scope="col">{{ __('Code') }}</th>
                            <th scope="col">{{ __('Date of birth') }}</th>
                          
                            <th scope="col"></th>
                        </tr>
                    </thead>
                    <tbody>

                        @foreach ($dataMember as $member)
                            <tr>
                                <td>{{ ($dataMember->currentPage() - 1) * $dataMember->perPage() + $loop->iteration }}</td>
                                {{-- <td>{{ $copy->id }}</td> --}}

                                <td>{{ $member->gender}}</td>
                                <td>{{ $member->FullNameMemeber}}</td>
                                <td>{{ $member->Membercode }}</td>
                                <td>{{ $member->b_date }}</td>
                              
                                <td>
                                    <div class="btn-group" role="group">
                                        <form method="POST" action="{{ route('member.destroy', $member) }}">
                                            @method('delete')
                                            @csrf
                                           
                                            <a href="{{ route('member.show', $member) }}" type="button" class="btn btn-warning btn-sm"><i
                                                    class="fa fa-eye" aria-hidden="true"></i> {{ __('Show') }}</a>
                                            <a href="{{ route('member.edit', $member) }}" type="button" class="btn btn-info btn-sm"><i
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
                {{ $dataMember->links() }}

            </div>
        </div>
    </x-card>
@endsection
