<?php

/**
 * Same as the normal system email class, but runs the content through
 * Emogrifier to merge css rules inline before sending.
 *
 * @author Mark Guinn
 * @package swipestripe
 * @subpackage emails
 */
class ProcessedEmail extends Email {
	/**
	 * CSS File, can be set using the config system (`ProcessedEmail.css_file`)
	 *
	 * @var string Filename of CSS file to be included in the Email, relative to project folder
	 */
	private static $css_file;

	/**
	 * Email signature
	 *
	 * @var String HTML content from central config for signature
	 * @see ShopConfig
	 */
	public $signature;

	/**
	 * @var Customer
	 */
	protected $customer;

	/**
	 * @var Order
	 */
	protected $order;

	/**
	 * @return Customer
	 */
	public function Customer() {
		return $this->customer;
	}

	/**
	 * @return Order
	 */
	public function Order() {
		return $this->order;
	}

	/**
	 * @return null|string
	 */
	public function Message() {
		return $this->Body();
	}

	/**
	 * @return string
	 */
	protected function InlineCSS() {
		// Get css for Email by reading css file and put css inline for emogrification
		$file = Config::inst()->get($this->class, 'css_file');
		if (!$file || !file_exists(Director::getAbsFile($file)) || !is_file(Director::getAbsFile($file))) {
			$file = 'swipestripe/css/ShopEmail.css';
		}
		return sprintf('<style>%s</style>', file_get_contents(Director::getAbsFile($file)));
	}

	/**
	 * Runs the content through Emogrifier to merge css style inline before sending
	 *
	 * @see Email::parseVariables()
	 */
	protected function parseVariables($isPlain = false) {
		parent::parseVariables($isPlain);

		// if it's an html email, filter it through emogrifier
		if (!$isPlain && preg_match('/<style[^>]*>(?:<\!--)?(.*)(?:-->)?<\/style>/ims', $this->body, $match)) {
			$css = $match[1];
			$html = str_replace(
				array(
					"<p>\n<table>",
					"</table>\n</p>",
					'&copy ',
					$match[0],
				),
				array(
					"<table>",
					"</table>",
					'',
					'',
				),
				$this->body
			);

			$emog = new Emogrifier($html, $css);
			$this->body = $emog->emogrify();
		}
	}

	public function __construct(
		Member $customer,
		Order $order,
		$from = null,
		$to = null,
		$subject = null,
		$body = null
	) {
		$this->customer = $customer;
		$this->order = $order;
		if (!$from) {
			$from = Config::inst()->get('Email', 'admin_email') ? : 'no-reply@' . $_SERVER['HTTP_HOST'];
		}
		parent::__construct($from, $to, $subject, $body);
	}

}