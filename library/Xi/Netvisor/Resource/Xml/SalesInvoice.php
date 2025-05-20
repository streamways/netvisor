<?php

namespace Xi\Netvisor\Resource\Xml;

use DateTimeInterface;
use JMS\Serializer\Annotation\XmlList;
use Xi\Netvisor\Resource\Xml\Component\Root;
use Xi\Netvisor\Resource\Xml\Component\AttributeElement;
use Xi\Netvisor\Resource\Xml\Component\WrapperElement;

class SalesInvoice extends Root
{
	private $salesInvoiceNumber;
	private $salesInvoiceDate;
	private $salesInvoiceDeliveryDate;
	private $salesInvoiceDueDate;
	private $salesInvoiceReferenceNumber;
	private $salesInvoiceAmount;
	private $sellerName;
	private $invoiceType;
	private $salesInvoiceStatus;
	private $salesinvoicefreetextbeforelines;
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

    #[XmlList(entry: "invoiceline")]
    private $invoiceLines = [];

	private $invoiceVoucherLines;
	private $salesInvoiceAccrual;

    #[XmlList(entry: "salesinvoiceattachment")]
    private $salesInvoiceAttachments;

	private $customTags;

	/**
	 * @param DateTimeInterface           $salesInvoiceDate
	 * @param string|float|int|array|null $salesInvoiceAmountData
	 * @param string                      $salesInvoiceStatus
	 * @param string                      $invoicingCustomerIdentifier
	 * @param int                         $paymentTermNetDays
	 * @param array                       $additionalFields
	 */
	public function __construct(
		DateTimeInterface $salesInvoiceDate,
		$salesInvoiceAmountData,
		$salesInvoiceStatus,
		$invoicingCustomerIdentifier,
		$paymentTermNetDays,
		array $additionalFields = []
	) {
		$this->salesInvoiceDate = $salesInvoiceDate->format("Y-m-d");
		if (is_array($salesInvoiceAmountData))
		{
			if (array_key_exists("type", $salesInvoiceAmountData))
			{
				$code = $salesInvoiceAmountData["code"];
			}
			else
			{
				$code = "EUR";
			}
			$this->salesInvoiceAmount = new AttributeElement($salesInvoiceAmountData["amount"], ["iso4217currencycode" => $code]);
		}
		else
		{
			$this->salesInvoiceAmount = new AttributeElement($salesInvoiceAmountData, ["iso4217currencycode" => "EUR"]);
		}
		$this->salesInvoiceStatus          = new AttributeElement($salesInvoiceStatus, ["type" => "netvisor"]);
		$this->invoicingCustomerIdentifier = new AttributeElement($invoicingCustomerIdentifier,
			["type" => "netvisor"]); // TODO: Type can be netvisor/customer.
		$this->paymentTermNetDays          = $paymentTermNetDays;
		$this->secondName                  = array_key_exists("secondName", $additionalFields)
			? new AttributeElement($additionalFields["secondName"], ["type" => "netvisor"])
			: null;

		foreach ($additionalFields as $key => $value)
		{
			if (in_array($key, ["secondName"]))
			{
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
		$this->invoiceLines[] = new WrapperElement("salesinvoiceproductline", $line);
	}

	/**
	 * @param SalesInvoiceCommentLine $line
	 */
	public function addSalesInvoiceCommentLine(SalesInvoiceCommentLine $line)
	{
		$this->invoiceLines[] = new WrapperElement("salesinvoicecommentline", $line);
	}

	/**
	 * @param int $salesInvoiceNumber
	 *
	 * @return $this
	 */
	public function setSalesInvoiceNumber(int $salesInvoiceNumber): self
	{
		$this->salesInvoiceNumber = $salesInvoiceNumber;

		return $this;
	}

	/**
	 * @param DateTimeInterface $salesInvoiceDueDate
	 *
	 * @return $this
	 */
	public function setSalesInvoiceDueDate(DateTimeInterface $salesInvoiceDueDate): self
	{
		$this->salesInvoiceDueDate = $salesInvoiceDueDate->format("Y-m-d");

		return $this;
	}

	/**
	 * @param string|int|float|null $salesInvoiceAmount
	 * @param string                $iso4217CurrencyCode
	 *
	 * @return $this
	 */
	public function setSalesInvoiceAmount($salesInvoiceAmount, string $iso4217CurrencyCode = "EUR"): self
	{
		$this->salesInvoiceAmount = new AttributeElement($salesInvoiceAmount, ["iso4217currencycode" => $iso4217CurrencyCode]);

		return $this;
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
	public function setSalesinvoiceprivatecomment($salesinvoiceprivatecomment)
	{
		$this->salesinvoiceprivatecomment = $salesinvoiceprivatecomment;
	}

	/**
	 * @param string $salesinvoiceyourreference
	 */
	public function setSalesinvoiceyourreference($salesinvoiceyourreference)
	{
		$this->salesInvoiceYourReference = $salesinvoiceyourreference;
	}

	/**
	 * @param mixed $salesinvoicefreetextbeforelines
	 */
	public function setSalesinvoicefreetextbeforelines($salesinvoicefreetextbeforelines)
	{
		$this->salesinvoicefreetextbeforelines = $salesinvoicefreetextbeforelines;
	}

	/**
	 * @param string $invoicingCustomerName
	 *
	 * @return $this
	 */
	public function setInvoicingCustomerName(string $invoicingCustomerName): self
	{
		$this->invoicingCustomerName = $invoicingCustomerName;

		return $this;
	}

	/**
	 * @param string $invoicingCustomerNameExtension
	 *
	 * @return $this
	 */
	public function setInvoicingCustomerNameExtension(string $invoicingCustomerNameExtension): self
	{
		$this->invoicingCustomerNameExtension = $invoicingCustomerNameExtension;

		return $this;
	}

	/**
	 * @param string $invoicingCustomerAddressLine
	 *
	 * @return $this
	 */
	public function setInvoicingCustomerAddressLine(string $invoicingCustomerAddressLine): self
	{
		$this->invoicingCustomerAddressLine = $invoicingCustomerAddressLine;

		return $this;
	}

	/**
	 * @param string $invoicingCustomerAdditionalAddressLine
	 *
	 * @return $this
	 */
	public function setInvoicingCustomerAdditionalAddressLine(string $invoicingCustomerAdditionalAddressLine): self
	{
		$this->invoicingCustomerAdditionalAddressLine = $invoicingCustomerAdditionalAddressLine;

		return $this;
	}

	/**
	 * @param string $invoicingCustomerPostNumber
	 *
	 * @return $this
	 */
	public function setInvoicingCustomerPostNumber(string $invoicingCustomerPostNumber): self
	{
		$this->invoicingCustomerPostNumber = $invoicingCustomerPostNumber;

		return $this;
	}

	/**
	 * @param string $invoicingCustomerTown
	 *
	 * @return $this
	 */
	public function setInvoicingCustomerTown(string $invoicingCustomerTown): self
	{
		$this->invoicingCustomerTown = $invoicingCustomerTown;

		return $this;
	}

	/**
	 * @param string $invoicingCustomerCountryCode
	 *
	 * @return $this
	 */
	public function setInvoicingCustomerCountryCode(string $invoicingCustomerCountryCode): self
	{
		$this->invoicingCustomerCountryCode = $invoicingCustomerCountryCode;

		return $this;
	}

	/**
	 * @inheritDoc
	 */
	public function getDtdPath(): string
	{
		return $this->getDtdFile("salesinvoice.dtd");
	}

	/**
	 * @inheritDoc
	 */
	protected function getXmlName(): string
	{
		return "salesinvoice";
	}
}
