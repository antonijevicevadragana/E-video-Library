@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="card">
            <div class="card-header">{{ __('Member') . ': ' . __('Add') }}</div>

            <form method="POST" action="{{ route('member.update', $member) }}" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="p-2 row">
                    <div class="btn-group" role="group" aria-label="Basic radio toggle button group">
                        <p class="col-sm-2 col-form-label">{{ __('Gender') }}</p>
                        <div class="p-2">
                            <input type="radio" class="btn-check" name="gender" id="male" value="male"
                                {{ old('gender', $member->gender) == 'male' ? 'checked' : '' }}>
                            <label class="btn btn-outline-primary" for="male">{{ __('Male') }}</label>

                            <input type="radio" class="btn-check" name="gender" id="female" value="female"
                                {{ old('gender', $member->gender) == 'female' ? 'checked' : '' }}>
                            <label class="btn btn-outline-primary" for="female">{{ __('Female') }}</label>

                            <input type="radio" class="btn-check" name="gender" id="other" value="other"
                                {{ old('gender', $member->gender) == 'other' ? 'checked' : '' }}>

                            <label class="btn btn-outline-primary" for="other">{{ __('Other') }}</label>
                        </div>
                    </div>
                </div>

                <div class="p-2 row">
                    <label for="name" class="col-sm-2 col-form-label">{{ __('Name') }}</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control @error('name') is-invalid @enderror" id="name"
                            name="name" value="{{ old('name', $member->name) }}">
                        @error('name')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>
                <div class="p-2 row">
                    <label for="surname" class="col-sm-2 col-form-label">{{ __('Surname') }}</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control @error('surname') is-invalid @enderror" id="surname"
                            name="surname" value="{{ old('surname', $member->surname) }}">
                        @error('surname')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>

                <div class="p-2 row">
                    <label for="b_date" class="col-sm-2 col-form-label">{{ __('Date of birth') }}</label>
                    <div class="col-sm-10">
                        <input type="date" class="form-control @error('b_date') is-invalid @enderror" id="b_date"
                            name="b_date" value="{{ old('b_date', $member->b_date) }}">
                        @error('surname')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>
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

                <div class="col-6">
                    <div class="input-group col-6">
                        <input type="file" class="form-control @error('image') is-invalid @enderror" id="image"
                            name="image" value="{{ old('image') }}">
                        @error('image')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <img src="{{$path}}" class="mb-2" style="width: 100px;" alt="...">
                </div>

                <div class="mb-3 row float-end">
                    <div class="col-12">
                        <button type="submit" class="btn btn-primary">
                            {{ __('Save') }}
                        </button>
                        <a href="{{ route('member.index') }}" class="btn btn-secondary">{{ __('Cancel') }}</a>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
