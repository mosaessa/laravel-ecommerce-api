<x-mail::message>
    Hello {{ $user->name }}
    You changed your email, so we need to verify this new email address. Please use the button below:
    @component('mail::button', ['url' => route("verify", $user->verification_token)])
        Verify Now
    @endcomponent
    Thanks,<br>
    {{ config('app.name') }}
</x-mail::message>
