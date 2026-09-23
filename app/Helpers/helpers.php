<?php

declare(strict_types=1);

use Illuminate\Support\Str;

if (! function_exists('safeMarkdownDom')) {
    /**
     * Render admin-authored markdown into a DOM wrapped in a single root div.
     * Raw HTML (and with it any event handler attribute) is stripped, unsafe
     * link schemes are dropped, and images are removed so a PDF renderer never
     * fetches a URL chosen by the content author.
     */
    function safeMarkdownDom(string $markdown): DOMDocument
    {
        $html = Str::markdown($markdown, [
            'html_input' => 'strip',
            'allow_unsafe_links' => false,
        ]);

        $dom = new DOMDocument();
        $dom->loadHTML('<?xml encoding="UTF-8"><div>' . $html . '</div>', LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);

        foreach (iterator_to_array($dom->getElementsByTagName('img')) as $image) {
            $image->parentNode?->removeChild($image);
        }

        return $dom;
    }
}

if (! function_exists('safeMarkdown')) {
    function safeMarkdown(string $markdown): string
    {
        $dom = safeMarkdownDom($markdown);

        return (string) $dom->saveHTML($dom->getElementsByTagName('div')->item(0));
    }
}

if (! function_exists('parseMarkdownWithClasses')) {
    function parseMarkdownWithClasses(string $markdown): string
    {
        $dom = safeMarkdownDom($markdown);

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
