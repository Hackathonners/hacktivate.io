<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0"><strong>Your project team</strong></h5>
        <div class="dropdown">
            <button class="btn btn-sm btn-outline-light border-0 dropdown-toggle text-muted" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class="far fa-cog"></i>
            </button>
            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuButton">
                <a class="dropdown-item" href="{{ route('teams.edit', Auth::user()->team->id) }}">Edit Team</a>
                <a class="dropdown-item" href="{{ route('members.index', Auth::user()->team->id) }}">Edit Members</a>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item" href="#" data-toggle="modal" data-target="#leave-team">Leave Team</a>
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

<div class="modal fade" id="leave-team" tabindex="-1" role="dialog" aria-labelledby="leave-Team-label">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="leave-Team-label">Leave Team</h4>
            </div>
            <div class="modal-body">
                <p> Are you sure you want to leave this team? </p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel
                </button>
                <form method="POST" action="{{ route('team.members.leave', $team->id)}}">
                    <input name="_token" type="hidden" value="{{ csrf_token() }}">
                    <span class="pull-right">

                        <button type="submit" class="btn btn-primary">
                            Leave Team
                        </button>
                    </span>
                </form>
            </div>
        </div>
    </div>
</div>
