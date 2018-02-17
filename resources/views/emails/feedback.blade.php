@component('mail::message')
# Hello {{ $user->name }},

Thank you for being part of the Hacktivate. <br/>
We hope you enjoyed it as much as we did organising it.

Now, it is time to get your feedback, so we can improve it.<br/>
**We want to give you the best, so tell us what is the best for you.**

@component('mail::button', ['color' => 'red', 'url' => 'https://goo.gl/forms/cwjDw21wcB2JlNMY2'])
Give your feedback
@endcomponent

See you soon,<br>
The {{ config('app.name') }} Staff
@endcomponent
