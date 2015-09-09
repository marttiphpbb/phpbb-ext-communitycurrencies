<?php
/**
* phpBB Extension - marttiphpbb community currency
* @copyright (c) 2015 marttiphpbb <info@martti.be>
* @license GNU General Public License, version 2 (GPL-2.0)
*/

namespace marttiphpbb\ccurrency\event;

use phpbb\auth\auth;
use phpbb\config\db as config;
use phpbb\controller\helper;
use phpbb\template\twig\twig as template;
use phpbb\user;

use marttiphpbb\ccurrency\datatransformer\currency_transformer;
use marttiphpbb\ccurrency\model\links;

/**
* @ignore
*/
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

/**
* Event listener
*/
class main_listener implements EventSubscriberInterface
{

	/* @var auth */
	protected $auth;

	/* @var config */
	protected $config;

	/* @var helper */
	protected $helper;

	/* @var string */
	protected $php_ext;

	/* @var template */
	protected $template;

	/* @var user */
	protected $user;

	/* @var currency_transformer */
	protected $currency_transformer;

	/* @var links */
	protected $links;

	/**
	* @param auth				$auth
	* @param config				$config
	* @param helper				$helper
	* @param string				$php_ext
	* @param template			$template
	* @param user				$user
	* @param currency_transformer				$currency_transformer
	* @param links				$links
	*/
	public function __construct(
			auth $auth,
			config $config,
			helper $helper,
			$php_ext,
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
		return array(
			'core.user_setup'						=> 'core_user_setup',
			'core.page_header'						=> 'core_page_header',
			'core.viewonline_overwrite_location'	=> 'core_viewonline_overwrite_location',
		);
	}

	public function core_user_setup($event)
	{
		$lang_set_ext = $event['lang_set_ext'];

		$lang_set_ext[] = array(
			'ext_name' => 'marttiphpbb/ccurrency',
			'lang_set' => 'common',
		);
		$event['lang_set_ext'] = $lang_set_ext;
	}

	public function core_page_header($event)
	{
		if (true || $this->auth->acl_get('u_cc_viewtransactions'))
		{
			$this->links->assign_template_vars();
			$this->template->assign_vars(array(
				'U_CCURRENCY_TRANSACTIONS'		=> $this->helper->route('marttiphpbb_cc_transactionlist_controller'),
				'CCURRENCY_REPO_LINK'			=> sprintf($this->user->lang['CCURRENCY_EXTENSION'], '<a href="http://github.com/marttiphpbb/phpbb-ext-ccurrency">', '</a>'),
			));
		}
	}

	public function core_viewonline_overwrite_location($event)
	{
		if (strrpos($event['row']['session_page'], 'app.' . $this->php_ext . '/transactions') === 0)
		{
			$event['location'] = $this->user->lang('CC_VIEWING_TRANSACTIONS');
			$event['location_url'] = $this->helper->route('marttiphpbb_cc_transactionlist_controller');
		}
	}
}
