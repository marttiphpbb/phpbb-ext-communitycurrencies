<?php
/**
* phpBB Extension - marttiphpbb Community Currencies
* @copyright (c) 2015 - 2020 marttiphpbb <info@martti.be>
* @license GNU General Public License, version 2 (GPL-2.0)
*/

namespace marttiphpbb\communitycurrencies\event;

use phpbb\event\data as event;
use phpbb\auth\auth;
use phpbb\config\db as config;
use phpbb\controller\helper;
use phpbb\template\twig\twig as template;
use phpbb\user;
use marttiphpbb\communitycurrencies\datatransformer\currency_transformer;
use marttiphpbb\communitycurrencies\model\links;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class main_listener implements EventSubscriberInterface
{
	protected $auth;
	protected $config;
	protected $helper;
	protected $php_ext;
	protected $template;
	protected $user;
	protected $currency_transformer;
	protected $links;

	public function __construct(
		auth $auth,
		config $config,
		helper $helper,
		string $php_ext,
		template $template,
		user $user,
		currency_transformer $currency_transformer,
		links $links
	)
	{
		$this->auth = $auth;
		$this->config = $config;
		$this->helper = $helper;
		$this->php_ext = $php_ext;
		$this->template = $template;
		$this->user = $user;
		$this->currency_transformer = $currency_transformer;
		$this->links = $links;
	}

	static public function getSubscribedEvents()
	{
		return [
			'core.user_setup'						=> 'core_user_setup',
			'core.page_header'						=> 'core_page_header',
			'core.viewonline_overwrite_location'	=> 'core_viewonline_overwrite_location',
		];
	}

	public function core_user_setup(event $event)
	{
		$lang_set_ext = $event['lang_set_ext'];

		$lang_set_ext[] = [
			'ext_name' => 'marttiphpbb/communitycurrencies',
			'lang_set' => 'common',
		];
		$event['lang_set_ext'] = $lang_set_ext;
	}

	public function core_page_header(event $event)
	{
		if ($this->auth->acl_get('u_cc_viewtransactions'))
		{
			$this->links->assign_template_vars();
			$this->template->assign_vars([
				'U_MARTTIPHPBB_COMMUNITYCURRENCIES_TRANSACTIONS'		=> $this->helper->route('marttiphpbb_cc_transactionlist_controller'),
				'MARTTIPHPBB_COMMUNITYCURRENCIES_REPO_LINK'			=> sprintf($this->user->lang['MARTTIPHPBB_COMMUNITYCURRENCIES_EXTENSION'], '<a href="http://github.com/marttiphpbb/phpbb-ext-communitycurrencies">', '</a>'),
			]);
		}
	}

	public function core_viewonline_overwrite_location(event $event)
	{
		if (strrpos($event['row']['session_page'], 'app.' . $this->php_ext . '/transactions') === 0)
		{
			$event['location'] = $this->user->lang('CC_VIEWING_TRANSACTIONS');
			$event['location_url'] = $this->helper->route('marttiphpbb_cc_transactionlist_controller');
		}
	}
}
