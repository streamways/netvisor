<?php

namespace Xi\Netvisor\Resource\Xml;

use Xi\Netvisor\Resource\Xml\Component\AttributeElement;

class CustomerDeliveryDetails
{
	private $deliveryname;
	private $deliverystreetaddress;
	private $deliverycity;
	private $deliverypostnumber;
	private $deliverycountry;

	public function __construct() {

	}

	/**
	 * @param mixed $deliverycity
	 */
	public function setDeliverycity($deliverycity) {
		$this->deliverycity = $deliverycity;
	}

	/**
	 * @param mixed $deliverycountry
	 */
	public function setDeliverycountry($deliverycountry) {
		$this->deliverycountry = new AttributeElement($deliverycountry, array("type" => "ISO-3166"));
	}

	/**
	 * @param mixed $deliveryname
	 */
	public function setDeliveryname($deliveryname) {
		$this->deliveryname = $deliveryname;
	}

	/**
	 * @param mixed $deliverypostnumber
	 */
	public function setDeliverypostnumber($deliverypostnumber) {
		$this->deliverypostnumber = $deliverypostnumber;
	}

	/**
	 * @param mixed $deliverystreetaddress
	 */
	public function setDeliverystreetaddress($deliverystreetaddress) {
		$this->deliverystreetaddress = $deliverystreetaddress;
	}
}
