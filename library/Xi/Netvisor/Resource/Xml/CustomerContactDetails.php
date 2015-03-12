<?php
/**
 * Created by Seapoint.
 * User: juhni
 * Date: 3/10/15
 * Time: 5:38 PM
 */

namespace Xi\Netvisor\Resource\Xml;

class CustomerContactDetails
{

	private $contactname;
	private $contactperson;
	private $contactpersonemail;
	private $contactpersonphone;

	public function __construct() {

	}

	/**
	 * @param mixed $contactname
	 */
	public function setContactname($contactname) {
		$this->contactname = $contactname;
	}

	/**
	 * @param mixed $contactperson
	 */
	public function setContactperson($contactperson) {
		$this->contactperson = $contactperson;
	}

	/**
	 * @param mixed $contactpersonemail
	 */
	public function setContactpersonemail($contactpersonemail) {
		$this->contactpersonemail = $contactpersonemail;
	}

	/**
	 * @param mixed $contactpersonphone
	 */
	public function setContactpersonphone($contactpersonphone) {
		$this->contactpersonphone = $contactpersonphone;
	}
}