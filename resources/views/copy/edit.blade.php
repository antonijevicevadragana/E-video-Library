@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="card">
            <div class="card-header">{{ __('Copy') . ': ' . __('Edit') }}</div>

            <form method="POST" action="{{ route('copy.update', $copy) }}">
                @csrf
                @method('PUT')
                <select class="form-select @error('film_id') is-invalid @enderror" aria-label="Default select example" name="film_id">

                    @foreach ($film as $p)
                            <option id="idFilm{{ $p->id }}" value="{{ $p->id }}" @if ($copy->film_id === $p->id || old('film_id') === $p->id) selected @endif>
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
                        <input type="radio" class="btn-check" name="active" id="yes" value="Yes"
                            {{ old('active', $copy->active) == 'Yes' ? 'checked' : '' }}>
                        <label class="btn btn-outline-primary" for="yes">{{ __('Yes') }}</label>

                        <input type="radio" class="btn-check" name="active" id="no" value="No"
                            {{ old('active', $copy->active) == 'No' ? 'checked' : '' }}>
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
