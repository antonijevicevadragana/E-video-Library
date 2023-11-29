@extends('layouts.app')

    @section('content')
        <div class="centar">
            <div class="welcome">
                <h3 class="animate__animate__animated__bounceOut">{{ __('Welcome') }} </h3>
                <h3 class="animate__animate__animated__bounceOut">{{ Auth::user()->name }} </h3>

            </div>
        </div>
@endsection
