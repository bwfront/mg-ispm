<?php

namespace Mg\Imoispm\Domain\Model;

use TYPO3\CMS\Extbase\DomainObject\AbstractEntity;

class ChiffreLog extends AbstractEntity
{
    protected string $chiffre = '';
    protected string $usercookie = '';
    protected string $userip = '';
    protected int $objectnr = 0;
    protected int $unitnr = 0;
    protected int $tstamp = 0;

    public function getChiffre(): string
    {
        return $this->chiffre;
    }

    public function setChiffre(string $chiffre): void
    {
        $this->chiffre = $chiffre;
    }

    public function getUsercookie(): string
    {
        return $this->usercookie;
    }

    public function setUserip(string $userip): void
    {
        $this->userip = $userip;
    }

    public function getUserip(): string
    {
        return $this->userip;
    }

    public function setUsercookie(string $usercookie): void
    {
        $this->usercookie = $usercookie;
    }

    public function getObjectnr(): int
    {
        return $this->objectnr;
    }

    public function setObjectnr(int $objectnr): void
    {
        $this->objectnr = $objectnr;
    }

    public function getUnitnr(): int
    {
        return $this->unitnr;
    }

    public function setUnitnr(int $unitnr): void
    {
        $this->unitnr = $unitnr;
    }

    public function getTstamp(): int
    {
        return $this->tstamp;
    }

    public function setTstamp(int $tstamp): void
    {
        $this->tstamp = $tstamp;
    }
}
