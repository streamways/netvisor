<?php

namespace Xi\Netvisor;

use DateTime;
use GuzzleHttp\Client;
use JMS\Serializer\Serializer;
use JMS\Serializer\SerializerBuilder;
use Xi\Netvisor\Component\Request;
use Xi\Netvisor\Component\Validate;
use Xi\Netvisor\Exception\NetvisorException;
use Xi\Netvisor\Resource\Xml\Component\Root;
use Xi\Netvisor\Resource\Xml\Customer;
use Xi\Netvisor\Resource\Xml\Product;
use Xi\Netvisor\Resource\Xml\SalesInvoice;
use Xi\Netvisor\Resource\Xml\SalesPayment;
use Xi\Netvisor\Resource\Xml\WarehouseEvent;
use Xi\Netvisor\Serializer\Naming\LowercaseNamingStrategy;

/**
 * Connects to Netvisor-interface via HTTP.
 * Authentication is based on HTTP headers.
 * A single XML file is sent to the server.
 * The server returns a XML response that contains the transaction status.
 *
 * @category Xi
 * @package  Netvisor
 * @author   Panu Leppäniemi <me@panuleppaniemi.com>
 * @author   Henri Vesala    <henri.vesala@gmail.fi>
 * @author   Petri Koivula   <petri.koivula@iki.fi>
 * @author   Artur Gajewski  <info@arturgajewski.com>
 * @author   Joel Hietanen   <joel.hietanen@nyholmsolutions.fi>
 */
class Netvisor
{
	/**
	 * @var Config
	 */
	private $config;

	/**
	 * @var Client
	 */
	private $client;

	/**
	 * @var Validate
	 */
	private $validate;

	/**
	 * @var Serializer
	 */
	private $serializer;

	/**
	 * Initialize with Netvisor::build()
	 *
	 * @param Client   $client
	 * @param Config   $config
	 * @param Validate $validate
	 */
	public function __construct(
		Client $client,
		Config $config,
		Validate $validate
	) {
		$this->client     = $client;
		$this->config     = $config;
		$this->validate   = $validate;
		$this->serializer = $this->createSerializer();
	}

	/**
	 * Builds a default instance of this class.
	 *
	 * @param Config $config
	 *
	 * @return Netvisor
	 */
	public static function build(Config $config)
	{
		return new Netvisor(new Client(), $config, new Validate());
	}

	/**
	 * @param SalesInvoice $invoice
	 * @param bool         $add
	 * @param string|null  $language
	 *
	 * @return string|null
	 * @throws \Xi\Netvisor\Exception\NetvisorException
	 */
	public function sendInvoice(SalesInvoice $invoice, string $language = null): ?string
	{
		return $this->requestWithBody(
			$invoice,
			'salesinvoice',
			[
				'method' => !empty($invoice->netvisorkey) ? 'edit' : 'add',
				'id' => $invoice->netvisorkey ?? null
			],
			$language
		);
	}

	/**
	 * @param Customer $customer
	 *
	 * @return null|string
	 */
	public function sendCustomer(Customer $customer)
	{
		return $this->requestWithBody(
            $customer,
            'customer',
            [
                'method' => !empty($customer->netvisorkey) ? 'edit' : 'add',
                'id' => $customer->netvisorkey ?? null
            ]
        );
	}

    /**
     * @param int $id
     *
     * @return string|null
     * @throws NetvisorException
     */
    public function deleteCustomer(int $id): ?string
    {
        if (!$this->config->isEnabled())
        {
            return null;
        }

        $request = new Request($this->client, $this->config);

        return $request->get(
            'deletecustomer',
            [
                'customerid' => $id
            ]
        );
    }

	/**
	 * @param Product $product
	 *
	 * @return null|string
	 */
	public function sendProduct(Product $product)
	{
		return $this->requestWithBody(
            $product,
            'product',
            [
                'method' => !empty($product->netvisorKey) ? 'edit' : 'add',
                'id' => $product->netvisorKey ?? null
            ]
        );
	}

	/**
	 * @param WarehouseEvent $warehouseEvent
	 *
	 * @return string|null
	 * @throws NetvisorException
	 */
	public function sendWarehouseEvent(WarehouseEvent $warehouseEvent): ?string
	{
		return $this->requestWithBody($warehouseEvent, 'warehouseevent');
	}

	/**
	 * @param SalesPayment $salesPayment
	 *
	 * @return string|null
	 * @throws NetvisorException
	 */
	public function sendSalesPayment(SalesPayment $salesPayment): ?string
	{
		return $this->requestWithBody($salesPayment, 'salespayment');
	}

