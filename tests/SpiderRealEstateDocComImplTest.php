<?php
use justinwang24\phprealtyspider\SpiderRealEstateDotComImpl;
use Sunra\PhpSimple\HtmlDomParser as HtmlDomParser;

class SpiderRealEstateDotComImplTest extends PHPUnit_Framework_TestCase{
	/*
		创建基境 Fixture
	*/
	protected $spider;
	protected $url;

	/*
		测试环境的初始化
	*/
	protected function setUp(){
		$this->spider = new SpiderRealEstateDotComImpl;
		$this->url = 'http://www.realestate.com.au/property-house-vic-ferntree+gully-120340141';
		$this->spider->init($this->url);
	}

	/*
		清理工作
	*/
	protected function tearDown(){
		$this->spider = null;
	}

	public function testInit()
	{	    
	    $this->assertEquals(
	    	$this->url,
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
	    $expectation = '120340141';
	    $this->assertEquals(
	    	$expectation,
	    	$this->spider->parsePropertyId()
	    );
	}

	public function testParsePropertyIdFailed()
	{
	    $this->spider->propertyUrl = 'sdfdas';
	    $this->assertNull(
	    	$this->spider->parsePropertyId()
	    );
	    //检查是否 id 解析后不是全数字也返回 null
	    $this->spider->propertyUrl = 'sdfdas-a1';
	    $this->assertNull(
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