<?php
/**
* @package phpBB Extension - marttiphpbb community currency
* @copyright (c) 2014 marttiphpbb <info@martti.be>
* @license http://opensource.org/licenses/MIT
*/

namespace marttiphpbb\ccurrency\util;

// uuid v4 - only validates to lower case hex
class uuid_validator
{

    public function __construct()
    {
    }

	
	/**
	 * @param string $uuid
	 * @return boolean
	 */
    public function validate($uuid)
    {
		return preg_match( '/^[0-9a-f]{8}-[0-9a-f]{4}-4[0-9a-f]{3}-[89ab][0-9a-f]{3}-[0-9a-f]{12}$/', $uuid);
    } 
}
