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
	    $expectation = '18 Craig Avenue';
	    $this->assertEquals(
	    	$expectation,
	    	$this->spider->parsePropertyAddress()
	    );
	}

	public function testParsePropertySuburb()
	{
	    $expectation = 'Ferntree Gully';
	    $this->assertEquals(
	    	$expectation,
	    	$this->spider->parsePropertySuburb()
	    );
	}

	public function testParsePropertyState()
	{
	    $expectation = 'VIC';
	    $this->assertEquals(
	    	$expectation,
	    	$this->spider->parsePropertyState()
	    );
	}

	public function testParsePropertyCountry()
	{
	    $expectation = 'AU';
	    $this->assertEquals(
	    	$expectation,
	    	$this->spider->parsePropertyCountry()
	    );
	}

	public function testParsePropertyPostcode()
	{
	    $expectation = '3156';
	    $this->assertEquals(
	    	$expectation,
	    	$this->spider->parsePropertyPostcode()
	    );
	}

	public function testParsePropertySlogon()
	{
	    $expectation = 'Double The Appeal - An Investors Dream!';
	    $this->assertEquals(
	    	$expectation,
	    	$this->spider->parsePropertySlogon()
	    );
	}

	public function testParsePropertyDescription()
	{
	    $expectation = 'Offering exceptional value for the quick-acting investor (current return $2,513 per calendar month), this \'two-for-one\' property enjoys double the rental income with two exceptionally well-maintained dwellings each offering secure tenancies already in place eliminating any immediate, non-income periods between tenants.<br><br>Set upon a substantial allotment of 1035sqm (approx.), the primary residence features a naturally-light split-level layout comprising a spacious living area featuring polished floorboards, an elevated family zone plus a well-appointed kitchen and three bedrooms serviced by the spotless full ensuite and modern family bathroom.<br><br>Placed to the rear, the self-contained bungalow (separately metered for gas, electricity and water) is also appealing with an open plan lounge and chic kitchenette, polished floorboards, a modern bathroom and huge, robed bedroom.<br><br>Perfectly located close to a choice of shopping precincts (Mountain Gate, Boronia and Westfield Knox), bus transport, quality schools, parklands and walking trails, and, with a high walkability aspect to Ferntree Gully Village with cafes and rail station, as well as easy proximity to freeways;<span data-description=" secure dual rental opportunities such as this one are a rare, and rewarding, investment find. Call to register your interest today!">...</span><a href="#" rel="revealDescription" class="more interesting hidden">show more</a>';
	    $this->assertEquals(
	    	$expectation,
	    	$this->spider->parsePropertyDescription()
	    );
	}
}