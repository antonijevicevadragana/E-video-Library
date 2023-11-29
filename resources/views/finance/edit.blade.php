@extends('layouts.app')
@section('content')
    <x-card>
        <div class="container">
            <div class="row mb-2">
                <div class="card">
                    <div class="row">
                        <div class="col-4 text-center my-5">
                            <p>{{ __('Member name') }} : {{ $finance->member->FullNameMemeber }}</p>
                            <p>{{ __('Film name') }} : {{ $finance->record->copy->film->name }}</p>
                            <p>{{ __('Film code') }} : {{ $finance->record->copy->code }}</p>
                        </div>
                        <div class="col-8">
                            <div class="card-body">
                                <h5>{{ __('Edit Finance - payment of penalty for delay') }}</h5>
                                <hr class="mt-0 mb-4">
                                <form method="POST" action="{{ route('finance.update', $finance) }}">
                                    @csrf
                                    @method('PUT')
                                    <div class="p-2 row">
                                        <div class="btn-group" role="group" aria-label="Basic radio toggle button group">
                                            <p class="col-sm-2 col-form-label">{{ __('Paid') }}</p>
                                            <div class="p-2">
                                                <input type="radio" class="btn-check" name="PaidCostLate" id="yes" value="Yes" checked>
                                                <label class="btn btn-outline-primary" for="yes">{{ __('Yes') }}</label>
                    
                                                <input type="radio" class="btn-check" name="PaidCostLate" id="no" value="No">
                                                <label class="btn btn-outline-primary" for="no">{{ __('No') }}</label>
                    
                                         
                                            </div>
                                        </div>
                                    </div>
                
                                    {{-- DatePaidCostLate --}}

                                    <div class="p-2 row">
                                        <label for="DatePaidCostLate"
                                            class="col-sm-2 col-form-label">{{ __('the date of payment of the late payment penalty ') }}</label>
                                        <div class="col-sm-10">
                                            <input type="date"
                                                class="form-control @error('DatePaidCostLate') is-invalid @enderror"
                                                id="DatePaidCostLate" name="DatePaidCostLate"
                                                value="{{ old('DatePaidCostLate') }}">
                                            @error('DatePaidCostLate')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="row mb-2 float-end">
                                        <div class="col-12">
                                            <button type="submit" class="btn btn-primary">
                                                {{ __('Save') }}
                                            </button>

                                            <a class="btn btn-secondary" href="{{ route('finance.index') }}">
                                                {{ __('Cancel') }}
                                            </a>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>    
                </div>
            </div>
        </div>
    </x-card>
@endsection
