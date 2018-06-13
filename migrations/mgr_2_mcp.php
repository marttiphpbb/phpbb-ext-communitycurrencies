<?php
/**
* phpBB Extension - marttiphpbb Community Currencies
* @copyright (c) 2015 - 2018 marttiphpbb <info@martti.be>
* @license GNU General Public License, version 2 (GPL-2.0)
*/

namespace marttiphpbb\communitycurrencies\migrations;

use phpbb\db\migration\migration;
use marttiphpbb\communitycurrencies\util\cnst;

class mgr_2_mcp extends migration
{
	static public function depends_on()
	{
		return [
			'\marttiphpbb\communitycurrencies\migrations\mgr_1_acp',
		];
	}

	public function update_data()
	{
		return [
			['module.add', [
				'mcp',
				'',
				cnst::L_MCP . '_TRANSACTIONS',
			]],

			['module.add', [
				'mcp',
				cnst::L_MCP . '_TRANSACTIONS',
				[
					'module_basename'	=> '\marttiphpbb\communitycurrencies\mcp\main_module',
					'modes'				=> [
						'new_transaction',
					],
				],
			]],
		];
	}
}
