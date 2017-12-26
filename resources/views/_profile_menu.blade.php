<li class="nav-item dropdown">
    <a href="#" class="nav-link dropdown-toggle" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        {{ Auth::user()->name }}
    </a>
    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdownMenuLink">
        <a href="{{ route('home') }}" class="dropdown-item">Your profile</a>
        <a href="{{ route('home') }}" class="dropdown-item">Your team</a>
        <div class="dropdown-divider"></div>
        <form id="logout-form" action="{{ route('logout') }}" method="POST">
            {{ csrf_field() }}
            <button type="submit" class="dropdown-item">
                Logout
            </button>
        </form>
    </div>
</li>
