<?php
use justinwang24\phprealtyspider\AuctionsResultSpiderReaImpl;
use Sunra\PhpSimple\HtmlDomParser as HtmlDomParser;

class AuctionsResultSpiderReaImplTest extends PHPUnit_Framework_TestCase{
	/*
		创建基境 Fixture
	*/
	protected $spider;
	protected $url;

	/*
		测试环境的初始化
	*/
	protected function setUp(){
		$this->spider = new AuctionsResultSpiderReaImpl;
		$this->url = 'https://www.realestate.com.au/auction-results/vic.html?rsf=edm:auction:vic';
		$this->spider->init($this->url);
	}

	/*
		清理工作
	*/
	protected function tearDown(){
		$this->spider = null;
	}

	public function testGetTotalScheduledAuctions(){
		var_dump($this->spider->getTotalScheduledAuctions());
	}

	// public function testGetClearanceRate(){
	// 	var_dump($this->spider->getClearanceRate());
	// }

	// public function testParse(){
	// 	var_dump($this->spider->parse());
	// }
}