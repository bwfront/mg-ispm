<?php
declare(strict_types=1);

namespace Mg\Imoispm\Hooks;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use TYPO3\CMS\Core\Error\PageErrorHandler\PageErrorHandlerInterface;
use TYPO3\CMS\Core\Http\RedirectResponse;
use TYPO3\CMS\Site\Entity\Site;

class ErrorHandler implements PageErrorHandlerInterface
{
    private const PAGE_LOGIN = 7;
    private const PAGE_DASHBOARD = 12;

    public function handlePageError(ServerRequestInterface $request, string $message, array $reasons = []): ResponseInterface
    {
        $frontendUser = $request->getAttribute('frontend.user');

        $targetPageId = self::PAGE_LOGIN;
        if ($frontendUser && $frontendUser->user) {
            $targetPageId = self::PAGE_DASHBOARD;
        }

        /** @var Site $site */
        $site = $request->getAttribute('site');

        // If multilingual -> language_uid here
        $parameters = [];

        $uri = $site->getRouter()->generateUri($targetPageId, $parameters);

        return new RedirectResponse($uri, 303);
    }
}
