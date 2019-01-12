<?php

namespace Xi\Netvisor\Resource\Xml;

use JMS\Serializer\Annotation\XmlList;
use Xi\Netvisor\Resource\Xml\Component\Root;
use Xi\Netvisor\Resource\Xml\Component\AttributeElement;
use Xi\Netvisor\Resource\Xml\Component\WrapperElement;

class Customer extends Root
{
	/** @var $customerbaseinformation CustomerBaseinformation */
	private $customerbaseinformation;

	/** @var $customerfinvoicedetails CustomerFinvoiceDetails */
    private $customerfinvoicedetails;

    /** @var $customerdeliverydetails CustomerDeliveryDetails */
    private $customerdeliverydetails;

	/** @var $customercontactdetails CustomerContactDetails */
    private $customercontactdetails;

    /** @var CustomerAdditionalInformation */
    private $customerAdditionalInformation;

    public function __construct() {

    }

	/**
	 * @param CustomerBaseinformation $customerbaseinformation
	 */
	public function setCustomerbaseinformation(CustomerBaseinformation $customerbaseinformation) {
		$this->customerbaseinformation = $customerbaseinformation;
	}

	/**
	 * @param CustomerContactDetails $customercontactdetails
	 */
	public function setCustomercontactdetails(CustomerContactDetails $customercontactdetails) {
		$this->customercontactdetails = $customercontactdetails;
	}

	/**
	 * @param CustomerDeliveryDetails $customerdeliverydetails
	 */
	public function setCustomerdeliverydetails(CustomerDeliveryDetails $customerdeliverydetails) {
		$this->customerdeliverydetails = $customerdeliverydetails;
	}

	/**
	 * @param CustomerFinvoiceDetails $customerfinvoicedetails
	 */
	public function setCustomerfinvoicedetails(CustomerFinvoiceDetails $customerfinvoicedetails) {
		$this->customerfinvoicedetails = $customerfinvoicedetails;
	}

    /**
     * @param CustomerAdditionalInformation $customerAdditionalInformation
     */
	public function setCustomerAdditionalInformation(CustomerAdditionalInformation $customerAdditionalInformation) {
	    $this->customerAdditionalInformation = $customerAdditionalInformation;
    }

    public function getDtdPath()
    {
        return $this->getDtdFile('customer.dtd');
    }

    protected function getXmlName()
    {
        return 'customer';
    }
}
