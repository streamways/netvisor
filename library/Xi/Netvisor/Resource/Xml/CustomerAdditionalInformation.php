<?php

namespace Xi\Netvisor\Resource\Xml;

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
    public function setDefaultPaymentTerm($defaultPaymentTerm)
    {
        $this->defaultPaymentTerm = $defaultPaymentTerm;
    }
}
