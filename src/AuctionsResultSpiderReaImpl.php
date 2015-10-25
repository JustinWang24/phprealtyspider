<?php namespace justinwang24\phprealtyspider;

/**
 * 针对 www.realestate.com.au 网站拍卖结果页面的抓取功能实现类
 * @author justinwang
 */

use justinwang24\phprealtyspider\AuctionsResultSpider;
use Sunra\PhpSimple\HtmlDomParser;

class AuctionsResultSpiderReaImpl implements AuctionsResultSpider{

	public $dom;
	public $link;
	public $suburbs = array();
	public $finalResult = array(
		'totalScheduledAuctions'	=> '',
		'clearanceRate'				=> '',
		'items' 					=> array()
	);

	public function __construct()
	{
		
	}

	public function init($link=null,$dom=null){
		$this->link = $link;
		$this->dom = HtmlDomParser::file_get_html( $this->link );
	}

	/* 取得总拍卖数字 */
	public function getTotalScheduledAuctions(){
		$el = $this->dom->find('.reported-auctions div.num',0);
		if ($el) {
			$this->finalResult['totalScheduledAuctions'] = $el->innertext;
		}
		return $this->link;
	}

	/* 取得总拍卖成功率 */
	public function getClearanceRate(){
		$el = $this->dom->find('.clearance-rate div.num',0);
		if ($el) {
			$this->finalResult['clearanceRate'] = $el->innertext;
		}
	}

	/* 解析 */
	public function parse(){
		$this->getTotalScheduledAuctions();
		$this->getClearanceRate();

		//找到所有的 table, 以便取得 suburb 的名字
		$els = $this->dom->find('.rui-table-responsive table');
		foreach ($els as $key => $el) {
			if($suburb = parseSuburbName($el)){
				$this->finalResult['items'][$suburb] = $this->parseSuburbData($el);
			}
		}
		return $this->finalResult;
	}

	/*
		专门取得区的名字的方法
	*/
	private function parseSuburbName($el){
		// $el = $this->dom->find('.rui-table-responsive table',$index);
		if($el){
			$id = trim($el->getAttribute('id'));  //airport-west
			$id = str_replace('-', ' ', $id);     //airport west
			return ucwords($id);				  //Airport West 是suburb 的名字
		}
		return null;
	}

	private function parseSuburbData($el){
		// $el = $this->dom->find('.rui-table-responsive table',$index);
		$data = array();
		if($el){
			$rows = $el->find('tbody tr');
			foreach ($rows as $key => $row) {
				$values = $row->find('td');
				$data[] = array(
					'address'	=> $row->find('td',0)->find('a',0)->innertext,
					'price'	=> $row->find('td',1)->find('div img',0)->getAttribute('src'),
					// 'beds'	=> $row->find('td',2)->innertext,
					'type'	=> $row->find('td',3)->find('div',0)->innertext,
					'result'	=> $row->find('td',4)->find('div',0)->innertext,
					'date'	=> $row->find('td',5)->find('div img',0)->getAttribute('src')
				);
			}
		}
		return $data;
	}
}