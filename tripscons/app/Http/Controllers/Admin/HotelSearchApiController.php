<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;



class HotelSearchApiController extends Controller
{
    protected $agency_id;
    protected $user_name;
    protected $password;
    protected $hotel_search_code;

    public function __construct(){
        $this->agency_id = 130082;
        $this->user_name = 'WANOLOGICALXMLTEST';
        $this->password = 'GL2UVH7F8P4';

        $this->hotel_search_code = (isset(request()->HotelSearchCode) && !empty(request()->HotelSearchCode)) ? request()->HotelSearchCode : '14952656/3010665012536413728/62';
    }
    
    public function searchAvailableHotels(){

        $url = 'https://wanological.xml.goglobal.travel/xmlwebservice.asmx';
        $xml_post_string = $this->searchAvailableHotelXML();
        $headers = $this->headersWithPostData($xml_post_string);
        $result = $this->curlSoapPostRequest($url, $xml_post_string, $headers);
        $result = json_decode($result);
        $this->status = 200;
        $this->response['success'] = true;
        $this->response['hotels'] = $result->Hotels;
        return response()->json($this->response, $this->status);
    }
    public function getHotelDetail($hotel_id=265394){

      $url = 'https://wanological.xml.goglobal.travel/xmlwebservice.asmx';
      $xml_post_string = $this->searchHotelDetailXML($hotel_id);
      $headers = $this->headersWithPostData($xml_post_string);
      $result = $this->curlSoapPostRequest($url, $xml_post_string, $headers);
      $result = json_decode($result);
      $this->status = 200;
      $this->response['success'] = true;
      $this->response['hotels'] = $result->Hotels;
      return response()->json($this->response, $this->status);

    }

    public function hotelinfoDetail(){
 
        $url = 'https://wanological.xml.goglobal.travel/xmlwebservice.asmx';
        $xml_post_string = $this->hotelInfoXML();
        $headers = $this->headersWithPostData($xml_post_string);
        $result = $this->curlSoapPostRequest($url, $xml_post_string, $headers);
        $result = $this->xmlToArray($result);
        $result = $result['Main'] ? $result['Main'] : $result;
        $this->status = 200;
        $this->response['success'] = true;
        $this->response['hotels'] = $result;
        return response()->json($this->response, $this->status);

    }

    function searchAvailableHotelXML(){
        $xml = '<?xml version="1.0" encoding="UTF-8"?>
                  <soap12:Envelope xmlns:soap12="http://www.w3.org/2003/05/soap-envelope" xmlns:xsd="http://www.w3.org/2001/XMLSchema" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance">
                     <soap12:Body>
                        <MakeRequest xmlns="http://www.goglobal.travel/">
                           <requestType>11</requestType>
                           <xmlRequest><![CDATA[<Root>
                  <Header>
                  <Agency>'.$this->agency_id.'</Agency>
                  <User>'.$this->user_name.'</User>
                  <Password>'.$this->password.'</Password>
                  <Operation>HOTEL_SEARCH_REQUEST</Operation>
                  <OperationType>Request</OperationType>
                  </Header>
                  <Main Version="2.3" ResponseFormat="JSON" IncludeGeo="false" Currency="USD">
                  <SortOrder>1</SortOrder>
                  <FilterPriceMin>0</FilterPriceMin>
                  <FilterPriceMax>10000</FilterPriceMax>
                  <MaximumWaitTime>15</MaximumWaitTime>
                  <MaxResponses>500</MaxResponses>
                  <FilterRoomBasises>
                  <FilterRoomBasis>HB</FilterRoomBasis>
                  <FilterRoomBasis>BB</FilterRoomBasis>
                  </FilterRoomBasises>
                  <Nationality>GB</Nationality>
                  <CityCode>75</CityCode>
                  <ArrivalDate>2022-04-05</ArrivalDate>
                  <Nights>3</Nights>
                  <Stars>5</Stars>
                  <Rooms>
                  <Room Adults="2" RoomCount="1" ChildCount="0"/>
                  <Room Adults="1" RoomCount="1" ChildCount="2">
                  <ChildAge>9</ChildAge>
                  <ChildAge>5</ChildAge>
                  </Room>
                  </Rooms>
                  </Main>
                  </Root>]]></xmlRequest>
                        </MakeRequest>
                     </soap12:Body>
                  </soap12:Envelope>';
        
        return $xml;
    }