	/**
	 * List customers, optionally filtered by a keyword.
	 *
	 * The keyword matches Netvisor fields
	 * Name, Customer Code, Organization identifier, CoName
	 *
	 * @param null|string $keyword
	 *
	 * @return null|string
	 */
	public function getCustomers($keyword = null)
	{
		return $this->get(
			'customerlist',
			[
				'keyword' => $keyword,
			]
		);
	}

	/**
	 * List products, optionally filtered by a keyword.
	 *
	 * @param null|string $keyword
	 *
	 * @return null|string
	 */
	public function getProducts($keyword = null)
	{
		return $this->getProductsBy([
            'keyword' => $keyword,
        ]);
	}

	/**
	 * List products, optionally filtered by params.
	 *
	 * @param array|null $params
	 *
	 * @return string|null
	 * @throws \Xi\Netvisor\Exception\NetvisorException
	 */
	public function getProductsBy(array $params = [])
	{
		return $this->get(
			'productlist',
			$params
		);
	}

	/**
	 * List customers that have changed since given date.
	 *
	 * Giving a keyword would override the changed since parameter.
	 *
	 * @param DateTime $changedSince
	 *
	 * @return null|string
	 */
	public function getCustomersChangedSince(DateTime $changedSince)
	{
		return $this->get(
			'customerlist',
			[
				'changedsince' => $changedSince->format('Y-m-d'),
			]
		);
	}

	/**
	 * List products that have changed since given date.
	 *
	 * Giving a keyword would override the changed since parameter.
	 *
	 * @param DateTime $changedSince
	 *
	 * @return null|string
	 */
	public function getProductsChangedSince(DateTime $changedSince)
	{
		return $this->get(
			'productlist',
			[
				'changedsince' => $changedSince->format('Y-m-d'),
			]
		);
	}

	/**
	 * Get details for a customer identified by Netvisor id.
	 *
	 * @param int $id
	 *
	 * @return null|string
	 */
	public function getCustomer($id)
	{
		return $this->get(
			'getcustomer',
			[
				'id' => $id,
			]
		);
	}

    /**
     * List invoices, optionally filtered by a keyword.
     *
     * @param null|string $keyword
     * @return null|string
     */
    public function getSalesInvoices($keyword = null)
    {
        return $this->get(
            'salesinvoicelist',
            [
                'keyword' => $keyword,
            ]
        );
    }

    /**
     * List invoices that have changed since given date.
     *
     * @param DateTime $changedSince
     * @return null|string
     */
    public function getSalesInvoicesChangedSince(DateTime $changedSince)
    {
        return $this->get(
            'salesinvoicelist',
            [
                'changedsince' => $changedSince->format('Y-m-d'),
            ]
        );
    }

    /**
     * Get details for a sales invoice identified by Netvisor id.
     *
     * @param int $id
     * @return null|string
     */
    public function getSalesInvoice($id)
    {
        return $this->get(
            'getsalesinvoice',
            [
                'netvisorkey' => $id,
            ]
        );
    }

    /**
     * Get details for a product identified by Netvisor id.
     *
     * @param int $id
     * @return null|string
     */
    public function getProduct($id)
    {
        return $this->get(
            'getproduct',
            [
                'id' => $id,
            ]
        );
    }

	/**
	 * List purchaseinvoices, optionally filtered by start and end date for invoice
	 *
	 * @param DateTime|null $beginDate
	 * @param DateTime|null $endDate
	 *
	 * @return null|string
	 */
	public function getPurchaseInvoiceList(DateTime $beginDate = null, DateTime $endDate = null)
	{
		$params = [];

		if ($beginDate !== null)
		{
			$params['begininvoicedate'] = $beginDate->format('Y-m-d');
		}

		if ($endDate !== null)
		{
			$params['endinvoicedate'] = $endDate->format('Y-m-d');
		}

		return $this->get(
			'purchaseinvoicelist',
			$params
		);
	}

	/**
	 * Get details for a purchaseinvoice identified by Netvisor Id.
	 *
	 * @param $netVisorKey
	 *
	 * @return null|string
	 */
	public function getPurchaseInvoice($netVisorKey)
	{
		return $this->get(
			'getpurchaseinvoice',
			[
				'netvisorkey' => $netVisorKey,
			]
		);
	}

	/**
	 * Retrieve product inventory for each warehouse
	 *
	 * @param array $params
	 *
	 * @return string|null
	 */
	public function inventoryByWarehouse(array $params = []): ?string
	{
		return $this->get(
			'inventorybywarehouse',
			$params
		);
	}

