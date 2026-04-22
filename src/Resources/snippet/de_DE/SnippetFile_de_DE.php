<?php declare(strict_types=1);

namespace PixzlFooterEditor\Resources\snippet\de_DE;

use Shopware\Core\System\Snippet\Files\SnippetFileInterface;

class SnippetFile_de_DE implements SnippetFileInterface
{
    public function getName(): string
    {
        return 'pixzl-footer.de-DE';
    }

    public function getPath(): string
    {
        return __DIR__ . '/pixzl-footer.de-DE.json';
    }

    public function getIso(): string
    {
        return 'de-DE';
    }

    public function getAuthor(): string
    {
        return 'Pixzl';
    }

    public function isBase(): bool
    {
        return false;
    }
}
