<?php

/**
* phpBB Extension - marttiphpbb community currency
* @copyright (c) 2015 marttiphpbb <info@martti.be>
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

// acl

	'ACL_M_CC_CREATETRANSACTIONS'	=> 'Can create transactions on behalf of users',
	'ACL_U_CC_CREATETRANSACTIONS'	=> 'Can create transactions',
	'ACL_U_CC_VIEWTRANSACTIONS'		=> 'Can view transactions',

// notification

	'NOTIFICATION_TYPE_TRANSACTION'		=> 'Someone made a transaction to you.',

// mcp

	'MCP_CCURRENCY_TRANSACTIONS'				=> 'Transactions',
	'MCP_CCURRENCY_NEW_TRANSACTION'				=> 'New transaction',
	'MCP_CCURRENCY_NEW_TRANSACTION_EXPLAIN'		=> 'Create a new transaction on behalf of a user.',

// viewonline

	'CCURRENCY_VIEWING_TRANSACTIONS'	=> 'Viewing transactions',

// transactions page

	'CCURRENCY_TRANSACTIONS'			=> 'Transactions',
	'CCURRENCY_NEW_TRANSACTION'			=> 'New transaction',
	'CCURRENCY_HIDE_NEW_TRANSACTION'	=> 'Hide transaction input',
	'CCURRENCY_FROM_USER'				=> 'From member',
	'CCURRENCY_TO_USER'					=> 'To member',
	'CCURRENCY_DESCRIPTION'				=> 'Description',
	'CCURRENCY_AMOUNT'					=> 'Amount',
	'CCURRENCY_TIME'					=> 'Time',
	'CCURRENCY_CREATED_AT'				=> 'Created at',
	'CCURRENCY_HOURS'					=> 'hours',
	'CCURRENCY_MINUTES'					=> 'minutes',
	'CCURRENCY_NO_TRANSACTIONS'			=> 'No transactions found for this search criterion.',

	'CCURRENCY_EMPTY_TO_USER'			=> 'You must fill in a user where you send the transaction to.',
	'CCURRENCY_AMOUNT_NOT_POSITIVE'		=> 'You must give a positive amount for the new transaction.',
	'CCURRENCY_EMPTY_DESCRIPTION'	 	=> 'You must give a description for the new transaction.',
	'CCURRENCY_USER_NOT_EXISTING'	 	=> 'You must give an existing username.',
	'CCURRENCY_NO_VALID_UUID'	 		=> 'The format of the uuid is not valid.',
	'CCURRENCY_TRANSACTION_NOT_UNIQUE'	 		=> 'Your transaction was already submitted.',
	'CCURRENCY_NO_TRANSACTION_TO_YOURSELF'	 	=> 'You cannot create a transaction to yourself.',

	'CCURRENCY_CONFIRM_TRANSACTION'	=> array(
		1 => 'Transfer <strong>%1s</strong> %2s to %3s with description <strong>`%4s`</strong> ?',
	),

	'CCURRENCY_TRANSACTION_CREATED'			=> 'The transaction was successfully created.',
	'CCURRENCY_RETURN_TRANSACTION'			=> 'Return to newly created %1s transaction %2s.',
	'CCURRENCY_RETURN_TRANSACTION_LIST'		=> 'Return to the %1s transaction list %2s.',

	'CCURRENCY_TRANSACTION_COUNT'			=> array(
		1 => '%s transaction',
		2 => '%s transactions',
	),

	'CCURRENCY_SEARCH_TRANSACTIONS'		=> 'Search transactions ...',

	'CCURRENCY_NO_AUTH_CREATE_TRANSACTION' => 'You are not authorised to create transactions.',
	'CCURRENCY_NO_AUTH_VIEW_TRANSACTIONS'	=> 'You are not authorised to view transactions.',

	'CCURRENCY_TIME_HOURS_AND_MINUTES'		=> '%1s:%2s',
	'CCURRENCY_TIME_HOURS_ONLY'			=> '%sh',

// profile

	'CCURRENCY_BALANCE'					=> 'Balance',
	'CCURRENCY_AMOUNT_CURRENCY'			=> '%1s %2s',

// show transaction

	'CCURRENCY_TRANSACTION_NOT_FOUND'		=> 'The transaction could not be found.',

// Profile (memberlist)

	'CCURRENCY_TOTAL_TRANSACTIONS'			=> 'Total transactions',
	'CCURRENCY_SHOW_USER_TRANSACTIONS'		=> 'Show this user\'s transactions',
	'CCURRENCY_USER_TRANSACTION_PCT'		=> '%.2f%% of all transactions',
	'CCURRENCY_USER_TRANSACTION_PER_DAY'	=> '%.2f transactions per day',

// Github link

	'CCURRENCY_EXTENSION'			=> '%1$sCommunity Currency%2$s extension for phpBB',

));
