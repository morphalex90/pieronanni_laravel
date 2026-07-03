<?php

declare(strict_types=1);

use Illuminate\Support\Str;

if (! function_exists('parseMarkdownWithClasses')) {
    function parseMarkdownWithClasses(string $markdown): string
    {
        $html = Str::markdown($markdown);

        $dom = new DOMDocument();
        $dom->loadHTML('<div>' . $html . '</div>', LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);

        $uls = $dom->getElementsByTagName('ul');
        foreach ($uls as $ul) {
            $existing = $ul->getAttribute('class');
            $ul->setAttribute('class', $existing . ' list-disc list-inside space-y-1');
        }

        $lis = $dom->getElementsByTagName('li');
        foreach ($lis as $li) {
            $existing = $li->getAttribute('class');
            $li->setAttribute('class', $existing . ' text-sm text-[#1C1C1C] font-light');
        }

        return (string) $dom->saveHTML($dom->getElementsByTagName('div')->item(0));
    }
}
