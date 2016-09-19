<?php
namespace justinwang24\phprealtyspider;
/**
 * Created by PhpStorm.
 * User: justinwang
 * Date: 19/09/2016
 * Time: 9:24 PM
 */
use justinwang24\phprealtyspider\PropertiesLinkSpider;
use Curl\Curl;

class PropertiesLinkSpiderRealEstateReactImpl implements PropertiesLinkSpider{
    public $pagination = array();
    public $propertiesLink = array();
    public $link;
    public $totalResult = 0;
    public $pageSize = 12;
    public $curlService = null;

    /**
     * 解析所需要的一些基本信息, 以便组合成下面的URL字符串
     * https://resi-agent-api.realestate.com.au/agency/EBASUR/listings?channel=buy&page=2&pageSize=12
     */
    public $basicUrl = 'https://resi-agent-api.realestate.com.au/agency/';  //
    public $agencyCode = null;           // 物业公司的代码
    public $fetchingPropertyType = 'buy';   // 需要被提取的房产的类型

    public function __construct()
    {
        $this->curlService = new Curl();
    }

    public function init($link,$type=null){
        $this->link = $link;
        /**
         * 设置需要提取的物业的类型: sold, sale, rent
         */
        if($type)
            $this->fetchingPropertyType = $type;
        $this->agencyCode = $this->_parseAgencyCode($link);
    }

    public function getPaginationLinks(){
        $totalPropertiesCount = $this->getTotalResult();
        $this->pagination = [];
        if($totalPropertiesCount>0){
            $pagesCount = round(ceil($totalPropertiesCount/$this->pageSize));
            for($pageNumber=1;$pageNumber<=$pagesCount;$pageNumber++){
                $this->pagination[] = $this->_createPaginationLink($pageNumber,$this->pageSize);
            }
        }
        return $this->pagination;
    }

    public function getPropertyLinks(){
        $pagination = $this->getPaginationLinks();
        $this->propertiesLink = [];
        foreach ($pagination as $pageUrl) {
            $this->curlService->get($pageUrl);
            if(!$this->curlService->error){
                $returnObject = json_decode( $this->curlService->response );
                if(isset($returnObject->results) && count($returnObject->results)){
                    foreach ($returnObject->results as $p) {
                        $this->propertiesLink[] = $p->prettyUrl;
                    }
                }
            }
        }
        return $this->propertiesLink;
    }

    /**
     * 获取总计可以加载的物业的数量
     *
     * @return int
     */
    public function getTotalResult(){
        if($this->totalResult==0){
            $testLink = $this->_createPaginationLink(1,1);
            $response = $this->_verifyPaginationLink($testLink);
            if(is_object($response)){
                $this->totalResult = intval($response->totalResultsCount);
            }else{
                die($response);
            }
        }
        return $this->totalResult;
    }

    /**
     * 专门通过URL解析出该中介公司代码的方法
     *
     * @param $link
     * @return mixed
     */
    private function _parseAgencyCode($link){
        $temp = explode('-',$link);
        if(count($temp)>0){
            return strtoupper( $temp[count($temp)-1] );
        }
    }

    /**
     * 创建 Ajax Call 的URL的方法
     *
     * @param $type
     * @param $pageNumber
     * @param $pageSize
     * @return string
     */
    private function _createPaginationLink($pageNumber,$pageSize){
        /**
         * 样例url
         * https://resi-agent-api.realestate.com.au/agency/EBASUR/listings?channel=buy&page=2&pageSize=12
         */
        return $this->basicUrl.$this->agencyCode.'/listings?channel='.$this->fetchingPropertyType.'&page='.$pageNumber.'&pageSize='.$pageSize;
    }

    /**
     * 检查给定的URL是否可以正常访问,如果可以访问,则将返回的结果打包成对象返回
     *
     * @param $paginationLink
     * @return bool|mixed
     */
    private function _verifyPaginationLink($paginationLink){
        $this->curlService->get($paginationLink);
        if($this->curlService->error){
            return $this->curlService->error_code;
        }else{
            return json_decode( $this->curlService->response );
        }
    }
}