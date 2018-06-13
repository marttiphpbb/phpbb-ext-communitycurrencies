<?php

/**
* phpBB Extension - marttiphpbb Community Currencies
* @copyright (c) 2015 - 2018 marttiphpbb <info@martti.be>
* @license GNU General Public License, version 2 (GPL-2.0)
*/

namespace marttiphpbb\communitycurrencies\controller;

use phpbb\auth\auth;
use phpbb\cache\service as cache;
use phpbb\config\db as config;
use phpbb\content_visibility;
use phpbb\db\driver\factory as db;
use phpbb\pagination;
use phpbb\request\request;
use phpbb\template\twig\twig as template;
use phpbb\user;
use phpbb\controller\helper;

use Symfony\Component\HttpFoundation\Response;

use marttiphpbb\communitycurrencies\datatransformer\currency_transformer;
use marttiphpbb\communitycurrencies\operators\transaction as transaction_operator;

use marttiphpbb\communitycurrencies\util\uuid_generator;
use marttiphpbb\communitycurrencies\util\uuid_validator;

class transaction
{
	protected $auth;
	protected $cache;
	protected $config;
	protected $content_visibility;
	protected $db;
	protected $pagination;
	protected $php_ext;
	protected $request;
	protected $template;
	protected $user;
	protected $helper;
	protected $currency_transformer;
	protected $transaction_operator;
	protected $root_path;
	protected $cc_transactions_table;
	protected $topics_table;
	protected $users_table;
	protected $is_time_banking;

   /**
   * @param auth $auth
   * @param cache $cache
   * @param config   $config
   * @param content_visibility $content_visibility
   * @param db   $db
   * @param pagination $pagination
   * @param string $php_ext
   * @param request   $request
   * @param template   $template
   * @param user   $user
   * @param helper $helper
   * @param currency_transformer $currency_transformer
   * @param transaction_operator $transaction_operator
   * @param string $root_path
   * @param string $cc_transactions_table
   * @param string $cc_topics_table
   * @param string $cc_users_table
   */

   public function __construct(
		auth $auth,
		cache $cache,
		config $config,
		content_visibility $content_visibility,
		db $db,
		pagination $pagination,
		$php_ext,
		request $request,
		template $template,
		user $user,
		helper $helper,
		currency_transformer $currency_transformer,
		transaction_operator $transaction_operator,
		$root_path,
		$cc_transactions_table,
		$topics_table,
		$users_table
	)
	{
		$this->auth = $auth;
		$this->cache = $cache;
		$this->config = $config;
		$this->content_visibility = $content_visibility;
		$this->db = $db;
		$this->pagination = $pagination;
		$this->php_ext = $php_ext;
		$this->request = $request;
		$this->template = $template;
		$this->user = $user;
		$this->helper = $helper;
		$this->currency_transformer = $currency_transformer;
		$this->transaction_operator = $transaction_operator;
		$this->root_path = $root_path;
		$this->cc_transactions_table = $cc_transactions_table;
		$this->topics_table = $topics_table;
		$this->users_table = $users_table;

		$this->is_time_banking = ($this->config['cc_currency_rate'] > 0) ? false : true;
   }

