<?php
/**
* phpBB Extension - marttiphpbb Community Currencies
* @copyright (c) 2015 - 2020 marttiphpbb <info@martti.be>
* @license GNU General Public License, version 2 (GPL-2.0)
*/

namespace marttiphpbb\communitycurrencies\migrations;

use phpbb\db\migration\migration;
use marttiphpbb\communitycurrencies\util\cnst;

class mgr_1_acp extends migration
{
	static public function depends_on()
	{
		return [
			'\phpbb\db\migration\data\v32x\v321',
		];
	}

	public function update_data()
	{
		return [
			['module.add', [
				'acp',
				'ACP_CAT_DOT_MODS',
				cnst::L_ACP
			]],
	
			['module.add', [
				'acp',
				cnst::L_ACP,
				[
					'module_basename'	=> '\marttiphpbb\communitycurrencies\acp\main_module',
					'modes'				=> [
						'rendering',
						'currency',
					],
				],
			]],
		];
	}
}
