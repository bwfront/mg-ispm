<?php

declare(strict_types=1);

namespace Mg\Imoispm\Domain\Repository;

/**
 * The repository for ImoChiffres
 */
class ImoChiffreRepository extends \TYPO3\CMS\Extbase\Persistence\Repository
{

    /**
     * @param string $chiffre
     */
    public function findByUnitnrDelete(int $unitnr)
    {
        $query = $this->createQuery();
        $result = $query->matching($query->equals('unitnr', $unitnr))->execute();
        if ($result->count() > 0) {
            return $result->getFirst();
        }
        return null;
    }

    /**
     * Find Chiffre by UnitNr
     *
     * @param int $unitnr
     * @return Mg\Imoispm\Domain\Model\ImoUnits|null
     */
    public function findByUnitnr(int $unitnr)
    {
        $query = $this->createQuery();
        $query->matching(
            $query->equals('unitnr', $unitnr)
        );
        return $query->execute()->getFirst();
    }

    /**
     * Find Chiffre by UnitNr
     *
     * @param int $unitnr
     * @return Mg\Imoispm\Domain\Model\ImoUnits|null
     */
    public function findByChiffre(string $chiffre)
    {
        $query = $this->createQuery();
        $query->matching(
            $query->equals('chiffre', $chiffre)
        );
        return $query->execute()->getFirst();
    }
}
