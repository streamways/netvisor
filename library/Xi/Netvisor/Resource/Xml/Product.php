<?php

namespace Xi\Netvisor\Resource\Xml;

use JMS\Serializer\Annotation\XmlList;
use Xi\Netvisor\Resource\Xml\Component\Root;
use Xi\Netvisor\Resource\Xml\Component\AttributeElement;
use Xi\Netvisor\Resource\Xml\Component\WrapperElement;

class Product extends Root
{
	public function __construct()
	{
	}

	public function getDtdPath()
	{
		return $this->getDtdFile('product.dtd');
	}

	protected function getXmlName()
	{
		return 'product';
	}
}
