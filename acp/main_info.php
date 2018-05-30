<?php
/**
* phpBB Extension - marttiphpbb Community Currencies
* @copyright (c) 2015 - 2018 marttiphpbb <info@martti.be>
* @license GNU General Public License, version 2 (GPL-2.0)
*/

namespace marttiphpbb\communitycurrencies\acp;

class main_info
{
	function module()
	{
		return [
			'filename'	=> '\marttiphpbb\communitycurrencies\acp\main_module',
			'title'		=> 'ACP_MARTTIPHPBB_COMMUNITYCURRENCIES',
			'modes'		=> [
				'rendering'	=> [
					'title' => 'ACP_MARTTIPHPBB_COMMUNITYCURRENCIES_RENDERING',
					'auth' => 'ext_marttiphpbb/communitycurrencies && acl_a_board',
					'cat' => ['ACP_MARTTIPHPBB_COMMUNITYCURRENCIES'],
				],
				'currency'	=> [
					'title' => 'ACP_MARTTIPHPBB_COMMUNITYCURRENCIES_CURRENCY',
					'auth' => 'ext_marttiphpbb/communitycurrencies && acl_a_board',
					'cat' => ['ACP_MARTTIPHPBB_COMMUNITYCURRENCIES'],
				],
			],
		];
	}
}
