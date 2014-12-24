<?php

/**
* @package phpBB Extension - marttiphpbb community currency
* @copyright (c) 2014 marttiphpbb <info@martti.be>
* @license http://opensource.org/licenses/MIT
*/

namespace marttiphpbb\ccurrency\operators;

use phpbb\cache\service as cache;
use phpbb\config\db as config;
use phpbb\content_visibility;
use phpbb\db\driver\factory as db;
use phpbb\user;


class currency_plural
{

	protected $cache;
	protected $config;
	protected $db;
	protected $user;
	protected $cc_currency_plural_table;
	protected $lang_table;


   /**
   * @param cache $cache
   * @param config   $config
   * @param db   $db  
   * @param user   $user   
   * @param string $cc_currency_plural_table 
   */
   
   public function __construct(
		cache $cache, 
		config $config,
		db $db,
		user $user, 
		$cc_currency_plural_table
	)
	{
		$this->cache = $cache;
		$this->config = $config;
		$this->db = $db;
		$this->user = $user;
		$this->cc_currency_plural_table = $cc_currency_plural_table;
		$this->lang_table = LANG_TABLE;   // no parameter in core is defined for this table;
   }

	/**
	* @param string $username
	* @return array
	*/
	public function get_languages()
	{
		$sql_ary = array(
			'SELECT'	=> 'l.lang_id, l.lang_iso, l.lang_local_name',
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
	public function get_all_currency_plural()
	{
		$sl_ary = array(
			'SELECT'	=> 'cp.*',
			'FROM'		=> array(
				$this->cc_currency_plural_table => 'cp',
			),
			'SORT BY'	=> 'cp.lang_iso, ASC',
		);
		
		$sql = $this->db->sql_build_query('SELECT', $sql_ary);
		$result = $this->db->sql_query($sql);
		$currency_plural_ary = $this->db->sql_fetchrowset($result);
		$this->db->sql_freeresult($result);
		return $currency_plural_ary;	
	}
	
	
	
}
