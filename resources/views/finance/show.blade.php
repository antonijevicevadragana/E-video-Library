@extends('layouts.app')

@section('content')
    <x-card>
        <div class="container">
            <div class="row mb-2">
                <div class="col-12">
                    {{-- <a class="btn btn-secondary float-end" href="{{ route('finance.index') }}">
                        {{ __('Back') }}
                    </a> --}}
                    <a class="btn btn-secondary float-end" href="{{ back()->getTargetUrl() }}">
                        {{ __('Back') }}
                    </a>
                </div>
            </div>
            <div class="row mb-2">
                <div class="card">
                    <div class="row">
                        <div class="col-4 text-center my-5">

                            <h5><a
                                    href="{{ route('member.show', ['member' => $finance->member_id]) }}">{{ $finance->member->FullNameMemeber }}</a>
                            </h5>
                            <h5>{{ $finance->member->Membercode }}</h5>
                            <hr>
                            @if ($finance->record->id == $finance->record_id)
                                <p><strong>{{ __('Name') }}:</strong>
                                    <a
                                        href="{{ route('film.show', ['film' => $finance->record->copy->film->id]) }}">{{ $finance->record->copy->film->name }}</a>
                                </p>
                                <p><strong>{{ __('Code') }}:</strong>
                                    <a
                                        href="{{ route('copy.show', ['copy' => $finance->record->copy->id]) }}">{{ $finance->record->copy->code }}</a>
                                </p>

                                @if ($finance->deleyInDays < 0 && $finance->DatePaidCostLate === null)
                                    <a href="{{ route('finance.edit', $finance) }}" type="button"
                                        class="btn btn-info btn-sm">{{ __('Pay delay') }}</a>
                                @elseif($finance->deleyInDays < 0 && $finance->DatePaidCostLate !== null)
                                    <p class="green">{{ __('Bravo, You paid delay') }}</p>
                                @elseif($finance->deleyInDays > 0)
                                    <p class="green">{{ __("Bravo, You don't have delay") }}</p>
                                @endif
                            @endif

                        </div>
                        <div class="col-8">
                            <div class="card-body">
                                <h5>{{ __('Finances information') }}</h5>
                                <hr class="mt-0 mb-4">


                                <div class="table-responsive">
                                    <table class="table table-bordered mb-0">
                                        <thead class="">
                                            <tr>

                                                <th>{{ __('Date of rent') }}</th>
                                                <th>{{ __('Rent price') }}</th>
                                                <th>{{ __('Rent payment date') }}</th>

                                                <th>{{ __('Expected day to return') }}</th>
                                                <th>{{ __('Returned') }}</th>
                                                <th>{{ __('Return date') }}</th>

                                                <th>{{ __('Delay in days') }}</th>
                                                <th>{{ __('Cost of delay') }}</th>
                                                <th>{{ __('Paid Cost of delay') }}</th>
                                                <th>{{ __('Cost of delay payment date') }}</th>

                                            </tr>
                                        </thead>
                                        <tbody>
                                            @if ($finance->record->id == $finance->record_id)
                                                @php
                                                    if ($finance->record->returned == 'No') {
                                                        $r = '❌';
                                                    } elseif ($finance->record->returned == 'Yes') {
                                                        $r = '✔️';
                                                    }
                                                    
                                                    if ($finance->record->returnDate == null) {
                                                        $date = '❌';
                                                    } else {
                                                        $date = $finance->record->returnDate;
                                                    }
                                                    
                                                    if ($finance->deleyInDays < 0) {
                                                        $deley = abs($finance->deleyInDays);
                                                    } elseif ($finance->deleyInDays == null) {
                                                        $deley = '';
                                                    } else {
                                                        $deley = 'No delay';
                                                    }
                                                    $dollar = '💲';
                                                @endphp
                                                <tr>

                                                    <td>{{ $finance->record->date_take }}</td>
                                                    <td>{{ $finance->RentPrice }} {{ $dollar }}</td>
                                                    <td>{{ $finance->DatePaidRentPrice }}</td>

                                                    <td>{{ $finance->record->date_expect_return }}</td>
                                                    <td>{{ $r }}</td>
                                                    <td>{{ $date }}</td>

                                                    {{-- <td>{{$finance->deleyInDays}}</td> --}}
                                                    <td>{{ $deley }}</td>
                                                    <td>{{ $finance->costLate }}</td>
                                                    <td>{{ $finance->PaidCostLate }}</td>
                                                    <td>{{ $finance->DatePaidCostLate }}</td>
                                                </tr>
                                            @endif
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
