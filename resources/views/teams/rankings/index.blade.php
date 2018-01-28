@extends('layouts.app')

@section('content')
<div class="card">
    @if($rankedTeams->isEmpty())
        @include('teams.rankings.empty')
    @else 
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0"><strong>Team Rankings</strong></h5>
        <div class="dropdown">
            <a href="{{ route('teams.rankings.refresh') }}" class="btn btn-primary btn-sm">Refresh rankings</a>
        </div>
    </div>
    <div class="card-body">
        <table class="card-table table">
            <tbody>
                <tr>
                    <th>Rank</th>
                    <th>Team Name</th>
                    <th>Members Number</th>
                    <th>Score</th>
                </tr>
                @foreach ($rankedTeams as $team)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $team['name'] }}</td>
                        <td><a href="#">{{ $team['members'] }}</a></td>
                        <td>{{ $team['score'] }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @endif
</div>
@endsection