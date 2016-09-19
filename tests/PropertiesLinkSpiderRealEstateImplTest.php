<?php
use justinwang24\phprealtyspider\PropertiesLinkSpiderRealEstateImpl;
use justinwang24\phprealtyspider\PropertiesLinkSpiderRealEstateReactImpl;
use Sunra\PhpSimple\HtmlDomParser as HtmlDomParser;

class PropertiesLinkSpiderRealEstateImplTest extends PHPUnit_Framework_TestCase{
	/*
		创建基境 Fixture
	*/
	protected $spider;
	protected $url;

	/*
		测试环境的初始化
	*/
	protected function setUp(){
		$this->spider = new PropertiesLinkSpiderRealEstateReactImpl;
//		$this->url = 'http://www.realestate.com.au/rent/in-vermont+south%2c+vic+3133%3b/list-1';
		$this->url = 'https://www.realestate.com.au/agency/eastfield-real-estate-surrey-hills-EBASUR';
		$this->spider->init($this->url,'rent');
	}

	/*
		清理工作
	*/
	protected function tearDown(){
		$this->spider = null;
	}

	public function testGetTotal(){
		echo 'Testing getTotal ..'.PHP_EOL;
		var_dump($this->spider->getTotalResult());
	}

	public function testGetPaginationLinks(){
		var_dump($this->spider->getPaginationLinks());
	}

	public function testGetPropertyLinks(){
		var_dump($this->spider->getPropertyLinks());
	}
}