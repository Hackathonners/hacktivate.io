@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-md-9 offset-md-2">
        @include('layouts.shared.status')

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
                    

                    <h5 class="text-primary mb-4">Application details</h5>
                    
                    <h6 class="text-primary mb-2">Deadlines</h6>
                    <div class="form-group">
                        <label for="applications_start_at">Applications submission start time</label>
                        <input id="applications_start_at" type="datetime-local" class="form-control {{ $errors->has('applications_start_at') ? 'is-invalid' : '' }}" name="applications_start_at" value="{{ old('applications_start_at', $settings->applications_start_at ? $settings->applications_start_at->format('Y-m-d\Th:i') : '') }}" required autofocus>
            
                        @if ($errors->has('applications_start_at'))
                            <span class="invalid-feedback">
                                <strong>{{ $errors->first('applications_start_at') }}</strong>
                            </span>
                        @endif
                    </div>

                    <div class="form-group">
                        <label for="applications_end_at">Applications submission end time</label>
                        <input id="applications_end_at" type="datetime-local" class="form-control {{ $errors->has('applications_end_at') ? 'is-invalid' : '' }}" name="applications_end_at" value="{{ old('applications_end_at', $settings->applications_end_at ? $settings->applications_end_at->format('Y-m-d\Th:i') : '') }}" required autofocus>

                        @if ($errors->has('applications_end_at'))
                            <span class="invalid-feedback">
                                <strong>{{ $errors->first('applications_end_at') }}</strong>
                            </span>
                        @endif
                    </div>

                    <h6 class="text-primary mb-2">Ranking</h6>
                    <div class="form-group">                    
                        <label for="factor_followers">Followers factor</label>
                        <input id="factor_followers" type="number" class="form-control {{ $errors->has('factor_followers') ? 'is-invalid' : '' }}" name="factor_followers" value="{{ old('factor_followers', $settings->factor_followers) }}" required autofocus>
            
                        @if ($errors->has('factor_followers'))
                            <span class="invalid-feedback">
                                <strong>{{ $errors->first('factor_followers') }}</strong>
                            </span>
                        @endif
                    </div>
                    <div class="form-group">                    
                        <label for="factor_gists">Gists factor</label>
                        <input id="factor_gists" type="number" class="form-control {{ $errors->has('factor_gists') ? 'is-invalid' : '' }}" name="factor_gists" value="{{ old('factor_gists', $settings->factor_gists) }}" required autofocus>
            
                        @if ($errors->has('factor_gists'))
                            <span class="invalid-feedback">
                                <strong>{{ $errors->first('factor_gists') }}</strong>
                            </span>
                        @endif
                    </div>
                    <div class="form-group">                    
                        <label for="factor_number_repositories">Number of repositories factor</label>
                        <input id="factor_number_repositories" type="number" class="form-control {{ $errors->has('factor_number_repositories') ? 'is-invalid' : '' }}" name="factor_number_repositories" value="{{ old('factor_number_repositories', $settings->factor_number_repositories) }}" required autofocus>
            
                        @if ($errors->has('factor_number_repositories'))
                            <span class="invalid-feedback">
                                <strong>{{ $errors->first('factor_number_repositories') }}</strong>
                            </span>
                        @endif
                    </div>
                    <div class="form-group">                    
                        <label for="factor_repository_contributions">Repository contributions factor</label>
                        <input id="factor_repository_contributions" type="number" class="form-control {{ $errors->has('factor_repository_contributions') ? 'is-invalid' : '' }}" name="factor_repository_contributions" value="{{ old('factor_repository_contributions', $settings->factor_repository_contributions) }}" required autofocus>
            
                        @if ($errors->has('factor_repository_contributions'))
                            <span class="invalid-feedback">
                                <strong>{{ $errors->first('factor_repository_contributions') }}</strong>
                            </span>
                        @endif
                    </div>
                    <div class="form-group">                    
                        <label for="factor_repository_stars">Repository stars factor</label>
                        <input id="factor_repository_stars" type="number" class="form-control {{ $errors->has('factor_repository_stars') ? 'is-invalid' : '' }}" name="factor_repository_stars" value="{{ old('factor_repository_stars', $settings->factor_repository_stars) }}" required autofocus>
            
                        @if ($errors->has('factor_repository_stars'))
                            <span class="invalid-feedback">
                                <strong>{{ $errors->first('factor_repository_stars') }}</strong>
                            </span>
                        @endif
                    </div>
                    <div class="form-group">                    
                        <label for="factor_repository_watchers">Repository watchers factor</label>
                        <input id="factor_repository_watchers" type="number" class="form-control {{ $errors->has('factor_repository_watchers') ? 'is-invalid' : '' }}" name="factor_repository_watchers" value="{{ old('factor_repository_watchers', $settings->factor_repository_watchers) }}" required autofocus>
            
                        @if ($errors->has('factor_repository_watchers'))
                            <span class="invalid-feedback">
                                <strong>{{ $errors->first('factor_repository_watchers') }}</strong>
                            </span>
                        @endif
                    </div>
                    <div class="form-group">                    
                        <label for="factor_repository_forks">Repository forks factor</label>
                        <input id="factor_repository_forks" type="number" class="form-control {{ $errors->has('factor_repository_forks') ? 'is-invalid' : '' }}" name="factor_repository_forks" value="{{ old('factor_repository_forks', $settings->factor_repository_forks) }}" required autofocus>
            
                        @if ($errors->has('factor_repository_forks'))
                            <span class="invalid-feedback">
                                <strong>{{ $errors->first('factor_repository_forks') }}</strong>
                            </span>
                        @endif
                    </div>
                    <div class="form-group mb-4">                    
                        <label for="factor_repository_size">Repository size factor</label>
                        <input id="factor_repository_size" type="number" class="form-control {{ $errors->has('factor_repository_size') ? 'is-invalid' : '' }}" name="factor_repository_size" value="{{ old('factor_repository_size', $settings->factor_repository_size) }}" required autofocus>
            
                        @if ($errors->has('factor_repository_size'))
                            <span class="invalid-feedback">
                                <strong>{{ $errors->first('factor_repository_size') }}</strong>
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
