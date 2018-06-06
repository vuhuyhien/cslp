@component('mail::message')
# Change email confirm

Hello {{$name}}!

You received this message because {{ $newEmail }} was chosen as an alternate email for {{ $oldEmail }} on the FinId system.
If {{ $oldEmail}} is not your {{ config('app.name') }} account, please ignore this message.

Please visit {{ $link }} to confirm that this is your new email!

@component('mail::button', ['url' => $link])
Confirm
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
