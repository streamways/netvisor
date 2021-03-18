<?php

namespace Xi\Netvisor\Resource\Xml;

use Xi\Netvisor\Resource\Xml\Component\AttributeElement;
use Xi\Netvisor\Resource\Xml\Component\Root;

/**
 * Class WarehouseEvent
 *
 * @package Xi\Netvisor\Resource\Xml
 */
class WarehouseEvent extends Root
{
	private $description;
	private $reference;
	private $deliveryMethod;
	private $distributer;
	private $warehouseEventLines = [];

	/**
	 * WarehouseEvent constructor.
	 *
	 * @param string $reference
	 */
	public function __construct(string $reference)
	{
		$this->reference = $reference;
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
	 * @param string $reference
	 *
	 * @return $this
	 */
	public function setReference(string $reference): self
	{
		$this->reference = $reference;

		return $this;
	}

	/**
	 * @param string $deliveryMethod
	 *
	 * @return $this
	 */
	public function setDeliveryMethod(string $deliveryMethod): self
	{
		$this->deliveryMethod = $deliveryMethod;

		return $this;
	}

	/**
	 * @param int|string $distributer
	 * @param string     $type
	 *
	 * @return $this
	 */
	public function setDistributer($distributer, string $type = "netvisor"): self
	{
		$this->distributer = new AttributeElement($distributer, ["type" => $type]);

		return $this;
	}

	/**
	 * @param WarehouseEventLine $warehouseEventLine
	 *
	 * @return $this
	 */
	public function addWarehouseEventLine(WarehouseEventLine $warehouseEventLine): self
	{
		$this->warehouseEventLines[] = $warehouseEventLine;

		return $this;
	}

	/**
	 * @inheritDoc
	 */
	public function getDtdPath(): string
	{
		return $this->getDtdFile("warehouseevent.dtd");
	}

	/**
	 * @inheritDoc
	 */
	protected function getXmlName(): string
	{
		return "warehouseevent";
	}
}
