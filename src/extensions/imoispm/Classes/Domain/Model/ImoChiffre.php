<?php

declare(strict_types=1);

namespace Mg\Imoispm\Domain\Model;

/**
 * ImoChiffre
 */
class ImoChiffre extends \TYPO3\CMS\Extbase\DomainObject\AbstractEntity
{

    /**
     * chiffre
     *
     * @var string
     */
    protected $chiffre = '';

    /**
     * 
     *
     * @var int
     */
    protected $objectnr = 0;

    /**
     * unitnr
     *
     * @var int
     */
    protected $unitnr = 0;
    
    /**
     * userid
     *
     * @var int
     */
    protected $userid = 0;

    /**
     * Returns the chiffre
     *
     * @return string
     */
    public function getChiffre()
    {
        return $this->chiffre;
    }

    /**
     * Sets the chiffre
     *
     * @param string $chiffre
     * @return void
     */
    public function setChiffre(string $chiffre)
    {
        $this->chiffre = $chiffre;
    }

    /**
     * Returns the objectnr
     *
     * @return int
     */
    public function getObjectnr()
    {
        return $this->objectnr;
    }

    /**
     * Sets the objectnr
     *
     * @param int $objectnr
     * @return void
     */
    public function setObjectnr(int $objectnr)
    {
        $this->objectnr = $objectnr;
    }

    /**
     * Returns the unitnr
     *
     * @return int
     */
    public function getUnitnr()
    {
        return $this->unitnr;
    }

    /**
     * Sets the unitnr
     *
     * @param int $unitnr
     * @return void
     */
    public function setUnitnr(int $unitnr)
    {
        $this->unitnr = $unitnr;
    }

    /**
     * Returns the userid
     *
     * @return int
     */
    public function getUserid()
    {
        return $this->userid;
    }

    /**
     * Sets the userid
     *
     * @param int $userid
     * @return void
     */
    public function setUserid(int $userid)
    {
        $this->userid = $userid;
    }
}
