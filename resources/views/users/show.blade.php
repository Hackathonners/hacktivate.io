@extends('layouts.app')

@section('content')
<div class="row">

    {{-- Profile sidebar --}}
    <div class="col-md-3">
        @include('users.shared.sidebar.show')
    </div>

    {{-- User summary --}}
    <div class="col-md-9">

        {{-- Application status --}}
        <div class="card mb-4">
            <div class="card-body">

                @if(Auth::user()->hasCompleteApplication())
                <div class="media wizard-status-done">
                    <span class="wizard-step-icon"><i class="icon fa fa-fw fa-check"></i></span>
                    <div class="media-body">
                        <h5 class="wizard-step-title">Your application is complete.</h5>
                        <p class="small mb-0">You may still change your profile details and move to another team.<br/>Keep in mind that your application remains complete while the conditions below are met.</p>
                    </div>
                </div>
                @else
                <div class="media wizard-status-undone">
                    <span class="wizard-step-icon"><i class="icon fa fa-fw fa-exclamation-triangle"></i></span>
                    <div class="media-body">
                        <h5 class="wizard-step-title">Your application is not complete yet.</h5>
                    </div>
                </div>
                @endif

            </div>
            <div class="card-body">
                <h5 class="mb-4"><strong>Do the following to complete your application:</strong></h5>

                {{-- Complete profile --}}
                <div class="media mb-3 wizard-step-{{ Auth::user()->hasCompleteProfile() ? 'done' : 'undone' }}">
                    <span class="wizard-step-icon"><i class="icon fa fa-fw fa fa-user"></i></span>
                    <div class="media-body">
                        <h6 class="wizard-step-title">Complete your profile</h6>
                        <p class="mb-0">A complete profile improves your chance to be accepted.
                            <br/>
                            <span class="small"><a href="{{ route('users.edit') }}" class="text-muted"><u>Edit your profile</u></a> and provide the most information as possible.</span>
                        </p>
                    </div>
                </div>

                {{-- Join or create team --}}
                <div class="media wizard-step-{{ Auth::user()->hasTeam() ? 'done' : 'undone' }}">
                    <span class="wizard-step-icon"><i class="icon fa fa-fw fa-users"></i></span>
                    <div class="media-body">
                        <h6 class="wizard-step-title">Join or create a team</h6>
                        <p class="mb-0">
                            Build your team and stay closer to the Hacktivate passport.
                            <br/>
                            <span class="small"><a href=""class="text-muted"><u>Join our Slack</u></a> to find a team looking for members or <a href=""class="text-muted"><u>create a team.</u></a></span>
                        </p>
                    </div>
                </div>
            </div>
        </div>

        {{-- Project team --}}
        @if(Auth::user()->hasTeam())
            @include('teams.shared.card.show', ['team' => Auth::user()->team])
        @endif
    </div>

</div>
@endsection
