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
	public function init($propertyUrl=null,$dom=null){
		$this->propertyUrl = $propertyUrl;
		$this->dom = HtmlDomParser::file_get_html( $propertyUrl );
	}

	/**
	 * 解析房产的信息并返回产品对象或者数组
	 */
	public function parseProperty(){
		$property = array(
			'property_id'=>$this->parsePropertyId(),
			'address'=>$this->parsePropertyAddress(),
			'suburb'=>$this->parsePropertySuburb(),
			'state'=>$this->parsePropertyState(),
			'country'=>$this->parsePropertyCountry(),
			'postcode'=>$this->parsePropertyPostcode(),
			'slogan'=>$this->parsePropertySlogon(),
			'description'=>$this->parsePropertyDescription(),
			'price_text'=>$this->parsePropertyPriceText(),
			'bed'=>$this->parsePropertyBedroomNumber(),
			'bath'=>$this->parsePropertyBathroomNumber(),
			'garage'=>$this->parsePropertyGarageNumber(),
			'type'=>$this->parsePropertyType(),
			'land_size'=>$this->parsePropertyLandSize(),
			'images'=>$this->parsePropertyImages(),
			'agency_name'=>$this->parsePropertyAgencyName(),
			'agent_name'=>$this->parsePropertyAgentName(),
			'agent_phone'=>$this->parsePropertyAgentPhone(),
			'realestate_url'=>$this->propertyUrl,
			'domain_url'=>'',
			'inspections'=>$this->parsePropertyInspection(),
			'agentAvatar'=>$this->parsePropertyAgentAvatar(),
			'agentProfileLink'=>$this->parsePropertyAgentProfileLink(),
			'auction'=>$this->parsePropertyAuctionDate(),
			'agents'=>$this->parseListingAgents(),
			'sold_date'=>$this->parsePropertySoldDate(),
			'indoorFeatures'=>$this->parsePropertyIndoorFeatures(),
			'outdoorFeatures'=>$this->parsePropertyOutdoorFeatures(),
			'isUnderContract'=>$this->parsePropertyStatus(),
			'generalFeatures'=>$this->parsePropertyGeneralFeatures()
		);
		return $property;
	}

	/**
	 * 一个房产关联的中介可能多余一个,所以都要抓取
	 * @return string
	 */
	public function parseListingAgents(){
		$agents = array();
		$agentElements = $this->dom->find('#agentInfoExpanded .agent');
		//$el= $this->dom->find('#agentInfoExpanded .agent .agentContactInfo .contactDetails .agentProfile a',0);

		if($agentElements){
			foreach ($agentElements as $index => $agent) {
				$agents[] = array(
					'agent_name' => $this->parsePropertyAgentName($index),
					'agent_phone'=>$this->parsePropertyAgentPhone($index),
					'agentAvatar'=>$this->parsePropertyAgentAvatar($index),
					'agentProfileLink'=>$this->parsePropertyAgentProfileLink($index)
				);
			}
		}

		return $agents;
	}

	/**
	 * 取得房产在对方网站中的 ID
	 * @param string $tag
	 */
	public function parsePropertyId(){
		if (!is_null($this->propertyUrl)) {
			$arr = explode('-', $this->propertyUrl);
			/*
				1: url中必须至少保证有一个 - 符号,所有 $arr 的元素数必须大于1才行
				2: Id 必须全部由数字组成才对
			*/
			if (count($arr)>1 && ctype_digit($arr[count($arr)-1])) {
				return $arr[count($arr)-1];
			}
		}
		return null;
	}
	
	/**
	 * 取得房产的地址
	 * @param string $tag
	 */
	public function parsePropertyAddress(){
		$address = $this->dom->find('#listing_header h1 span',0);
		if ($address) {
			# code...
			return trim($address->innertext);
		}
		return trim($address);
	}
	
	/**
	 * 取得 房产的Suburb信息
	 * @param string $tag
	 */
	public function parsePropertySuburb(){
		$suburb = $this->dom->find('#listing_header h1 span',1);
		if ($suburb) {
			# code...
			return trim($suburb->innertext);
		}
		return trim($suburb);
	}

	/**
	 * 取得房产的State
	 * @param string $tag
	 */
	public function parsePropertyState(){
		$state = $this->dom->find('#listing_header h1 span',2);
		if ($state) {
			# code...
			return trim($state->innertext);
		}
		return strtoupper( trim($state) );
	}

	/**
	 * 取得房产的国家
	 * @param string $tag
	 */
	public function parsePropertyCountry(){
		return 'AU';
	}

	/**
	 * 取得房产的 postcode
	 * @param string $tag
	 */
	public function parsePropertyPostcode(){
		$postcode = $this->dom->find('#listing_header h1 span',3);
		if ($postcode) {
			# code...
			return trim($postcode->innertext);
		}
		return trim($postcode);
	}

	/**
	 * 取得房产的宣传的短语
	 * @param string $tag
	 */
	public function parsePropertySlogon(){
		$slogon = $this->dom->find('#description .title',0);
		if($slogon){
			return trim($slogon->innertext);
		}
		return $slogon;
	}

	/**
	 * 取得房产的描述信息
	 * @param string $tag
	 */
	public function parsePropertyDescription(){
		$el = $this->dom->find('#description .body',0);
		$desc = '';

		if ($el && is_object($el)) {
			# code...
			$desc = $el->innertext;
		}

		return $desc;
	}

	/**
	 * 取得房产的起始价格
	 * @param string $tag
	 */
	public function parsePropertyMinPrice(){
		$el = $this->dom->find('.priceText',0);
		$price = '';

		if ($el && is_object($el)) {
			$price = $el->innertext;
		}

		return $price;
	}

	/**
	 * 取得房产的希望最高价格
	 * @param string $tag
	 */
	public function parsePropertyMaxPrice(){
		$el = $this->dom->find('.priceText',0);
		$price = '';

		if ($el && is_object($el)) {
			$price = $el->innertext;
		}

		return $price;
	}

	/**
	 * 取得房产价格的描述,比如 POA, Indoor Auction等
	 * @param string $tag
	 */
	public function parsePropertyPriceText(){
		$price = $this->dom->find('#listing_info .priceText',0);
		if ($price) {
			return trim($price->innertext);
		}else{
			$price = 'Contact Agent';
		}
		return $price;
	}

	/**
	 * 取得房产的卧房数量
	 * @param string $tag
	 */
	public function parsePropertyBedroomNumber(){
		return $this->_getPropertyOutdoorFeature('Bedrooms');
	}

	/**
	 * 取得房产的卫生间数量
	 * @param string $tag
	 */
	public function parsePropertyBathroomNumber(){
		return $this->_getPropertyOutdoorFeature('Bathrooms');
	}

	/**
	 * 取得房产的车库数量
	 * @param string $tag
	 */
	public function parsePropertyGarageNumber(){
		$garages = $this->_getPropertyOutdoorFeature('Garages');
		if(empty($garages)){
			//try another dev
			$garages = $this->_getPropertyOutdoorFeature('Garage Spaces');
			if(empty($garages)){
				$garages = $this->_getPropertyOutdoorFeature('Carport Spaces');
			}
		}
		return $garages;
	}

	/**
	 * 取得房产的类型
	 * @param string $tag
	 */
	public function parsePropertyType(){
		return $this->_getPropertyOutdoorFeature('Property Type');
	}

	/**
	 * 取得房产的土地面积
	 * @param string $tag
	 */
	public function parsePropertyLandSize(){
		return $this->_getPropertyOutdoorFeature('Land Size');
	}

	/*
		由于网页中 Outdoor Feature 的特殊性而采用的方法
	*/
	private function _getPropertyOutdoorFeature($keyword=null){
		$features_array = $this->dom->find('.featureList ul li');
		$result = null;
		foreach ($features_array as $obj) {
			$txt = trim( $obj->innertext );
			$len = strlen($keyword);
			if ( substr($txt, 0,$len) == $keyword) {
				# code...
				$txt = str_replace( $keyword.':<span>', '', $txt);
				$result = trim(str_replace('</span>', '', $txt));
				break;
			}
		}
		return $result;
	}

	/**
	 * 取得房产的状态,比如 Under Contract 等
	 * @param string $tag
	 */
	public function parsePropertyStatus(){
		$result = $this->dom->find('.auction_details strong',0);
		if($result){
			return trim($result->innertext);
		}
		return trim($result);
	}

	/**
	 * 取得房产的 Inspection 日期
	 * @param string $tag
	 */
	public function parsePropertyOpenForInspectionSchedule(){
		$el = $this->dom->find('#inspectionTimes p',0);
		$result = '';
		if($el && is_object($el)){
			$result = trim($el->innertext);
		}
		return $result;
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
		$images_array = $this->dom->find('.thumb img');
		$images = array();
		foreach ($images_array as  $key => $el) {
			# 通过属性检查,是否该图片是 floorplan 图
			
			if($el->getAttribute('data-type')=='floorplan'){
				//Floor plan 可能有多张,因此要打上一个标记
				$images['floorplan'.$key] = $el->getAttribute('src');
			}else{
				$images[] = $el->getAttribute('src');
			}
		}
		return $images;
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
		$agencyName = '';
		$el = $this->dom->find('.agencyName',0);
		if($el && is_object($el)){
			$agencyName = $el->innertext;
		}
		return trim($agencyName);
	}

	/**
	 * 取得房产的中介公司销售人员名称,联系方式,头像,邮件等信息
	 * @return string
	 */
	public function parsePropertyAgentName($index=0){
		$agentName = '';
		$el = $this->dom->find('.agentName strong',$index);
		if($el && is_object($el)){
			$agentName = $el->innertext;
		}
		return $agentName;
	}

	/**
	 * 取得房产的中介公司销售人员联系方式
	 * @return string
	 */
	public function parsePropertyAgentPhone($index=0){
		$el = $this->dom->find('.phone a',$index);
		$agencyPhone = '';
		if($el && is_object($el)){
			$agencyPhone = $el->innertext;
		}
		return $agencyPhone;
	}

	/**
	 * 取得房产的中介公司销售人员头像
	 * @return string
	 */
	public function parsePropertyAgentAvatar($index=0){
		$el = $this->dom->find('.agentPhoto img',$index);
		$avatar = '';
		if($el && is_object($el)){
			$avatar = $el->getAttribute('src');
		}
		return $avatar;
	}

	/**
	 * 取得房产的中介公司销售人员简介的网址
	 * @return string
	 */
	public function parsePropertyAgentProfileLink($index=0){
		$link = '';
		$el = $this->dom->find('#agentInfoExpanded .agent .agentContactInfo .contactDetails .agentProfile a',$index);
		if($el && is_object($el)){
			$link = $el->getAttribute('href');
		}
		if( !empty($link) && strpos($link, 'www.realestate.com.au')===false){
			$link = 'https://www.realestate.com.au'.$link;
		}
		return $link;
	}

	/**
	 * 取得房产的inepection计划
	 * @return string
	 */
	public function parsePropertyInspection(){

		$result = array();
		
		//可能有具体计划了
			$list = $this->dom->find('#inspectionTimes a');
			$time_string_list = $this->dom->find('#inspectionTimes a .time');

			if($list){
				foreach ($list as $key => $el) {
					$href = $el->getAttribute('href');
					// /oficalendar.ds?id=120761345&inspectionStartTime=1300&inspectionDate=20150919
					$arr = explode('&amp;', $href);
					$startTime = '';
					$date = '';
					if( isset($arr[1]) ){
						$startTime = str_replace('inspectionStartTime=', '', $arr[1]);
					}
					if( isset($arr[2]) ){
						$date = str_replace('inspectionDate=', '', $arr[2]);
					}

					if(strlen($date)==8 && strlen($startTime)==4){
						$year = substr($date, 0,4);
						$month = substr($date, 4,2);
						$day = substr($date, 6,2);
						$hour = substr($startTime, 0,2);
						$minute = substr($startTime, 2,2);
						$start = $year.'-'.$month.'-'.$day.' '.$hour.':'.$minute.':00';
						$theEnd = strtotime($startTime)+1800;

						$schedule_date = $year.'-'.$month.'-'.$day;
						$end_at = date('Y-m-d H:i:s',$theEnd);

						//for end time
						if( isset($time_string_list[$key]) ){
							$time_el = $time_string_list[$key];
							$time_string = $time_el->innertext;
							////11:30AM - 11:45AM
							$time_str_array = explode('-',$time_string);
							if(isset($time_str_array[1])){
								$time_string = trim($time_str_array[1]);
								$time_string = str_replace('AM',':00',$time_string);
								$end_at = $schedule_date.' '.str_replace('PM',':00',$time_string);
							}
						}

						$result[] = array(
							'start_at'=>$start,
							'end_at'=>$end_at,
							'schedule_date'=>$schedule_date
						);
					}
				}
			}
		
		return $result;
	}

	/**
	 * 取得房产的Auction日期时间,返回值为 Y-m-d H:i:s
	 * @return string
	 */
	public function parsePropertyAuctionDate(){
		$el = $this->dom->find('.auctionDetails meta',0);
		$auctionDate = null;
		if( $el && !empty( $el->getAttribute('content') ) ){
			$auctionDate = $el->getAttribute('content');

			# 2015-10-31T12:00:00+11:00  一个实例的值
			$temp = explode('T', $auctionDate);

			if(count($temp)==2){
				$date = $temp[0];

				$temp2 = explode('+', $temp[1]);

				if (count($temp2)>0) {
					# code...
					$auctionDate = $date . ' ' . $temp2[0];
				}
			}
		}

		return $auctionDate;
	}

	/**
	 * 取得房产的是否 under contract
	 * 
	 * @return string
	 */
	public function parsePropertyIsUnderContract(){
		$el = $this->dom->find('.auctionDetails',0);
		$auctionDate = null;
		if( $el && !empty( $el->innertext ) ){
			$auctionDate = $el->innertext;

			# 2015-10-31T12:00:00+11:00  一个实例的值
			
		}

		return $auctionDate;
	}

	/**
	 * 如果房屋已经卖出,那么尝试抓取 sold date
	 * 
	 * @return string
	 */
	public function parsePropertySoldDate(){
		$el = $this->dom->find('.sold_date span',0);
		$soldDate = null;
		if( $el && !empty( $el->innertext ) ){
			$soldDate = $el->innertext;
			# Sat 19-Mar-16  一个实例的值
		}

		return $soldDate;
	}

	public function parsePropertyIndoorFeatures(){
		$el = $this->dom->find('#features .featureListWrapper .featureList ul',1);
		$indoorFeatures = '';
		if( $el && !empty( $el->innertext ) ){
			$indoorFeatures = $el->innertext;
			# Sat 19-Mar-16  一个实例的值
		}
		return $indoorFeatures;
	}

	public function parsePropertyOutdoorFeatures(){
		$el = $this->dom->find('#features .featureListWrapper .featureList ul',2);
		$outdoorFeatures = '';
		if( $el && !empty( $el->innertext ) ){
			$outdoorFeatures = $el->innertext;
			# Sat 19-Mar-16  一个实例的值
		}
		return $outdoorFeatures;
	}

	public function parsePropertyGeneralFeatures(){
		$el = $this->dom->find('#features .featureListWrapper .featureList ul',0);
		$generalFeatures = '';
		if( $el && !empty( $el->innertext ) ){
			$generalFeatures = $el->innertext;
			# Sat 19-Mar-16  一个实例的值
		}
		return $generalFeatures;
	}
}