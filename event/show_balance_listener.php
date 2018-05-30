<?php
/**
* phpBB Extension - marttiphpbb Community Currencies
* @copyright (c) 2015 - 2018 marttiphpbb <info@martti.be>
* @license GNU General Public License, version 2 (GPL-2.0)
*/

namespace marttiphpbb\communitycurrencies\event;

use phpbb\auth\auth;
use phpbb\config\db as config;
use phpbb\controller\helper;
use phpbb\template\twig\twig as template;
use phpbb\user;

use marttiphpbb\communitycurrencies\datatransformer\currency_transformer;

/**
* @ignore
*/
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

/**
* Event listener
*/
class show_balance_listener implements EventSubscriberInterface
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

	/**
	* @param auth				$auth
	* @param config				$config
	* @param helper				$helper
	* @param string				$php_ext
	* @param template			$template
	* @param user				$user
	* @param currency_transformer				$currency_transformer
	*/
	public function __construct(
			auth $auth,
			config $config,
			helper $helper,
			$php_ext,
			template $template,
			user $user,
			currency_transformer $currency_transformer
		)
	{
		$this->auth = $auth;
		$this->config = $config;
		$this->helper = $helper;
		$this->php_ext = $php_ext;
		$this->template = $template;
		$this->user = $user;
		$this->currency_transformer = $currency_transformer;
	}

	static public function getSubscribedEvents()
	{
		return array(
			'core.memberlist_view_profile'			=> 'core_memberlist_view_profile',
			'core.viewtopic_cache_user_data'		=> 'core_viewtopic_cache_user_data',
			'core.viewtopic_modify_post_row'		=> 'core_viewtopic_modify_post_row',
		);
	}

	public function core_memberlist_view_profile($event)
	{
		if (!$this->auth->acl_get('u_cc_viewtransactions'))
		{
			return;
		}

		$member = $event['member'];

		$amount = $this->currency_transformer->transform($member['user_cc_balance']);

		$this->template->assign_vars(array(
			'CC_USER_TRANSACTION_COUNT'	=> $member['user_cc_transaction_count'],
			'U_CC_USER_TRANSACTIONS' 	=> ($this->auth->acl_get('u_cc_viewtransactions')) ? $this->helper->route('marttiphpbb_cc_transactionlist_controller', array('user_id' => $member['user_id'])) : '',
			'CC_USER_AMOUNT_CURRENCY'	=> $this->user->lang('CC_AMOUNT_CURRENCY', $amount['local']),
		));
	}

	public function core_viewtopic_cache_user_data($event)
	{
		$row = $event['row'];
		$user_cache_data = $event['user_cache_data'];
		$poster_id = $event['poster_id'];

		$amount = $this->currency_transformer->transform($row['user_cc_balance']);

		$user_cache_data['cc_user_amount_currency'] =  $this->user->lang('CC_AMOUNT_CURRENCY', $amount['local']);
		$user_cache_data['cc_user_transaction_search'] = ($this->auth->acl_get('u_cc_viewtransactions')) ? $this->helper->route('marttiphpbb_cc_transactionlist_controller', array('user_id' => $poster_id)) : '';

		$event['user_cache_data'] = $user_cache_data;
	}

	public function core_viewtopic_modify_post_row($event)
	{
		$user_poster_data = $event['user_poster_data'];
		$post_row = $event['post_row'];

		$post_row['CC_USER_AMOUNT_CURRENCY'] = $user_poster_data['cc_user_amount_currency'];
		$post_row['U_CC_USER_TRANSACTIONS'] = $user_poster_data['cc_user_transaction_search'];

		$event['post_row'] = $post_row;
	}
}
