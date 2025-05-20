<?php

namespace Xi\Netvisor\Resource\Xml;

/**
 * Class ProductBookKeepingDetails
 *
 * @package Xi\Netvisor\Resource\Xml
 */
class ProductBookKeepingDetails
{
	private $defaultVatPercentage;

	/**
	 * @param $defaultVatPercentage
	 */
	public function setDefaultVatPercentage($defaultVatPercentage)
	{
		$this->defaultVatPercentage = $defaultVatPercentage;
	}
}
