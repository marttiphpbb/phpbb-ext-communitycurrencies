<?php
/**
* @package phpBB Extension - marttiphpbb community currency
* @copyright (c) 2014 marttiphpbb <info@martti.be>
* @license http://opensource.org/licenses/MIT
*/

namespace marttiphpbb\ccurrency\mcp;

class transactions_module
{
	var $p_master;
	var $u_action;

	function __construct(&$p_master)
	{
		$this->p_master = &$p_master;
	}


	function main($id, $mode)
	{
		global $db, $user, $auth, $template, $cache, $request;
		global $config, $phpbb_root_path, $phpbb_admin_path, $phpEx;

		$user->add_lang_ext('marttiphpbb/ccurrency', 'common'); 
		add_form_key('marttiphpbb/ccurrency');		
		
		switch ($mode)
		{
			case 'new_transaction': 
				$this->tpl_name = 'mcp_new_transaction';
				$this->page_title = $user->lang('MCP_CC_NEW_TRANSACTION');
				
				if ($request->is_set_post('submit'))
				{
					if (!check_form_key('marttiphpbb/ccurrency'))
					{
						trigger_error('FORM_INVALID');
					}

					trigger_error($user->lang('MCP_CC_SETTING_SAVED') . adm_back_link($this->u_action));
				}
				
				$template->assign_vars(array(
					'U_ACTION'							=> $this->u_action,
				));

				break;			
		}
	}
}
