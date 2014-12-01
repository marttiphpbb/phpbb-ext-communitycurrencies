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

$lang = array_merge($lang, array(

	'LOG_CC_TRANSACTION'	=> 'Transaction posted from to by',	


// acp 

	'ACP_CCURRENCY'				=> 'Community Currency',
	'ACP_CC_SETTING_SAVED'		=> 'Settings have been saved successfully!',

// acp rendering 

	'ACP_CC_RENDERING'							=> 'Rendering',

	'ACP_CC_LINKS'								=> 'Links',
	'ACP_CC_TRANSACTIONS_MENU_LINK_QUICK'		=> 'Enable transactions link in Quick menu',
	'ACP_CC_TRANSACTIONS_MENU_LINK_HEADER' 		=> 'Enable transactions link in header',
	'ACP_CC_TRANSACTIONS_MENU_LINK_FOOTER'		=> 'Enable transactions link in footer',
	'ACP_CC_HIDE_GITHUB_LINK'					=> 'Hide Github link in footer',
	
	'ACP_CC_TRANSACTIONS_PAGE'					=> 'Transactions page',
	'ACP_CC_TRANSACTIONS_PER_PAGE'				=> 'Default number of transactions per page',

// acp currency 

	'ACP_CC_CURRENCY'				=> 'Currency',
	'ACP_CC_CURRENCY_NAME' 			=> 'Currency name',	
	'ACP_CC_CURRENCY_NAME_EXPLAIN'	=> 'The currency name is not in use when Time Banking',
	'ACP_CC_CURRENCY_RATE' 			=> 'Currency rate in seconds',
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


// notification


	'NOTIFICATION_TYPE_TRANSACTION'		=> 'Someone made a transaction to you.',


		
// mcp

	'MCP_CC_TRANSACTIONS'				=> 'Transactions',
	'MCP_CC_NEW_TRANSACTION'			=> 'New transaction',
	'MCP_CC_NEW_TRANSACTION_EXPLAIN'	=> 'Create a new transaction on behalf of a user.',
	




// acl 
	
	'ACL_M_CC_CREATETRANSACTIONS'	=> 'Can create transactions on behalf of users',
	'ACL_U_CC_CREATETRANSACTIONS'	=> 'Can create transactions',
	'ACL_U_CC_VIEWTRANSACTIONS'		=> 'Can view transactions',


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
	'CC_HOURS'					=> 'hours',
	'CC_MINUTES'				=> 'minutes',
	'CC_TRANSACTION_TIME'		=> 'Created at', 
	'CC_NO_TRANSACTIONS'		=> 'No transactions found for this search criterion.',
	
	'CC_EMPTY_TO_USER'			=> 'You must fill in a user where you send the transaction to.',
	'CC_AMOUNT_NOT_POSITIVE'	=> 'You must give a positive amount for the new transaction.',
	'CC_EMPTY_DESCRIPTION'	 	=> 'You must give a description for the new transaction.',
	'CC_USER_NOT_EXISTING'	 	=> 'You must give an existing username.',
	'CC_NO_VALID_UUID'	 		=> 'The format of the uuid is not valid.',
	'CC_UUID_NOT_UNIQUE'	 	=> 'Your transaction was already submitted.',
	'CC_NO_TRANSACTION_TO_YOURSELF'	 	=> 'You cannot create a transaction to yourself.',
	
	'CC_CONFIRM_TRANSACTION'	=> array(
		1 => 'Transfer %1s %2s to user %3s with description %4s ?', 
	), 
	
	'CC_TRANSACTION_CREATED'	=> 'The transaction was successfully created.',
	
	
	
	'CC_NO_AUTH_CREATE_TRANSACTION' => 'You are not authorised to create transactions.',
	'CC_NO_AUTH_VIEW_TRANSACTIONS'	=> 'You are not authorised to view transactions.',



// Profile (memberlist)

	'CC_TOTAL_TRANSACTIONS'			=> 'Total transactions',
	'CC_SEARCH_USER_TRANSACTIONS'	=> 'Search user\'s transactions',
	

// groups

	'G_CC_ACTIVE_ACCOUNTS'		=> 'Active accounts',

));
