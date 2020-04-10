<?php
/**
* phpBB Extension - marttiphpbb Community Currencies
* @copyright (c) 2015 - 2020 marttiphpbb <info@martti.be>
* @license GNU General Public License, version 2 (GPL-2.0)
*/

namespace marttiphpbb\communitycurrencies\migrations;

use phpbb\db\migration\migration;
use marttiphpbb\communitycurrencies\util\cnst;

class mgr_3_ucp extends migration
{
	static public function depends_on()
	{
		return [
			'\marttiphpbb\communitycurrencies\migrations\mgr_2_mcp',
		];
	}

	public function update_data()
	{
		return [
			['module.add', [
				'ucp',
				'',
				cnst::L_UCP,
			]],

			['module.add', [
				'ucp',
				cnst::L_UCP,
				[
					'module_basename'	=> '\marttiphpbb\communitycurrencies\ucp\main_module',
					'modes'				=> [
						'new_transaction',
						'transactions',
					],
				],
			]],
		];
	}
}
