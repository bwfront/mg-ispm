<?php
declare(strict_types=1);

namespace Mg\Imoispm\Domain\Repository;

use Mg\Imoispm\Domain\Model\ChiffreLog as ModelChiffreLog;
use TYPO3\CMS\Extbase\Persistence\Repository;


class ChiffreLogRepository extends Repository
{
    /**
     * Adds a new Chiffre log entry.
     *
     * @param string $chiffre
     * @param string $usercookie
     * @param int $objectnr
     * @param int $unitnr
     */
    public function addLog(string $chiffre, string $usercookie, string $userip, int $objectnr, int $unitnr): void
    {
        $log = new ModelChiffreLog();
        $log->setPid(1);
        $log->setChiffre($chiffre);
        $log->setUsercookie($usercookie);
        $log->setUserip($userip);
        $log->setObjectnr($objectnr);
        $log->setUnitnr($unitnr);

        $this->add($log);
        $this->persistenceManager->persistAll();
    }

    public function findLogsForChiffre(string $chiffre): array
    {
        $query = $this->createQuery();
        $query->matching($query->equals('chiffre', $chiffre));
        return $query->execute()->toArray();
    }
}
