<?php

declare(strict_types=1);

namespace Mg\Imoispm\Domain\Model;

/**
 * ImoUnits
 */
class ImoUnits extends \TYPO3\CMS\Extbase\DomainObject\AbstractEntity
{

    /**
     * chiffre
     *
     * @var string
     */
    public $chiffre = '';

    /**
     * number
     *
     * @var string
     */
    protected $number = '';

    /**
     * placeholder
     *
     * @var string
     */
    protected $placeholder = '';

    /**
     * offer
     *
     * @var string
     */
    protected $offer = '';

    /**
     * imoobjectuid
     *
     * @var int
     */
    protected $imoobjectuid = '';

    /**
     * Sets the imoobject_uid
     *
     * @param int $imoobject_uid
     */
    public function setImoobjectuid(int $imoobjectuid)
    {
        $this->imoobjectuid = $imoobjectuid;
    }

    /**
     * Returns the imoobject_uid
     *
     * @return int
     */
    public function getImoobjectuid()
    {
        return $this->imoobjectuid;
    }

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
     * Returns the number
     *
     * @return string
     */
    public function getNumber()
    {
        return $this->number;
    }

    /**
     * Sets the number
     *
     * @param string $number
     * @return void
     */
    public function setNumber(string $number)
    {
        $this->number = $number;
    }

    /**
     * Returns the placeholder
     *
     * @return string
     */
    public function getPlaceholder()
    {
        return $this->placeholder;
    }

    /**
     * Sets the number
     *
     * @param string $placeholder
     * @return void
     */
    public function setPlaceholder(string $placeholder)
    {
        $this->placeholder = $placeholder;
    }

    /**
     * Returns the offer
     *
     * @return string
     */
    public function getOffer()
    {
        return $this->offer;
    }

    /**
     * Sets the offer
     *
     * @param string $offer
     * @return void
     */
    public function setOffer(string $offer)
    {
        $this->offer = $offer;
    }
}
