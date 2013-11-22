<?php

class ExampleTest extends TestCase {

	/**
	 * A basic functional test example.
	 *
	 * @return void
	 */
	public function testBasicExample()
	{
		$crawler = $this->client->request('GET', '/');

		$this->assertTrue($this->client->getResponse()->isOk());

		$this->assertCount(1, $crawler->filter('h1:contains("Hello World!")'));
	}

	public function testUserCreateViewMake()
    {
        // Our first test!
        $this->call('get', URL::action('UserController@create'));
	}

}