Hello {{ $user->name }}
Thank you for create an account . Please verify you email usign this link:
{{ route('verify', $user->verification_token) }}
