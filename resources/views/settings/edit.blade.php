@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-md-9 off-set-2">
        {{-- @include('layouts.shared.status') --}}

        <div class="card">
            <div class="card-header">
                <h4 class="text-primary">Edit settings</h4>
            </div>
            <form class="form" method="POST" action="{{ route('settings.update') }}">
                <div class="card-body">
                    {{ csrf_field() }}
                    {{ method_field('PUT') }}

                    <h5 class="text-primary mb-2">Team Details</h5>
                    <div class="form-group">
                        <label for="min_members_team">Minimum number of members per team</label>
                        <input id="min_members_team" type="number" class="form-control {{ $errors->has('min_members_team') ? 'is-invalid' : '' }}" name="min_members_team" value="{{ old('min_members_team') }}" min="1" required autofocus>

                        @if ($errors->has('min_members_team'))
                            <span class="invalid-feedback">
                                <strong>{{ $errors->first('min_members_team') }}</strong>
                            </span>
                        @endif
                    </div>

                    <div class="form-group">
                        <label for="max_members_team">Maximum number of members per team</label>
                        <input id="max_members_team" type="number" class="form-control {{ $errors->has('max_members_team') ? 'is-invalid' : '' }}" name="max_members_team" value="{{ old('max_members_team') }}" min="1" required autofocus>

                        @if ($errors->has('max_members_team'))
                            <span class="invalid-feedback">
                                <strong>{{ $errors->first('max_members_team') }}</strong>
                            </span>
                        @endif
                    </div>
                    

                    <h5 class="text-primary mb-2">Submitting details</h5>
                    <div class="form-group">
                        <label for="projects_submission_end_at">Deadline for submit applications</label>
                        <input id="projects_submission_end_at" type="datetime-local" class="form-control {{ $errors->has('projects_submission_end_at') ? 'is-invalid' : '' }}" name="projects_submission_end_at" value="{{ old('projects_submission_end_at') }}" required autofocus>

                        @if ($errors->has('projects_submission_end_at'))
                            <span class="invalid-feedback">
                                <strong>{{ $errors->first('projects_submission_end_at') }}</strong>
                            </span>
                        @endif
                    </div>

                    <button type="submit" class="btn btn-primary">
                        Edit settings
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection