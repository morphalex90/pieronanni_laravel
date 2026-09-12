<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
<title>{{ config('app.name') }}</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<meta name="color-scheme" content="dark">
<meta name="supported-color-schemes" content="dark light">
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Fira+Mono:wght@400;500;700&display=swap" rel="stylesheet">
<style>
:root {
color-scheme: dark;
supported-color-schemes: dark light;
}

/* The site is dark-only, so the email is dark in every client. These rules
   re-assert that against clients that rewrite colors for their own dark mode. */

/* Outlook.com / Outlook mobile prefix classes with data-ogsc (text) / data-ogsb (background) */
[data-ogsb] body,
[data-ogsb] .wrapper,
[data-ogsb] .content,
[data-ogsb] .body,
[data-ogsb] .inner-body,
[data-ogsb] .footer,
[data-ogsb] .content-cell,
[data-ogsc] body,
[data-ogsc] .wrapper,
[data-ogsc] .content,
[data-ogsc] .body,
[data-ogsc] .inner-body,
[data-ogsc] .footer,
[data-ogsc] .content-cell {
background-color: #000000 !important;
}

[data-ogsc] .panel-content {
background-color: #0d0d0d !important;
}

[data-ogsc] h1,
[data-ogsc] h2,
[data-ogsc] h3,
[data-ogsc] .content-cell p,
[data-ogsc] .table td,
[data-ogsc] .table th,
[data-ogsc] .panel-content p,
[data-ogsc] .header a {
color: #ffffff !important;
}

[data-ogsc] .button {
color: #ffffff !important;
}

[data-ogsb] .button-cell {
background-color: #000000 !important;
}

[data-ogsc] .content-cell a:not(.button),
[data-ogsc] .header-accent {
color: #ff1493 !important;
}

[data-ogsc] .footer p,
[data-ogsc] .footer a,
[data-ogsc] .subcopy p {
color: #b4b4b4 !important;
}

/* Gmail / Apple Mail dark mode: keep the dark palette instead of an inverted one */
@media (prefers-color-scheme: dark) {
body,
.wrapper,
.content,
.body,
.inner-body,
.footer,
.content-cell {
background-color: #000000 !important;
}

h1,
h2,
h3,
.content-cell p,
.table td,
.table th {
color: #ffffff !important;
}

.content-cell a:not(.button) {
color: #ff1493 !important;
}

.button {
color: #ffffff !important;
}

.button-cell {
background-color: #000000 !important;
}

.footer p,
.footer a,
.subcopy p {
color: #b4b4b4 !important;
}
}

/* Mobile */
@media only screen and (max-width: 600px) {
.inner-body {
width: 100% !important;
}

.footer {
width: 100% !important;
}

.body {
padding: 0 12px !important;
}

.content-cell {
padding: 24px !important;
}

.header {
padding: 20px 0 !important;
}

.header a {
font-size: 17px !important;
}

h1 {
font-size: 20px !important;
}

.table table,
pre {
display: block !important;
overflow-x: auto !important;
}

.button-cell {
padding: 14px 20px !important;
}
}
</style>
{!! $head ?? '' !!}
</head>
<body bgcolor="#000000" style="background-color: #000000;">

<table class="wrapper" width="100%" bgcolor="#000000" cellpadding="0" cellspacing="0" role="presentation">
<tr>
<td align="center" bgcolor="#000000">
<table class="content" width="100%" cellpadding="0" cellspacing="0" role="presentation">
{!! $header ?? '' !!}

<!-- Email Body -->
<tr>
<td class="body" width="100%" cellpadding="0" cellspacing="0" bgcolor="#000000" style="border: hidden !important;">
<table class="inner-body" align="center" width="570" bgcolor="#000000" cellpadding="0" cellspacing="0" role="presentation">
<!-- Body content -->
<tr>
<td class="content-cell">
{!! Illuminate\Mail\Markdown::parse($slot) !!}

{!! $subcopy ?? '' !!}
</td>
</tr>
</table>
</td>
</tr>

{!! $footer ?? '' !!}
</table>
</td>
</tr>
</table>
</body>
</html>
