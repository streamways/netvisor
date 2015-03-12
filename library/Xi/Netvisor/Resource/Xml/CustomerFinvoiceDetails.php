<?php
/**
 * Created by Seapoint.
 * User: juhni
 * Date: 3/10/15
 * Time: 5:38 PM
 */

namespace Xi\Netvisor\Resource\Xml;

class CustomerFinvoiceDetails
{

	private $finvoiceaddress;
	private $finvoiceroutercode;

	public function __construct() {

	}

	/**
	 * @param mixed $finvoiceaddress
	 */
	public function setFinvoiceaddress($finvoiceaddress) {
		$this->finvoiceaddress = $finvoiceaddress;
	}

	/**
	 * @param mixed $finvoiceroutercode
	 */
	public function setFinvoiceroutercode($finvoiceroutercode) {
		$this->finvoiceroutercode = $finvoiceroutercode;
	}


}