    function searchHotelDetailXML($hotel_id){

        $xml = '<?xml version="1.0" encoding="UTF-8"?>
                <soap12:Envelope xmlns:soap12="http://www.w3.org/2003/05/soap-envelope" xmlns:xsd="http://www.w3.org/2001/XMLSchema" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance">
                   <soap12:Body>
                      <MakeRequest xmlns="http://www.goglobal.travel/">
                         <requestType>11</requestType>
                         <xmlRequest><![CDATA[<Root>
                <Header>
                <Agency>'.$this->agency_id.'</Agency>
                <User>'.$this->user_name.'</User>
                <Password>'.$this->password.'</Password>
                <Operation>HOTEL_SEARCH_REQUEST</Operation>
                <OperationType>Request</OperationType>
                </Header>
                <Main Version="2.3" ResponseFormat="JSON" IncludeGeo="false" Currency="USD">
                <SortOrder>1</SortOrder>

                <Nationality>GB</Nationality>
                <CityCode>75</CityCode>
                <Hotels>
                    <HotelId>'.$hotel_id.'</HotelId>
                </Hotels>
                <ArrivalDate>2022-04-05</ArrivalDate>
                <Nights>3</Nights>
                <Rooms>
                    <Room Adults="2" RoomCount="1" ChildCount="0"/>
                    <Room Adults="1" RoomCount="1" ChildCount="2">
                        <ChildAge>9</ChildAge>
                        <ChildAge>5</ChildAge>
                    </Room>
                </Rooms>
                </Main>
                </Root>]]></xmlRequest>
                      </MakeRequest>
                   </soap12:Body>
                </soap12:Envelope>';

        return $xml;
    }

    function hotelInfoXML(){

        $xml = '<?xml version="1.0" encoding="UTF-8"?>
                    <soap12:Envelope xmlns:soap12="http://www.w3.org/2003/05/soap-envelope" xmlns:xsd="http://www.w3.org/2001/XMLSchema" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance">
                       <soap12:Body>
                          <MakeRequest xmlns="http://www.goglobal.travel/">
                             <requestType>61</requestType>
                             <xmlRequest><![CDATA[<Root>
                    <Header>
                    <Agency>'.$this->agency_id.'</Agency>
                    <User>'.$this->user_name.'</User>
                    <Password>'.$this->password.'</Password>
                    <Operation>HOTEL_INFO_REQUEST</Operation>
                    <OperationType>Request</OperationType>
                    </Header>
                    <Main Version="2.2">
                    <HotelSearchCode>'.$this->hotel_search_code.'</HotelSearchCode>
                    <InfoLanguage>en</InfoLanguage>
                    </Main>
                    </Root>]]></xmlRequest>
                          </MakeRequest>
                       </soap12:Body>
                    </soap12:Envelope>';

        return $xml;
    }


    public function headersWithPostData($xml_post_string){
      $headers = array(
        "POST /package/package_1.3/packageservices.asmx HTTP/1.1",
        "Host: privpakservices.schenker.nu",
        "Content-Type: application/soap+xml; charset=utf-8",
        "Content-Length: ".strlen($xml_post_string)
        ); 
      return $headers;
    }

    function curlSoapPostRequest($url, $xml_post_string, $headers){
      $ch = curl_init();
      curl_setopt($ch, CURLOPT_URL, $url);
      curl_setopt($ch, CURLOPT_POST, true);
      curl_setopt($ch, CURLOPT_POSTFIELDS, $xml_post_string);
      curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
      $response = curl_exec($ch); 
      curl_close($ch);
      // dd($response);
      $response1 = str_replace("<soap:Body>","",$response);
      $response2 = str_replace("</soap:Body>","",$response1);
      $parser = simplexml_load_string($response2);
      return $parser->MakeRequestResponse->MakeRequestResult;
      dd($parser, $response2);

      return json_decode($parser->MakeRequestResponse->MakeRequestResult);
    }


    function xmlToArray($xmlstring){    
      $xml = simplexml_load_string($xmlstring, "SimpleXMLElement", LIBXML_NOCDATA);
      $json = json_encode($xml);
      $array = json_decode($json,TRUE);
      return $array;

    }

}