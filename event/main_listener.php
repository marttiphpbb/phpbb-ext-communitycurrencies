<?php
/**
* @package phpBB Extension - marttiphpbb community currency
* @copyright (c) 2014 marttiphpbb <info@martti.be>
* @license http://opensource.org/licenses/MIT
*/

namespace marttiphpbb\ccurrency\event;

use phpbb\auth\auth;
use phpbb\config\db as config;
use phpbb\controller\helper;
use phpbb\template\twig\twig as template;
use phpbb\user;

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
	
	/**
	* @param auth				$auth
	* @param config				$config
	* @param helper				$helper	
	* @param string				$php_ext	
	* @param template			$template
	* @param user				$user
	*/
	public function __construct(
			auth $auth,
			config $config,
			helper $helper, 
			$php_ext,
			template $template,
			user $user
		)
	{
		$this->auth = $auth;
		$this->config = $config;
		$this->helper = $helper;
		$this->php_ext = $php_ext;
		$this->template = $template;
		$this->user = $user;
	}	
	

	static public function getSubscribedEvents()
	{
		return array(
			'core.user_setup'						=> 'core_user_setup',
			'core.page_footer'						=> 'core_page_footer',
			'core.viewonline_overwrite_location'	=> 'add_viewonline',
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
	
	public function core_page_footer($event)
	{
		$this->template->assign_vars(array(
			'U_CC_TRANSACTIONS'				=> $this->helper->route('marttiphpbb_cc_transactionlist_controller'),
			'S_CC_TRANSACTIONS_MENU_QUICK'	=> $this->config['cc_transactions_menu_quick'] && $this->auth->acl_get('u_cc_viewtransactions'),
			'S_CC_TRANSACTIONS_MENU_HEADER'	=> $this->config['cc_transactions_menu_header'] && $this->auth->acl_get('u_cc_viewtransactions'),
			'S_CC_TRANSACTIONS_MENU_FOOTER'	=> $this->config['cc_transactions_menu_footer'] && $this->auth->acl_get('u_cc_viewtransactions'), 
			'S_CC_HIDE_GITHUB_LINK'			=> $this->config['cc_hide_github_link'],
			'CC_CURRENCY_NAME'				=> $this->config['cc_currency_name'],
		));
	}
	
	public function add_viewonline($event)
	{
		if (strrpos($event['row']['session_page'], 'app.' . $this->php_ext . '/transactions') === 0)
		{
			$event['location'] = $this->user->lang('CC_VIEWING_TRANSACTIONS');
			$event['location_url'] = $this->helper->route('marttiphpbb_cc_transactionlist_controller');
		}		
	}	
}
