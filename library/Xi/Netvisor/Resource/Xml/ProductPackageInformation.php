<?php

namespace Xi\Netvisor\Resource\Xml;

/**
 * Class ProductPackageInformation
 *
 * @package Xi\Netvisor\Resource\Xml
 */
class ProductPackageInformation
{
	private $packageWidth;
	private $packageHeight;
	private $packageLength;

	/**
	 * @param mixed $packageWidth
	 */
	public function setPackageWidth($packageWidth)
	{
		$this->packageWidth = $packageWidth;
	}

	/**
	 * @param mixed $packageHeight
	 */
	public function setPackageHeight($packageHeight)
	{
		$this->packageHeight = $packageHeight;
	}

	/**
	 * @param mixed $packageLength
	 */
	public function setPackageLength($packageLength)
	{
		$this->packageLength = $packageLength;
	}
}
