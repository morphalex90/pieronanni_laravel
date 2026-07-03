<?php

declare(strict_types=1);

namespace App\Support\Csp;

use Spatie\Csp\Directive;
use Spatie\Csp\Keyword;
use Spatie\Csp\Policy;
use Spatie\Csp\Preset;

/**
 * Same as Spatie's Basic preset, but it does NOT add a nonce to the
 * style-src directive.
 *
 * A nonce can only authorise <style> elements, never inline style=""
 * attributes. Our SSR output and framer-motion both write inline style
 * attributes, which can only be allowed via 'unsafe-inline'. As soon as a
 * nonce is present in style-src the browser ignores 'unsafe-inline', so
 * nonce-ing style-src breaks every inline style. Script-src keeps its nonce.
 */
class BasicWithoutStyleNonce implements Preset
{
    public function configure(Policy $policy): void
    {
        $policy
            ->add(Directive::BASE, Keyword::SELF)
            ->add(Directive::CONNECT, Keyword::SELF)
            ->add(Directive::DEFAULT, Keyword::SELF)
            ->add(Directive::FONT, Keyword::SELF)
            ->add(Directive::FORM_ACTION, Keyword::SELF)
            ->add(Directive::FRAME, Keyword::SELF)
            ->add(Directive::IMG, Keyword::SELF)
            ->add(Directive::MEDIA, Keyword::SELF)
            ->add(Directive::OBJECT, Keyword::NONE)
            ->add(Directive::SCRIPT, Keyword::SELF)
            ->add(Directive::STYLE, Keyword::SELF)
            ->addNonce(Directive::SCRIPT);
    }
}
