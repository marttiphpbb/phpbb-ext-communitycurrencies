<?php

/**
* @package phpBB Extension - marttiphpbb community currency
* @copyright (c) 2014 marttiphpbb <info@martti.be>
* @license http://opensource.org/licenses/MIT
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

// acp module / modes

	'ACP_CCURRENCY'				=> 'Community Currency',
	'ACP_CC_RENDERING'			=> 'Rendering',
	'ACP_CC_CURRENCY'			=> 'Currency',

// acl 
	
	'ACL_M_CC_CREATETRANSACTIONS'	=> 'Can create transactions on behalf of users',
	'ACL_U_CC_CREATETRANSACTIONS'	=> 'Can create transactions',
	'ACL_U_CC_VIEWTRANSACTIONS'		=> 'Can view transactions',



// notification


	'NOTIFICATION_TYPE_TRANSACTION'		=> 'Someone made a transaction to you.',


		
// mcp

	'MCP_CC_TRANSACTIONS'				=> 'Transactions',
	'MCP_CC_NEW_TRANSACTION'			=> 'New transaction',
	'MCP_CC_NEW_TRANSACTION_EXPLAIN'	=> 'Create a new transaction on behalf of a user.',
	

// viewonline


	'CC_VIEWING_TRANSACTIONS'	=> 'Viewing transactions',


// transactions page
	
	'CC_TRANSACTIONS'			=> 'Transactions',
	'CC_NEW_TRANSACTION'		=> 'New transaction',
	'CC_HIDE_NEW_TRANSACTION'	=> 'Hide new transaction input',
	'CC_FROM_USER'				=> 'From member',
	'CC_TO_USER'				=> 'To member',
	'CC_DESCRIPTION'			=> 'Description',
	'CC_AMOUNT'					=> 'Amount', 
	'CC_TIME'					=> 'Time',
	'CC_CREATED_AT'				=> 'Created at',	
	'CC_HOURS'					=> 'hours',
	'CC_MINUTES'				=> 'minutes',
	'CC_NO_TRANSACTIONS'		=> 'No transactions found for this search criterion.',
	
	'CC_EMPTY_TO_USER'			=> 'You must fill in a user where you send the transaction to.',
	'CC_AMOUNT_NOT_POSITIVE'	=> 'You must give a positive amount for the new transaction.',
	'CC_EMPTY_DESCRIPTION'	 	=> 'You must give a description for the new transaction.',
	'CC_USER_NOT_EXISTING'	 	=> 'You must give an existing username.',
	'CC_NO_VALID_UUID'	 		=> 'The format of the uuid is not valid.',
	'CC_TRANSACTION_NOT_UNIQUE'	 		=> 'Your transaction was already submitted.',
	'CC_NO_TRANSACTION_TO_YOURSELF'	 	=> 'You cannot create a transaction to yourself.',
	
	'CC_CONFIRM_TRANSACTION'	=> array(
		1 => 'Transfer <strong>%1s</strong> %2s to %3s with description <strong>`%4s`</strong> ?', 
	), 
	
	'CC_TRANSACTION_CREATED'		=> 'The transaction was successfully created.',
	'CC_RETURN_TRANSACTION'			=> 'Return to newly created %1s transaction %2s.',
	'CC_RETURN_TRANSACTION_LIST'	=> 'Return to the %1s transaction list %2s.',
	
	'CC_TRANSACTIONS_COUNT'			=> array(
		1 => '%s transaction',
		2 => '%s transactions',
	),
	
	'CC_SEARCH_TRANSACTIONS'		=> 'Search transactions ...',
	
	'CC_NO_AUTH_CREATE_TRANSACTION' => 'You are not authorised to create transactions.',
	'CC_NO_AUTH_VIEW_TRANSACTIONS'	=> 'You are not authorised to view transactions.',

	'CC_TIME_HOURS_AND_MINUTES'		=> '%1s:%2s',
	'CC_TIME_HOURS_ONLY'			=> '%sh',
	'CC_BALANCE'					=> '%1s %2s',	
	
	

// show transaction
 
	'CC_TRANSACTION_NOT_FOUND'		=> 'The transaction could not be found.',	


// Profile (memberlist)

	'CC_TOTAL_TRANSACTIONS'			=> 'Total transactions',
	'CC_SHOW_USER_TRANSACTIONS'		=> 'Show this user\'s transactions',
	'CC_USER_TRANSACTION_PCT'		=> '%.2f%% of all transactions',
	'CC_USER_TRANSACTION_PER_DAY'	=> '%.2f transactions per day',



));
