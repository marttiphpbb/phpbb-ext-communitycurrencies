<?php
/**
* phpBB Extension - marttiphpbb community currency
* @copyright (c) 2014 marttiphpbb <info@martti.be>
* @license GNU General Public License, version 2 (GPL-2.0)
*/

namespace marttiphpbb\ccurrency\entity;

use phpbb\db\driver\factory as db;
use marttiphp\util\uuid_generator;

class transaction
{
	/* @var array
			transaction_id
			transaction_uuid
			transaction_from_user_id
			transaction_to_user_id
			transaction_description
			transaction_amount
			transaction_created_at
			transaction_confirmed
			transaction_confirmed_at
			transaction_created_by
	 */
	protected $data;

	/* @var db */
	protected $db;

	/* @var string */
	protected $cc_transactions_table;

   /**
   * @param db   $db
   * @param string $cc_transactions_table
   */

   public function __construct(
		db $db,
		uuid_generator $uuid_generator,
		$cc_transactions_table,
	)
	{
		$this->db = $db;
		$this->cc_transactions_table = $cc_transactions_table;

		$this->data['transaction_uuid'] = $uuid_generator->generate();
	}

}
