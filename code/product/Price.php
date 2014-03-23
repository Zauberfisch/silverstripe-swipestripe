<?php
require_once 'Zend/Locale/Math.php';

class Price extends Money {
	private static $default_options = array(
		'Zend_Currency' => array(
			'display' => 'USE_SYMBOL',
			'position' => 'LEFT',
		),
	);
	protected $symbol;

	public function setSymbol($symbol) {
		$this->symbol = $symbol;
		return $this;
	}

	public function getSymbol($currency = null, $locale = null) {
		return $this->symbol;
	}

	/**
	 * @return float|string
	 */
	public function getAmount() {
		return Zend_Locale_Math::round($this->amount, 2);
	}

	/**
	 * Use config Price.default_options to set default options that are passed to currencyLib->toCurrency()
	 * The values of display and position are translated to Zend_Currency statics
	 * Config::inst()->update('Price', 'default_options', array('Zend_Currency' => array(
	 *    'display' => 'NO_SYMBOL', // will be Zend_Currency::NO_SYMBOL
	 *    'display' => 'USE_SYMBOL', // will be Zend_Currency::USE_SYMBOL
	 *    'display' => 'USE_SHORTNAME', // will be Zend_Currency::USE_SHORTNAME
	 *    'display' => 'USE_NAME', // will be Zend_Currency::USE_NAME
	 *    'position' => 'STANDARD', // will be Zend_Currency::STANDARD
	 *    'position' => 'RIGHT', // will be Zend_Currency::RIGHT
	 *    'position' => 'LEFT', // will be Zend_Currency::LEFT
	 * )));
	 * @return array
	 */
	public function getDefaultOptions() {
		$config = Config::inst()->get($this->class, 'default_options');
		if (!is_array($config)) {
			$config = array();
		}
		if (isset($config['Zend_Currency'])) {
			if (isset($config['Zend_Currency']['display'])) {
				if (in_array($config['Zend_Currency']['display'], array('NO_SYMBOL', 'USE_SYMBOL', 'USE_SHORTNAME', 'USE_NAME'))) {
					$config['Zend_Currency']['display'] = constant("Zend_Currency::{$config['Zend_Currency']['display']}");
				}
			}
			if (isset($config['Zend_Currency']['position'])) {
				if (in_array($config['Zend_Currency']['position'], array('STANDARD', 'RIGHT', 'LEFT'))) {
					$config['Zend_Currency']['position'] = constant("Zend_Currency::{$config['Zend_Currency']['position']}");
				}
			}
		}
		return $config;
	}

	/**
	 * @param array $options
	 * @return string
	 */
	public function Nice($options = array()) {
		//  TODO not sure if $this->symbol is a good thing
		if($this->symbol && !isset($options['symbol'])) $options['symbol'] = $this->symbol;
		$defaultOptions = $this->getDefaultOptions();
		if (is_a($this->currencyLib, 'Zend_Currency') && isset($defaultOptions['Zend_Currency'])) {
			$defaultOptions = $defaultOptions['Zend_Currency'];
			$options = array_merge($defaultOptions, $options);
		}
		if(!isset($options['currency'])) $options['currency'] = $this->getCurrency();
		if(!isset($options['display'])) $options['display'] = Zend_Currency::USE_SYMBOL;
		$amount = $this->getAmount();
		return $this->currencyLib->toCurrency($amount, $options);
	}
}