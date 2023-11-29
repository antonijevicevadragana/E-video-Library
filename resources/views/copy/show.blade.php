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


            <div class="card">
                <div class="row p-2">
                    <div class="col-6">

                        <div class="col-12 mb-3">
                            <h5 class="mb-0">{{ __('Film') }}</h5>
                            <p class="text-muted">
                                <a href="{{ route('film.show', ['film' => $copy->film->id]) }}">{{ $copy->film->name }}</a>
                            </p>
                            <h5 class="mb-0">{{ __('Code') }}</h5>
                            <p class="text-muted">
                                {{ $copy->code }}
                            </p>
                            <h5 class="mb-0">{{ __('Active') }}</h5>
                            <p class="text-muted">
                                {{ $copy->active }}
                            </p>
                        </div>
                        <a href="{{ route('copy.edit', $copy) }}" type="button"
                            class="btn btn-info btn-sm">{{ __('Edit') }}</a>
                    </div>

                    <div class="col-6">


                        @php
                            if ($copy->status == 'Not Available') {
                                $s = 'red';
                            } elseif ($copy->status == 'Available') {
                                $s = 'green';
                            } else {
                                $s = 'grey';
                            }
                            
                        @endphp
                        <h5 class="mb-0">{{ __('Status') . ': ' }} <span class="{{ $s }}">
                                {{ $copy->status }}</span></h5>

                        {{-- vodi na stranicu koja pokazuje ko je zaduzen film -- records.show (tu su svi podaci o zaduzenju) --}}
                        @if ($copy->status == 'Not Available')
                              {{-- @if ($copy->status == 'Not Available')
                            <a href="{{ route('member.show', ['member' => $copy->record->member_id, 'copy_id' => $copy->id]) }}"
                                type="button" class="btn btn-warning btn-sm"><i class="fa fa-eye" aria-hidden="true"></i>
                                {{ __('Show Members') }}</a> --}}

                            {{--  @foreach ($record as $st)
                                <a href="{{ route('member.show', $st->member_id) }}"
                                type="button" class="btn btn-warning btn-sm"><i class="fa fa-eye" aria-hidden="true"></i>
                                {{ __('Show Members') }}</a>
                                 @endforeach
                        @endif --}}

                            @if ($copy->status == 'Not Available')
                                @php $LastMemberId = $record->last()->member_id; @endphp
                                {{-- prikazuje poslednjeg clana kod koga je copija, bez oboga prikazuje sve clanove kod kojih je u nekom momentu bila kopija --}}
                                <a href="{{ route('member.show', $LastMemberId) }}" type="button"
                                    class="btn btn-warning btn-sm">
                                    <i class="fa fa-eye" aria-hidden="true"></i>
                                    {{ __('Show Member') }}</a>
                            @endif  
                        @endif

                        @if ($copy->status == 'Available')
                            <a href="{{ route('record.create', ['copy_id' => $copy->id]) }}
                            "
                                type="button" class="btn btn-info btn-sm"><i class="fa-solid fa-film"></i></i>
                                {{ __('Rent Copy') }}</a>
                        @endif
                    </div>
                </div>
            </div>
        </div>


    </x-card>
@endsection
