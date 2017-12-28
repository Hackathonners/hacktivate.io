{{-- Avatar --}}
<img src="https://avatars1.githubusercontent.com/u/1722352?s=460&v=4" alt="Github's avatar of {{ '@'.Auth::user()->github }}" class="img-fluid rounded mb-3">

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
    <li class="mb-1"><span class="fa-li"><i class="far fa-map-marker-alt"></i></span>Guimarães, Portugal</li>
    <li class="mb-1"><span class="fa-li"><i class="far fa-envelope"></i></span>{{ Auth::user()->email }}</li>
    <li class="mb-1"><span class="fa-li"><i class="far fa-graduation-cap"></i></span>{{ Auth::user()->school }}</li>
</ul>
