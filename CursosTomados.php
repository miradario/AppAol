<?php
$url ="https://apidev.artofliving.org/0.1/contacts/participants/history";
$headers=array(
      "Authorization:56499d8fcaa45b2d05000001279adcc340474b0ca98dd5990e5bc847"
      );

$api=new Api($url);
$api->setHeaders($headers);


// making call to the API
$param2= array(
      "application_key"=>"vCAsFcILX0y0xNA4aXnvkkplPOxuPmcZ",
      "program_country"=>"ar",
      "email_address"=>"miradario@gmail.com"
  );

echo $api->call("get",$param2,'info');

class Api{
  protected $baseUrl ;
  protected $url;
  protected $headers;
  protected $method;
  protected $post;
  protected $postFields;
  function __construct($url){
    $this->baseUrl=trim($url,"/");
  }

  public function setHeaders($arrHeaders=array()){
    $this->headers=$arrHeaders;
  }
  public function addHeader($k,$v){
    array_push($this->headers,$k.":".$v );
  }

  public function call($method="get",$arrparams=array(),$endpoint=""){

    $this->url=$this->baseUrl."/".$endpoint;

    if ("get"==strtolower($method)){
      $this->method="GET";
      $this->post=false;
      $this->url=$this->url."?".http_build_query($arrparams);
    }else{
      $this->postFields=$arrparams;
      $this->method=strtoupper($method);
      $this->post=true;

    }
    return $this->makeCall();

  }

  private function makeCall(){
    $ch=curl_init();
    curl_setopt($ch, CURLOPT_URL, $this->url);
    curl_setopt($ch,CURLOPT_HTTPHEADER,$this->headers);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    if ($this->post){
      curl_setopt($ch,CURLOPT_CUSTOMREQUEST,$this->method);
      curl_setopt($ch,CURLOPT_POSTFIELDS,http_build_query($this->postFields));
    }
    $result = curl_exec($ch);
      
      if(curl_errno($ch)){
        $result = 'Curl error: ' . curl_error($ch);
      }
    
    curl_close($ch);
    return $result;

  }
}