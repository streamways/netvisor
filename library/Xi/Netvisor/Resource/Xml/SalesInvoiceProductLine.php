<?php

namespace Xi\Netvisor\Resource\Xml;

use JMS\Serializer\Annotation\XmlList;
use Xi\Netvisor\Resource\Xml\Component\AttributeElement;

/**
 * Class SalesInvoiceProductLine
 *
 * @package Xi\Netvisor\Resource\Xml
 */
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
	private $productUnitName;

	/**
	 * @XmlList(inline = true, entry = "dimension")
	 */
	private $dimensions;

	/**
	 * @param int|string|array $productIdentifierData
	 * @param string           $productName
	 * @param array            $productUnitPrice
	 * @param string           $productVatPercentage
	 * @param int              $salesInvoiceProductLineQuantity
	 * @param array            $additionalFields
	 */
	public function __construct(
		$productIdentifierData,
		$productName,
		array $productUnitPrice,
		$productVatPercentage,
		$salesInvoiceProductLineQuantity,
		array $additionalFields = []
	) {
		if (is_array($productIdentifierData))
		{
			if (array_key_exists("type", $productIdentifierData))
			{
				$type = $productIdentifierData["type"];
			}
			else
			{
				$type = "netvisor";
			}
			$this->productIdentifier = new AttributeElement($productIdentifierData["productIdentifier"], ["type" => $type]);
		}
		else
		{
			$this->productIdentifier = new AttributeElement($productIdentifierData, ["type" => "netvisor"]);
		}
		$this->productName                     = substr($productName, 0, 200);
		$this->productUnitPrice                = new AttributeElement($productUnitPrice["price"], ["type" => $productUnitPrice["type"]]);
		$this->productVatPercentage            = new AttributeElement($productVatPercentage, ["vatcode" => "KOMY"]); // TODO: different values.
		$this->salesInvoiceProductLineQuantity = $salesInvoiceProductLineQuantity;

		foreach ($additionalFields as $key => $value)
		{
			$this->$key = $value;
		}
	}

	/**
	 * @param mixed $salesInvoiceProductLineFreeText
	 */
	public function setSalesInvoiceProductLineFreeText($salesInvoiceProductLineFreeText)
	{
		$this->salesInvoiceProductLineFreeText = $salesInvoiceProductLineFreeText;
	}

	/**
	 * @param string $productUnitName
	 *
	 * @return $this
	 */
	public function setProductUnitName(string $productUnitName): self
	{
		$this->productUnitName = $productUnitName;

		return $this;
	}

	/**
	 * @param string|float|int|null $salesInvoiceProductLineDiscountPercentage
	 *
	 * @return $this
	 */
	public function setSalesInvoiceProductLineDiscountPercentage($salesInvoiceProductLineDiscountPercentage): self
	{
		$this->salesInvoiceProductLineDiscountPercentage = $salesInvoiceProductLineDiscountPercentage;

		return $this;
	}
}
