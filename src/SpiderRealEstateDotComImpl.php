<?php namespace justinwang24\phprealtyspider;

/**
 * 针对 www.realestate.com.au 网站房产页面的抓取功能实现类
 * @author justinwang
 */

use justinwang24\phprealtyspider\PropertySpider;
use Sunra\PhpSimple\HtmlDomParser;

class SpiderRealEstateDotComImpl implements PropertySpider{
	/*
		HTML解析类对象实例
	*/
	public $dom = null;

	/*
		需要抓取的页面的 URL
	*/
	public $propertyUrl = null;

	/*
		设置需要爬行的 url 地址
	*/
	public function init($propertyUrl="http://www.realestage.com.au",$dom=null){
		$this->dom = new HtmlDomParser;
		$this->propertyUrl = $propertyUrl;
	}

	/**
	 * 解析房产的信息并返回产品对象或者数组
	 */
	public function parseProperty(){
		return 'OK';
	}
	
	/**
	 * 取得房产的地址
	 * @param string $tag
	 */
	public function parsePropertyAddress(){
		return 'OK';
	}
	
	/**
	 * 取得 房产的Suburb信息
	 * @param string $tag
	 */
	public function parsePropertySuburb(){
		return 'OK';
	}

	/**
	 * 取得房产的State
	 * @param string $tag
	 */
	public function parsePropertyState(){
		return 'OK';
	}

	/**
	 * 取得房产的国家
	 * @param string $tag
	 */
	public function parsePropertyCountry(){
		return 'OK';
	}

	/**
	 * 取得房产的 postcode
	 * @param string $tag
	 */
	public function parsePropertyPostcode(){
		return 'OK';
	}

	/**
	 * 取得房产的描述信息
	 * @param string $tag
	 */
	public function parsePropertyDescription(){
		return 'OK';
	}

	/**
	 * 取得房产的起始价格
	 * @param string $tag
	 */
	public function parsePropertyMinPrice(){
		return 'OK';
	}

	/**
	 * 取得房产的希望最高价格
	 * @param string $tag
	 */
	public function parsePropertyMaxPrice(){
		return 'OK';
	}

	/**
	 * 取得房产价格的描述,比如 POA, Indoor Auction等
	 * @param string $tag
	 */
	public function parsePropertyPriceText(){
		return 'OK';
	}

	/**
	 * 取得房产的卧房数量
	 * @param string $tag
	 */
	public function parsePropertyBedroomNumber(){
		return 'OK';
	}

	/**
	 * 取得房产的卫生间数量
	 * @param string $tag
	 */
	public function parsePropertyBathroomNumber(){
		return 'OK';
	}

	/**
	 * 取得房产的车库数量
	 * @param string $tag
	 */
	public function parsePropertyGarageNumber(){
		return 'OK';
	}

	/**
	 * 取得房产的类型
	 * @param string $tag
	 */
	public function parsePropertyType(){
		return 'OK';
	}

	/**
	 * 取得房产的状态,比如 Under Contract 等
	 * @param string $tag
	 */
	public function parsePropertyStatus(){
		return 'OK';
	}
	
	/**
	 * 取得房产的宣传的短语
	 * @param string $tag
	 */
	public function parsePropertySlogon(){
		return 'OK';
	}

	/**
	 * 取得房产的 Inspection 日期
	 * @param string $tag
	 */
	public function parsePropertyOpenForInspectionSchedule(){
		return 'OK';
	}

	/**
	 * 取得房产的购买方式,比如 Action,Private Sale
	 * @param string $tag
	 */
	public function parsePropertySalesMethod(){
		return 'OK';
	}

	/**
	 * 取得产品的原始图片 url 地址
	 * @return string
	 */
	public function parsePropertyImages(){
		return 'OK';
	}
	
	/**
	 * 取得产品的缩略图片 url 地址
	 * @return string
	 */
	public function parsePropertyVideo(){
		return 'OK';
	}

	/**
	 * 取得房产的中介公司名称
	 * @return string
	 */
	public function parsePropertyAgencyName(){
		return 'OK';
	}

	/**
	 * 取得房产的中介公司销售人员名称,联系方式,头像,邮件等信息
	 * @return string
	 */
	public function parsePropertyAgentDetails(){
		return 'OK';
	}
}