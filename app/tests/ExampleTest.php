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
		$text=trans('pages.helloworld');
		$this->assertCount(1, $crawler->filter("h1:contains($text)"));
	}

}