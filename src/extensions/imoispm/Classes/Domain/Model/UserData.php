<?php

namespace Mg\Imoispm\Domain\Model;

use TYPO3\CMS\Extbase\DomainObject\AbstractEntity;

class UserData extends AbstractEntity
{
    protected string $chiffre = '';
    protected int $objectnr = 0;
    protected string $usercookie = '';
    protected int $unitnr = 0;
    protected int $tstamp = 0;
    protected string $salutation = "";
    protected string $firstname = "";
    protected string $surname = "";
    protected string $email = "";
    protected string $telefon = "";

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

    public function getSalutation(): string
    {
        return $this->salutation;
    }

    public function setSalutation(string $salutation): void
    {
        $this->salutation = $salutation;
    }

    public function getFirstname(): string
    {
        return $this->firstname;
    }

    public function setFirstname(string $firstname): void
    {
        $this->firstname = $firstname;
    }

    public function getSurname(): string
    {
        return $this->surname;
    }

    public function setSurname(string $surname): void
    {
        $this->surname = $surname;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function setEmail(string $email): void
    {
        $this->email = $email;
    }

    public function getTelefon(): string
    {
        return $this->telefon;
    }

    public function setTelefon(string $telefon): void
    {
        $this->telefon = $telefon;
    }
}
