<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0"><strong>Your project team</strong></h5>
        <div class="dropdown">
            <button class="btn btn-sm btn-outline-light border-0 dropdown-toggle text-muted" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class="far fa-cog"></i>
            </button>
            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuButton">
                <a class="dropdown-item" href="#">Edit Team</a>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item" href="#">Leave Team</a>
            </div>
        </div>
    </div>
    <div class="card-body">
        <h6 class="mb-1 text-info">{{ $team->name }}</h6>
        <p class="small">{{ $team->description }}</p>
        <div class="row grid">
            @foreach($team->users as $user)
            {{-- Team member --}}
            <div class="col-sm-6">
                <div class="media">
                    <img class="mr-3 rounded" width="48" src="{{ $user->avatar }}" alt="{{ '@'.$user->github }} avatar">
                    <div class="media-body">
                        <h6 class="pt-1 mb-0">{{ $user->name }}</h6>
                        <p class="small text-muted mb-0">
                            {{ '@'.$user->github }}
                            @if($team->isOwner($user))
                            <span class="badge badge-light">Owner</span></p>
                            @endif
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>
