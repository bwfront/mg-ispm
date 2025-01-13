<?php

declare(strict_types=1);

namespace Mg\Imoispm\Domain\Repository;


/**
 * The repository for ImoObjects
 */
class ImoObjectsRepository extends \TYPO3\CMS\Extbase\Persistence\Repository
{
    /**
     * Override findAll to accept orderings
     *
     * @param array $orderings
     * @return \TYPO3\CMS\Extbase\Persistence\QueryResultInterface
     */
    public function findAll(array $orderings = []): \TYPO3\CMS\Extbase\Persistence\QueryResultInterface
    {
        $query = $this->createQuery();
        if (!empty($orderings)) {
            $query->setOrderings($orderings);
        }
        return $query->execute();
    }

    /**
     * Find ImoObjects with the objectNrs
     *
     * @param array $objectNrs
     * @param array $orderings
     * @return \TYPO3\CMS\Extbase\Persistence\QueryResultInterface
     */
    public function findByIdentifiersWithSorting(array $objectNrs, array $orderings = []): \TYPO3\CMS\Extbase\Persistence\QueryResultInterface
    {
        $query = $this->createQuery();
        $query->matching(
            $query->in('uid', $objectNrs)
        );
        if (!empty($orderings)) {
            $query->setOrderings($orderings);
        }
        return $query->execute();
    }
}

