@extends('layouts.app')

@section('content')
<div class="row">
    {{-- Profile sidebar --}}
    <div class="col-md-3">
        @include('users.shared.sidebar.show')
    </div>

    <div class="col-md-8 off-set-2">

        <div class="card">
            <div class="card-header">
                <h4 class="text-primary">Edit profile</h4>
                <p class="mb-0">This information will be used to know if you are really a hacker for the hackathon.</p>
            </div>
            <form class="form" method="POST" action="{{ route('users.update') }}">
                <div class="card-body">
                    {{ csrf_field() }}
                    {{ method_field('PUT') }}

                    <h5 class="text-primary mb-2">Account details</h5>

                    <div class="form-group mb-4">
                        <label for="phone_number">Mobile phone</label>
                        <input id="phone_number" type='tel' class="form-control {{ $errors->has('phone_number') ? 'is-invalid' : '' }}" name="phone_number" value="{{ old('phone_number', $user->phone_number) }}"
                        pattern='(\+(\d{3}))?\d{9}' title="Mobile phone should only contain nine digits" required>

                        @if ($errors->has('phone_number'))
                            <span class="invalid-feedback">
                                <strong>{{ $errors->first('phone_number') }}</strong>
                            </span>
                        @endif
                    </div>

                    <div class="form-group mb-4">
                        <label for="birthdate">Birthdate</label>
                        <input id="birthdate" type="date" class="form-control {{ $errors->has('birthdate') ? 'is-invalid' : '' }}" name="birthdate" value="{{ old('birthdate', $user->birthdate) }}" required>

                        @if ($errors->has('birthdate'))
                            <span class="invalid-feedback">
                                <strong>{{ $errors->first('birthdate') }}</strong>
                            </span>
                        @endif
                    </div>

                    <div class="form-group mb-4">
                        <label for="gender">Gender</label>

                        <select id="gender" name="gender" class="custom-select form-control {{ $errors->has('gender') ? 'is-invalid' : '' }}" required>
                            <option {{ old('gender', $user->gender) ? '' : 'selected' }}> Choose...</option>
                            <option value="m" {{ old('gender', $user->gender) === 'm' ? 'selected' : '' }}>Male</option>
                            <option value="f" {{ old('gender', $user->gender) === 'f' ? 'selected' : '' }}>Female</option>
                            <option value="o" {{ old('gender', $user->gender) === 'o' ? 'selected' : '' }}>Other</option>
                        </select>

                        @if ($errors->has('gender'))
                            <span class="invalid-feedback">
                                <strong>{{ $errors->first('gender') }}</strong>
                            </span>
                        @endif
                    </div>

                    <div class="form-group mb-4">
                        <label for="bio">Bio</label>

                        <textarea id="bio" class="form-control {{ $errors->has('bio') ? 'is-invalid' : '' }}" name="bio" rows="4" required>{{ old('bio', $user->bio) }}</textarea>

                        @if ($errors->has('bio'))
                            <span class="invalid-feedback">
                                <strong>{{ $errors->first('bio') }}</strong>
                            </span>
                        @endif
                    </div>

                    <h5 class="text-primary mb-2">Professional Details</h5>
                    <div class="form-group mb-4">
                        <label for="school">Education Institution</label>
                        <input id="school" type="text" class="form-control {{ $errors->has('school') ? 'is-invalid' : '' }}" name="school" value="{{ old('school', $user->school) }}" required>

                        @if ($errors->has('school'))
                            <span class="invalid-feedback">
                                <strong>{{ $errors->first('school') }}</strong>
                            </span>
                        @endif
                    </div>

                    <div class="form-group mb-4">
                        <label for="major">Major</label>
                        <input id="major" type="text" class="form-control {{ $errors->has('major') ? 'is-invalid' : '' }}" name="major" value="{{ old('major', $user->major) }}" required>

                        @if ($errors->has('major'))
                            <span class="invalid-feedback">
                                <strong>{{ $errors->first('major') }}</strong>
                            </span>
                        @endif
                    </div>

                    <div class="form-group mb-4">
                        <label for="study_level">Study Level</label>
                        <input id="study_level" type="text" class="form-control {{ $errors->has('study_level') ? 'is-invalid' : '' }}" name="study_level" value="{{ old('study_level', $user->study_level) }}" required>

                        @if ($errors->has('study_level'))
                            <span class="invalid-feedback">
                                <strong>{{ $errors->first('study_level') }}</strong>
                            </span>
                        @endif
                    </div>

                    <h5 class="text-primary mb-2">Other details</h5>
                    <div class="form-group mb-4">
                        <label for="dietary_restrictions">Dietary Restrictions</label>

                        <textarea id="dietary_restrictions" class="form-control {{ $errors->has('dietary_restrictions') ? 'is-invalid' : '' }}" name="dietary_restrictions" rows="4">{{ old('dietary_restrictions', $user->dietary_restrictions) }}</textarea>

                        @if ($errors->has('dietary_restrictions'))
                            <span class="invalid-feedback">
                                <strong>{{ $errors->first('dietary_restrictions') }}</strong>
                            </span>
                        @endif
                    </div>

                    <div class="form-group mb-4">
                        <label for="special_needs">Special Needs</label>

                        <textarea id="special_needs" class="form-control {{ $errors->has('special_needs') ? 'is-invalid' : '' }}" name="special_needs" rows="4">{{ old('special_needs', $user->special_needs) }}</textarea>

                        @if ($errors->has('special_needs'))
                            <span class="invalid-feedback">
                                <strong>{{ $errors->first('special_needs') }}</strong>
                            </span>
                        @endif
                    </div>

                    <button type="submit" class="btn btn-primary">
                        Edit profile
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
