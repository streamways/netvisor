<?php

namespace Xi\Netvisor\Resource\Xml;

/**
 * Class SalesInvoiceCommentLine
 *
 * @package Xi\Netvisor\Resource\Xml
 */
class SalesInvoiceCommentLine
{
	private $comment;

	/**
	 * SalesInvoiceCommentLine constructor.
	 *
	 * @param string $comment
	 */
	public function __construct(string $comment)
	{
		$this->comment = $comment;
	}

	/**
	 * @param string $comment
	 */
	public function setComment(string $comment)
	{
		$this->comment = $comment;
	}
}
