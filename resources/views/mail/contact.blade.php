<x-mail::message>
    # User <i>{{ $data['name'] }}</i> asked:

    {{ $data['message'] }}

    Thanks,
    {{ config('app.name') }}
</x-mail::message>
