<?php
/**
* phpBB Extension - marttiphpbb community currency
* @copyright (c) 2014 marttiphpbb <info@martti.be>
* @license GNU General Public License, version 2 (GPL-2.0)
*/

namespace marttiphpbb\ccurrency\mcp;

class transactions_info
{
	function module()
	{
		return array(
			'filename'	=> '\marttiphpbb\ccurrency\mcp\transactions_module',
			'title'		=> 'MCP_CC_TRANSACTIONS',
			'modes'		=> array(
				'new_transaction'	=> array(
					'title' => 'MCP_CC_NEW_TRANSACTION',
					'auth' => 'ext_marttiphpbb/ccurrency && acl_m_cc_createtransaction',
					'cat' => array('ACP_CC_TRANSACTIONS'),
				),
			),
		);
	}
}
