@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-md-9 offset-md-2">
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
                    <div class="form-group mb-4">
                        <label for="min_team_members">Minimum number of members per team</label>
                        <input id="min_team_members" type="number" class="form-control {{ $errors->has('min_team_members') ? 'is-invalid' : '' }}" name="min_team_members" value="{{ old('min_team_members', $settings->min_team_members) }}" min="1" required autofocus>

                        @if ($errors->has('min_team_members'))
                            <span class="invalid-feedback">
                                <strong>{{ $errors->first('min_team_members') }}</strong>
                            </span>
                        @endif
                    </div>

                    <div class="form-group mb-4">
                        <label for="max_team_members">Maximum number of members per team</label>
                        <input id="max_team_members" type="number" class="form-control {{ $errors->has('max_team_members') ? 'is-invalid' : '' }}" name="max_team_members" value="{{ old('max_team_members', $settings->max_team_members) }}" min="1" required autofocus>

                        @if ($errors->has('max_team_members'))
                            <span class="invalid-feedback">
                                <strong>{{ $errors->first('max_team_members') }}</strong>
                            </span>
                        @endif
                    </div>
                    

                    <h5 class="text-primary mb-2">Application details</h5>
                    <div class="form-group mb-4">
                        <label for="applications_start_at">Applications submission start time</label>
                        <input id="applications_start_at" type="datetime-local" class="form-control {{ $errors->has('applications_start_at') ? 'is-invalid' : '' }}" name="applications_start_at" value="{{ old('applications_start_at', $settings->applications_start_at ? $settings->applications_start_at->format('Y-m-d\Th:i') : '') }}" required autofocus>
            
                        @if ($errors->has('applications_start_at'))
                            <span class="invalid-feedback">
                                <strong>{{ $errors->first('applications_start_at') }}</strong>
                            </span>
                        @endif
                    </div>

                    <div class="form-group mb-4">
                        <label for="applications_end_at">Applications submission end time</label>
                        <input id="applications_end_at" type="datetime-local" class="form-control {{ $errors->has('applications_end_at') ? 'is-invalid' : '' }}" name="applications_end_at" value="{{ old('applications_end_at', $settings->applications_end_at ? $settings->applications_end_at->format('Y-m-d\Th:i') : '') }}" required autofocus>

                        @if ($errors->has('applications_end_at'))
                            <span class="invalid-feedback">
                                <strong>{{ $errors->first('applications_end_at') }}</strong>
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