<?php

declare(strict_types=1);

namespace App\Support\Csp;

use Spatie\Csp\Directive;
use Spatie\Csp\Keyword;
use Spatie\Csp\Policy;
use Spatie\Csp\Preset;
use Spatie\Csp\Scheme;

/**
 * Policy for the Horizon dashboard.
 *
 * Horizon ships a pre-built Vue bundle with inline bootstrap scripts that
 * carry no nonce, data: URI images and a Bunny Fonts stylesheet. The
 * application policy blocks all three, so the dashboard gets its own
 * relaxed policy. No nonce is added to script-src, otherwise the browser
 * would ignore 'unsafe-inline' and Horizon's inline scripts stay blocked.
 */
final class HorizonPreset implements Preset
{
    public function configure(Policy $policy): void
    {
        $policy
            ->add(Directive::BASE, Keyword::SELF)
            ->add(Directive::DEFAULT, Keyword::SELF)
            ->add(Directive::CONNECT, Keyword::SELF)
            ->add(Directive::FORM_ACTION, Keyword::SELF)
            ->add(Directive::FRAME_ANCESTORS, Keyword::SELF)
            ->add(Directive::OBJECT, Keyword::NONE)
            ->add(Directive::IMG, [Keyword::SELF, Scheme::DATA])
            ->add(Directive::FONT, [Keyword::SELF, Scheme::DATA, 'https://fonts.bunny.net'])
            ->add(Directive::STYLE, [Keyword::SELF, Keyword::UNSAFE_INLINE, 'https://fonts.bunny.net'])
            ->add(Directive::SCRIPT, [Keyword::SELF, Keyword::UNSAFE_INLINE, Keyword::UNSAFE_EVAL]);
    }
}
