<?php

/**
* phpBB Extension - marttiphpbb Community Currencies
* @copyright (c) 2015 - 2020 marttiphpbb <info@martti.be>
* @license GNU General Public License, version 2 (GPL-2.0)
*/

namespace marttiphpbb\communitycurrencies\exception;

use phpbb\user;

class out_of_bounds extends base
{
	public function get_message(user $user)
	{
		return $this->translate_portions($user, $this->message_full, 'EXCEPTION_OUT_OF_BOUNDS');
	}
}