	/**
	* @param int $page
	* @return Response
	*/
	public function listAction($page = 1)
	{
		if (!$this->auth->acl_get('u_cc_viewtransactions'))
		{
			trigger_error('CC_NO_AUTH_VIEW_TRANSACTIONS');
		}

		add_form_key('new_transaction');
		$error = [];

		$to_user = utf8_normalize_nfc($this->request->variable('to_user', '', true));
		$description = utf8_normalize_nfc($this->request->variable('description', '', true));
		$unique_id = $this->request->variable('unique_id', '');
		$confirm = $this->request->variable('confirm_uid', 0);
		$amount_seconds = $this->request->variable('amount_seconds', 0);
		$hours = $this->request->variable('hours', 0);
		$minutes = $this->request->variable('minutes', 0);
		$amount = $this->request->variable('amount', 0);
		$search_query = $this->request->variable('q', '', true);

		$sort_dir = $this->request->variable('sort_dir', 'desc');
		$sort_by = $this->request->variable('sort_by', 'created_at');

		$limit = $this->request->variable('limit', $this->config['cc_transactions_per_page']);

		if (!$confirm)
		{
			$amount_seconds = ($this->is_time_banking) ? ($hours * 3600) + ($minutes * 60) : $amount * $this->config['cc_currency_rate'];
		}

		if ($this->request->is_set_post('create_transaction'))
		{
			if (!$this->auth->acl_get('u_cc_createtransactions'))
			{
				trigger_error('CC_NO_AUTH_CREATE_TRANSACTION');
			}

			if (!$confirm && !check_form_key('new_transaction'))
			{
				$error[] = $this->user->lang('FORM_INVALID');
			}

			if (empty($error))
			{
				if (utf8_clean_string($to_user) === '')
				{
					$error[] = $this->user->lang['CC_EMPTY_TO_USER'];
				}
				if (utf8_clean_string($description) === '')
				{
					$error[] = $this->user->lang['CC_EMPTY_DESCRIPTION'];
				}
				if ($amount_seconds < 1)
				{
					$error[] = $this->user->lang['CC_AMOUNT_NOT_POSITIVE'];
				}
				if ($to_user == $this->user->data['username'])
				{
					$error[] = $this->user->lang['CC_NO_TRANSACTION_TO_YOURSELF'];
				}
			}

			if (empty($error))
			{
				$to_user_ary = $this->transaction_operator->get_user_by_username($to_user);

				if (!$to_user_ary)
				{
					$error[] = $this->user->lang['CC_USER_NOT_EXISTING'];
				}
			}

			if (empty($error))
			{
				$uuid_validator = new uuid_validator();

				if (!$uuid_validator->validate($unique_id))
				{
					$error[] = $this->user->lang['CC_NO_VALID_UUID'];
				}

				if ($this->transaction_operator->transaction_unique_id_exists($unique_id))
				{
					$error[] = $this->user->lang['CC_TRANSACTION_NOT_UNIQUE'];
				}
			}

			if (empty($error))
			{
				if (confirm_box(true))
				{
					$id = $this->transaction_operator->insert_transaction($unique_id, $this->user->data['user_id'], $to_user_ary['user_id'], $amount_seconds, $description);

					$url_transactions = $this->helper->route('marttiphpbb_cc_transactionlist_controller');

					if ($id)
					{
						$url_transaction = $this->helper->route('marttiphpbb_cc_transactionshow_controller', ['id' => $id]);

						meta_refresh(3, $url_transactions);

						$message = $this->user->lang['CC_TRANSACTION_CREATED'] . '<br /><br />';
						$message .= sprintf($this->user->lang['CC_RETURN_TRANSACTION_LIST'], '<a href="' . $url_transactions . '">', '</a>') . '<br /><br />';
						$message .= sprintf($this->user->lang['CC_RETURN_TRANSACTION'], '<a href="' . $url_transaction . '">', '</a>');

						trigger_error($message);
					}
					else
					{
						trigger_error('CC_TRANSACTION_ERROR');
					}
				}
				else
				{
					$s_hidden_fields = [
						'create_transaction'	=> 1,
						'unique_id'				=> $unique_id,
						'amount_seconds'		=> $amount_seconds,
						'description'			=> $description,
						'to_user'				=> $to_user,
					];

					$to_username_string = get_username_string('no_profile', $to_user_ary['user_id'], $to_user_ary['username'], $to_user_ary['user_colour']);

					$confirm_msg = sprintf($this->user->lang('CC_CONFIRM_TRANSACTION', $amount, $this->config['cc_currency_name'], $to_username_string, $description));

					confirm_box(false, $confirm_msg, build_hidden_fields($s_hidden_fields));
				}
			}

			$this->template->assign_var('S_DISPLAY_NEW_TRANSACTION', true);
		}

		$topic_id = $this->request->variable('n_t', 0);
		$to_user_id = $this->request->variable('n_u', 0);

		// pre-fill fields in new transaction creation form
		if ($topic_id || $to_user_id)
		{
			if (!$this->auth->acl_get('u_cc_createtransactions'))
			{
				trigger_error('CC_NO_AUTH_CREATE_TRANSACTION');
			}

			if ($topic_id)
			{
				$sql = 'SELECT forum_id
					FROM ' . $this->topics_table . '
					WHERE topic_id = ' . $topic_id;
				$forum_id = '';

				$sql = 'SELECT topic_id, topic_title, topic_poster
					FROM ' . $this->topics_table . '
					WHERE topic_id = ' . $topic_id . '
					AND ' . $this->content_visibility->get_visibility_sql('topic', $forum_id);

			}

			$this->template->assign_var('S_DISPLAY_NEW_TRANSACTION', true);
		}

		if ($this->is_time_banking)
		{
			$granularity = $this->config['cc_time_banking_granularity'];

			$minutes = round($amount_seconds / 60);
			$hours = floor($minutes / 60);
			$minutes = $minutes - $hours * 60;

			if ($granularity && $granularity < 1801)
			{
				$minutes_options = '';

				for ($sec = 0; $sec < 3600; $sec = $sec + $granularity)
				{

					$value = round($sec / 60);
					$minutes_options .= '<option value="' . $value . '"';
					$minutes_options .= ($value == $minutes) ? ' selected="selected"' : '';
					$minutes_options .= '>' . str_pad($value, 2, '0', STR_PAD_LEFT) . '</option>';
				}
			}

			$amount = 0;

		}
		else
		{
			$amount = round($amount_seconds / $this->config['cc_currency_rate']);
			$hours = $minutes = 0;
			$minutes_options = [];
		}

		$uuid_generator = new uuid_generator();

		$sort_keys = [
			'from_username',
			'to_username',
			'amount',
			'description',
			'created_at',
		];

		$route = $page == 1 ? '' : 'page';
		$route = 'marttiphpbb_cc_transactionlist' . $route . '_controller';

		foreach ($sort_keys as $sort_key)
		{
			$opposite_dir = ($sort_dir == 'asc') ? 'desc' : 'asc';
			$dir = ($sort_key == $sort_by) ? $opposite_dir : 'asc';

			$sort = strtoupper($sort_key) . '_SORT';
	
			$params = [
				'sort_dir' => $dir,
				'sort_by' => $sort_key,
			];

			if ($page > 1)
			{
				$params['page'] = $page;
			}
	
			if ($search_query)
			{
				$params['q'] = $search_query;
			}

			$this->template->assign_vars([
				'U_' . $sort  => $this->helper->route($route, $params),
				$sort => $sort_key == $sort_by ? strtoupper($sort_dir) : '',
			]);
		}

		$this->template->assign_vars([
			'ERROR'					=> (sizeof($error)) ? implode('<br />', $error) : '',
			'U_ACTION'				=> $this->helper->route('marttiphpbb_cc_transactionlist_controller'),
			'S_AUTH_CREATE_TRANSACTION'	=> $this->auth->acl_get('u_cc_createtransactions'),
			'S_TIME_BANKING'		=> $this->is_time_banking,
			'S_MINUTES_OPTIONS' 	=> $minutes_options,
			'HOURS'					=> $hours,
			'MINUTES'				=> $minutes,
			'AMOUNT'				=> $amount,
			'TO_USER'				=> $to_user,
			'DESCRIPTION'			=> $description,
			'UNIQUE_ID'				=> $uuid_generator->generate(),
			'SEARCH'				=> $search_query,
		]);

		// get transactions

		$transaction_count = ($search_query) ? $this->transaction_operator->get_transaction_count($search_query) : $this->config['cc_transaction_count'];

		$start = ($page - 1) * $limit;

		$params = [];

		if ($sort_by != 'created_at')
		{
			$params['sort_by'] = $sort_by;
		}

		if ($sort_dir != 'desc')
		{
			$params['sort_dir'] = $sort_dir;
		}

		if ($search_query)
		{
			$params['q'] = $search_query;
		}

		$this->pagination->generate_template_pagination(
			[
				'routes' => [
					'marttiphpbb_cc_transactionlist_controller',
					'marttiphpbb_cc_transactionlistpage_controller',
				],
				'params' => $params,
			],
			'pagination',
			'page',
			$transaction_count,
			$limit,
			$start
		);

		$this->template->assign_vars([
			'PAGE_NUMBER'			=> $page,
			'TOTAL_TRANSACTIONS'	=> $this->user->lang('MARTTIPHPBB_COMMUNITYCURRENCIES_TRANSACTION_COUNT', $transaction_count),
		]);

		$transactions = $this->transaction_operator->get_transactions($search_query, $sort_by, $sort_dir, $start, $limit);

		foreach ($transactions as $row)
		{
			$amount = $this->currency_transformer->transform($row['amount']);

			$this->template->assign_block_vars('transactionrow', [
				'FROM_USER_FULL'	=> get_username_string('full', $row['from_user_id'], $row['from_username'], $row['from_user_colour']),
				'FROM_USER_COLOUR'	=> get_username_string('colour', $row['from_user_id'], $row['from_username'], $row['from_user_colour']),
				'FROM_USER'			=> get_username_string('username', $row['from_user_id'], $row['from_username'], $row['from_user_colour']),
				'U_FROM_USER'		=> get_username_string('profile', $row['from_user_id'], $row['from_username'], $row['from_user_colour']),
				'TO_USER_FULL'		=> get_username_string('full', $row['to_user_id'], $row['to_username'], $row['to_user_colour']),
				'TO_USER_COLOUR'	=> get_username_string('colour', $row['to_user_id'], $row['to_username'], $row['to_user_colour']),
				'TO_USER'			=> get_username_string('username', $row['to_user_id'], $row['to_username'], $row['to_user_colour']),
				'U_TO_USER'			=> get_username_string('profile', $row['to_user_id'], $row['to_username'], $row['to_user_colour']),
				'AMOUNT_LOCAL'		=> $amount['local'],
				'AMOUNT_HOURS'		=> $amount['hours'],
				'AMOUNT_MINUTES'	=> $amount['minutes'],
				'AMOUNT'			=> $row['amount'],
				'DESCRIPTION'		=> $row['description'],
				'CREATED_AT'		=> $this->user->format_date($row['created_at']),
				'CREATED_BY'		=> $row['created_by'],
				'CONFIRMED'			=> ($row['confirmed_at']) ? true : false,
				'CONFIRMDED_AT'		=> $this->user->format_date($row['confirmed_at']),
				'U_TRANSACTION'		=> $this->helper->route('marttiphpbb_cc_transactionshow_controller', ['id' => $row['id']]),
				'UNIQUE_ID'			=> $row['unique_id'],
				'CHILD_COUNT'		=> $row['child_count'],
			]);
		}

		make_jumpbox(append_sid($this->root_path . 'viewforum.' . $this->php_ext));
		return $this->helper->render('transactions.html');
	}

