@component('mail::message')
# Hello {{ $user->name }},

Congratulations! Your team was accepted.

Your team is the team **#{{ $team->id }}**.

**We recomment you to do the following steps before the hackathon:**
1. Update your team details;
2. Carefully read the entire regulation;
3. <a href="https://join.slack.com/t/hacktivate-hackathon/shared_invite/enQtMzAwMDM5NjUwODY1LTE2ODU3ZjlhMmE3Y2MzZTRkZjMwZDZjZDViYjNiMDE2MjhmYjQ3MWRhNDNiNzU3NjY3YWFkOGNhMDM2NjcxNjI">Join our Slack team</a> to stay up to date during the event;
4. Install everything you need to develop your prototype.

**Registrations open in Saturday, at 9:30 AM.**

See you soon,<br>
The {{ config('app.name') }} Staff
@endcomponent
