<?php

namespace Xi\Netvisor\Resource\Xml;

use Xi\Netvisor\Resource\Xml\Component\AttributeElement;

class CustomerAdditionalInformation
{
    private $invoicingLanguage;

    private $defaultPaymentTerm;

    /**
     * @param string $invoicingLanguage
     */
    public function __construct(
        $invoicingLanguage = 'FI'
    ) {
        $this->invoicingLanguage = $invoicingLanguage;
    }

    /**
     * @param $defaultPaymentTerm
     *
     * @return void
     */
    public function setDefaultPaymentTerm($defaultPaymentTerm, $type = "netvisor")
    {
        $this->defaultPaymentTerm = new AttributeElement($defaultPaymentTerm, ["type" => $type]);
    }
}
