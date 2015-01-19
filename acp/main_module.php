<?php
/**
* phpBB Extension - marttiphpbb community currency
* @copyright (c) 2014 marttiphpbb <info@martti.be>
* @license GNU General Public License, version 2 (GPL-2.0)
*/

namespace marttiphpbb\ccurrency\acp;

class main_module
{
	var $u_action;

	function main($id, $mode)
	{
		global $db, $user, $auth, $template, $cache, $request;
		global $config, $phpbb_root_path, $phpbb_admin_path, $phpEx;
		global $phpbb_container;

		$user->add_lang_ext('marttiphpbb/ccurrency', 'acp');
		add_form_key('marttiphpbb/ccurrency');

		switch ($mode)
		{
			case 'rendering':
				$this->tpl_name = 'rendering';
				$this->page_title = $user->lang('ACP_CC_RENDERING');

				if ($request->is_set_post('submit'))
				{
					if (!check_form_key('marttiphpbb/ccurrency'))
					{
						trigger_error('FORM_INVALID');
					}

					$config->set('cc_transactions_menu_quick', $request->variable('cc_transactions_menu_quick', 0));
					$config->set('cc_transactions_menu_header', $request->variable('cc_transactions_menu_header', 1));
					$config->set('cc_transactions_menu_footer', $request->variable('cc_transactions_menu_footer', 0));
					$config->set('cc_hide_github_link', $request->variable('cc_hide_github_link', 0));
					$config->set('cc_transactions_per_page', $request->variable('cc_transactions_per_page', 25));

					trigger_error($user->lang('ACP_CC_SETTING_SAVED') . adm_back_link($this->u_action));
				}

				$template->assign_vars(array(
					'U_ACTION'							=> $this->u_action,
					'S_CC_TRANSACTIONS_MENU_QUICK'		=> $config['cc_transactions_menu_quick'],
					'S_CC_TRANSACTIONS_MENU_HEADER'		=> $config['cc_transactions_menu_header'],
					'S_CC_TRANSACTIONS_MENU_FOOTER'		=> $config['cc_transactions_menu_footer'],
					'S_CC_HIDE_GITHUB_LINK'				=> $config['cc_hide_github_link'],
					'CC_TRANSACTIONS_PER_PAGE'			=> $config['cc_transactions_per_page'],
				));

				break;

			case 'currency':
				$this->tpl_name = 'currency';
				$this->page_title = $user->lang('ACP_CC_CURRENCY');

				$currency_plural_operator = $phpbb_container->get('marttiphpbb.ccurrency.currency_plural.operator');
				$ext_manager = $phpbb_container->get('ext.manager');
				$language_dir = $ext_manager->get_extension_path('marttiphpbb/ccurrency', true) . 'language';

				$language_ary = $currency_plural_operator->get_languages();

				if ($request->is_set_post('submit'))
				{

					if (!check_form_key('marttiphpbb/ccurrency'))
					{
						trigger_error('FORM_INVALID');
					}

					$config->set('cc_time_banking_granularity', $request->variable('cc_time_banking_granularity', 900));

					$currency_plural_ary = $request->variable('cc_currency_name', array('' => array('')), true);

					$currency_plural_operator->set($currency_plural_ary);

					trigger_error($user->lang('ACP_CC_SETTING_SAVED') . adm_back_link($this->u_action));
				}

				$granularity_ary = $user->lang['ACP_CC_TB_GRANULARITY_OPTIONS'];
				$granularity_ary = (is_array($granularity_ary)) ? $granularity_ary : array();
				$granularity_options = '';

				foreach ($granularity_ary as $key => $option)
				{
					$granularity_options .= '<option value="'.$key.'"';
					$granularity_options .= ($key == $config['cc_time_banking_granularity']) ? ' selected="selected"' : '';
					$granularity_options .= '>'.$option.'</option>';
				}

				$currency_name_ary = unserialize($config['cc_currency_name']);

				$currency_name_ary = $currency_plural_operator->get();

				foreach ($language_ary as $lang)
				{
					$lang_dir = $lang['lang_dir'];

					$template->assign_block_vars('lang', array(
						'LANG_LOCAL_NAME'	=> $lang['lang_local_name'],
						'LANG_DIR'			=> $lang_dir,
					));

					$lang_file = $language_dir . '/' . $lang_dir . '/acp.' . $phpEx;

					if (!file_exists($lang_file))
					{
						continue;
					}

					include $lang_file;

					$placeholder_ary = $lang['ACP_CC_CURRENCY_NAME_PLURAL_FORMS_PLACEHOLDERS'];
					$plural_forms = $lang['ACP_CC_CURRENCY_NAME_PLURAL_FORMS'];

					foreach ($plural_forms as $key => $name)
					{
						$template->assign_block_vars('lang.plural_forms', array(
							'KEY'			=> $key,
							'NAME'			=> $name,
							'VALUE'			=> (isset($currency_name_ary[$lang_dir][$key])) ? $currency_name_ary[$lang_dir][$key] : '',
							'PLACEHOLDER'	=> isset($placeholder_ary[$key]) ? $placeholder_ary[$key] : '',
						));
					}

					unset($lang);
				}

				$template->assign_vars(array(
					'U_ACTION'				=> $this->u_action,

					'CC_CURRENCY_RATE'					=> $config['cc_currency_rate'],
					'S_CC_TB_GRANULARITY_OPTIONS'		=> $granularity_options,
				));

				break;
		}
	}
}
