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
                        <div class="col-3 text-center my-5">
                            @php
                                if ($member->image) {
                                    $path = asset('storage/' . $member->image);
                                }
                                if (empty($member->image) && $member->gender == 'male') {
                                    $path = asset('img/male.png');
                                }
                                if (empty($member->image) && $member->gender == 'female') {
                                    $path = asset('img/female.jpg');
                                }
                                if (empty($member->image) && $member->gender == 'other') {
                                    $path = asset('img/other.jpg');
                                }
                            @endphp
                            <img src="{{ $path }}" class="mb-2" style="width: 100px;" alt="">
                            <h5>{{ $member->FullNameMemeber }} </h5>
                            <h5>{{ $member->Membercode }}</h5>
                            <p>{{ __('Date of birth') }} : {{ $member->b_date }}</p>

                            <p><a href="{{ route('member.edit', $member) }}" type="button"
                                class="btn btn-info btn-sm">{{ __('Edit') }}</a></p>

                                {{-- @foreach ($member->finances as $f)
                                <p>{{ __('Code: ') }} <a
                                        href="{{ route('finance.show', $f->id) }}">{{ __('Finance') }}</a></a>
                                </p>
                            @endforeach --}}

                         
                              @php
                                 $dollar = '💲';
                                 $rent = $finances
                                 ->where('member_id', $member->id)
                                ->sum('RentPrice');

                                 $delay=$finances
                                 ->where('member_id', $member->id)
                                 ->sum('costLate');
                                 

                                 $paid=$finances
                                 ->where('member_id', $member->id)
                                 ->where('DatePaidCostLate')
                                 ->sum('costLate');

                                 $credit = $delay - $paid;



                              @endphp
                         
                            <p>{{__('Rental cost')}} : {{ $rent}}{{$dollar}} </p> 
                            <p>{{__('Delay cost')}} : {{$delay}}{{$dollar}} </p>
                            <p>{{__('Paid delay cost')}} : {{$delay}}{{$dollar}} </p>
                            <p>{{__('Credit')}}: {{$credit}}{{$dollar}}  </p>
                           
                        </div>
                        <div class="col-9">
                            <div class="card-body">
                                <h5>{{ __('Film rental information') }}</h5>
                                <hr class="mt-0 mb-4">


                                <div class="table-responsive">
                                    <table class="table table-bordered mb-0">
                                        <thead class="">
                                            <tr>
                                                <th>{{ __('Film Name') }}</th>
                                                <th>{{ __('Film Copy') }}</th>
                                                <th>{{ __('Rent date') }}</th>
                                                <th>{{ __('Expected return date') }}</th>
                                                <th>{{ __('Returned') }}</th>
                                                <th>{{ __('Return Date') }}</th>
                                                <th></th>



                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($member->records as $record)
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
                                                <tr>
                                                    <td>
                                                        <a
                                                            href=" {{ route('film.show', ['film' => $record->copy->film->id]) }}
                                            ">{{ $record->copy->film->name }}</a>
                                                    </td>
                                                    <td><a href="{{ route('copy.show', ['copy' => $record->copy->id]) }}">
                                                            {{ $record->copy->code }}</a>
                                                    </td>
                                                    <td>{{ $record->date_take }}</td>
                                                    <td>{{ $record->date_expect_return }}</td>
                                                    <td>{{ $r }}</td>
                                                    <td>{{ $date }}</td>
                                                    <td>
                                                        <div class="btn-group d-grid gap-2 d-md-block" role="group">
                                                       
                                                            <a href="{{ route('record.edit', ['record' => $record->id]) }}"
                                                                type="button" class="btn btn-primary btn-sm"><i
                                                                    class="fa-solid fa-right-left"></i>
                                                                {{ __('Return Film') }}</a>

                                                                @foreach ($member->finances as $f)
                                                                @if ($f->record && $f->record->id === $record->id)
                                                                    
                                                               
                                                                    <a href="{{ route('finance.show', $f->id) }}" type="button"
                                                                        class="btn btn-success btn-sm"><i class="fa-solid fa-dollar-sign"></i>
                                                                        {{ __('Finance') }}</a>
                                                                @endif
                                                                  
                                                            @endforeach
                                                               
                                                        </div>
                                                        
                                                    </td>


                                                </tr>
                                            @endforeach
                                           
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
