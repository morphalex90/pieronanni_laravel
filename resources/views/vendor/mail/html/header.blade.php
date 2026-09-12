@props(['url'])
<tr>
<td class="header">
<a href="{{ $url }}" style="display: inline-block;">
@if (trim($slot) === 'Laravel')
<img src="https://laravel.com/img/notification-logo-v2.1.png" class="logo" alt="Laravel Logo">
@else
<span class="header-accent">{{ mb_substr(trim($slot), 0, 1) }}</span>{{ mb_substr(trim($slot), 1) }}
@endif
</a>
</td>
</tr>
