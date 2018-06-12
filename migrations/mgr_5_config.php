<?php
/**
* phpBB Extension - marttiphpbb Community Currencies
* @copyright (c) 2015 - 2018 marttiphpbb <info@martti.be>
* @license GNU General Public License, version 2 (GPL-2.0)
*/

namespace marttiphpbb\communitycurrencies\migrations;

use phpbb\db\migration\migration;
use marttiphpbb\communitycurrencies\util\cnst;

class mgr_1_config extends migration
{
	static public function depends_on()
	{
		return [
			'\marttiphpbb\communitycurrencies\migrations\mgr_4_schema',
		];
	}

	public function update_data()
	{
		return [
			['config_text.add', ['marttiphpbb_communitycurrencies', serialize([])]],

			['permission.add', ['u_cc_viewtransactions']],
			['permission.add', ['u_cc_createtransactions']],
			['permission.add', ['m_cc_createtransactions']],

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

			['module.add', [
				'mcp',
				'',
				cnst::L_MCP . '_TRANSACTIONS'
			]],

			['module.add', [
				'mcp',
				cnst::L_MCP . '_TRANSACTIONS',
				[
					'module_basename'	=> '\marttiphpbb\communitycurrencies\mcp\transactions_module',
					'modes'				=> [
						'new_transaction',
					],
				],
			]],
		];
	}

	public function update_schema()
	{
		return [

			'add_tables'    => [
				$this->table_prefix . 'cc_events' => [
					'COLUMS'	=> [
						'id'		=> ['UINT', NULL, 'auto_increment'],
						'data'		=> ['TEXT', NULL],
						'ts'		=> ['TIMESTAMP', NULL],
					],
				],
				$this->table_prefix . 'cc_transactions'		=> [
					'COLUMNS'        => [
						'id'                => ['UINT', NULL, 'auto_increment'],
						'currency_id'		=> ['UINT', NULL],
						'from_account_id'	=> ['UINT', NULL],
						'to_account_id'		=> ['UINT', NULL],
						'description' 		=> ['VCHAR_UNI', ''],
						'amount'			=> ['UINT', NULL],
						'created_by'		=> ['UINT', NULL],
						'created_at'		=> ['TIMESTAMP', NULL],
					],
					'PRIMARY_KEY'  	=> 'id',
					'KEYS' 		=> [
						'cfid'		=> ['INDEX', 'from_account_id'],
						'ctid'		=> ['INDEX', 'to_account_id'],
						'crby'		=> ['INDEX', 'created_by'],
					],
				],
				$this->table_prefix . 'cc_currencies' => [
					'COLUMNS'	=> [
						'id'			=> ['UINT', NULL, 'auto_increment'],
						'group_id'		=> ['UINT', NULL],
						'created_at' 	=> ['TIMESTAMP', NULL],
						'owner_id'		=> ['UINT', NULL],
					],
				],
				$this->table_prefix . 'cc_accounts'	=> [
					'COLUMS'	=> [
						'id'				=> ['UINT', NULL, 'auto_increment'],
						'balance'			=> ['INT', 0],
						'owner'				=> ['UINT', NULL],
					],
					'PRIMARY_KEY' => 'id',
				],
				$this->table_prefix . 'cc_'
			],
		];
	}

	public function revert_schema()
	{
		return [
			'drop_tables'			=> [
				$this->table_prefix . 'cc_transactions',
			],
	   ];
	}
}
