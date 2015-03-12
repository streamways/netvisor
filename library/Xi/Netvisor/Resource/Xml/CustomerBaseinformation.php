<?php

namespace Xi\Netvisor\Resource\Xml;

use Xi\Netvisor\Resource\Xml\Component\WrapperElement;
use Xi\Netvisor\Resource\Xml\Component\AttributeElement;

class CustomerBaseinformation
{

	private $internalidentifier;
    private $externalidentifier;
    private $name;
    private $nameextension;
    private $streetaddress;
	private $additionaladdressLine;
	private $city;
	private $postnumber;
	private $country;
	private $email;
	private $isactive;

	/**
	 * @param string $name
	 */
    public function __construct($name) {
    	$this->name = $name;
	}
	
	public function setInternalidentifier($internalidentifier) {
		$this->internalidentifier = $internalidentifier;
	}
	
	public function setExternalidentifier($externalidentifier) {
		$this->externalidentifier = $externalidentifier;
	}

	/**
	 * @param $additionaladdressLine
	 */
	public function setAdditionaladdressLine($additionaladdressLine) {
		$this->additionaladdressLine = $additionaladdressLine;
	}

	/**
	 * @param mixed $city
	 */
	public function setCity($city) {
		$this->city = $city;
	}

	/**
	 * @param mixed $country
	 */
	public function setCountry($country) {
		$this->country = new AttributeElement($country, array("type" => "ISO-3166"));
	}

	/**
	 * @param mixed $email
	 */
	public function setemail($email) {
		$this->email = $email;
	}

	/**
	 * @param mixed $isactive
	 */
	public function setIsactive($isActive) {
		$this->isactive = $isActive;
	}

	/**
	 * @param mixed $nameextension
	 */
	public function setNameextension($nameExtension) {
		$this->nameextension = $nameExtension;
	}

	/**
	 * @param mixed $postnumber
	 */
	public function setPostnumber($postnumber) {
		$this->postnumber = $postnumber;
	}

	/**
	 * @param mixed $streetaddress
	 */
	public function setStreetaddress($streetAddress) {
		$this->streetaddress = $streetAddress;
	}


}
