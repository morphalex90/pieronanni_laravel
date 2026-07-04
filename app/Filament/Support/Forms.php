<?php

declare(strict_types=1);

namespace App\Filament\Support;

use Filament\Forms\Components\MarkdownEditor;

final class Forms
{
    public static function markdown(string $name, int $maxLength): MarkdownEditor
    {
        return MarkdownEditor::make($name)
            ->maxLength($maxLength)
            ->required()
            ->hint(fn ($state, $component) => mb_strlen($state ?? '') . '/' . $component->getMaxLength() . ' characters')
            ->lazy()
            ->disableToolbarButtons(['attachFiles', 'codeBlock', 'heading', 'orderedList', 'table', 'blockquote', 'strike']);
    }
}
