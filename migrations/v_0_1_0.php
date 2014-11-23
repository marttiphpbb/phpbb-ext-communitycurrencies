<?php
/**
* @package phpBB Extension - marttiphpbb community currency
* @copyright (c) 2014 marttiphpbb <info@martti.be>
* @license http://opensource.org/licenses/MIT
*/

namespace marttiphpbb\ccurrency\migrations;

use phpbb\db\migration\migration;

class v_0_1_0 extends migration
{

	public function update_data()
	{
		return array(
			array('config.add', array('cc_transactions_menu_quick', 1)),
			array('config.add', array('cc_transactions_menu_header', 0)),
			array('config.add', array('cc_transactions_menu_footer', 0)),
			array('config.add', array('cc_hide_github_link', 0)),
			array('config.add', array('cc_transactions_per_page', 25)),		
				
			array('config.add', array('cc_currency_name', '')),
			array('config.add', array('cc_currency_rate', 60)),
			array('config.add', array('cc_time_banking_granularity', 900)),

			array('permission.add', array('u_cc_viewtransactions')),
			array('permission.add', array('u_cc_createtransactions')),
			array('permission.add', array('m_cc_createtransactions')),
			


			array('module.add', array(
				'acp',
				'ACP_CAT_DOT_MODS',
				'ACP_CCURRENCY'
			)),
			array('module.add', array(
				'acp',
				'ACP_CCURRENCY',
				array(
					'module_basename'	=> '\marttiphpbb\ccurrency\acp\main_module',
					'modes'				=> array(
						'links',
						'currency',
					),
				),
			)),
					
			array('module.add', array(
				'mcp',
				'',
				'MCP_CC_TRANSACTIONS'
			)),
			array('module.add', array(
				'mcp',
				'MCP_CC_TRANSACTIONS',
				array(
					'module_basename'	=> '\marttiphpbb\ccurrency\mcp\transactions_module',
					'modes'				=> array(
						'new_transaction',
					),
				),
			)),		
	
		);
	}
	
	public function update_schema()
	{
		return array(
		
			'add_tables'    => array(
				$this->table_prefix . 'cc_transactions'        => array(
					'COLUMNS'        => array(
						'transaction_id'                => array('UINT', NULL, 'auto_increment'),
						'transaction_uuid' 				=> array('VCHAR', ''),
						'transaction_from_user_id'		=> array('UINT', NULL),
						'transaction_from_user_name'	=> array('VCHAR_UNI', ''),
						'transaction_from_user_colour'	=> array('VCHAR:6', ''),
						'transaction_to_user_id'		=> array('UINT', NULL),
						'transaction_to_user_name'		=> array('VCHAR_UNI', ''),
						'transaction_to_user_colour'	=> array('VCHAR:6', ''),
						'transaction_description' 		=> array('VCHAR_UNI', ''),
						'transaction_amount'			=> array('UINT', NULL),											
						'transaction_confirmed'			=> array('BOOL', 0),
						'transaction_confirmed_at'		=> array('TIMESTAMP', NULL),
						'transaction_created_by'		=> array('UINT', NULL),
						'transaction_created_at'		=> array('TIMESTAMP', NULL),												
					),
					'PRIMARY_KEY'  	=> 'transaction_id',
					'KEYS' 		=> array(
						'tuuid' 	=> array('UNIQUE', 'transaction_uuid'),
						'ufid'		=> array('INDEX', 'transaction_from_user_id'),
						'utid'		=> array('INDEX', 'transaction_to_user_id'),
						'crby'		=> array('INDEX', 'transaction_created_by'),							
					),
				),			
			),


			'add_columns'        => array(
				$this->table_prefix . 'users'        => array(
					'user_cc_balance'    				=> array('INT:11', 0),
					'user_cc_transaction_count'			=> array('INT:11', 0),
					'user_cc_status'					=> array('UINT', 0),
					'user_cc_leaving_time'				=> array('TIMESTAMP', NULL),
					'user_cc_active_time'				=> array('TIMESTAMP', NULL),
					'user_cc_inactive_time'				=> array('TIMESTAMP', NULL),				
				),
			),	
		);
	}	
	
	public function revert_schema()
	{
		return array(
			'drop_columns'        => array(
				$this->table_prefix . 'users'        => array(				
					'user_cc_balance',
					'user_cc_transaction_count',
					'user_cc_status',
					'user_cc_leaving_time',
					'user_cc_active_time',
					'user_cc_inactive_time',								
				),
			),
			'drop_tables'			=> array(
				$this->table_prefix . 'cc_transactions',
			),
	   );
	}	
}
