<?php

namespace Xi\Netvisor\Resource\Xml;

/**
 * Class ProductInventoryDetails
 *
 * @package Xi\Netvisor\Resource\Xml
 */
class ProductInventoryDetails
{
	private $inventoryAmount;
	private $inventoryMidPrice;
	private $inventoryValue;
	private $inventoryReservedAmount;
	private $inventoryOrderedAmount;

	/**
	 * @param $inventoryAmount
	 */
	public function setInventoryAmount($inventoryAmount)
	{
		$this->inventoryAmount = $inventoryAmount;
	}

	/**
	 * @param $inventoryMidPrice
	 */
	public function setInventoryMidPrice($inventoryMidPrice)
	{
		$this->inventoryMidPrice = $inventoryMidPrice;
	}

	/**
	 * @param mixed $inventoryValue
	 */
	public function setInventoryValue($inventoryValue)
	{
		$this->inventoryValue = $inventoryValue;
	}

	/**
	 * @param mixed $inventoryReservedAmount
	 */
	public function setInventoryReservedAmount($inventoryReservedAmount)
	{
		$this->inventoryReservedAmount = $inventoryReservedAmount;
	}

	/**
	 * @param mixed $inventoryOrderedAmount
	 */
	public function setInventoryOrderedAmount($inventoryOrderedAmount)
	{
		$this->inventoryOrderedAmount = $inventoryOrderedAmount;
	}
}
