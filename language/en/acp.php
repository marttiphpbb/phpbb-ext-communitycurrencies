<?php

/**
* phpBB Extension - marttiphpbb community currency
* @copyright (c) 2014 marttiphpbb <info@martti.be>
* @license GNU General Public License, version 2 (GPL-2.0)
*/

if (!defined('IN_PHPBB'))
{
	exit;
}

if (empty($lang) || !is_array($lang))
{
	$lang = array();
}

// DEVELOPERS PLEASE NOTE
//
// All language files should use UTF-8 as their encoding and the files must not contain a BOM.
//
// Placeholders can now contain order information, e.g. instead of
// 'Page %s of %s' you can (and should) write 'Page %1$s of %2$s', this allows
// translators to re-order the output of data while ensuring it remains correct
//
// You do not need this where single placeholders are used, e.g. 'Message %d' is fine
// equally where a string contains only two placeholders which are used to wrap text
// in a url you again do not need to specify an order e.g., 'Click %sHERE%s' is fine

$lang = array_merge($lang, array(

	'LOG_CC_TRANSACTION'	=> 'Transaction posted from to by',

	'ACP_CC_SETTING_SAVED'		=> 'Settings have been saved successfully!',

// acp rendering

	'ACP_CC_LINKS'								=> 'Links',
	'ACP_CC_TRANSACTIONS_MENU_LINK_QUICK'		=> 'Enable transactions link in Quick menu',
	'ACP_CC_TRANSACTIONS_MENU_LINK_HEADER' 		=> 'Enable transactions link in header',
	'ACP_CC_TRANSACTIONS_MENU_LINK_FOOTER'		=> 'Enable transactions link in footer',
	'ACP_CC_HIDE_GITHUB_LINK'					=> 'Hide Github link in footer',

	'ACP_CC_TRANSACTIONS_PAGE'					=> 'Transactions page',
	'ACP_CC_TRANSACTIONS_PER_PAGE'				=> 'Default number of transactions per page',

// acp currency

	'ACP_CC_CURRENCY_NAME' 			=> 'Currency name',
	'ACP_CC_CURRENCY_NAME_PLURAL_FORMS_PLACEHOLDERS'	=> array(
		1 => 'bean',
		2 => 'beans',
	),
	'ACP_CC_CURRENCY_NAME_PLURAL_FORMS'	=> array(
		1 => 'Singular',
		2 => 'Plural',
	),
	'ACP_CC_LANGUAGE_FILE_NOT_AVAILABLE' => 'Translation in this language is not available (yet). You can help the Community Currency extension by feeding back translation files.',

	'ACP_CC_CURRENCY_NAME_EXPLAIN'	=> 'The currency name is not in use when Time Banking',
	'ACP_CC_CURRENCY_RATE' 			=> 'Currency rate in seconds',
	'ACP_CC_TIME_BANKING'			=> 'Time banking',
	'ACP_CC_CURRENCY_RATE_EXPLAIN'	=> 'Set to zero when Time Banking',
	'ACP_CC_TIME_BANKING_GRANULARITY'	=> 'Time Banking granularity',
	'ACP_CC_TB_GRANULARITY_OPTIONS' => array(
		60		=> '1 min.',
		300		=> '5 min.',
		600		=> '10 min.',
		900		=> '15 min.',
		1800	=> '30 min.',
		3600	=> '1 hour',
	),
));
