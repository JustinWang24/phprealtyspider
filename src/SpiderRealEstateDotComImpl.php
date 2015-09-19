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
			'agentProfileLink'=>$this->parsePropertyAgentProfileLink()
		);
		return $property;
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
		$desc = $this->dom->find('#description .body',0)->innertext;
		return $desc;
	}

	/**
	 * 取得房产的起始价格
	 * @param string $tag
	 */
	public function parsePropertyMinPrice(){
		$price = $this->dom->find('.priceText',0)->innertext;
		return $price;
	}

	/**
	 * 取得房产的希望最高价格
	 * @param string $tag
	 */
	public function parsePropertyMaxPrice(){
		$price = $this->dom->find('.priceText',0)->innertext;
		return $price;
	}

	/**
	 * 取得房产价格的描述,比如 POA, Indoor Auction等
	 * @param string $tag
	 */
	public function parsePropertyPriceText(){
		$price = $this->dom->find('.priceText',0);
		if ($price) {
			return trim($price->innertext);
		}else{
			$price = 'Contract Agent';
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
		return $this->_getPropertyOutdoorFeature('Garages');
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
		return $result = trim($this->dom->find('#inspectionTimes p',0)->innertext);
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
		foreach ($images_array as  $el) {
			# code...
			$images[] = $el->getAttribute('src');
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
		$agencyName = $this->dom->find('.agencyName',0)->innertext;
		return trim($agencyName);
	}

	/**
	 * 取得房产的中介公司销售人员名称,联系方式,头像,邮件等信息
	 * @return string
	 */
	public function parsePropertyAgentName(){
		return $agencyName = $this->dom->find('.agentName strong',0)->innertext;
	}

	/**
	 * 取得房产的中介公司销售人员联系方式
	 * @return string
	 */
	public function parsePropertyAgentPhone(){
		$agencyPhone = $this->dom->find('.phone a',0)->innertext;
		return $agencyPhone;
	}

	/**
	 * 取得房产的中介公司销售人员头像
	 * @return string
	 */
	public function parsePropertyAgentAvatar(){
		$avatar = $this->dom->find('.agentPhoto img',0)->getAttribute('src');

		return $avatar;
	}

	/**
	 * 取得房产的中介公司销售人员简介的网址
	 * @return string
	 */
	public function parsePropertyAgentProfileLink(){
		$link = $this->dom->find('#agentInfoExpanded .agent .agentContactInfo .contactDetails .agentProfile a',0)->getAttribute('href');
		if(strpos($link, 'www.realestate.com.au')===false){
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
						$result[] = array(
							'start_at'=>$start,
							'end_at'=>date('Y-m-d H:i:s',$theEnd)
						);
					}
				}
			}
		
		
		return $result;
	}
}