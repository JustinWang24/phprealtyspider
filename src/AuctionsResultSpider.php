<?php namespace justinwang24\phprealtyspider;

/**
 * 解析 Html 页面内容的工具类接口
 */
interface AuctionsResultSpider{
	/*初始化方法,取得 url 和创建 dom 对象 */
	public function init($link,$dom);
	/* 取得总拍卖数字 */
	public function getTotalScheduledAuctions();

	/* 取得总拍卖成功率 */
	public function getClearanceRate();

	/* 解析 */
	public function parse();
}	