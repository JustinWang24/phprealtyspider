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
		$this->url = 'http://www.realestate.com.au/property-house-vic-hawthorn+east-122858202';
		$this->spider->init($this->url);
	}

	/*
		清理工作
	*/
	protected function tearDown(){
		$this->spider = null;
	}

	public function testIndoors(){
		var_dump( $this->spider->parsePropertyIndoorFeatures() );
	}

	public function testOutdoors(){
		var_dump( $this->spider->parsePropertyOutdoorFeatures() );
	}
/*
	public function testInspection(){
		var_dump($this->spider->parsePropertyAgentAvatar());
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

	public function testParsePropertyAuction()
	{
	    $expectation = '2015-10-31 12:00:00';
	    $this->assertEquals(
	    	$expectation,
	    	$this->spider->parsePropertyAuctionDate()
	    );
	}

	public function testParsePropertyFloorplan()
	{
	    var_dump($this->spider->parsePropertyImages());
	    $expectation = 'floorplan';
	    $this->assertArrayHasKey(
	    	$expectation,
	    	$this->spider->parsePropertyImages()
	    );
	}

	public function testParseProperty()
	{
	    $expectation = 'url';
	    $this->assertArrayHasKey(
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

	public function testParsePropertyMinPrice()
	{
	    $expectation = '$540,000 Plus';
	    $this->assertEquals(
	    	$expectation,
	    	$this->spider->parsePropertyMinPrice()
	    );
	}

	public function testParsePropertyMaxPrice()
	{
	    $expectation = '$540,000 Plus';
	    $this->assertEquals(
	    	$expectation,
	    	$this->spider->parsePropertyMaxPrice()
	    );
	}

	public function testParsePropertyPriceText()
	{
	    $expectation = '$540,000 Plus';
	    $this->assertEquals(
	    	$expectation,
	    	$this->spider->parsePropertyPriceText()
	    );
	}

	public function testParsePropertyBedroomNumber()
	{
	    $expectation = '4';
	    $this->assertEquals(
	    	$expectation,
	    	$this->spider->parsePropertyBedroomNumber()
	    );
	}

	public function testParsePropertyBathroomNumber()
	{
	    $expectation = '3';
	    $this->assertEquals(
	    	$expectation,
	    	$this->spider->parsePropertyBathroomNumber()
	    );
	}

	public function testParsePropertyGarageNumber()
	{
	    $expectation = '$540,000 Plus';
	    $this->assertNull(
	    	$this->spider->parsePropertyGarageNumber()
	    );
	}

	public function testParsePropertyType()
	{
	    $expectation = 'House';
	    $this->assertEquals(
	    	$expectation,
	    	$this->spider->parsePropertyType()
	    );
	}

	public function testParsePropertyLandSize()
	{
	    $expectation = '1035 m² (approx)';
	    $this->assertEquals(
	    	$expectation,
	    	$this->spider->parsePropertyLandSize()
	    );
	}

	public function testParsePropertyStatus()
	{
	    $expectation = 'Under Contract';
	    $this->assertEquals(
	    	$expectation,
	    	$this->spider->parsePropertyStatus()
	    );
	}

	public function testParsePropertyOpenForInspectionSchedule()
	{
	    $expectation = 'No inspections are currently scheduled.';
	    $this->assertEquals(
	    	$expectation,
	    	$this->spider->parsePropertyOpenForInspectionSchedule()
	    );
	}

	public function testParsePropertySalesMethod()
	{
	    $expectation = 'OK';
	    $this->assertEquals(
	    	$expectation,
	    	$this->spider->parsePropertySalesMethod()
	    );
	}

	// public function testParsePropertyImages()
	// {
	//     $expectation = array(
	//     	"http://i1.au.reastatic.net/150x112/f142f555fac1d1012324835fd47cd75ee6f4715677b3003669a62a9c86af6848/image2.jpg"
	// 		,"http://i2.au.reastatic.net/150x112/6bfeff38e3d6bdb02c52e77554df1f83c5e4c3e74e9f3645656823f1e844e6f3/image3.jpg"
	// 		,"http://i3.au.reastatic.net/150x112/8c00c7ff7b8d5edfe5739287a57423d6bcdb624dab8ae0ac8d0067d197176d46/image4.jpg"
	// 		,"http://i4.au.reastatic.net/150x112/95c67929ddbd354e92e48de3e8361a290b138f8dc2b563f2071d376ecbab70f4/image5.jpg"
	// 		,"http://i1.au.reastatic.net/150x112/fd0b860e5f725d0a13bbd42d5488e622a60f14953398f01b6dff98d21df7e96b/image6.jpg"
	// 		,"http://i2.au.reastatic.net/150x112/957b5ca094976f559855ef240d787b638b0ffead190824d7e84d72f6d96385e5/image7.jpg"
	// 		,"http://i3.au.reastatic.net/150x112/194035868078d4896d667914c3d0ba0e6dbb27dc410619c767529d19c20b984c/image8.jpg"
	// 		,"http://i4.au.reastatic.net/150x112/5ff7a5f09b2fa96e0e97711c6faeeec8dd08755d1d6916b90ec81fb381a9e638/image9.jpg"
	// 		,"http://i1.au.reastatic.net/150x112/20e3b49075c57c6692f13d9e63d0a33c5c03b06101db69dd2b2132b9d3d07cb7/image10.jpg"
	// 		,"http://i2.au.reastatic.net/150x112/a624781da7cde069f5417a34379064e7386030499e66f4502ec60d2890345667/image11.jpg"
	// 		,"http://i3.au.reastatic.net/150x112/a90124bdb9d380f0164c9ef250ad9676ce367e58ff5a617158012243022fa681/floorplan1.jpg"
	//     );
	//     $this->assertEquals(
	//     	$expectation,
	//     	$this->spider->parsePropertyImages()
	//     );
	// }

	// public function testParsePropertyVideo()
	// {
	//     $expectation = 'Under Contract';
	//     $this->assertEquals(
	//     	$expectation,
	//     	$this->spider->parsePropertyVideo()
	//     );
	// }

	public function testParsePropertyAgencyName()
	{
	    $expectation = 'Barry Plant - Boronia';
	    $this->assertEquals(
	    	$expectation,
	    	$this->spider->parsePropertyAgencyName()
	    );
	}

	public function testParsePropertyAgentName()
	{
	    $expectation = 'Alan Garbuio';
	    $this->assertEquals(
	    	$expectation,
	    	$this->spider->parsePropertyAgentName()
	    );
	}

	public function testParsePropertyAgentPhone()
	{
	    $expectation = '0425 791 341';
	    $this->assertEquals(
	    	$expectation,
	    	$this->spider->parsePropertyAgentPhone()
	    );
	}
	*/
}