<?php

namespace Xi\Netvisor\Resource\Xml;

use JMS\Serializer\Annotation\XmlList;
use Xi\Netvisor\Resource\Xml\Component\Root;
use Xi\Netvisor\Resource\Xml\Component\AttributeElement;
use Xi\Netvisor\Resource\Xml\Component\WrapperElement;

/**
 * TODO: Should be kept immutable?
 */
class SalesInvoice extends Root
{
    private $salesInvoiceNumber;
    private $salesInvoiceDate;
    private $salesInvoiceDeliveryDate;
    private $salesInvoiceReferenceNumber;
    private $salesInvoiceAmount;
    private $sellerName;
    private $invoiceType;
    private $salesInvoiceStatus;
	private $salesinvoicefreetextbeforelines;
	private $salesinvoiceyourreference;
	private $salesinvoiceprivatecomment;
    private $salesInvoiceFreeTextBeforeLines;
    private $salesInvoiceFreeTextAfterLines;
    private $salesInvoiceOurReference;
    private $salesInvoiceYourReference;
    private $salesInvoicePrivateComment;
    private $invoicingCustomerIdentifier;
    private $invoicingCustomerName;
    private $invoicingCustomerNameExtension;
    private $invoicingCustomerAddressLine;
    private $invoicingCustomerAdditionalAddressLine;
    private $invoicingCustomerPostNumber;
    private $invoicingCustomerTown;
    private $invoicingCustomerCountryCode;
    private $deliveryAddressName;
    private $deliveryAddressLine;
    private $deliveryAddressPostNumber;
    private $deliveryAddressTown;
    private $deliveryAddressCountryCode;
    private $deliveryMethod;
    private $deliveryTerm;
    private $salesInvoiceTaxHandlingType;
    private $paymentTermNetDays;
    private $paymentTermCashDiscountDays;
    private $paymentTermCashDiscount;
    private $expectPartialPayments;
    private $overrideVoucherSalesReceivablesAccountNumber;
    private $salesInvoiceAgreementIdentifier;
    private $printChannelFormat;
    private $secondName;

    /**
     * @XmlList(entry = "invoiceline")
     */
    private $invoiceLines = [];

    private $invoiceVoucherLines;
    private $salesInvoiceAccrual;

    /**
     * @XmlList(entry = "salesinvoiceattachment")
     */
    private $salesInvoiceAttachments;

    private $customTags;

	/**
	 * @param \DateTime $salesInvoiceDate
	 * @param string|null $salesInvoiceAmount
	 * @param string $salesInvoiceStatus
	 * @param string $invoicingCustomerIdentifier
	 * @param int $paymentTermNetDays
	 * @param array $additionalFields
	 */
	public function __construct(
		\DateTime $salesInvoiceDate,
		?string $salesInvoiceAmount,
		$salesInvoiceStatus,
		$invoicingCustomerIdentifier,
		$paymentTermNetDays,
		array $additionalFields = []
	) {
		$this->salesInvoiceDate = $salesInvoiceDate->format('Y-m-d');
		$this->salesInvoiceAmount = new AttributeElement($salesInvoiceAmount, ["iso4217currencycode" => "EUR"]);
		$this->salesInvoiceStatus = new AttributeElement($salesInvoiceStatus, array('type' => 'netvisor'));
		$this->invoicingCustomerIdentifier = new AttributeElement($invoicingCustomerIdentifier, array('type' => 'netvisor')); // TODO: Type can be netvisor/customer.
		$this->paymentTermNetDays = $paymentTermNetDays;
		$this->secondName = array_key_exists('secondName', $additionalFields) ? new AttributeElement($additionalFields['secondName'], ['type' => 'netvisor']) : null;

		foreach ($additionalFields as $key => $value) {
			if (in_array($key, ['secondName'])) {
				continue;
			}

			$this->$key = $value;
		}
	}

    /**
     * @param SalesInvoiceProductLine $line
     */
    public function addSalesInvoiceProductLine(SalesInvoiceProductLine $line)
    {
        $this->invoiceLines[] = new WrapperElement('salesinvoiceproductline', $line);
    }

	/**
	 * @param SalesInvoiceCommentLine $line
	 */
	public function addSalesInvoiceCommentLine(SalesInvoiceCommentLine $line)
	{
		$this->invoiceLines[] = new WrapperElement("salesinvoicecommentline", $line);
	}

	/**
	 * @param int|string $salesInvoiceReferenceNumber
	 *
	 * @return $this
	 */
	public function setSalesInvoiceReferenceNumber($salesInvoiceReferenceNumber): self
	{
		$this->salesInvoiceReferenceNumber = $salesInvoiceReferenceNumber;

		return $this;
	}

	/**
	 * @param string $salesinvoiceprivatecomment
	 */
	public function setSalesinvoiceprivatecomment($salesinvoiceprivatecomment) {
		$this->salesinvoiceprivatecomment = $salesinvoiceprivatecomment;
	}

	/**
	 * @param string $salesinvoiceyourreference
	 */
	public function setSalesinvoiceyourreference($salesinvoiceyourreference) {
		$this->salesinvoiceyourreference = $salesinvoiceyourreference;
	}

	/**
	 * @param mixed $salesinvoicefreetextbeforelines
	 */
	public function setSalesinvoicefreetextbeforelines($salesinvoicefreetextbeforelines) {
		$this->salesinvoicefreetextbeforelines = $salesinvoicefreetextbeforelines;
	}

    public function getDtdPath()
    {
        return $this->getDtdFile('salesinvoice.dtd');
    }

    protected function getXmlName()
    {
        return 'salesinvoice';
    }
}
