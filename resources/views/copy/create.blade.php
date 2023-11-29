
@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="card">
            <div class="card-header">{{ __('Copy') . ': ' . __('Add') }}</div>

            <form method="POST" action="{{ route('copy.store') }}">
                @csrf
                
                <label for="film_id">{{__('Film select menu')}}:</label>
                    <select class="form-select @error('film_id') is-invalid @enderror" aria-label="Default select example" name="film_id">
                        <option value="">--</option>
                        @foreach ($film as $p)
                            <option name="film_id" id="idFilm{{ $p->id }}" value="{{ $p->id }}">
                                {{ $p->name }}</option>
                        @endforeach
                    </select>
                    @error('film_id')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror

                
                <div class="p-2">
                    <div class="btn-group" role="group" aria-label="Basic radio toggle button group">
                        <p class="p-2">{{ __('Active') }}</p>
                        <input type="radio" class="btn-check" name="active" id="yes" value="Yes" checked>
                        <label class="btn btn-outline-primary" for="yes">{{ __('Yes') }}</label>

                        <input type="radio" class="btn-check" name="active" id="no" value="No">
                        <label class="btn btn-outline-primary" for="no">{{ __('No') }}</label>
                    </div>
                    <p>*{{ __('active means that it can be used, it is not damaged') }} </p>
                </div>
                <div class="mb-3 row float-end">
                    <div class="col-12">
                        <button type="submit" class="btn btn-primary">
                            {{ __('Save') }}
                        </button>
                        <a href="{{ route('copy.index') }}" class="btn btn-secondary">{{ __('Cancel') }}</a>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
