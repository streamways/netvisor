<?php

namespace Xi\Netvisor\Resource\Xml;

/**
 * Class ProductBookKeepingDetails
 *
 * @package Xi\Netvisor\Resource\Xml
 */
class ProductBookKeepingDetails
{
	private $defaultVatPercent;

	/**
	 * @param $defaultVatPercent
	 */
	public function setDefaultVatPercent($defaultVatPercent)
	{
		$this->defaultVatPercent = $defaultVatPercent;
	}
}
