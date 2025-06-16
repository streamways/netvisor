<?php

namespace Xi\Netvisor\Resource\Xml;

use Xi\Netvisor\Resource\Xml\Component\Root;

/**
 * Class SalesPayment
 *
 * @package Xi\Netvisor\Resource\Xml
 */
class MatchCreditNote extends Root
{
	private $creditnotenetvisorkey;
	private $invoicenetvisorkey;

	/**
	 * SalesPayment constructor.
	 *
	 * @param int $creditnotenetvisorkey
	 * @param int $invoicenetvisorkey
	 */
	public function __construct(int $creditnotenetvisorkey, int $invoicenetvisorkey)
	{
		$this->creditnotenetvisorkey = $creditnotenetvisorkey;
		$this->invoicenetvisorkey = $invoicenetvisorkey;
	}

	/**
	 * @inheritDoc
	 */
	public function getDtdPath(): string
	{
		return $this->getDtdFile("matchcreditnote.dtd");
	}

	/**
	 * @inheritDoc
	 */
	protected function getXmlName(): string
	{
		return "matchcreditnote";
	}
}
