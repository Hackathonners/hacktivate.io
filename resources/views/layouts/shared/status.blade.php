{{-- Show session status --}}
@if (session('status'))
    <div class="alert alert-success">
        {{ session('status') }}
    </div>
@endif

{{-- Show session errors, if any --}}
@if ($errors->isNotEmpty())
    <div class="alert alert-danger">
        <strong>Sorry, there was a problem.</strong>
        <br/>
        You will find more details highlighted below.
    </div>
@endif
