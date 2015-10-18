<?php namespace justinwang24\phprealtyspider;

/**
 * 针对 www.realestate.com.au 网站房产页面的抓取功能实现类
 * @author justinwang
 */

use justinwang24\phprealtyspider\PropertiesLinkSpider;
use Sunra\PhpSimple\HtmlDomParser;

class PropertiesLinkSpiderRealEstateImpl implements PropertiesLinkSpider{
	public $pagination = array();
	public $propertiesLink = array();
	public $dom;
	public $link;

	public function __construct()
	{
		
	}

	public function init($link=null,$dom=null){
		$this->dom = $dom;
		$this->link = $link;
		$this->dom = HtmlDomParser::file_get_html( $this->link );
	}

	public function getPaginationLinks(){
		$pagination_tags = $this->dom->find('.pagination li a');
		foreach ($pagination_tags as $key => $el) {
			$tagLink = 'http://www.realestate.com.au/'.$el->getAttribute('href');
			if (!in_array($tagLink, $this->pagination)) {
				$this->pagination[] = $tagLink;
			}
		}
		return $this->pagination;
	}

	public function getPropertyLinks(){
		$property_links_tags = $this->dom->find('#searchResultsTbl article header a');
		foreach ($property_links_tags as $key => $el) {
			$tagLink = 'http://www.realestate.com.au/'.$el->getAttribute('href');
			if (!in_array($tagLink, $this->propertiesLink)) {
				$this->propertiesLink[] = $tagLink;
			}
		}
		return $this->propertiesLink;
	}
}