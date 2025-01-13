<?php

declare(strict_types=1);

namespace Mg\Imoispm\PageTitle;

use TYPO3\CMS\Core\PageTitle\AbstractPageTitleProvider;

final class ISPMPageTitleProvider extends AbstractPageTitleProvider
{
    public function setTitle(string $title): void
    {
        $this->title = "ISPM | " . $title;
    }

    public function getTitle(): string
    {
        return $this->title;
    }
}
