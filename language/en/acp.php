<?php

/**
* phpBB Extension - marttiphpbb Community Currencies
* @copyright (c) 2015 - 2018 marttiphpbb <info@martti.be>
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

	'LOG_MARTTIPHPBB_COMMUNITYCURRENCIES_TRANSACTION'	=> 'Transaction posted from to by',

	'ACP_MARTTIPHPBB_COMMUNITYCURRENCIES_SETTING_SAVED'		=> 'Settings have been saved successfully!',

// acp rendering

	'ACP_MARTTIPHPBB_COMMUNITYCURRENCIES_LINKS'								=> 'Links',
	'ACP_MARTTIPHPBB_COMMUNITYCURRENCIES_LINK_LOCATIONS' 						=> 'Enable Link locations to the transaction page',
	'ACP_MARTTIPHPBB_COMMUNITYCURRENCIES_REPO_LINK'							=> 'Enable link to the Community Currencies extension repository in copyright footer',

	'ACP_MARTTIPHPBB_COMMUNITYCURRENCIES_OVERALL_HEADER_NAVIGATION_PREPEND'	=> 'Overall header navigation prepend',
	'ACP_MARTTIPHPBB_COMMUNITYCURRENCIES_OVERALL_HEADER_NAVIGATION_APPEND'	=> 'Overall header navigation append',
	'ACP_MARTTIPHPBB_COMMUNITYCURRENCIES_NAVBAR_HEADER_QUICK_LINKS_BEFORE'	=> 'Navbar header quick links before',
	'ACP_MARTTIPHPBB_COMMUNITYCURRENCIES_NAVBAR_HEADER_QUICK_LINKS_AFTER'		=> 'Navbar header quick links after',
	'ACP_MARTTIPHPBB_COMMUNITYCURRENCIES_OVERALL_HEADER_BREADCRUMBS_BEFORE'	=> 'Overall header breadcrumbs before',
	'ACP_MARTTIPHPBB_COMMUNITYCURRENCIES_OVERALL_HEADER_BREADCRUMBS_AFTER'	=> 'Overall header breadcrumbs after',
	'ACP_MARTTIPHPBB_COMMUNITYCURRENCIES_OVERALL_FOOTER_TIMEZONE_BEFORE'		=> 'Overall footer timezone before',
	'ACP_MARTTIPHPBB_COMMUNITYCURRENCIES_OVERALL_FOOTER_TIMEZONE_AFTER'		=> 'Overall footer timezone after',
	'ACP_MARTTIPHPBB_COMMUNITYCURRENCIES_OVERALL_FOOTER_TEAMLINK_BEFORE'		=> 'Overall footer teamlink before',
	'ACP_MARTTIPHPBB_COMMUNITYCURRENCIES_OVERALL_FOOTER_TEAMLINK_AFTER'		=> 'Overall footer teamlink after',

	'ACP_MARTTIPHPBB_COMMUNITYCURRENCIES_TRANSACTIONS_PAGE'					=> 'Transactions page',
	'ACP_MARTTIPHPBB_COMMUNITYCURRENCIES_TRANSACTIONS_PER_PAGE'				=> 'Default number of transactions per page',

// acp currency

	'ACP_MARTTIPHPBB_COMMUNITYCURRENCIES_CURRENCY'				=> 'Currency',
	'ACP_MARTTIPHPBB_COMMUNITYCURRENCIES_CURRENCY_NAME' 			=> 'Currency name',
	'ACP_MARTTIPHPBB_COMMUNITYCURRENCIES_CURRENCY_NAME_PLURAL_FORMS_PLACEHOLDERS'	=> array(
		1 => 'bean',
		2 => 'beans',
	),
	'ACP_MARTTIPHPBB_COMMUNITYCURRENCIES_CURRENCY_NAME_PLURAL_FORMS'	=> array(
		1 => 'Singular',
		2 => 'Plural',
	),
	'ACP_MARTTIPHPBB_COMMUNITYCURRENCIES_LANGUAGE_FILE_NOT_AVAILABLE' => 'Translation in this language is not available (yet). You can help the Community Currencies extension by feeding back translation files.',

	'ACP_MARTTIPHPBB_COMMUNITYCURRENCIES_CURRENCY_NAME_EXPLAIN'	=> 'The currency name is not in use when Time Banking is enabled',
	'ACP_MARTTIPHPBB_COMMUNITYCURRENCIES_CURRENCY_RATE' 			=> 'Currency rate in seconds',
	'ACP_MARTTIPHPBB_COMMUNITYCURRENCIES_TIME_BANKING'			=> 'Time banking',
	'ACP_MARTTIPHPBB_COMMUNITYCURRENCIES_CURRENCY_RATE_EXPLAIN'	=> 'Set to zero to enable Time Banking',
	'ACP_MARTTIPHPBB_COMMUNITYCURRENCIES_TIME_BANKING_GRANULARITY'	=> 'Time Banking granularity',
	'ACP_MARTTIPHPBB_COMMUNITYCURRENCIES_TB_GRANULARITY_OPTIONS' => array(
		60		=> '1 min.',
		300		=> '5 min.',
		600		=> '10 min.',
		900		=> '15 min.',
		1800	=> '30 min.',
		3600	=> '1 hour',
	),
));
