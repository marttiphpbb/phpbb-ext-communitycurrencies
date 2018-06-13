<?php
/**
* phpBB Extension - marttiphpbb Community Currencies
* @copyright (c) 2015 - 2018 marttiphpbb <info@martti.be>
* @license GNU General Public License, version 2 (GPL-2.0)
*/

namespace marttiphpbb\communitycurrencies\mcp;

class main_module
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
		global $phpbb_container;

		$language = $phpbb_container->get('language');

		$user->add_lang_ext('marttiphpbb/communitycurrencies', 'common');
		add_form_key('marttiphpbb/communitycurrencies');

		switch ($mode)
		{
			case 'new_transaction':
				$this->tpl_name = 'mcp_new_transaction';
				$this->page_title = $user->lang('MCP_CC_NEW_TRANSACTION');

				if ($request->is_set_post('submit'))
				{
					if (!check_form_key('marttiphpbb/communitycurrencies'))
					{
						trigger_error('FORM_INVALID');
					}

					trigger_error($user->lang('MCP_CC_SETTING_SAVED') . adm_back_link($this->u_action));
				}

				$template->assign_vars([
					'U_ACTION'	=> $this->u_action,
				]);

				break;
		}
	}
}
