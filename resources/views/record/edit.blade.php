@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="card">
            <div class="card-header">{{ __('Add') . ': ' . __('Record') }}</div>
            {{ $copy_id }}
            <div class="card-body">
                <form method="POST" action="{{ route('record.update', ['record'=>$record->id]) }}">
                    @method('PUT')
                    @csrf
                    <div>
                        <input type="hidden" name="copy_id" value="{{ $copy_id }}">
                        
                    </div>
                        {{-- SELECT member --}}
                    <div class="p-2">
                        <label for="film_id">{{ __('Member select menu') }}:</label>
                        <select class="form-select @error('member_id') is-invalid @enderror"
                            aria-label="Default select example" name="member_id">
                            <option value="">--</option>

                            @foreach ($member as $p)
                            <option id="idFilm{{ $p->id }}" value="{{ $p->id }}" @if ($record->member_id === $p->id || old('member_id') === $p->id) selected @endif>
                                {{ $p->NameCodeMemeber }}</option>
                    @endforeach
                        </select>
                        @error('member_id')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    {{-- RENT DATE --}}

                    <div class="p-2 row">
                        <label for="date_take" class="col-sm-2 col-form-label">{{ __('Rent Date') }}</label>
                        <div class="col-sm-10">
                            <input type="date" class="form-control @error('date_take') is-invalid @enderror"
                                id="date_take" name="date_take" value="{{ old('date_take', $record->date_take) }}">
                            @error('date_take')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                  
                        {{-- Returned radio button --}}
                    <div class="p-2">
                        <div class="btn-group" role="group" aria-label="Basic radio toggle button group">
                            <p class="p-2">{{ __('Returned') }}</p>
                            <input type="radio" class="btn-check" name="returned" id="yes" value="Yes"
                                {{ old('returned', $record->returned) == 'Yes' ? 'checked' : '' }}>
                            <label class="btn btn-outline-primary" for="yes">{{ __('Yes') }}</label>
    
                            <input type="radio" class="btn-check" name="returned" id="no" value="No"
                                {{ old('returned', $record->returned) == 'No' ? 'checked' : '' }}>
                            <label class="btn btn-outline-primary" for="no">{{ __('No') }}</label>
    
                        </div>
                        <div class="p-2 row">
                            <label for="returnDate" class="col-sm-2 col-form-label">{{ __('return Date') }}</label>
                            <div class="col-sm-10">
                                <input type="date" class="form-control @error('returnDate') is-invalid @enderror"
                                    id="returnDate" name="returnDate" value="{{ old('returnDate', $record->returnDate) }}">
                                @error('date_take')
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
                            <a href="{{route('member.index')}}" class="btn btn-secondary">{{ __('Back to Members') }}</a>
                        </div>
                    </div>

                </form>
            </div>
        @endsection
