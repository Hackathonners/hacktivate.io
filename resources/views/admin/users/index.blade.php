@extends('layouts.app')

@section('content')
<div class="row">

    @include('layouts.shared.status')

    {{-- Users summary --}}

    <div class="card">
        <div class="card-header ">
            <h5 class="mb-0"><strong>Users With a Complete Application</strong></h5>
        </div>

        <div class="card-body">
            <div class="row grid">
                @foreach($usersWithCompleteApplication as $user)
                {{-- Users with a complete application --}}
                <div class="col-sm-12">
                    <div class="media">
                        <img class="mr-3 rounded" width="48" src="{{ $user->avatar }}" alt="{{ '@'.$user->github }} avatar">
                        <div class="media-body">
                            <h6 class="pt-1 mb-0">{{ $user->name }}</h6>
                            <p class="small text-muted mb-0">
                                {{ '@'.$user->github }}
                            <i class="icon fa fa-fw fa-check"></i>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-header ">
            <h5 class="mb-0"><strong>Users Without a Complete Application</strong></h5>
        </div>

        <div class="card-body">
            <div class="row grid">
                @foreach($usersWithoutCompleteApplication as $user)
                {{--  Users without a complete application --}}
                <div class="col-sm-12">
                    <div class="media">
                        <img class="mr-3 rounded" width="48" src="{{ $user->avatar }}" alt="{{ '@'.$user->github }} avatar">
                        <div class="media-body">
                            <h6 class="pt-1 mb-0">{{ $user->name }}</h6>
                            <p class="small text-muted mb-0">
                                {{ '@'.$user->github }}
                            @if($user->hasEligibleTeam())
                            <i class="icon fa fa-fw fa-code"></i>
                            @endif
                            @if($user->hasCompleteProfile())
                            <i class="icon fa fa-fw fa-user"></i>
                            @endif
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>

</div>
@endsection
