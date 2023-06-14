<?php declare(strict_types=1);

namespace PixzlFooterEditor;
use Shopware\Core\Framework\Plugin;

class PixzlFooterEditor extends Plugin
{
    public function rebuildContainer(): bool
    {
        return false;
    }
	
}