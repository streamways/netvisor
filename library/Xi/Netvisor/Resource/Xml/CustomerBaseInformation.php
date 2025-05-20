<?php

namespace Xi\Netvisor\Resource\Xml;

use Xi\Netvisor\Resource\Xml\Component\WrapperElement;
use Xi\Netvisor\Resource\Xml\Component\AttributeElement;

class CustomerBaseInformation
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
	private $isActive;
	private $isPrivateCustomer;

	/**
	 * @param string $name
	 */
	public function __construct($name) {
		$this->name = $name;
	}

	public function setInternalIdentifier($internalidentifier) {
		$this->internalidentifier = $internalidentifier;
	}

	public function setExternalIdentifier($externalidentifier) {
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
	public function setEmail($email) {
		$this->email = $email;
	}

	/**
	 * @param mixed $isactive
	 */
	public function setIsActive($isActive) {
		$this->isActive = $isActive;
	}

	/**
	 * @param mixed $nameextension
	 */
	public function setNameExtension($nameExtension) {
		$this->nameextension = $nameExtension;
	}

	/**
	 * @param mixed $postnumber
	 */
	public function setPostNumber($postnumber) {
		$this->postnumber = $postnumber;
	}

	/**
	 * @param mixed $streetaddress
	 */
	public function setStreetAddress($streetAddress) {
		$this->streetaddress = $streetAddress;
	}

	/**
	 * @param mixed $isPrivateCustomer
	 */
	public function setIsPrivateCustomer($isPrivateCustomer) {
		$this->isPrivateCustomer = $isPrivateCustomer;
	}
}
