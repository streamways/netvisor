<?php

namespace Xi\Netvisor\Resource\Xml;

use DateTime;
use Xi\Netvisor\Resource\Xml\Component\AttributeElement;
use Xi\Netvisor\Resource\Xml\Component\Root;

/**
 * Class SalesPayment
 *
 * @package Xi\Netvisor\Resource\Xml
 */
class SalesPayment extends Root
{
	private $sum;
	private $paymentDate;
	private $targetIdentifier;
	private $sourceName;
	private $paymentMethod;

	/**
	 * SalesPayment constructor.
	 *
	 * @param array    $sumData
	 * @param DateTime $paymentDate
	 * @param array    $targetIdentifierData
	 * @param string   $sourceName
	 * @param array    $paymentMethodData
	 */
	public function __construct(array $sumData, DateTime $paymentDate, array $targetIdentifierData, string $sourceName,
		array $paymentMethodData)
	{
		$this->sum              = new AttributeElement($sumData["sum"], ["currency" => $sumData["currency"]]);
		$this->paymentDate      = $paymentDate->format("Y-m-d");
		$this->targetIdentifier = new AttributeElement(
			$sumData["targetIdentifier"],
			[
				"type"       => $sumData["type"],
				"targetType" => array_key_exists("targetType", $targetIdentifierData) ? $targetIdentifierData["targetType"] : null,
			]
		);
		$this->sourceName       = $sourceName;
		$this->paymentMethod    = new AttributeElement(
			$paymentMethodData["paymentMethod"],
			[
				"type"                                 => $sumData["type"],
				"overrideAccountingAccountNumber"      => array_key_exists("overrideAccountingAccountNumber", $targetIdentifierData)
					? $targetIdentifierData["overrideAccountingAccountNumber"]
					: null,
				"overrideSalesReceivableAccountNumber" => array_key_exists("overrideSalesReceivableAccountNumber", $targetIdentifierData)
					? $targetIdentifierData["overrideSalesReceivableAccountNumber"]
					: null,
			]
		);
	}

	/**
	 * @inheritDoc
	 */
	public function getDtdPath(): string
	{
		return $this->getDtdFile("salespayment.dtd");
	}

	/**
	 * @inheritDoc
	 */
	protected function getXmlName(): string
	{
		return "salespayment";
	}
}
