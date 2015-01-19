<?php
/**
* phpBB Extension - marttiphpbb community currency
* @copyright (c) 2014 marttiphpbb <info@martti.be>
* @license GNU General Public License, version 2 (GPL-2.0)
*/

namespace marttiphpbb\ccurrency\acp;

class main_info
{
	function module()
	{
		return array(
			'filename'	=> '\marttiphpbb\ccurrency\acp\main_module',
			'title'		=> 'ACP_CCURRENCY',
			'modes'		=> array(
				'rendering'	=> array(
					'title' => 'ACP_CC_RENDERING', 
					'auth' => 'ext_marttiphpbb/ccurrency && acl_a_board', 
					'cat' => array('ACP_CCURRENCY'),
				),			
				'currency'	=> array(
					'title' => 'ACP_CC_CURRENCY', 
					'auth' => 'ext_marttiphpbb/ccurrency && acl_a_board', 
					'cat' => array('ACP_CCURRENCY'),
				),
			),
		);
	}
}
