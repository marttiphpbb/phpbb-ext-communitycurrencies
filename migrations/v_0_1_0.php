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
			array('config.add', array('cc_transactions_menu_quick', 0)),
			array('config.add', array('cc_transactions_menu_header', 1)),
			array('config.add', array('cc_transactions_menu_footer', 0)),
			array('config.add', array('cc_hide_github_link', 0)),
			array('config.add', array('cc_transactions_per_page', 25)),		
				
			array('config.add', array('cc_currency_symbol', '')),
			array('config.add', array('cc_currency_symbol_before', 1)),

			array('config.add', array('cc_currency_rate', 60)),
			array('config.add', array('cc_time_banking_granularity', 900)),
			
			array('config.add', array('cc_transaction_count', 0, true)),

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
						'rendering',
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
				$this->table_prefix . 'cc_currency_plural'	=> array(
					'COLUMNS'	=> array(
						'id'		=> array('UINT', NULL, 'auto_increment'),
						'lang_dir'	=> array('VCHAR:30', ''),
						'form'		=> array('UINT', NULL),
						'name'		=> array('VCHAR_UNI', ''), 
					),
					'PRIMARY_KEY'	=> 'id',
				),
				$this->table_prefix . 'cc_transactions'		=> array(
					'COLUMNS'        => array(
						'id'                => array('UINT', NULL, 'auto_increment'),
						'unique_id' 		=> array('VCHAR', ''),
						'from_user_id'		=> array('UINT', NULL),
						'from_username'		=> array('VCHAR_UNI', ''),
						'from_user_colour'	=> array('VCHAR:6', ''),
						'to_user_id'		=> array('UINT', NULL),
						'to_username'		=> array('VCHAR_UNI', ''),
						'to_user_colour'	=> array('VCHAR:6', ''),
						'description' 		=> array('VCHAR_UNI', ''),
						'amount'			=> array('UINT', NULL),											
						'confirmed'			=> array('BOOL', 0),
						'confirmed_at'		=> array('TIMESTAMP', NULL),
						'created_by'		=> array('UINT', NULL),
						'created_at'		=> array('TIMESTAMP', NULL),
						'parent_id'			=> array('UINT', NULL),												
						'children_count'	=> array('UINT', 0),												
					),
					'PRIMARY_KEY'  	=> 'id',
					'KEYS' 		=> array(
						'tuid' 		=> array('UNIQUE', 'unique_id'),
						'ufid'		=> array('INDEX', 'from_user_id'),
						'utid'		=> array('INDEX', 'to_user_id'),
						'crby'		=> array('INDEX', 'created_by'),							
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
				$this->table_prefix . 'cc_currency_plural',
			),
	   );
	}	
}
