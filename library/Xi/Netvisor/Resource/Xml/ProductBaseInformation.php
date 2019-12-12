<?php

namespace Xi\Netvisor\Resource\Xml;

use Xi\Netvisor\Resource\Xml\Component\AttributeElement;

/**
 * Class ProductBaseInformation
 *
 * @package Xi\Netvisor\Resource\Xml
 */
class ProductBaseInformation
{
	private $productCode;
	private $productGroup;
	private $name;
	private $description;
	private $unitPrice;
	private $unit;
	private $purchasePrice;
	private $tariffHeading;
	private $comissionPercentage;
	private $isActive;
	private $isSalesProduct;
	private $inventoryEnabled;
	private $countyOfOrigin;

	/**
	 * ProductBaseInformation constructor.
	 *
	 * @param string $name
	 */
	public function __construct($name)
	{
		$this->name = $name;
	}

	/**
	 * @param $productCode
	 */
	public function setProductCode($productCode)
	{
		$this->productCode = $productCode;
	}

	/**
	 * @param $productGroup
	 */
	public function setProductGroup($productGroup)
	{
		$this->productGroup = $productGroup;
	}

	/**
	 * @param $unit
	 */
	public function setUnit($unit)
	{
		$this->unit = $unit;
	}

	/**
	 * @param mixed $tariffHeading
	 */
	public function setTariffHeading($tariffHeading)
	{
		$this->tariffHeading = $tariffHeading;
	}

	/**
	 * @param mixed $comissionPercentage
	 */
	public function setComissionPercentage($comissionPercentage)
	{
		$this->comissionPercentage = $comissionPercentage;
	}

	/**
	 * @param mixed $isActive
	 */
	public function setIsActive($isActive)
	{
		$this->isActive = $isActive;
	}

	/**
	 * @param mixed $description
	 */
	public function setDescription($description)
	{
		$this->description = $description;
	}

	/**
	 * @param mixed $purchasePrice
	 */
	public function setPurchasePrice($purchasePrice)
	{
		$this->purchasePrice = $purchasePrice;
	}

	/**
	 * @param mixed  $unitPrice
	 * @param string $type
	 */
	public function setUnitPrice($unitPrice, $type = "net")
	{
		$this->unitPrice = new AttributeElement($unitPrice, ["type" => $type]);;
	}

	/**
	 * @param mixed $isSalesProduct
	 */
	public function setIsSalesProduct($isSalesProduct)
	{
		$this->isSalesProduct = $isSalesProduct;
	}

	/**
	 * @param mixed $inventoryEnabled
	 */
	public function setInventoryEnabled($inventoryEnabled)
	{
		$this->inventoryEnabled = $inventoryEnabled;
	}

	/**
	 * @param mixed $countyOfOrigin
	 */
	public function setCountyOfOrigin($countyOfOrigin)
	{
		$this->countyOfOrigin = new AttributeElement($countyOfOrigin, ["type" => "ISO-3166"]);;
	}
}
