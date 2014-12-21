<?php

/**
* @package phpBB Extension - marttiphpbb community currency
* @copyright (c) 2014 marttiphpbb <info@martti.be>
* @license http://opensource.org/licenses/MIT
*/

namespace marttiphpbb\ccurrency\datatransformer;

use phpbb\config\db as config;

class currency_transformer
{

    private $config;
    private $is_time_banking;

    /**
     * @param config $config
     */
    public function __construct($config)
    {
        $this->config = $config;
        $this->is_time_banking = ($this->config['cc_currency_rate'] && $this->config['cc_currency_rate'] > 0) ? false : true;
    }

    /**
     * Transforms internal amount (seconds) to hours, minutes and local currency.
     *
     * @param  integer|null $seconds
     * @return array
     */
    public function transform($amount)
    {
		$minutes = round($amount / 60);
		$hours = floor($minutes / 60);
		$minutes = $minutes - ($hours * 60);
		
		return array(
			'hours'		=> $hours,
			'minutes' 	=> $minutes,
			'local' 	=> ($this->is_time_banking) ? 0 : round($amount / $this->config['cc_currency_rate']),
		);
    }

    /**
     * Transforms local currency or time (hours + minutes) to internal amount (seconds).
     *
     * @param  integer $hours
     * @param  integer $minutes
     * @param  integer $local
     * @return integer 
     */
    public function reverse_transform($hours = 0, $minutes = 0, $local = 0)
    {
		return ($this->is_time_banking) ? ($hours * 3600) + ($minutes * 60) : $amount * $this->config['cc_currency_rate'];
    }
    
    /*
     * @return bool
     */
    public function is_time_banking()
    {
		return $this->is_time_banking;
	}
}