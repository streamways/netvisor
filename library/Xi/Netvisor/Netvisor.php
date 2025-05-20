<?php
namespace Xi\Netvisor;

use DateTime;
use GuzzleHttp\Client;
use JMS\Serializer\SerializerBuilder;
use Xi\Netvisor\Config;
use Xi\Netvisor\Component\Request;
use Xi\Netvisor\Exception\NetvisorException;
use Xi\Netvisor\Component\Validate;
use Xi\Netvisor\Resource\Xml\Component\Root;
use JMS\Serializer\Serializer;
use Xi\Netvisor\Resource\Xml\Customer;
use Xi\Netvisor\Resource\Xml\SalesInvoice;
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
     * @param  Config   $config
     * @return Netvisor
     */
    public static function build(Config $config)
    {
        return new Netvisor(new Client(), $config, new Validate());
    }

    /**
     * @param  SalesInvoice $invoice
     * @return null|string
     */
    public function sendSalesInvoice(SalesInvoice $invoice)
    {
        return $this->requestWithBody($invoice, 'salesinvoice', ['method' => 'add']);
    }

    /**
     * @param Customer $customer
     * @return null|string
     */
    public function sendCustomer(Customer $customer)
    {
        return $this->requestWithBody($customer, 'customer', ['method' => 'add']);
    }

    /**
     * List customers, optionally filtered by a keyword.
     *
     * The keyword matches Netvisor fields
     * Name, Customer Code, Organization identifier, CoName
     *
     * @param null|string $keyword
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
     * List customers that have changed since given date.
     *
     * Giving a keyword would override the changed since parameter.
     *
     * @param DateTime $changedSince
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
     * Get details for a customer identified by Netvisor id.
     *
     * @param int $id
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
     * Set status for a sales invoice identified by Netvisor id.
     *
     * @param int $id
     * @param string $status
     * @return null|string
     */
    public function setSalesInvoiceStatus($id, $status)
    {
        return $this->get(
            'updatesalesinvoicestatus',
            [
                'netvisorkey' => $id,
                'status' => $status,
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
     * @return null|string
     */
    public function getPurchaseInvoiceList(DateTime $beginDate = null, DateTime $endDate = null)
    {
        $params = [];

        if ($beginDate !== null) {
            $params["begininvoicedate"] = $beginDate->format("Y-m-d");
        }

        if ($endDate !== null) {
            $params["endinvoicedate"] = $endDate->format("Y-m-d");
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
     * @return null|string
     */
    public function getPurchaseInvoice($netVisorKey)
    {
        return $this->get(
            'getpurchaseinvoice',
            [
                'netvisorkey' => $netVisorKey
            ]
        );
    }


    /**
     * @param string  $service
     * @param array   $params
     * @return null|string
     */
    private function get($service, array $params = [])
    {
        if (!$this->config->isEnabled()) {
            return null;
        }

        $request = new Request($this->client, $this->config);

        return $request->get($service, $params);
    }

    /**
     * @param  Root              $root
     * @param  string            $service
     * @param  array             $params
     * @param  string            $language
     * @return null|string
     * @throws NetvisorException
     */
    public function requestWithBody(Root $root, $service, array $params = [], $language = null)
    {
        if (!$this->config->isEnabled()) {
            return null;
        }

        $xml = $this->serializer->serialize($root->getSerializableObject(), 'xml');

        if (!$this->validate->isValid($xml, $root->getDtdPath())) {
            throw new NetvisorException('XML is not valid according to DTD');
        }

        if ($language !== null) {
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
     * @param  string $xml
     * @return string
     */
    public function processXml($xml)
    {
        $xml = str_replace("<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n", "", $xml);

        return $xml;
    }
}
