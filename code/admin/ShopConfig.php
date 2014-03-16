<?php
/**
 * Shop configuration object for containing all the shop settings.
 * 
 * @author Frank Mullenger <frankmullenger@gmail.com>
 * @copyright Copyright (c) 2011, Frank Mullenger
 * @package swipestripe
 * @subpackage admin
 * @property string LicenceKey
 * @property string BaseCurrency
 * @property int CartTimeout
 * @property string CartTimeoutUnit
 * @property bool StockCheck
 * @property string StockManagement
 * @property string EmailSignature
 * @property string ReceiptSubject
 * @property string ReceiptBody
 * @property string ReceiptFrom
 * @property string NotificationSubject
 * @property string NotificationBody
 * @property string NotificationTo
 * @method HasManyList Attributes
 */
class ShopConfig extends DataObject {

	private static $singular_name = 'Settings';
	private static $plural_name = 'Settings';

	private static $db = array(
		'LicenceKey' => 'Varchar',

		'BaseCurrency' => 'Varchar(3)',
		'BaseCurrencySymbol' => 'Varchar(10)',

		'CartTimeout' => 'Int',
		'CartTimeoutUnit' => "Enum('minute, hour, day', 'hour')",
		'StockCheck' => 'Boolean',
		'StockManagement' => "Enum('strict, relaxed', 'strict')",

		'EmailSignature' => 'HTMLText',
		'ReceiptSubject' => 'Varchar',
		'ReceiptBody' => 'HTMLText',
		'ReceiptFrom' => 'Varchar',
		'NotificationSubject' => 'Varchar',
		'NotificationBody' => 'HTMLText',
		'NotificationTo' => 'Varchar'
	);

	private static $has_many = array(
		'Attributes' => 'Attribute_Default'
	);

	private static $defaults = array(
		'CartTimeout' => 1,
		'CartTimeoutUnit' => 'hour',
		'StockCheck' => false,
		'StockManagement' => 'strict'
	);

	/**
	 * @return static
	 */
	public static function current_shop_config() {

		//TODO: lazy load this

		return ShopConfig::get()->First();
	}

	/**
	 * @return null|string
	 */
	public static function base_currency_warning() {
		$config = self::current_shop_config();
		$warning = null;

		if (!$config->BaseCurrency) {
		 $warning = _t('ShopConfig.BASE_CURRENCY_WARNING','
				 Warning: Base currency is not set, please set base currency in the shop settings area before proceeding
		 ');
		}
		return $warning;
	}

	/**
	 * Setup a default ShopConfig record if none exists
	 */
	public function requireDefaultRecords() {

		parent::requireDefaultRecords();

		if(!self::current_shop_config()) {
			$shopConfig = new ShopConfig();
			$shopConfig->write();
			DB::alteration_message('Added default shop config', 'created');
		}
	}
}
