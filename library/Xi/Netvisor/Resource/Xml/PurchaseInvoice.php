<?php

namespace Xi\Netvisor\Resource\Xml;

use JMS\Serializer\Annotation\XmlList;
use Xi\Netvisor\Resource\Xml\Component\Root;
use Xi\Netvisor\Resource\Xml\Component\AttributeElement;
use Xi\Netvisor\Resource\Xml\Component\WrapperElement;

/**
 * TODO: Should be kept immutable?
 */
class PurchaseInvoice extends Root
{
    /**
     * @param array $additionalFields
     */
    public function __construct(
        array $additionalFields = []
    ) {
        foreach ($additionalFields as $key => $value) {
            if (in_array($key, ['secondName'])) {
                continue;
            }

            $this->$key = $value;
        }
    }

    public function getDtdPath()
    {
        return $this->getDtdFile('purchaseinvoice.dtd');
    }

    protected function getXmlName()
    {
        return 'purchaseinvoice';
    }
}
