<?php
declare(strict_types=1);

namespace Mg\Imoispm\Domain\Repository;

use TYPO3\CMS\Extbase\Persistence\Repository;
use TYPO3\CMS\Extbase\Persistence\Generic\QuerySettingsInterface;
use TYPO3\CMS\Core\Utility\GeneralUtility;

class FrontendUserRepository extends Repository
{
    public function findAllFromPid(int $pid = 10)
    {
        $query = $this->createQuery();

        $querySettings = GeneralUtility::makeInstance(QuerySettingsInterface::class);
        $querySettings->setRespectStoragePage(false);
        $querySettings->setStoragePageIds([$pid]);
        $query->setQuerySettings($querySettings);

        return $query->execute();
    }
}
