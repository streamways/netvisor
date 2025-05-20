<?php

namespace Xi\Netvisor\Resource\Xml;

use Xi\Netvisor\Resource\Xml\Component\AttributeElement;

/**
 * Class ProductAdditionalInformation
 *
 * @package Xi\Netvisor\Resource\Xml
 */
class ProductAdditionalInformation
{
	private $productNetWeight;
	private $productGrossWeight;
	private $productWeightUnit;

	/**
	 * @param mixed $productNetWeight
	 */
	public function setProductNetWeight($productNetWeight)
	{
		$this->productNetWeight = $productNetWeight;
	}

	/**
	 * @param mixed $productGrossWeight
	 */
	public function setProductGrossWeight($productGrossWeight)
	{
		$this->productGrossWeight = $productGrossWeight;
	}

	/**
	 * @param mixed $productWeightUnit
	 */
	public function setProductWeightUnit($productWeightUnit)
	{
		$this->productWeightUnit = $productWeightUnit;
	}
}
