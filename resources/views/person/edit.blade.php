@extends('layouts.app')
@section('content')
<div class="container">
<div class="row mb-2">

    <div class="card">
        <div class="card-header">{{ __('People'). ": ". __('Edit') }}</div>

        <div class="card-body">
            <form method="POST" action="{{route('person.update', ['person'=>$person->id])}}">
                @method('PUT')
                @csrf <!-- kad se salje svim metodama osim get mora da se doda @csrr-->
                <div class="mb-3 row">
                    <label for="name" class="col-sm-2 col-form-label">{{__('Name')}}</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name', $person->name) }}">
                        @error('name')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                </div>
                <div class="mb-3 row">
                    <label for="surname" class="col-sm-2 col-form-label">{{__('Surname')}}</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control @error('surname') is-invalid @enderror" id="surname" name="surname" value="{{ old('surname',  $person->surname) }}">
                        @error('surname')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                </div>

                <div class="mb-3 row">
                    <label for="b_date" class="col-sm-2 col-form-label">{{__('Date of birth')}}</label>
                    <div class="col-sm-10">
                        <input type="date" class="form-control @error('b_date') is-invalid @enderror" id="b_date" name="b_date" value="{{ old('b_date', $person->b_date) }}">
                        @error('surname')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                </div>
                <div class="mb-3 row float-end">
                    <div class="col-12">
                        <button type="submit" class="btn btn-success">{{__('Save')}}</button>
                        <a href="{{ route('person.index') }}" class="btn btn-secondary">{{ __('Cancel') }}</a>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
    @endsection