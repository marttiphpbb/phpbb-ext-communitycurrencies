<?php
/**
* phpBB Extension - marttiphpbb Community Currencies
* @copyright (c) 2015 - 2018 marttiphpbb <info@martti.be>
* @license GNU General Public License, version 2 (GPL-2.0)
*/

namespace marttiphpbb\communitycurrencies\migrations;

use phpbb\db\migration\migration;
use marttiphpbb\communitycurrencies\util\cnst;

class mgr_4_schema extends migration
{
	static public function depends_on()
	{
		return [
			'\marttiphpbb\communitycurrencies\migrations\mgr_3_ucp',
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
					'PRIMARY_KEY' 	=> 'id',
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
					'PRIMARY_KEY'  	=> ['id', 'currency_id'],
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
						'name'			=> ['VCHAR_UNI', ''],
					],
				],
				$this->table_prefix . 'cc_accounts'	=> [
					'COLUMNS'	=> [
						'id'				=> ['UINT', NULL, 'auto_increment'],
						'balance'			=> ['INT', 0],
						'owner'				=> ['UINT', NULL],
					],
					'PRIMARY_KEY' => 'id',
				],
				$this->table_prefix . 'cc_accounts_users' => [
					'COLUMS'	=> [
						'user_id'		=> ['UINT', NULL],
						'account_id'	=> ['UINT', NULL],
					]
				],
			],
		];
	}

	public function revert_schema()
	{
		return [
			'drop_tables'			=> [
				$this->table_prefix . 'cc_events',
				$this->table_prefix . 'cc_transactions',
				$this->table_prefix . 'cc_currencies',
				$this->table_prefix . 'cc_accounts',
				$this->table_prefix . 'cc_accounts_users',
			],
	   ];
	}
}
