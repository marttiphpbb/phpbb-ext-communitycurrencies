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
	$lang = [];
}

$lang = array_merge($lang, [

	'ACP_MARTTIPHPBB_COMMUNITYCURRENCIES'				=> 'Community Currencies',
	'ACP_MARTTIPHPBB_COMMUNITYCURRENCIES_RENDERING'		=> 'Rendering',
	'ACP_MARTTIPHPBB_COMMUNITYCURRENCIES_CURRENCY'		=> 'Currency',
]);
