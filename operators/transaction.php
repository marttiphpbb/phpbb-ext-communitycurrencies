<?php

/**
* phpBB Extension - marttiphpbb Community Currencies
* @copyright (c) 2015 - 2020 marttiphpbb <info@martti.be>
* @license GNU General Public License, version 2 (GPL-2.0)
*/

namespace marttiphpbb\communitycurrencies\operators;

use phpbb\cache\service as cache;
use phpbb\config\db as config;
use phpbb\content_visibility;
use phpbb\db\driver\factory as db;
use phpbb\user;
use phpbb\controller\helper;

use marttiphpbb\communitycurrencies\util\uuid_generator;
use marttiphpbb\communitycurrencies\util\uuid_validator;

class transaction
{
	protected $cache;
	protected $config;
	protected $content_visibility;
	protected $db;
	protected $user;
	protected $helper;
	protected $cc_transactions_table;
	protected $topics_table;
	protected $users_table;
	protected $is_time_banking;

   	public function __construct(
		cache $cache,
		config $config,
		content_visibility $content_visibility,
		db $db,
		user $user,
		helper $helper,
		string $cc_transactions_table,
		string $topics_table,
		string $users_table
	)
	{
		$this->cache = $cache;
		$this->config = $config;
		$this->content_visibility = $content_visibility;
		$this->db = $db;
		$this->user = $user;
		$this->helper = $helper;
		$this->cc_transactions_table = $cc_transactions_table;
		$this->topics_table = $topics_table;
		$this->users_table = $users_table;

		$this->is_time_banking = ($this->config['cc_currency_rate'] > 0) ? false : true;
   	}

	/**
	* @param string $username
	* @return array
	*/
	public function get_user_by_username(string $username)
	{
		$sql_ary = [
			'SELECT'	=> 'u.user_id, u.username, u.user_colour',
			'FROM'		=> [
				$this->users_table => 'u',
			],
			'WHERE'		=> 'u.username = \'' . $this->db->sql_escape($username) . '\'',

		];

		$sql = $this->db->sql_build_query('SELECT', $sql_ary);
		$result = $this->db->sql_query($sql);
		$user_ary = $this->db->sql_fetchrow($result);
		$this->db->sql_freeresult($result);
		return $user_ary;
	}

	public function transaction_unique_id_exists(string $unique_id):array
	{
		$sql_ary = [
			'SELECT'	=> 'tr.unique_id',
			'FROM'		=> [
				$this->cc_transactions_table => 'tr',
			],
			'WHERE'		=> 'tr.unique_id = \'' . $this->db->sql_escape($unique_id) . '\'',
		];

		$sql = $this->db->sql_build_query('SELECT', $sql_ary);
		$result = $this->db->sql_query($sql);

		return $this->db->sql_fetchfield('unique_id') == $unique_id ? true : false;
	}

	public function insert_transaction(
		string $unique_id,
		int $from_user_id,
		int $to_user_id,
		int $amount,
		string $description
	)
	{
		$now = time();

		$sql_ary = [
			'unique_id'			=> $unique_id,
			'from_user_id'		=> $from_user_id,
			'to_user_id'		=> $to_user_id,
			'description'		=> $description,
			'amount'			=> $amount,
			'confirmed_at'		=> $now,
			'created_by'		=> $from_user_ary['user_id'],
			'created_at'		=> $now,
		];

		$this->db->sql_transaction('begin');

		$r = $this->db->sql_query('INSERT INTO ' . $this->cc_transactions_table . ' ' . $this->db->sql_build_array('INSERT', $sql_ary));

		$sql = 'UPDATE ' . $this->users_table . '
			SET user_cc_balance = user_cc_balance - ' . $amount . ',
			user_cc_transaction_count = user_cc_transaction_count + 1
			WHERE user_id = ' . $from_user_id;
		$this->db->sql_query($sql);

		$sql = 'UPDATE ' . $this->users_table . '
			SET user_cc_balance = user_cc_balance + ' . $amount . '
			WHERE user_id = ' . $to_user_id;
		$this->db->sql_query($sql);

		$this->config->increment('cc_transaction_count', 1);

		$this->db->sql_transaction('commit');

		if ($r)
		{
			return $this->db->sql_nextid();
		}

		return false;
	}

