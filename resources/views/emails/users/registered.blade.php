@component('mail::message')

# Hello {{ $user->name }},

You just finished the **first step** to be part of Hacktivate.

**Here are the next steps to complete your application:**
1. Complete your profile
2. Join or create a team of 2-4 members

**<span class="highlight">Don't have a team?</span> We can help you, join us on Slack!**

@component('mail::button', ['color' => 'red', 'url' => 'https://join.slack.com/t/hacktivate-hackathon/shared_invite/enQtMzAwMDM5NjUwODY1LTE2ODU3ZjlhMmE3Y2MzZTRkZjMwZDZjZDViYjNiMDE2MjhmYjQ3MWRhNDNiNzU3NjY3YWFkOGNhMDM2NjcxNjI'])
Join our Slack community
@endcomponent

Thank you,<br>
The {{ config('app.name') }} Staff
@endcomponent
