@if(app('settings')->hasApplicationsPeriod())
    @if(app('settings')->withinApplicationsPeriod())
        <div class="alert alert-warning">
            The applications period will end at {{ app('settings')->applications_end_at->toDayDateTimeString() }}
        </div>
    @elseif(app('settings')->applications_end_at->isPast())
        <div class="alert alert-warning">
            The applications period is now closed.
        </div>
    @endif
@endif