	public function get_transaction_count(string $search_query):int
	{
		$sql_where = 'tr.parent_id IS NULL';

		if ($search_query)
		{
			$sql_where .= ' AND tr.description ' . $this->db->sql_like_expression(str_replace('*', $this->db->get_any_char(), utf8_clean_string($search_query)));
		}

		$sql_ary = [
			'SELECT' => 'count(*) as num',
			'FROM' => [
				$this->cc_transactions_table => 'tr',
			],
			'WHERE' => $sql_where,
		];
		$sql = $this->db->sql_build_query('SELECT', $sql_ary);
		$result = $this->db->sql_query($sql);
		$transaction_count = $this->db->sql_fetchfield('num');
		$this->db->sql_freeresult($result);

		return $transaction_count;
	}

	public function get_transactions(
		string $search_query = '',
		string $sort_by = 'created_at',
		string $sort_dir = 'desc',
		int $start = 0,
		int $limit = 25
	):array
	{
		$sort_map = [
			'from_username' => 'uf.username',
			'to_username'	=> 'ut.username',
			'description'	=> 'tr.description',
			'amount'		=> 'tr.amount',
			'created_at'	=> 'tr.created_at',
		];

		$sql_where = 'tr.parent_id IS NULL';

		if ($search_query)
		{
			$sql_where .= ' AND tr.description ' . $this->db->sql_like_expression(str_replace('*', $this->db->get_any_char(), utf8_clean_string($search_query)));
		}

		$sql = 'SELECT tr.*,
				uf.username as from_username, uf.user_colour as from_user_colour,
				ut.username as to_username, ut.user_colour as to_user_colour
			FROM ' . $this->cc_transactions_table . ' tr,
				' . $this->users_table . ' uf,
				' . $this->users_table . ' ut
			WHERE ' . $sql_where . '
				AND uf.user_id = tr.from_user_id
				AND ut.user_id = tr.to_user_id
			ORDER BY ' . $sort_map[$sort_by] . ' ' . (($sort_dir == 'desc') ? 'DESC' : 'ASC');

		$result = $this->db->sql_query_limit($sql, $limit, $start);
		$transactions = $this->db->sql_fetchrowset($result);
		$this->db->sql_freeresult($result);
		return $transactions;
	}

	/**
	 * @param int $id
	 * @return array
	*/
	public function get_transaction(int $id):array
	{
		$sql = 'SELECT tr.*,
				uf.username as from_username, uf.user_colour as from_user_colour,
				ut.username as to_username, ut.user_colour as to_user_colour
			FROM ' . $this->cc_transactions_table . ' tr,
				' . $this->users_table . ' uf,
				' . $this->users_table . ' ut
			WHERE tr.id = ' . $id . '
				AND uf.user_id = tr.from_user_id
				AND ut.user_id = tr.to_user_id';
		$result = $this->db->sql_query($sql);
		$row = $this->db->sql_fetchrow($result);
		$this->db->sql_freeresult($result);
		return $row;
	}

	public function get_child_transaction_count(int $id):int
	{
		$sql_ary = [
			'SELECT' => 'count(*) as num',
			'FROM' => [
				$this->cc_transactions_table => 'tr',
			],
			'WHERE' => 'tr.parent_id = ' . $id,
		];
		$sql = $this->db->sql_build_query('SELECT', $sql_ary);
		$result = $this->db->sql_query($sql);
		$transaction_count = $this->db->sql_fetchfield('num');
		$this->db->sql_freeresult($result);
		return $transaction_count;
	}
}
