<?php
/**
* phpBB Extension - marttiphpbb communitycurrencies
* @copyright (c) 2015 - 2020 marttiphpbb <info@martti.be>
* @license GNU General Public License, version 2 (GPL-2.0)
*/

namespace marttiphpbb\communitycurrencies\model;

use phpbb\config\config;
use phpbb\template\template;
use phpbb\user;

class links
{
	protected $config;
	protected $template;
	protected $user;

	protected $links = [
		1		=> 'OVERALL_FOOTER_COPYRIGHT_APPEND',
		2		=> 'OVERALL_HEADER_NAVIGATION_PREPEND',
		4		=> 'OVERALL_HEADER_NAVIGATION_APPEND',
		8		=> 'NAVBAR_HEADER_QUICK_LINKS_BEFORE',
		16		=> 'NAVBAR_HEADER_QUICK_LINKS_AFTER',
		32		=> 'OVERALL_HEADER_BREADCRUMBS_BEFORE',
		64		=> 'OVERALL_HEADER_BREADCRUMBS_AFTER',
		128		=> 'OVERALL_FOOTER_TIMEZONE_BEFORE',
		256		=> 'OVERALL_FOOTER_TIMEZONE_AFTER',
		512		=> 'OVERALL_FOOTER_TEAMLINK_BEFORE',
		1024	=> 'OVERALL_FOOTER_TEAMLINK_AFTER',
	];

	public function __construct(
		config $config,
		template $template,
		user $user
	)
	{
		$this->config = $config;
		$this->template = $template;
		$this->user = $user;
	}

	public function assign_template_vars()
	{
		$links_enabled = $this->config['communitycurrencies_links'];
		$template_vars = [];

		foreach ($this->links as $key => $value)
		{
			if ($key & $links_enabled)
			{
				$template_vars['S_MARTTIPHPBB_COMMUNITYCURRENCIES_' . $value] = true;
			}
		}

		$this->template->assign_vars($template_vars);
		return $this;
	}

	public function assign_acp_select_template_vars()
	{
		$links_enabled = $this->config['communitycurrencies_links'];

		$this->template->assign_var('S_MARTTIPHPBB_COMMUNITYCURRENCIES_REPO_LINK', ($links_enabled & 1) ? true : false);

		$return_ary = [];
		$links = $this->links;
		unset($links[1]);

		foreach ($links as $key => $value)
		{
			$this->template->assign_block_vars('links', [
				'VALUE'			=> $key,
				'S_SELECTED'	=> ($key & $links_enabled) ? true : false,
				'LANG'			=> $this->user->lang('ACP_MARTTIPHPBB_COMMUNITYCURRENCIES_' . $value),
			]);
		}
		return $this;
	}

	public function set($links, $communitycurrencies_repo_link)
	{
		$this->config->set('communitycurrencies_links', array_sum($links) + $communitycurrencies_repo_link);
		return $this;
	}
}
