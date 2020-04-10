<?php
/**
* phpBB Extension - marttiphpbb Community Currencies
* @copyright (c) 2015 - 2020 marttiphpbb <info@martti.be>
* @license GNU General Public License, version 2 (GPL-2.0)
*/

namespace marttiphpbb\communitycurrencies\migrations;

use phpbb\db\migration\migration;
use marttiphpbb\communitycurrencies\util\cnst;

class mgr_6_permissions extends migration
{
	static public function depends_on()
	{
		return [
			'\marttiphpbb\communitycurrencies\migrations\mgr_5_permissions',
		];
	}

	public function update_data()
	{
		return [
			['permission.add', ['u_cc_viewtransactions']],
			['permission.add', ['u_cc_createtransactions']],
			['permission.add', ['m_cc_createtransactions']],
		];
	}
}
