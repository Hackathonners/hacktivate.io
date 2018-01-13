@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-md-8 offset-md-2">
        @include('layouts.shared.status')

        <div class="card">
            <div class="card-header">
                <h4 class="text-primary">Edit team members</h4>
                <p class="mb-0">As the owner of this team project, you can add or remove members.</p>
            </div>
            <div class="card-body">
                <div class="form-group">
                    <team-members
                        :current-members="{{ $team->users }}"
                        :owner-id="{{ $team->owner->id }}"
                        :team-id="{{ $team->id }}"
                    ></team-members>
                </div>

                <a href="{{ route('home') }}" class="btn btn-primary">
                    Finish
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
