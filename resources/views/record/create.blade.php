@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="card">
            <div class="card-header">{{ __('Add') . ': ' . __('Record') }}</div>
            {{ $copy_id }}
            <div class="card-body">
                <form method="POST" action="{{ route('record.store') }}">
                    @csrf
                    <div>
                        {{-- <label for="copy_id">{{ __('Copy code') }}:</label> --}}
                        <input type="hidden" name="copy_id" value="{{ $copy_id }}">
                        
                    </div>
                    <div class="p-2">
                        <label for="film_id">{{ __('Member select menu') }}:</label>
                        <select class="form-select @error('member_id') is-invalid @enderror"
                            aria-label="Default select example" name="member_id">
                            <option value="">--</option>
                            @foreach ($member as $m)
                                <option name="member_id" id="idMember{{ $m->id }}" value="{{ $m->id }}">
                                    {{ $m->NameCodeMemeber }}</option>
                            @endforeach
                        </select>
                        @error('member_id')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="p-2 row">
                        <label for="date_take" class="col-sm-2 col-form-label">{{ __('Rent Date') }}</label>
                        <div class="col-sm-10">
                            <input type="date" class="form-control @error('date_take') is-invalid @enderror"
                                id="date_take" name="date_take" value="{{ old('date_take') }}">
                            @error('date_take')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                   

                    <div class="mb-3 row">
                        <label for="RentPrice" class="col-sm-2 col-form-label">{{__('Rent Price')}}</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control @error('RentPrice') is-invalid @enderror" id="RentPrice" name="RentPrice" value="{{ old('RentPrice') }}">
                            @error('RentPrice')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>

                    <div class="mb-3 row float-end">
                        <div class="col-12">
                            <button type="submit" class="btn btn-primary">
                                {{ __('Save') }}
                            </button>
                            <a href="{{route('copy.index')}}" class="btn btn-secondary">{{ __('Cancel') }}</a>
                        </div>
                    </div>

                </form>
            </div>
        @endsection
