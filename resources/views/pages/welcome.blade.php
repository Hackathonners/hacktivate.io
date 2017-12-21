<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="apple-touch-icon" sizes="57x57" href="/favicon/apple-icon-57x57.png">
    <link rel="apple-touch-icon" sizes="60x60" href="/favicon/apple-icon-60x60.png">
    <link rel="apple-touch-icon" sizes="72x72" href="/favicon/apple-icon-72x72.png">
    <link rel="apple-touch-icon" sizes="76x76" href="/favicon/apple-icon-76x76.png">
    <link rel="apple-touch-icon" sizes="114x114" href="/favicon/apple-icon-114x114.png">
    <link rel="apple-touch-icon" sizes="120x120" href="/favicon/apple-icon-120x120.png">
    <link rel="apple-touch-icon" sizes="144x144" href="/favicon/apple-icon-144x144.png">
    <link rel="apple-touch-icon" sizes="152x152" href="/favicon/apple-icon-152x152.png">
    <link rel="apple-touch-icon" sizes="180x180" href="/favicon/apple-icon-180x180.png">
    <link rel="icon" type="image/png" sizes="192x192"  href="/favicon/android-icon-192x192.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/favicon/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="96x96" href="/favicon/favicon-96x96.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/favicon/favicon-16x16.png">
    <link rel="manifest" href="/favicon/manifest.json">
    <meta name="msapplication-TileColor" content="#ffffff">
    <meta name="msapplication-TileImage" content="/favicon/ms-icon-144x144.png">
    <meta name="theme-color" content="#ffffff">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>HACKTIVATE, February 10-11 2018, Museu Dom Diogo de Sousa (Braga, Portugal)</title>
    <!-- Styles -->
    <link href="{{ mix('css/app.css') }}" rel="stylesheet">
  </head>
  <body>
    <div class="hero full-height">
      <div class="overlay"></div>
      <video class="hero-video" autoplay="" loop="" playsinline="" poster="">
        <source src="{{ asset('media/return.mp4') }}" type="video/mp4">
        <source src="{{ asset('media/return.webm') }}" type="video/webm">
      </video>
      <nav id="navbar" class="navbar navbar-expand-lg navbar-dark fixed-top">
        <div class="container">
          <a class="navbar-brand" href="{{ url('/') }}"><img height="38" src="{{ asset('images/hacktivate-logo.svg') }}" alt="Hacktivate"></a>
          <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
          </button>
          <div class="collapse navbar-collapse justify-content-end" id="navbarSupportedContent">
            <ul class="navbar-nav">
              <li class="nav-item"><a href="{{ route('login') }}" class="nav-link mr-2">Mentors</a></li>
              {{--
              <li class="nav-item"><a href="{{ route('login') }}" class="nav-link">Regulation</a></li>
              --}}
              <li class="nav-item"><a href="{{ route('login') }}" class="nav-link mr-4">Code of conduct</a></li>
              @if (Auth::guest())
              <li class="nav-item"><a href="{{ route('login') }}" class="btn btn-outline-info call-to-action">Apply</a></li>
              @else
              <li class="nav-item dropdown">
                <a href="#" class="nav-link dropdown-toggle" id="navbarDropdownMenuLink" data-toggle="dropdown"
                  aria-haspopup="true" aria-expanded="false">
                {{ Auth::user()->name }}
                </a>
                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdownMenuLink">
                  <a href="{{ route('logout') }}" class="dropdown-item"
                    onclick="event.preventDefault();document.getElementById('logout-form').submit();">
                  Logout
                  </a>
                  <form id="logout-form" action="{{ route('logout') }}" method="POST"
                    style="display: none;">
                    {{ csrf_field() }}
                  </form>
                </div>
              </li>
              @endif
            </ul>
          </div>
        </div>
      </nav>
      <div class="jumbotron d-flex align-items-center hero-content no-background text-light text-center">
        <div class="container">
          <h1 class="display-4 hero-display mx-auto p-4">The hackathon<br/>for &lt;code&gt; lovers</h1>
          <h4 class="pt-5"><strong>February 10-11, 2018</strong></h4>
          <h5 class="pt-2">Museu Dom Diogo de Sousa, Braga</h5>
          <a class="hero-action btn btn-outline-info call-to-action mt-4" href="#" role="button">Apply now</a>
        </div>
      </div>
    </div>
    <div class="section">
      <div class="container">
        <h4 class="section-title"><span>&lt; About HACKTIVATE &gt;</span></h4>
        <p class="lead">A programming marathon open for students for creating something outstanding in 24 hours. It will take place at the event <a href="http://seium.org" target="_blank">Semana da Engenharia Informática</a>, a week of activities about tech trends.</p>
        <div class="row">
          <div class="col-xs-6 col-sm-6">
            <h6 class="section-subtitle text-info"><i class="fas fa-gamepad fa-fw fa-lg"></i> Talks and relax moments</h6>
            <p>When programming becomes challenging, take a moment to attend a talk, relax, play games and even to connect with people of the other teams.</p>
            <img src="/images/return-relax.jpg" alt="Prizes" class="img-fluid img-about">
          </div>
          <div class="col-xs-6 col-sm-6">
            <h6 class="section-subtitle text-info"><i class="fa fa-trophy-alt fa-fw fa-lg"></i> Winning prizes</h6>
            <p>Get the chance to win prizes valued at 1000€ in total. Ready for the challenge? Prepare your idea, build your prototype and captivate the jury to be one of the three winner projects.</p>
            <img src="/images/return-prizes.jpg" alt="Prizes" class="img-fluid img-about">
          </div>
        </div>
      </div>
    </div>
    <div class="location">
      <div class="container">
        <div class="location-details">
          <h4 class="section-title"><span>&lt; Location &gt;</span></h4>
          <h5>Museu Dom Diogo de Sousa</h5>
          <p>R. dos Bombeiros Voluntários<br/>4700-025 Braga<br/> Portugal</p>
          <h6 class="section-subtitle">GPS Coordinates</h6>
          <p>Latitude: 41.546000<br/>Longitude: -8.427199</p>
        </div>
      </div>
      <div id="map" style="height: 500px"></div>
    </div>
    <div class="section">
      <div class="container">
        <h4 class="section-title"><span>&lt; Schedule &gt;</span></h4>
        <div class="row">
          <div class="col-md-6">
            <h5 class="section-subtitle text-center">Saturday, February 10</h5>
            <table class="table">
              <tbody>
                <tr>
                  <td><strong>Doors and registration open</strong></td>
                  <td class="text-right text-muted">09h30</td>
                </tr>
                <tr>
                  <td><strong>Opening session</strong></td>
                  <td class="text-right text-muted">10h00</td>
                </tr>
                <tr>
                  <td><strong>Hackathon begins</strong></td>
                  <td class="text-right text-muted">10h30</td>
                </tr>
                <tr>
                  <td><strong>Lunch</strong></td>
                  <td class="text-right text-muted">12h30</td>
                </tr>
                {{--
                <tr>
                  <td class="text-muted"><i>TBA</i></td>
                  <td class="text-muted"><i>Talks</i></td>
                </tr>
                --}}
                <tr>
                  <td><strong>Dinner</strong></td>
                  <td class="label text-right text-muted">20h00</td>
                </tr>
              </tbody>
            </table>
          </div>
          <div class="col-md-6">
            <h5 class="section-subtitle text-center">Sunday, February 11</h5>
            <table class="table">
              <tbody>
                <tr>
                  <td><strong>Breakfast</strong></td>
                  <td class="text-right text-muted">08h30</td>
                </tr>
                <tr>
                  <td><strong>Demos start</strong></td>
                  <td class="text-right text-muted">09h30</td>
                </tr>
                <tr>
                  <td><strong>Hackathon ends</strong></td>
                  <td class="text-right text-muted">10h30</td>
                </tr>
                <tr>
                  <td><strong>Presentations start</strong></td>
                  <td class="text-right text-muted">10h45</td>
                </tr>
                {{--
                <tr>
                  <td class="text-muted"><i>TBA</i></td>
                  <td class="text-muted"><i>Talks</i></td>
                </tr>
                --}}
                <tr>
                  <td><strong>Award ceremony & closing session</strong></td>
                  <td class="label text-right text-muted">12h30</td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
    <div class="section bg-light">
      <div class="container">
        <h4 class="section-title"><span>&lt; Backers &gt;</span></h4>
        <div class="row">
          <div class="col-xs-6 col-sm-4">
            <a href="//cesium.di.uminho.pt" target="_blank" class="partner">
            <img class="img-fluid" src="http://cesium.di.uminho.pt/assets/logo-130aa2b71d4ca3daf2922a30af8574d2356002f2ac0e8059ff529754b0d935bd.png" alt="CeSIUM">
            </a>
          </div>
        </div>
      </div>
    </div>
    <div class="section section-dark text-light">
      <div class="container">
        <h4 class="section-title">
          <div class="d-none d-sm-block"><span>&lt; Frequently asked questions &gt;</span></div>
          <div class="d-block d-sm-none"><span>&lt; F.A.Q. &gt;</span></div>
        </h4>
        <div class="row">
          <div class="col-xs-6 col-sm-4">
            <h6 class="section-subtitle">What is a hackathon?</h6>
            <p>It is a programming marathon, where teams of 2-4 put their ideas together to create something exciting in only 24 hours. It gives hackers a chance to turn their ideas into prototypes.</p>
          </div>
          <div class="col-xs-6 col-sm-4">
            <h6 class="section-subtitle">Can I participate?</h6>
            <p>To be elegible for participation, you need to be a university student or left the university in the past year. Unfortunately, we are unable to accept students under 18 years old.</p>
          </div>
          <div class="col-xs-6 col-sm-4">
            <h6 class="section-subtitle">How do I register?</h6>
            <p>After applying for the hackathon using your Github account, you should either create or join a team. Only teams of 2-4 are eligible for acceptance, but full teams are preferable.</p>
          </div>
        </div>
        <div class="row">
          <div class="col-xs-6 col-sm-4">
            <h6 class="section-subtitle">What about sleep?</h6>
            <p>We have a special room for people who want to get some Z's during the night. It is also recommend to take some time to rest during the event.</p>
          </div>
          <div class="col-xs-6 col-sm-4">
            <h6 class="section-subtitle">What do I need to bring?</h6>
            <p>Just your laptop and lots of motivation for this hackathon. We provide free Wi-fi access, food and one table for teams to work on their ideas.</p>
          </div>
          <div class="col-xs-6 col-sm-4">
            <h6 class="section-subtitle">What about food?</h6>
            <p>We provide lunch, dinner and snacks during the event. You will be able to specify dietary restrictions in your profile. We will do our best to respect them.</p>
          </div>
        </div>
        <div class="row">
          <div class="col-xs-6 col-sm-4">
            <h6 class="section-subtitle">What is the subject?</h6>
            <p>This hackathon is subject-free. We encourage you to think out of the box, build your idea and surprise the judges.</p>
          </div>
          <div class="col-xs-6 col-sm-4">
            <h6 class="section-subtitle">What are the rules?</h6>
            <p>Your should be aware of the <a href="">Regulation</a> of the hackathon and entirely respect the <a href="">Code of Conduct</a>.</p>
          </div>
          <div class="col-xs-6 col-sm-4">
          </div>
        </div>
        <ul class="fa-ul link-list text-primary">
          <li class="link-item">
            <span class="fa-li"><i class="far fa-chevron-circle-right"></i></span>
            <a class="small" href="/faq">Do you have a question? E-mail us.</a>
          </li>
        </ul>
      </div>
    </div>
    <div class="py-5 section-footer text-light">
      <div class="container">
        <div class="row">
          <div class="col-xs-12 col-sm-4 text-center text-sm-right d-block d-sm-none">
            <p class="text-muted small">
              <a href="mailto:hello@hacktivate.io"><i class="fas fa-lg fa-envelope pr-2"></i></a>
              <a href="//twitter.com/hackathonners"><i class="fab fa-lg fa-twitter pr-2"></i></a>
              <a href="//github.com/hackathonners"><i class="fab fa-lg fa-github pr-2"></i></a>
              <a href="//hacktivate-hackathon.slack.com"><i class="fab fa-lg fa-slack-hash"></i></a>
            </p>
          </div>
          <div class="col-xs-12 col-sm-8 text-center text-sm-left">
            <p class="mb-1">Built for you with <i class="fas fa-heart text-primary"></i> & <i class="fas fa-coffee"></i> by <a href="//hackathonners.org">Hackathonners</a></p>
            <span class="text-muted small">&copy; Copyright 2017 <a class="text-muted" href="//hackathonners.org" target="_blank">Hackathonners</a>. All rights reserved.</span>
          </div>
          <div class="col-xs-12 col-sm-4 text-center text-sm-right d-none d-sm-block">
            <p class="mb-1">
              <a href="//twitter.com/hackathonners"><i class="fab fa-lg fa-twitter pr-2"></i></a>
              <a href="//github.com/hackathonners"><i class="fab fa-lg fa-github pr-2"></i></a>
              <a href="//hacktivate-hackathon.slack.com"><i class="fab fa-lg fa-slack-hash"></i></a>
            </p>
            <a class="small" href="mailto:hello@hacktivate.io">hello@hacktivate.io</a>
          </div>
        </div>
      </div>
    </div>
    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}"></script>
    <script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyApgz_rHdzXxfhQscIWMxqxl3nM9rpR1Ow&callback=initVenueMap"></script>
  </body>
</html>