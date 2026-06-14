<?php

declare(strict_types=1);

namespace App\Helpers;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\HtmlString;

/**
 * Builds <link rel="preload"> tags for only the latin subsets of the locally
 * cached Google Fonts, parsed straight from the package-generated fonts.css.
 *
 * Spatie's built-in `preload` option emits every subset/weight (cyrillic, greek,
 * vietnamese, ...). Because browsers ignore `unicode-range` for preloaded fonts,
 * that force-downloads ~230 KB the page never renders. Latin is all an English
 * page needs above the fold, so we preload just those files. No hashes are
 * hardcoded: URLs are read from the generated CSS, so they survive a re-fetch.
 */
final class GoogleFontsPreload
{
    /**
     * @param  string  $font  Key from config('google-fonts.fonts')
     */
    public static function latinLinks(string $font = 'default'): HtmlString
    {
        $url = config("google-fonts.fonts.{$font}");

        if (! is_string($url)) {
            return new HtmlString('');
        }

        $disk = Storage::disk(config('google-fonts.disk'));
        $cssPath = config('google-fonts.path') . '/' . mb_substr(md5($url), 0, 10) . '/fonts.css';

        if (! $disk->exists($cssPath)) {
            return new HtmlString('');
        }

        // Re-fetching keeps the same folder (md5 of the URL) but rewrites the
        // woff2 filenames, so key the cache on the file's last-modified time.
        $cacheKey = "google-fonts-preload:{$font}:" . $disk->lastModified($cssPath);

        $html = Cache::rememberForever($cacheKey, static function () use ($disk, $cssPath): string {
            return self::build($disk->get($cssPath));
        });

        return new HtmlString($html);
    }

    private static function build(string $css): string
    {
        preg_match_all('/@font-face\s*{([^}]*)}/i', $css, $blocks);

        $links = [];

        foreach ($blocks[1] as $block) {
            // Only the latin subset (its unicode-range covers basic latin) and
            // upright styles, which is what renders above the fold.
            if (! str_contains($block, 'U+0000-00FF')) {
                continue;
            }

            if (! preg_match('/font-style:\s*normal/i', $block)) {
                continue;
            }

            if (! preg_match('/src:\s*url\(([^)]+)\)/i', $block, $match)) {
                continue;
            }

            // The CSS stores absolute URLs built from APP_URL at fetch time, so
            // reduce to a root-relative path to stay correct across environments.
            $path = parse_url(mb_trim($match[1], '\'"'), PHP_URL_PATH);

            if (! is_string($path)) {
                continue;
            }

            $links[$path] = sprintf(
                '<link rel="preload" href="%s" as="font" type="font/woff2" crossorigin>',
                e($path),
            );
        }

        return implode("\n", $links);
    }
}
