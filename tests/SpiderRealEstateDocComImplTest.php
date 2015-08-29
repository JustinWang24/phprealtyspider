<?php
use justinwang24\phprealtyspider\SpiderRealEstateDotComImpl;
use Sunra\PhpSimple\HtmlDomParser as HtmlDomParser;

class SpiderRealEstateDotComImplTest extends PHPUnit_Framework_TestCase{
	/*
		创建基境 Fixture
	*/
	protected $spider;

	/*
		测试环境的初始化
	*/
	protected function setUp(){
		$this->spider = new SpiderRealEstateDotComImpl;
	}

	/*
		清理工作
	*/
	protected function tearDown(){
		$this->spider = null;
	}

	public function testInit()
	{
	    $expectation = 'http://www.realestage.com.au';
	    $this->spider->init();
	    $this->assertEquals(
	    	$expectation,
	    	$this->spider->propertyUrl
	    );
	    $this->assertNotNull(
	    	$this->spider->dom
	    );
	}

	public function testParseProperty()
	{
	    $expectation = 'OK';
	    $this->assertEquals(
	    	$expectation,
	    	$this->spider->parseProperty()
	    );
	}

	public function testParsePropertyId()
	{
	    $expectation = 'OK';
	    $this->assertEquals(
	    	$expectation,
	    	$this->spider->parsePropertyId()
	    );
	}

	public function testParsePropertyAddress()
	{
	    $expectation = 'OK';
	    $this->assertEquals(
	    	$expectation,
	    	$this->spider->parsePropertyAddress()
	    );
	}

	public function testParsePropertySuburb()
	{
	    $expectation = 'OK';
	    $this->assertEquals(
	    	$expectation,
	    	$this->spider->parsePropertySuburb()
	    );
	}

	public function testParsePropertyState()
	{
	    $expectation = 'OK';
	    $this->assertEquals(
	    	$expectation,
	    	$this->spider->parsePropertyState()
	    );
	}

	public function testParsePropertyCountry()
	{
	    $expectation = 'OK';
	    $this->assertEquals(
	    	$expectation,
	    	$this->spider->parsePropertyCountry()
	    );
	}
}