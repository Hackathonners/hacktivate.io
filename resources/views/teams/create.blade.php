@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-md-8 offset-md-2">
        @include('layouts.shared.status')

        {{-- Warn user that it is already on a team --}}
        @if (Auth::user()->hasTeam() && $errors->isEmpty())
            <div class="alert alert-warning">
                <strong>You are already in a team.</strong>
                <br/>
                Creating a new team will make you leave the current one.
            </div>
        @endif


        <div class="card">
            <div class="card-header">
                <h4 class="text-primary">Create a project team</h4>
                <p class="mb-0">This information will be used to recommend mentors for your team.</p>
            </div>
            <form class="form" method="POST" action="{{ route('teams.store') }}">
                <div class="card-body">
                    {{ csrf_field() }}

                    <div class="form-group">
                        <label for="name">Project name</label>
                        <input id="name" type="text" class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}" name="name" value="{{ old('name') }}" required autofocus>

                        @if ($errors->has('name'))
                            <span class="invalid-feedback">
                                <strong>{{ $errors->first('name') }}</strong>
                            </span>
                        @endif
                    </div>

                    <div class="form-group mb-4">
                        <label for="description">Project description</label>
                        <textarea id="description" class="form-control {{ $errors->has('description') ? 'is-invalid' : '' }}" name="description" rows="4" required>{{ old('description') }}</textarea>

                        @if ($errors->has('description'))
                            <span class="invalid-feedback">
                                <strong>{{ $errors->first('description') }}</strong>
                            </span>
                        @endif
                    </div>

                    <button type="submit" class="btn btn-primary">
                        Create team
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