	/**
	 * List sales invoices/orders
	 *
	 * @param array $params
	 *
	 * @return string|null
	 */
	public function salesInvoiceList(array $params = []): ?string
	{
		return $this->get(
			'salesinvoicelist',
			$params
		);
	}

	/**
	 * Get details for an order identified by Netvisor key.
	 *
	 * @param array $params
	 *
	 * @return string|null
	 */
	public function getOrder(array $params = []): ?string
	{
		return $this->get(
			'getorder',
			$params
		);
	}

	/**
	 * @param int    $id
	 * @param string $status
	 *
	 * @return string|null
	 * @throws NetvisorException
	 */
	public function updateInvoiceStatus(int $id, string $status): ?string
	{
		if (!$this->config->isEnabled()) {
			return null;
		}

		$request = new Request($this->client, $this->config);

		return $request->get('updatesalesinvoicestatus', [
			'netvisorkey' => $id,
			'status'      => $status,
		]);
	}

	/**
	 * @param int $id
	 *
	 * @return string|null
	 * @throws NetvisorException
	 */
	public function deleteSalesInvoice(int $id): ?string
	{
		if (!$this->config->isEnabled())
		{
			return null;
		}

		$request = new Request($this->client, $this->config);

		return $request->get('deletesalesinvoice', [
			'invoiceid' => $id,
		]);
	}

	/**
	 * @param int $id
	 *
	 * @return string|null
	 * @throws NetvisorException
	 */
	public function deleteSalesOrder(int $id): ?string
	{
		if (!$this->config->isEnabled())
		{
			return null;
		}

		$request = new Request($this->client, $this->config);

		return $request->get('deletesalesinvoice', [
			'orderid' => $id,
		]);
	}

    /**
     * @return string|null
     * @throws NetvisorException
     */
    public function getPaymentTerms(): ?string
    {
        return $this->get('paymenttermlist');
    }

    /**
     * List products, optionally filtered by a keyword, with extended data.
     *
     * The keyword matches Netvisor fields
     * Name, Customer Code, Organization identifier, CoName
     *
     * @param string|null $keyword
     *
     * @return string|null
     * @throws NetvisorException
     */
    public function getExtendedProducts(?string $keyword = null): ?string
    {
        return $this->get(
            'extendedproductlist',
            [
                'keyword' => $keyword,
            ]
        );
    }

    /**
     * List products, optionally filtered by params, with extended data.
     *
     * @param array|null $params
     *
     * @return string|null
     * @throws NetvisorException
     */
    public function getExtendedProductsBy(array $params = []): ?string
    {
        return $this->get(
            'extendedproductlist',
            $params
        );
    }

    /**
     * List products that have changed since given date, with extended data.
     *
     * @param DateTime $changedSince
     *
     * @return string|null
     * @throws NetvisorException
     */
    public function getExtendedProductsChangedSince(DateTime $changedSince): ?string
    {
        return $this->get(
            'extendedproductlist',
            [
                'productchangedsince' => $changedSince->format('Y-m-d'),
            ]
        );
    }

	/**
	 * @param string $service
	 * @param array  $params
	 *
	 * @return null|string
	 * @throws NetvisorException
	 */
	private function get($service, array $params = []): ?string
	{
		if (!$this->config->isEnabled())
		{
			return null;
		}

		$request = new Request($this->client, $this->config);

		return $request->get($service, $params);
	}

	/**
	 * @param Root   $root
	 * @param string $service
	 * @param array  $params
	 * @param string $language
	 *
	 * @return null|string
	 * @throws NetvisorException
	 */
	public function requestWithBody(Root $root, $service, array $params = [], $language = null): ?string
	{
		if (!$this->config->isEnabled())
		{
			return null;
		}

		$xml = $this->serializer->serialize($root->getSerializableObject(), 'xml');

		if (!$this->validate->isValid($xml, $root->getDtdPath()))
		{
			throw new NetvisorException('XML is not valid according to DTD');
		}

		if ($language !== null)
		{
			$this->config->setLanguage($language);
		}

		$request = new Request($this->client, $this->config);

		return $request->post($this->processXml($xml), $service, $params);
	}

	/**
	 * @return Serializer
	 */
	private function createSerializer()
	{
		$builder = SerializerBuilder::create();
		$builder->setPropertyNamingStrategy(new LowercaseNamingStrategy());

		return $builder->build();
	}

	/**
	 * Process given XML into Netvisor specific format
	 *
	 * @param string $xml
	 *
	 * @return string
	 */
	public function processXml($xml)
	{
		$xml = str_replace("<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n", "", $xml);

		return $xml;
	}
}
