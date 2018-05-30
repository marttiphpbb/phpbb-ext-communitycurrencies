<?php
/**
* phpBB Extension - marttiphpbb Community Currencies
* @copyright (c) 2015 - 2018 marttiphpbb <info@martti.be>
* @license GNU General Public License, version 2 (GPL-2.0)
*/

namespace marttiphpbb\communitycurrencies\migrations;

use phpbb\db\migration\migration;

class v_0_1_0 extends migration
{

	public function update_data()
	{
		return [
			['config_text.add', ['marttiphpbb_communitycurrencies_plural_forms', '']],

			['config.add', ['communitycurrencies_links', 3]],			

			['config.add', ['cc_transactions_per_page', 25]],
			['config.add', ['communitycurrencies_symbol', '']],
			['config.add', ['communitycurrencies_symbol_before', 1]],

			['config.add', ['communitycurrencies_rate', 60]],
			['config.add', ['cc_time_banking_granularity', 900]],

			['config.add', ['cc_transaction_count', 0, true]],

			['permission.add', ['u_cc_viewtransactions']],
			['permission.add', ['u_cc_createtransactions']],
			['permission.add', ['m_cc_createtransactions']],

			['module.add', [
				'acp',
				'ACP_CAT_DOT_MODS',
				'ACP_MARTTIPHPBB_COMMUNITYCURRENCIES'
			]],
			['module.add', [
				'acp',
				'ACP_MARTTIPHPBB_COMMUNITYCURRENCIES',
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
				'MCP_MARTTIPHPBB_COMMUNITYCURRENCIES_TRANSACTIONS'
			]],
			['module.add', [
				'mcp',
				'MCP_MARTTIPHPBB_COMMUNITYCURRENCIES_TRANSACTIONS',
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
				$this->table_prefix . 'cc_transactions'		=> [
					'COLUMNS'        => [
						'id'                => ['UINT', NULL, 'auto_increment'],
						'unique_id' 		=> ['VCHAR', ''],
						'from_user_id'		=> ['UINT', NULL],
						'to_user_id'		=> ['UINT', NULL],
						'description' 		=> ['VCHAR_UNI', ''],
						'amount'			=> ['UINT', NULL],
						'confirmed_at'		=> ['TIMESTAMP', NULL],
						'created_by'		=> ['UINT', NULL],
						'created_at'		=> ['TIMESTAMP', NULL],
						'parent_id'			=> ['UINT', NULL],
						'child_count'		=> ['UINT', 0],
					],
					'PRIMARY_KEY'  	=> 'id',
					'KEYS' 		=> [
						'tuid' 		=> ['UNIQUE', 'unique_id'],
						'ufid'		=> ['INDEX', 'from_user_id'],
						'utid'		=> ['INDEX', 'to_user_id'],
						'crby'		=> ['INDEX', 'created_by'],
					],
				],
			],

			'add_columns'        => [
				$this->table_prefix . 'users'        => [
					'user_cc_balance'    				=> ['INT:11', 0],
					'user_cc_transaction_count'			=> ['INT:11', 0],
					'user_cc_status'					=> ['UINT', 0],
					'user_cc_leaving_time'				=> ['TIMESTAMP', NULL],
					'user_cc_active_time'				=> ['TIMESTAMP', NULL],
					'user_cc_inactive_time'				=> ['TIMESTAMP', NULL],
				],
			],
		];
	}

	public function revert_schema()
	{
		return [
			'drop_columns'        => [
				$this->table_prefix . 'users'        => [
					'user_cc_balance',
					'user_cc_transaction_count',
					'user_cc_status',
					'user_cc_leaving_time',
					'user_cc_active_time',
					'user_cc_inactive_time',
				],
			],
			'drop_tables'			=> [
				$this->table_prefix . 'cc_transactions',
			],
	   ];
	}
}
