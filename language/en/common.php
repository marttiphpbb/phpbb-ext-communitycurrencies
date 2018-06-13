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

// acl

	'ACL_M_CC_CREATETRANSACTIONS'	=> 'Can create transactions on behalf of users',
	'ACL_U_CC_CREATETRANSACTIONS'	=> 'Can create transactions',
	'ACL_U_CC_VIEWTRANSACTIONS'		=> 'Can view transactions',

// notification

	'NOTIFICATION_TYPE_TRANSACTION'		=> 'Someone made a transaction to you.',

// mcp

	'MCP_MARTTIPHPBB_COMMUNITYCURRENCIES_TRANSACTIONS'				=> 'Transactions',
	'MCP_MARTTIPHPBB_COMMUNITYCURRENCIES_NEW_TRANSACTION'				=> 'New transaction',
	'MCP_MARTTIPHPBB_COMMUNITYCURRENCIES_NEW_TRANSACTION_EXPLAIN'		=> 'Create a new transaction on behalf of a user.',

// viewonline

	'MARTTIPHPBB_COMMUNITYCURRENCIES_VIEWING_TRANSACTIONS'	=> 'Viewing transactions',

// transactions page

	'MARTTIPHPBB_COMMUNITYCURRENCIES_TRANSACTIONS'			=> 'Transactions',
	'MARTTIPHPBB_COMMUNITYCURRENCIES_NEW_TRANSACTION'			=> 'New transaction',
	'MARTTIPHPBB_COMMUNITYCURRENCIES_HIDE_NEW_TRANSACTION'	=> 'Hide transaction input',
	'MARTTIPHPBB_COMMUNITYCURRENCIES_FROM_USER'				=> 'From member',
	'MARTTIPHPBB_COMMUNITYCURRENCIES_TO_USER'					=> 'To member',
	'MARTTIPHPBB_COMMUNITYCURRENCIES_DESCRIPTION'				=> 'Description',
	'MARTTIPHPBB_COMMUNITYCURRENCIES_AMOUNT'					=> 'Amount',
	'MARTTIPHPBB_COMMUNITYCURRENCIES_TIME'					=> 'Time',
	'MARTTIPHPBB_COMMUNITYCURRENCIES_CREATED_AT'				=> 'Created at',
	'MARTTIPHPBB_COMMUNITYCURRENCIES_HOURS'					=> 'hours',
	'MARTTIPHPBB_COMMUNITYCURRENCIES_MINUTES'					=> 'minutes',
	'MARTTIPHPBB_COMMUNITYCURRENCIES_NO_TRANSACTIONS'			=> 'No transactions found for this search criterion.',

	'MARTTIPHPBB_COMMUNITYCURRENCIES_EMPTY_TO_USER'			=> 'You must fill in a user where you send the transaction to.',
	'MARTTIPHPBB_COMMUNITYCURRENCIES_AMOUNT_NOT_POSITIVE'		=> 'You must give a positive amount for the new transaction.',
	'MARTTIPHPBB_COMMUNITYCURRENCIES_EMPTY_DESCRIPTION'	 	=> 'You must give a description for the new transaction.',
	'MARTTIPHPBB_COMMUNITYCURRENCIES_USER_NOT_EXISTING'	 	=> 'You must give an existing username.',
	'MARTTIPHPBB_COMMUNITYCURRENCIES_NO_VALID_UUID'	 		=> 'The format of the uuid is not valid.',
	'MARTTIPHPBB_COMMUNITYCURRENCIES_TRANSACTION_NOT_UNIQUE'	 		=> 'Your transaction was already submitted.',
	'MARTTIPHPBB_COMMUNITYCURRENCIES_NO_TRANSACTION_TO_YOURSELF'	 	=> 'You cannot create a transaction to yourself.',

	'MARTTIPHPBB_COMMUNITYCURRENCIES_CONFIRM_TRANSACTION'	=> [
		1 => 'Transfer <strong>%1s</strong> %2s to %3s with description <strong>`%4s`</strong> ?',
	],

	'MARTTIPHPBB_COMMUNITYCURRENCIES_TRANSACTION_CREATED'			=> 'The transaction was successfully created.',
	'MARTTIPHPBB_COMMUNITYCURRENCIES_RETURN_TRANSACTION'			=> 'Return to newly created %1s transaction %2s.',
	'MARTTIPHPBB_COMMUNITYCURRENCIES_RETURN_TRANSACTION_LIST'		=> 'Return to the %1s transaction list %2s.',

	'MARTTIPHPBB_COMMUNITYCURRENCIES_TRANSACTION_COUNT'			=> [
		1 => '%s transaction',
		2 => '%s transactions',
	],

	'MARTTIPHPBB_COMMUNITYCURRENCIES_SEARCH_TRANSACTIONS'		=> 'Search transactions ...',

	'MARTTIPHPBB_COMMUNITYCURRENCIES_NO_AUTH_CREATE_TRANSACTION' => 'You are not authorised to create transactions.',
	'MARTTIPHPBB_COMMUNITYCURRENCIES_NO_AUTH_VIEW_TRANSACTIONS'	=> 'You are not authorised to view transactions.',

	'MARTTIPHPBB_COMMUNITYCURRENCIES_TIME_HOURS_AND_MINUTES'		=> '%1s:%2s',
	'MARTTIPHPBB_COMMUNITYCURRENCIES_TIME_HOURS_ONLY'			=> '%sh',

// profile

	'MARTTIPHPBB_COMMUNITYCURRENCIES_BALANCE'					=> 'Balance',
	'MARTTIPHPBB_COMMUNITYCURRENCIES_AMOUNT_CURRENCY'			=> '%1s %2s',

// show transaction

	'MARTTIPHPBB_COMMUNITYCURRENCIES_TRANSACTION_NOT_FOUND'		=> 'The transaction could not be found.',

// Profile (memberlist)

	'MARTTIPHPBB_COMMUNITYCURRENCIES_TOTAL_TRANSACTIONS'			=> 'Total transactions',
	'MARTTIPHPBB_COMMUNITYCURRENCIES_SHOW_USER_TRANSACTIONS'		=> 'Show this user\'s transactions',
	'MARTTIPHPBB_COMMUNITYCURRENCIES_USER_TRANSACTION_PCT'		=> '%.2f%% of all transactions',
	'MARTTIPHPBB_COMMUNITYCURRENCIES_USER_TRANSACTION_PER_DAY'	=> '%.2f transactions per day',

// Github link

	'MARTTIPHPBB_COMMUNITYCURRENCIES_EXTENSION'			=> '%1$sCommunity Currencies%2$s extension for phpBB',

]);
