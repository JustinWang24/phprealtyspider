<?php namespace justinwang24\phprealtyspider;

/**
 * 解析 Html 页面内容的工具类接口
 */
interface PropertiesLinkSpider{
	public function init($link,$dom);
	public function getPaginationLinks();
	public function getPropertyLinks();
	public function getTotalResult();
}	