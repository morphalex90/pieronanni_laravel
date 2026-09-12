<x-mail::message>
# User <i>{{ $data['name'] }}</i> asked:

{{ $data['message'] }}

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>
