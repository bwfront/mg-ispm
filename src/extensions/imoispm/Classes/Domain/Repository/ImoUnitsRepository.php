<?php

declare(strict_types=1);

namespace Mg\Imoispm\Domain\Repository;

/**
 * The repository for ImoUnits
 */
class ImoUnitsRepository extends \TYPO3\CMS\Extbase\Persistence\Repository
{

    /**
     * @param array $uids
     */
    public function findByUids(array $uids)
    {
        $query = $this->createQuery();
        $query->matching($query->in('uid', $uids));
        return $query->execute();
    }
}
