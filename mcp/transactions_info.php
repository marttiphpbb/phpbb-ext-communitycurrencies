<?php
/**
* phpBB Extension - marttiphpbb Community Currencies
* @copyright (c) 2015 - 2018 marttiphpbb <info@martti.be>
* @license GNU General Public License, version 2 (GPL-2.0)
*/

namespace marttiphpbb\communitycurrencies\mcp;

class transactions_info
{
	function module()
	{
		return [
			'filename'	=> '\marttiphpbb\communitycurrencies\mcp\transactions_module',
			'title'		=> 'MCP_CC_TRANSACTIONS',
			'modes'		=> [
				'new_transaction'	=> [
					'title' => 'MCP_CC_NEW_TRANSACTION',
					'auth' => 'ext_marttiphpbb/communitycurrencies && acl_m_cc_createtransaction',
					'cat' => ['ACP_CC_TRANSACTIONS'],
				],
			],
		];
	}
}
