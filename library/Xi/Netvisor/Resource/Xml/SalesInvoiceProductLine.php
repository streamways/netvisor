<?php

namespace Xi\Netvisor\Resource\Xml;

use JMS\Serializer\Annotation\XmlList;
use Xi\Netvisor\Resource\Xml\Component\AttributeElement;

class SalesInvoiceProductLine
{
    private $productIdentifier;
    private $productName;
    private $productUnitPrice;
    private $productUnitPurchasePrice;
    private $productVatPercentage;
    private $salesInvoiceProductLineQuantity;
    private $salesInvoiceProductLineDiscountPercentage;
    private $salesInvoiceProductLineFreeText;
    private $salesInvoiceProductLineVatSum;
    private $salesInvoiceProductLineSum;
    private $accountingAccountSuggestion;
    private $skipAccrual;

    /**
     * @XmlList(inline = true, entry = "dimension")
     */
    private $dimensions;

    /**
     * @param string $productIdentifier
     * @param string $productName
     * @param array $productUnitPrice
     * @param string $productVatPercentage
     * @param int $salesInvoiceProductLineQuantity
     * @param array $additionalFields
     */
    public function __construct(
        $productIdentifier,
        $productName,
        array $productUnitPrice,
        $productVatPercentage,
        $salesInvoiceProductLineQuantity,
        array $additionalFields = []
    ) {
        $this->productIdentifier = new AttributeElement($productIdentifier, array('type' => 'netvisor')); // TODO: netvisor/customer.
        $this->productName = substr($productName, 0, 50);
        $this->productUnitPrice = new AttributeElement($productUnitPrice["price"], array('type' => $productUnitPrice["type"]));
        $this->productVatPercentage = new AttributeElement($productVatPercentage, array('vatcode' => 'KOMY')); // TODO: different values.
        $this->salesInvoiceProductLineQuantity = $salesInvoiceProductLineQuantity;

		foreach ($additionalFields as $key => $value) {
			$this->$key = $value;
		}
	}

	/**
	 * @param mixed $salesInvoiceProductLineFreeText
	 */
	public function setSalesInvoiceProductLineFreeText($salesInvoiceProductLineFreeText) {
		$this->salesInvoiceProductLineFreeText = $salesInvoiceProductLineFreeText;
	}
}
