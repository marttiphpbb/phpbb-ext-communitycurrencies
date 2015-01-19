<?php
/**
* phpBB Extension - marttiphpbb ccurrency
* @copyright (c) 2014 marttiphpbb <info@martti.be>
* @license GNU General Public License, version 2 (GPL-2.0)
*/

namespace marttiphpbb\ccurrency\tests\functional;

/**
* @group functional
*/
class ccurrency_test extends \phpbb_functional_test_case
{
	static protected function setup_extensions()
	{
		return array('marttiphpbb/ccurrency');
	}

	public function test_demo_acme()
	{
		$crawler = self::request('GET', 'app.php/demo/acme');
		$this->assertContains('acme', $crawler->filter('h2')->text());

		$this->add_lang_ext('marttiphpbb/ccurrency', 'common');
		$this->assertContains($this->lang('DEMO_HELLO', 'marttiphpbb'), $crawler->filter('h2')->text());
		$this->assertNotContains($this->lang('DEMO_GOODBYE', 'marttiphpbb'), $crawler->filter('h2')->text());

		$this->assertNotContainsLang('ACP_DEMO', $crawler->filter('h2')->text());
	}

	public function test_demo_world()
	{
		$crawler = self::request('GET', 'app.php/demo/world');
		$this->assertNotContains('acme', $crawler->filter('h2')->text());
		$this->assertContains('world', $crawler->filter('h2')->text());
	}
}
