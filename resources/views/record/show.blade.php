@extends('layouts.app')

@section('content')
    <x-card>
        <div class="container">
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
                            @php
                                if ($record->member->image) {
                                    $path = asset('storage/' . $record->member->image);
                                }
                                if (empty($record->member->image) && $record->member->gender == 'male') {
                                    $path = asset('img/male.png');
                                }
                                if (empty($record->member->image) && $record->member->gender == 'female') {
                                    $path = asset('img/female.jpg');
                                }
                                if (empty($record->member->image) && $record->member->gender == 'other') {
                                    $path = asset('img/other.jpg');
                                }
                            @endphp
                            <img src="{{ $path }}" class="mb-2" style="width: 100px;" alt="">

                            <h5>{{ $record->member->FullNameMemeber }} </h5>
                            <h5>{{ $record->member->Membercode }}</h5>
                            <a href="{{ route('member.show', ['member' => $record->member_id]) }}" type="button"
                                class="btn btn-info btn-sm">{{ __('Go to Member') }}</a>
                        </div>
                        <div class="col-8">
                            <div class="card-body">
                                <h5>{{ __('Film rental information') }}</h5>
                                <hr class="mt-0 mb-4">
                                <div class="table-responsive">
                                    <table class="table table-bordered mb-0">
                                        <thead class="">
                                            <tr>
                                                <th>{{ __('Film') }}</th>
                                                <th>{{ __('Code') }}</th>
                                                <th>{{ __('Date of rent') }}</th>
                                                <th>{{ __('	Ecpected day to return') }}</th>
                                                <th>{{ __('Returned') }}</th>
                                                <th>{{ __('Return date') }}</th>
                                                <th></th>


                                            </tr>
                                        </thead>
                                        <tbody>

                                            <tr>
                                                <td>
                                                    @php
                                                        if ($record->returned == 'No') {
                                                            $r = '❌';
                                                        } elseif ($record->returned == 'Yes') {
                                                            $r = '✔️';
                                                        }
                                                        
                                                        if ($record->returnDate == null) {
                                                            $date = '❌';
                                                        } else {
                                                            $date = $record->returnDate;
                                                        }
                                                    @endphp
                                                    <a
                                                        href=" {{ route('film.show', ['film' => $record->copy->film->id]) }}
                                            ">{{ $record->copy->film->name }}</a>
                                                </td>
                                                <td><a href="{{ route('copy.show', ['copy' => $record->copy_id]) }}">
                                                        {{ $record->copy->code }}</a>
                                                </td>
                                                <td>{{ $record->date_take }}</td>
                                                <td>{{ $record->date_expect_return }}</td>
                                                <td>{{ $r }}</td>
                                                <td> {{ $date }}</td>
                                                <td> <a href="{{ route('record.edit', ['record' => $record->id]) }}"
                                                        type="button" class="btn btn-primary btn-sm"><i
                                                            class="fa-solid fa-right-left"></i>
                                                        {{ __('Edit record') }}</a></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </x-card>
@endsection
