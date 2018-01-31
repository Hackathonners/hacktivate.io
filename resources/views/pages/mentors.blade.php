@extends('layouts.master')

@section('body')

<nav id="navbar" class="navbar navbar-expand-lg navbar-dark fixed-top">
	<div class="container">
		<a class="navbar-brand" href="{{ url('/') }}">
			<img height="38" src="{{ asset('images/hacktivate-logo.svg') }}" alt="Hacktivate">
		</a>
		<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
		 aria-expanded="false" aria-label="Toggle navigation">
			<span class="navbar-toggler-icon"></span>
		</button>
		<div class="collapse navbar-collapse justify-content-end" id="navbarSupportedContent">
			<ul class="navbar-nav">
				
				<li class="nav-item">
					<a href="/mentors" class="nav-link mr-2">Mentors</a>
				</li>
				<li class="nav-item">
					<a href="{{ asset('storage/docs/coc.pdf') }}" class="nav-link mr-2">Code of conduct</a>
				</li>
				
				@guest
                    <li class="nav-item">
                        <a href="{{ route('login') }}" class="btn btn-outline-info call-to-action">Apply</a>
                    </li>
				@else
                    @include('_profile_menu')
				@endguest
			</ul>
		</div>
	</div>
</nav>

<div class="jumbotron d-flex align-items-center hero-image text-light text-center">
</div>

<div class="section">
	<div class="container">
		<h4 class="section-title">
			<span>&lt; Mentors &gt;</span>
		</h4>
	<div class="row grid">
			@foreach($mentors as $mentor)
			<div class="offset-sm-1 offset-md-0 col-sm-10 col-md-12">
				<div class="card flex-md-row">
			    	<img class="card-img-top" src="{{ asset('images/mentors/'.$mentor['image'].'.jpg') }}" alt="{{ $mentor['name'] }}">
				    <div class="card-body">
				    	<h5 class="card-title mb-2">{{ $mentor['name'] }}</h5>
				    	<h6>{{ $mentor['position'] }} {{ $mentor['company'] ? 'at '. $mentor['company'] : '' }}</h6>
				    	<p class="card-text small">{{ $mentor['description'] }}</p>
				    </div>
				</div>
			</div>
			@endforeach
	</div>
</div>
</div>
<div class="section section-dark text-light">
	<div class="container">
		<h4 class="section-title">
			<div class="d-none d-sm-block">
				<span>&lt; Frequently asked questions &gt;</span>
			</div>
			<div class="d-block d-sm-none">
				<span>&lt; F.A.Q. &gt;</span>
			</div>
		</h4>
		<div class="row">
			<div class="col-xs-6 col-sm-4">
				<h6 class="section-subtitle">What is a hackathon?</h6>
				<p>It is a programming marathon, where teams of 2-4 put their ideas together to create something exciting in only 24 hours.
					It gives hackers the chance to turn their ideas into prototypes.</p>
			</div>
			<div class="col-xs-6 col-sm-4">
				<h6 class="section-subtitle">Can I participate?</h6>
				<p>To be eligible for participation, you need to be a university student or recently left the university. Unfortunately,
					we are unable to accept students under 18 years old.</p>
			</div>
			<div class="col-xs-6 col-sm-4">
				<h6 class="section-subtitle">How do I register?</h6>
				<p>After applying for the hackathon using your Github account, you should either create or join a team. Only teams of 2-4
					are eligible for acceptance, but full teams are preferable.</p>
			</div>
		</div>
		<div class="row">
			<div class="col-xs-6 col-sm-4">
				<h6 class="section-subtitle">What about sleep?</h6>
				<p>We have a special room for people who want to get some Z's during the night. It is also recommended to take some time to
					rest during the marathon.</p>
			</div>
			<div class="col-xs-6 col-sm-4">
				<h6 class="section-subtitle">What do I need to bring?</h6>
				<p>Just your laptop and lots of motivation for this hackathon. We provide free Wi-fi access, food and one table for teams
					to work on their ideas.</p>
			</div>
			<div class="col-xs-6 col-sm-4">
				<h6 class="section-subtitle">What about food?</h6>
				<p>We provide lunch, dinner and snacks during the event. You are able to specify dietary restrictions in your profile.
					We'll do our best to fulfill them.</p>
			</div>
		</div>
		<div class="row">
			<div class="col-xs-6 col-sm-4">
				<h6 class="section-subtitle">What is the subject?</h6>
				<p>This hackathon is subject-free. We encourage you to think out of the box, build up your idea prototype and surprise the jurors.</p>
			</div>
			<div class="col-xs-6 col-sm-4">
				<h6 class="section-subtitle">Don't have a team?</h6>
				<p>We have an active Slack community with all potential attendees. Join us on Slack, find your buddies and build up a talented team!</p>
			</div>
			<div class="col-xs-6 col-sm-4">
				<h6 class="section-subtitle">What are the rules?</h6>
				<p>Your should be aware of the
					<a href="{{ asset('storage/docs/regulation.pdf') }}">Regulation</a> of the hackathon and entirely respect the
					<a href="{{ asset('storage/docs/coc.pdf') }}">Code of Conduct</a>.</p>
			</div>
			<div class="col-xs-6 col-sm-4">
			</div>
		</div>
		<ul class="fa-ul link-list text-primary">
			<li class="link-item">
				<span class="fa-li">
					<i class="far fa-chevron-circle-right"></i>
				</span>
				<a class="small" href="mailto:hello@hacktivate.io">Do you have a question? E-mail us.</a>
			</li>
		</ul>
	</div>
</div>
@endsection

@push('scripts')
<script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyApgz_rHdzXxfhQscIWMxqxl3nM9rpR1Ow&callback=initVenueMap"></script>
@endpush
