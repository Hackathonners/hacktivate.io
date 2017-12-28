{{-- Avatar --}}
@if(Auth::user()->avatar)
<img src="{{ Auth::user()->avatar }}" alt="Github's avatar of {{ '@'.Auth::user()->github }}" class="img-fluid rounded mb-3">
@endif

{{-- Name and Github's handle --}}
<div class="mb-3">
    <h5 class="mb-1"><strong>{{ Auth::user()->name }}</strong></h5>
    <h6 class="text-muted">{{ '@'.Auth::user()->github }}</h6>
</div>

{{-- Biography --}}
<p class="small">{{ Auth::user()->bio }}</p>
<hr/>

{{-- Details --}}
<ul class="fa-ul small">
    <li class="mb-1"><span class="fa-li"><i class="far fa-envelope"></i></span>{{ Auth::user()->email }}</li>

    @if(Auth::user()->location)
    <li class="mb-1"><span class="fa-li"><i class="far fa-map-marker-alt"></i></span>{{ Auth::user()->location }}</li>
    @endif

    @if(Auth::user()->school)
    <li class="mb-1"><span class="fa-li"><i class="far fa-graduation-cap"></i></span>{{ Auth::user()->school }}</li>
    @endif
</ul>
