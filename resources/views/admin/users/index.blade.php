@extends('layouts.app')

@section('content')
<div class="row">

    @include('layouts.shared.status')

    {{-- Users summary --}}

    <div class="card">
        <div class="card-header ">
            <h5 class="mb-0"><strong>Users</strong></h5>
        </div>

        <div class="card-body">
            <div class="row grid">
                @foreach($users as $user)
                <div class="col-sm-12">
                    <div class="media">
                        <img class="mr-3 rounded" width="48" src="{{ $user->avatar }}" alt="{{ '@'.$user->github }} avatar">
                        <div class="media-body">
                            <h6 class="pt-1 mb-0">{{ $user->name }}</h6>
                            <p class="small text-muted mb-0">
                                {{ '@'.$user->github }}
                            @if($user->hasCompleteApplication())
                            <i class="icon fa fa-fw fa-check"></i>
                            @elseif($user->hasEligibleTeam())
                            <i class="icon fa fa-fw fa-users"></i>
                            @elseif($user->hasCompleteProfile())
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
