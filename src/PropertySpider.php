<?php namespace justinwang24\phprealtyspider;

/**
 * 解析 Html 页面内容的工具类接口
 */
interface PropertySpider{
	
	/**
	 * Description
	 * @param type $propertyUrl 
	 * @param type $dom 
	 * @return type
	 */
	public function init($propertyUrl,$dom);

	/**
	 * 解析房产的信息并返回产品对象或者数组
	 */
	public function parseProperty();

	/**
	 * 取得房产在对方网站中的 ID
	 * @param string $tag
	 */
	public function parsePropertyId();
	
	/**
	 * 取得房产的地址
	 * @param string $tag
	 */
	public function parsePropertyAddress();
	
	/**
	 * 取得 房产的Suburb信息
	 * @param string $tag
	 */
	public function parsePropertySuburb();

	/**
	 * 取得房产的State
	 * @param string $tag
	 */
	public function parsePropertyState();

	/**
	 * 取得房产的国家
	 * @param string $tag
	 */
	public function parsePropertyCountry();

	/**
	 * 取得房产的 postcode
	 * @param string $tag
	 */
	public function parsePropertyPostcode();

	/**
	 * 取得房产的描述信息
	 * @param string $tag
	 */
	public function parsePropertyDescription();

	/**
	 * 取得房产的起始价格
	 * @param string $tag
	 */
	public function parsePropertyMinPrice();

	/**
	 * 取得房产的希望最高价格
	 * @param string $tag
	 */
	public function parsePropertyMaxPrice();

	/**
	 * 取得房产价格的描述,比如 POA, Indoor Auction等
	 * @param string $tag
	 */
	public function parsePropertyPriceText();

	/**
	 * 取得房产的卧房数量
	 * @param string $tag
	 */
	public function parsePropertyBedroomNumber();

	/**
	 * 取得房产的卫生间数量
	 * @param string $tag
	 */
	public function parsePropertyBathroomNumber();

	/**
	 * 取得房产的车库数量
	 * @param string $tag
	 */
	public function parsePropertyGarageNumber();

	/**
	 * 取得房产的类型
	 * @param string $tag
	 */
	public function parsePropertyType();

	/**
	 * 取得房产的土地面积
	 * @param string $tag
	 */
	public function parsePropertyLandSize();

	/**
	 * 取得房产的状态,比如 Under Contract 等
	 * @param string $tag
	 */
	public function parsePropertyStatus();
	
	/**
	 * 取得房产的宣传的短语
	 * @param string $tag
	 */
	public function parsePropertySlogon();

	/**
	 * 取得房产的 Inspection 日期
	 * @param string $tag
	 */
	public function parsePropertyOpenForInspectionSchedule();

	/**
	 * 取得房产的购买方式,比如 Action,Private Sale
	 * @param string $tag
	 */
	public function parsePropertySalesMethod();

	/**
	 * 取得产品的原始图片 url 地址
	 * @return string
	 */
	public function parsePropertyImages();
	
	/**
	 * 取得产品的缩略图片 url 地址
	 * @return string
	 */
	public function parsePropertyVideo();

	/**
	 * 取得房产的中介公司名称
	 * @return string
	 */
	public function parsePropertyAgencyName();

	/**
	 * 取得房产的中介公司销售人员名称
	 * @return string
	 */
	public function parsePropertyAgentName();

	/**
	 * 取得房产的中介公司销售人员联系方式
	 * @return string
	 */
	public function parsePropertyAgentPhone();

	/**
	 * 取得房产的中介公司销售人员头像
	 * @return string
	 */
	public function parsePropertyAgentAvatar();

	/**
	 * 取得房产的中介公司销售人员简介的网址
	 * @return string
	 */
	public function parsePropertyAgentProfileLink();

	/**
	 * 取得房产的inepection计划
	 * @return string
	 */
	public function parsePropertyInspection();

	/**
	 * 取得房产的Auction日期
	 * @return string
	 */
	public function parsePropertyAuctionDate();

	/**
	 * 一个房产关联的中介可能多余一个,所以都要抓取
	 * @return string
	 */
	public function parseListingAgents();

	/**
	 * 如果房屋已经卖出,那么尝试抓取 sold date
	 * 
	 * @return string
	 */
	public function parsePropertySoldDate();

	/**
	 * 取得 Indoor的 features
	 * 
	 * @return string
	 */
	public function parsePropertyIndoorFeatures();

	/**
	 * 取得 Indoor的 features
	 * 
	 * @return string
	 */
	public function parsePropertyOutdoorFeatures();

	/**
	 * 取得 General features
	 * 
	 * @return string
	 */
	public function parsePropertyGeneralFeatures();
}