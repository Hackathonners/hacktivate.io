@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-md-8 offset-md-2">
        @include('layouts.shared.status')

        <div class="card">
            <div class="card-header">
                <h4 class="text-primary">Edit project team</h4>
                <p class="mb-0">This information will be used to recommend mentors for your team.</p>
            </div>
            <form class="form" method="POST" action="{{ route('teams.update', $team->id) }}">
                <div class="card-body">
                    {{ csrf_field() }}
                    {{ method_field('PUT') }}

                    <div class="form-group">
                        <label for="name">Project name</label>
                        <input id="name" type="text" class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}" name="name" value="{{ old('name', $team->name) }}" required autofocus>

                        @if ($errors->has('name'))
                            <span class="invalid-feedback">
                                <strong>{{ $errors->first('name') }}</strong>
                            </span>
                        @endif
                    </div>

                    <div class="form-group mb-4">
                        <label for="description">Project description</label>
                        <textarea id="description" class="form-control {{ $errors->has('description') ? 'is-invalid' : '' }}" name="description" rows="4" required>{{ old('description', $team->description) }}</textarea>

                        @if ($errors->has('description'))
                            <span class="invalid-feedback">
                                <strong>{{ $errors->first('description') }}</strong>
                            </span>
                        @endif
                    </div>

                    <button type="submit" class="btn btn-primary">
                        Save changes
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
