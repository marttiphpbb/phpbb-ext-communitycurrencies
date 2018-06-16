<?php
/**
* phpBB Extension - marttiphpbb Community Currencies
* @copyright (c) 2015 - 2018 marttiphpbb <info@martti.be>
* @license GNU General Public License, version 2 (GPL-2.0)
*/

namespace marttiphpbb\communitycurrencies\ucp;

use marttiphpbb\communitycurrencies\util\cnst;

class main_info
{
	function module()
	{
		return [
			'filename'	=> '\marttiphpbb\communitycurrencies\ucp\main_module',
			'title'		=> cnst::L_MCP . '_TRANSACTIONS',
			'modes'		=> [
				'new_transaction'	=> [
					'title' => cnst::L_MCP . '_NEW_TRANSACTION',
					'auth' => 'ext_marttiphpbb/communitycurrencies && acl_u_', //cc_createtransaction',
					'cat' => [cnst::L_MCP . '_TRANSACTIONS'],
				],
			],
		];
	}
}
