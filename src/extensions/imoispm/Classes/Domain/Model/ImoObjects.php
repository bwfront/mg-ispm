<?php

declare(strict_types=1);

namespace Mg\Imoispm\Domain\Model;

/**
 * ImoObjects
 */
class ImoObjects extends \TYPO3\CMS\Extbase\DomainObject\AbstractEntity
{

    /**
     * city
     *
     * @var string
     */
    protected $city = '';

    /**
     * state
     *
     * @var string
     */
    protected $state = '';

    /**
     * street
     *
     * @var string
     */
    protected $street = '';

    /**
     * streetnumber
     *
     * @var string
     */
    protected $streetnumber = '';

    /**
     * postalcode
     *
     * @var string
     */
    protected $postalcode = 0;

    /**
     * Returns the city
     *
     * @return string
     */
    public function getCity()
    {
        return $this->city;
    }

    /**
     * Sets the city
     *
     * @param string $city
     * @return void
     */
    public function setCity(string $city)
    {
        $this->city = $city;
    }

    /**
     * Gets the state
     *
     * @return string $state
     */
    public function getState()
    {
        return $this->state;
    }

    /**
     * Sets the state
     *
     * @param string $state New value for the state
     */
    public function setState($state)
    {
        $this->state = $state;
    }

    /**
     * Returns the street
     *
     * @return string
     */
    public function getStreet()
    {
        return $this->street;
    }

    /**
     * Sets the street
     *
     * @param string $street
     * @return void
     */
    public function setStreet(string $street)
    {
        $this->street = $street;
    }

    /**
     * Returns the streetnumber
     *
     * @return string
     */
    public function getStreetnumber()
    {
        return $this->streetnumber;
    }

    /**
     * Sets the streetnumber
     *
     * @param string $streetnumber
     * @return void
     */
    public function setStreetnumber(string $streetnumber)
    {
        $this->streetnumber = $streetnumber;
    }

    /**
     * Returns the postalcode
     *
     * @return string
     */
    public function getPostalcode()
    {
        return $this->postalcode;
    }

    /**
     * Sets the postalcode
     *
     * @param string $postalcode
     * @return void
     */
    public function setPostalcode(string $postalcode)
    {
        $this->postalcode = $postalcode;
    }
}
