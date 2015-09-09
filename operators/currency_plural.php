<?php

/**
* phpBB Extension - marttiphpbb community currency
* @copyright (c) 2015 marttiphpbb <info@martti.be>
* @license GNU General Public License, version 2 (GPL-2.0)
*/

namespace marttiphpbb\ccurrency\operators;

use phpbb\cache\service as cache;
use phpbb\config\db as config;
use phpbb\config\db_text as config_text;
use phpbb\content_visibility;
use phpbb\db\driver\factory as db;
use phpbb\user;

class currency_plural
{

	protected $cache;
	protected $config;
	protected $config_text;
	protected $db;
	protected $user;
	protected $lang_table;

	/* @var array */
	protected $local_cache;

   /**
   * @param cache $cache
   * @param config   $config
   * @param config_text   $config_text
   * @param db   $db
   * @param user   $user
   */

   public function __construct(
		cache $cache,
		config $config,
		config_text $config_text,
		db $db,
		user $user
	)
	{
		$this->cache = $cache;
		$this->config = $config;
		$this->config_text = $config_text;
		$this->db = $db;
		$this->user = $user;
		$this->lang_table = LANG_TABLE;   // no parameter in core is defined for this table;
   }

	/**
	* @param string $username
	* @return array
	*/
	public function get_languages()
	{
		$sql_ary = array(
			'SELECT'	=> 'l.lang_id, l.lang_iso, l.lang_dir, l.lang_local_name',
			'FROM'		=> array(
				$this->lang_table => 'l',
			),
			'SORT BY'		=> 'l.lang_iso, ASC',

		);

		$sql = $this->db->sql_build_query('SELECT', $sql_ary);
		$result = $this->db->sql_query($sql);
		$lang_ary = $this->db->sql_fetchrowset($result);
		$this->db->sql_freeresult($result);
		return $lang_ary;
	}

	/**
	 * @return array
	 */
	public function get_all()
	{
		if ($this->local_cache)
		{
			return $this->local_cache;
		}
		
		if ($this->cache->_exists('ccurrency_plural'))
		{
			return $this->local_cache = $this->cache->get('ccurrency_plural');
		}

		$ary = unserialize($this->config_text->get('marttiphpbb_ccurrency_plural_forms'));
		$this->local_cache = $ary;
		$this->cache->put('ccurrency_plural', $ary);
		return $ary;
	}

	/**
	 * @return array
	 */
	public function get()
	{
		return $this->get_all()[$this->user->lang_dir];
	}

	/**
	 * @param array
	 * @return currency_plural
	 */
	public function set($ary)
	{
		$this->config_text->set('marttiphpbb_ccurrency_plural_forms', serialize($ary));
		$this->cache->put('ccurrency_plural', $ary);
		return $this;
	}

	
}
