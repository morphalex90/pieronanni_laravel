<?php

declare(strict_types=1);

it('strips raw html and event handlers from cv markdown', function (): void {
    $html = safeMarkdown("- item <img src=x onerror=\"alert(1)\">\n\n<script>alert(1)</script>");

    expect($html)->toContain('<li>item')
        ->not->toContain('onerror')
        ->not->toContain('<script')
        ->not->toContain('<img');
});

it('removes markdown images so the renderer never fetches them', function (): void {
    $html = safeMarkdown('Text ![x](http://169.254.169.254/latest/meta-data)');

    expect($html)->toContain('Text')
        ->not->toContain('<img')
        ->not->toContain('169.254.169.254');
});

it('drops unsafe link schemes but keeps safe links', function (): void {
    $html = safeMarkdown('[bad](javascript:alert(1)) [good](https://example.com)');

    expect($html)->not->toContain('javascript:')
        ->toContain('href="https://example.com"');
});

it('keeps the tailwind classes applied to cv lists', function (): void {
    $html = parseMarkdownWithClasses("- one\n- two <b onclick=\"x()\">bold</b>");

    expect($html)->toContain('list-disc')
        ->toContain('text-sm')
        ->not->toContain('onclick');
});