	/**
	 * returns one transaction or all transactions from a mass-transaction
	 *
	* @param int $id
	* @param int $page
	* @return Response
	*/
	public function showAction($id, $page = 1)
	{
		if (!$this->auth->acl_get('u_cc_viewtransactions'))
		{
			trigger_error('CC_NO_AUTH_VIEW_TRANSACTIONS');
		}

		$sort_dir = $this->request->variable('sort_dir', 'desc');
		$sort_by = $this->request->variable('sort_by', 'created_at');

		$limit = $this->request->variable('limit', $this->config['cc_transactions_per_page']);

		// get transaction

		$row = $this->transaction_operator->get_transaction($id);

		if (!$row)
		{
			trigger_error('CC_TRANSACTION_NOT_FOUND');
		}

		if (!$row['children_count'])
		{
			// show transaction

			$amount = $this->currency_transformer->transform($row['amount']);

			$this->template->assign_vars([
				'S_TIME_BANKING'		=> $this->is_time_banking,
				'AMOUNT_HOURS'			=> $amount['hours'],
				'AMOUNT_MINUTES'		=> $amount['minutes'],
				'AMOUNT_LOCAL'			=> $amount['local'],
				'TO_USER'				=> $to_user,
				'DESCRIPTION'			=> $description,
			]);

		}

		// the transaction is a mass-transaction

			if ($row['from_user_id'])
			{

			}

		// get transactions

		$start = ($page - 1) * $limit;

		$params = [];

		if ($sort_by != 'created_at')
		{
			$params['sort_by'] = $sort_by;
		}

		if ($sort_dir != 'desc')
		{
			$params['sort_dir'] = $sort_dir;
		}

		$this->pagination->generate_template_pagination([
			'routes' => [
				'marttiphpbb_cc_transactionlist_controller',
				'marttiphpbb_cc_transactionlistpage_controller',
			],
			'params' => $params,
			],
			'pagination',
			'page',
			$transaction_count,
			$limit,
			$start);

		$this->template->assign_vars([
			'PAGE_NUMBER'			=> $page,
			'TOTAL_TRANSACTIONS'	=> $this->user->lang('MARTTIPHPBB_COMMUNITYCURRENCIES_TRANSACTION_COUNT', $transaction_count),
		]);

		$sql_ary = [
			'SELECT'	=> 'tr.*',
			'FROM'		=> [
				$this->cc_transactions_table => 'tr',
			],
			'WHERE'		=> $sql_where,
			'ORDER_BY'	=> 'tr.' . $sort_by . ' ' . (($sort_dir == 'desc') ? 'DESC' : 'ASC'),
			'LIMIT'		=> $limit . ', ' . $start,
		];

		$sql = $this->db->sql_build_query('SELECT', $sql_ary);
		$result = $this->db->sql_query_limit($sql, $limit, $start);

		while ($row = $this->db->sql_fetchrow($result))
		{
			$transaction_list[] = $row;

			$this->template->assign_block_vars('transactionrow', [
				'FROM_USER_FULL'	=> get_username_string('full', $row['from_user_id'], $row['from_username'], $row['from_user_colour']),
				'FROM_USER_COLOUR'	=> get_username_string('colour', $row['from_user_id'], $row['from_username'], $row['from_user_colour']),
				'FROM_USER'			=> get_username_string('username', $row['from_user_id'], $row['from_username'], $row['from_user_colour']),
				'U_FROM_USER'		=> get_username_string('profile', $row['from_user_id'], $row['from_username'], $row['from_user_colour']),
				'TO_USER_FULL'		=> get_username_string('full', $row['to_user_id'], $row['to_username'], $row['to_user_colour']),
				'TO_USER_COLOUR'	=> get_username_string('colour', $row['to_user_id'], $row['to_username'], $row['to_user_colour']),
				'TO_USER'			=> get_username_string('username', $row['to_user_id'], $row['to_username'], $row['to_user_colour']),
				'U_TO_USER'			=> get_username_string('profile', $row['to_user_id'], $row['to_username'], $row['to_user_colour']),
				'AMOUNT'			=> round($row['amount'] / $this->config['cc_currency_rate']),
				'AMOUNT_SECONDS'	=> $row['amount'],
				'DESCRIPTION'		=> $row['description'],
				'CREATED_AT'		=> $this->user->format_date($row['created_at']),
				'CREATED_BY'		=> $row['created_by'],
				'CONFIRMED'			=> ($row['confirmed']) ? true : false,
				'CONFIRMDED_AT'		=> $this->user->format_date($row['confirmed_at']),
				'U_TRANSACTION'		=> $this->helper->route('marttiphpbb_cc_transactionshow_controller', ['id' => $row['id']]),
				'UNIQUE_ID'			=> $row['unique_id'],
			]);
		}
		$this->db->sql_freeresult($result);

		make_jumpbox(append_sid($this->root_path . 'viewforum.' . $this->php_ext));
		return $this->helper->render('transactions.html');
	}
}
