@extends('layouts.master')

@section('body-class', 'hacker-box')

@section('body')
<div id="app" class="sticky-footer">
    <nav class="navbar navbar-expand-lg navbar-dark navbar-small">
        <div class="container">
            <a class="navbar-brand" href="{{ url('/') }}">
				<img height="38" src="{{ asset('images/hacktivate-logo.svg') }}" alt="Hacktivate">
			</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
                    aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse justify-content-end" id="navbarSupportedContent">
                <ul class="navbar-nav">
                    @include('_profile_menu')
                </ul>
            </div>

        </div>
    </nav>

    <div class="container py-5">
        @yield('content')
    </div>
</div>
@endsection