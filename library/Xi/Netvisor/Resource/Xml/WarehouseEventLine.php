<?php

namespace Xi\Netvisor\Resource\Xml;

use Xi\Netvisor\Resource\Xml\Component\AttributeElement;

/**
 * Class WarehouseEventLine
 *
 * @package Xi\Netvisor\Resource\Xml
 */
class WarehouseEventLine
{
	private $eventType;
	private $product;
	private $inventoryPlace;
	private $description;
	private $quantity;
	private $unitPrice;
	private $valueDate;
	private $status;

	/**
	 * WarehouseEventLine constructor.
	 *
	 * @param string           $eventType
	 * @param int|string|array $productIdentifierData
	 * @param int|float|string $quantity
	 * @param int|float|string $unitPrice
	 * @param string           $valueDate
	 * @param string           $status
	 */
	public function __construct(string $eventType, $productIdentifierData, $quantity, $unitPrice, string $valueDate,
		string $status)
	{
		$this->eventType = new AttributeElement($eventType, ["type" => "customer"]);
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
			$this->product = new AttributeElement($productIdentifierData["productIdentifier"], ["type" => $type]);
		}
		else
		{
			$this->product = new AttributeElement($productIdentifierData, ["type" => "netvisor"]);
		}
		$this->quantity  = $quantity;
		$this->unitPrice = $unitPrice;
		$this->valueDate = new AttributeElement($valueDate, ["format" => "ansi"]);
		$this->status    = $status;
	}

	/**
	 * @param string $eventType
	 *
	 * @return $this
	 */
	public function setEventType(string $eventType): self
	{
		$this->eventType = new AttributeElement($eventType, ["type" => "customer"]);

		return $this;
	}

	/**
	 * @param int|string $productIdentifier
	 * @param string     $type
	 *
	 * @return $this
	 */
	public function setProduct($productIdentifier, string $type = "netvisor"): self
	{
		$this->product = new AttributeElement($productIdentifier, ["type" => $type]);

		return $this;
	}

	/**
	 * @param string $inventoryPlace
	 *
	 * @return $this
	 */
	public function setInventoryPlace(string $inventoryPlace): self
	{
		$this->inventoryPlace = $inventoryPlace;

		return $this;
	}

	/**
	 * @param string $description
	 *
	 * @return $this
	 */
	public function setDescription(string $description): self
	{
		$this->description = $description;

		return $this;
	}

	/**
	 * @param int|float|string $quantity
	 *
	 * @return $this
	 */
	public function setQuantity($quantity): self
	{
		$this->quantity = $quantity;

		return $this;
	}

	/**
	 * @param int|float|string $unitPrice
	 *
	 * @return $this
	 */
	public function setUnitPrice($unitPrice): self
	{
		$this->unitPrice = $unitPrice;

		return $this;
	}

	/**
	 * @param string $valueDate
	 *
	 * @return $this
	 */
	public function setValueDate(string $valueDate): self
	{
		$this->valueDate = new AttributeElement($valueDate, ["format" => "ansi"]);

		return $this;
	}

	/**
	 * @param string $status
	 *
	 * @return $this
	 */
	public function setStatus(string $status): self
	{
		$this->status = $status;

		return $this;
	}
}
