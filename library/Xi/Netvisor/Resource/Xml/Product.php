<?php

namespace Xi\Netvisor\Resource\Xml;

use Xi\Netvisor\Resource\Xml\Component\Root;

/**
 * Class Product
 *
 * @package Xi\Netvisor\Resource\Xml
 */
class Product extends Root
{
	/** @var ProductBaseInformation */
	private $productBaseInformation;

	/** @var ProductBookKeepingDetails */
	private $productBookKeepingDetails;

	/** @var ProductInventoryDetails */
	private $productInventoryDetails;

	/** @var ProductPackageInformation */
	private $productPackageInformation;

	/** @var ProductAdditionalInformation */
	private $productAdditionalInformation;

	/**
	 * Product constructor.
	 */
	public function __construct()
	{
	}

	/**
	 * @param ProductBaseinformation $productBaseInformation
	 */
	public function setProductBaseInformation(ProductBaseinformation $productBaseInformation)
	{
		$this->productBaseInformation = $productBaseInformation;
	}

	/**
	 * @param ProductBookKeepingDetails $productBookKeepingDetails
	 */
	public function setProductBookKeepingDetails(ProductBookKeepingDetails $productBookKeepingDetails)
	{
		$this->productBookKeepingDetails = $productBookKeepingDetails;
	}

	/**
	 * @param ProductInventoryDetails $productInventoryDetails
	 */
	public function setProductInventoryDetails(ProductInventoryDetails $productInventoryDetails)
	{
		$this->productInventoryDetails = $productInventoryDetails;
	}

	/**
	 * @param ProductPackageInformation $productPackageInformation
	 */
	public function setProductPackageInformation(ProductPackageInformation $productPackageInformation)
	{
		$this->productPackageInformation = $productPackageInformation;
	}

	/**
	 * @param ProductAdditionalInformation $productAdditionalInformation
	 */
	public function setProductAdditionalInformation(ProductAdditionalInformation $productAdditionalInformation)
	{
		$this->productAdditionalInformation = $productAdditionalInformation;
	}

	/**
	 * @inheritDoc
	 */
	public function getDtdPath()
	{
		return $this->getDtdFile("product.dtd");
	}

	/**
	 * @inheritDoc
	 */
	protected function getXmlName()
	{
		return "product";
	}
}
