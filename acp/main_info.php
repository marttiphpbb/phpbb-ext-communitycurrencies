<?php
/**
* @package phpBB Extension - marttiphpbb community currency
* @copyright (c) 2014 marttiphpbb <info@martti.be>
* @license http://opensource.org/licenses/MIT
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
				'links'	=> array(
					'title' => 'ACP_CC_LINKS', 
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
