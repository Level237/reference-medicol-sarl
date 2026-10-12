Nom : {{ $message->name }}
@if ($message->organization)
Établissement : {{ $message->organization }}
@endif
E-mail : {{ $message->email }}
@if ($message->phone)
Téléphone : {{ $message->phone }}
@endif

{{ $message->message }}
