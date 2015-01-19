<?php

/**
* phpBB Extension - marttiphpbb community currency
* @copyright (c) 2014 marttiphpbb <info@martti.be>
* @license GNU General Public License, version 2 (GPL-2.0)
*/

namespace marttiphpbb\ccurrency\exception;

use phpbb\user;

class out_of_bounds extends base
{
	/**
	* @param user $user
	* @return string
	* @access public
	*/
	public function get_message(user $user)
	{
		return $this->translate_portions($user, $this->message_full, 'EXCEPTION_OUT_OF_BOUNDS');
	}
}
