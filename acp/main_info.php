<?php
/**
* phpBB Extension - marttiphpbb Community Currencies
* @copyright (c) 2015 - 2020 marttiphpbb <info@martti.be>
* @license GNU General Public License, version 2 (GPL-2.0)
*/

namespace marttiphpbb\communitycurrencies\acp;
use marttiphpbb\communitycurrencies\util\cnst;

class main_info
{
	function module()
	{
		return [
			'filename'	=> '\marttiphpbb\communitycurrencies\acp\main_module',
			'title'		=> cnst::L_ACP,
			'modes'		=> [
				'rendering'	=> [
					'title' => cnst::L_ACP . '_RENDERING',
					'auth' => 'ext_marttiphpbb/communitycurrencies && acl_a_board',
					'cat' => [cnst::L_ACP],
				],
				'currency'	=> [
					'title' => cnst::L_ACP . '_CURRENCY',
					'auth' => 'ext_marttiphpbb/communitycurrencies && acl_a_board',
					'cat' => [cnst::L_ACP],
				],
			],
		];
	}
}
