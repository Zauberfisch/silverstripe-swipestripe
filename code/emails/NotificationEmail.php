<?php

/**
 * A notification email that is sent to an email address specified in {@link ShopConfig}, usually
 * a site administrator or owner.
 *
 * @author Frank Mullenger <frankmullenger@gmail.com>
 * @copyright Copyright (c) 2011, Frank Mullenger
 * @package swipestripe
 * @subpackage emails
 */
class NotificationEmail extends ProcessedEmail {

	/**
	 * Create the new notification email.
	 *
	 * @param Member $customer
	 * @param Order $order
	 */
	public function __construct(Member $customer, Order $order) {
		$shopConfig = ShopConfig::current_shop_config();
		if ($shopConfig->NotificationTo) {
			$to = $shopConfig->NotificationTo;
		} elseif (Config::inst()->get('Email', 'admin_email')) {
			$to = Config::inst()->get('Email', 'admin_email');
		} else {
			// TODO it should not be possible that Email is empty, but there is nothing we can do here, SwipeStripe should ensure an Email is only created if a Email is set on the ShopConfig
			$to = '';
		}
		$subject = _t(
			'NotificationEmail.Subject',
			'{subject} - Order #{orderID}',
			array(
				'subject' => $shopConfig->NotificationSubject ? : 'Notification',
				'orderID' => $order->BillingIDNice(),
			)
		);
		$this->setTemplate('Order_NotificationEmail');
		$this->populateTemplate(array('AdminLink' => Director::absoluteURL('/admin/shop/')));
		parent::__construct($customer, $order, $customer->Email, $to, $subject, $shopConfig->NotificationBody);
	}
}
