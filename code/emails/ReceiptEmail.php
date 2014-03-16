<?php

/**
 * A receipt email that is sent to the customer after they have completed their {@link Order}.
 *
 * @author Frank Mullenger <frankmullenger@gmail.com>
 * @copyright Copyright (c) 2011, Frank Mullenger
 * @package swipestripe
 * @subpackage emails
 */
class ReceiptEmail extends ProcessedEmail {

	/**
	 * Create the new receipt email.
	 *
	 * @param Member $customer
	 * @param Order $order
	 */
	public function __construct(Member $customer, Order $order) {
		$shopConfig = ShopConfig::current_shop_config();
		$subject = _t(
			'ReceiptEmail.Subject',
			'{subject} - Order #{orderID}',
			array(
				$shopConfig->ReceiptSubject ? : 'Receipt',
				$order->ID,
			)
		);
		$this->setTemplate('Order_ReceiptEmail');
		$this->signature = $shopConfig->EmailSignature;
		parent::__construct(
			$customer,
			$order,
			$shopConfig->ReceiptFrom,
			// TODO it should not be possible that Email is empty, but there is nothing we can do here, SwipeStripe should ensure an Email is only created if a Email is set on the Customer
			$customer->Email,
			$subject,
			$shopConfig->ReceiptBody
		);
	}

}
