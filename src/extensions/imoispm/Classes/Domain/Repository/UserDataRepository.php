<?php

declare(strict_types=1);

namespace Mg\Imoispm\Domain\Repository;

use TYPO3\CMS\Extbase\Persistence\QueryInterface;
use TYPO3\CMS\Extbase\Persistence\Repository;


class UserDataRepository extends Repository
{
    /**
     * Finds all UserData objects ordered by tstamp (newest first).
     *
     * @return \TYPO3\CMS\Extbase\Persistence\QueryResultInterface
     */
    public function findAllOrderedByTimestamp()
    {
        $query = $this->createQuery();
        $query->setOrderings(['tstamp' => QueryInterface::ORDER_DESCENDING]);
        return $query->execute();
    }

    /**
     * Find all UserData entries with a specific chiffre sorted by tstamp (newest first).
     *
     * @param string $chiffre
     * @return \TYPO3\CMS\Extbase\Persistence\QueryResultInterface|array
     */
    public function findByChiffreOrderedByDate(string $chiffre)
    {
        $query = $this->createQuery();

        // Set filter for chiffre
        $query->matching(
            $query->equals('chiffre', $chiffre)
        );

        // Set order by tstamp descending (newest first)
        $query->setOrderings(['tstamp' => QueryInterface::ORDER_DESCENDING]);

        return $query->execute();
    }
}
