<?php

class WebMerge {
    
    private static $api_endpoint = 'https://www.webmerge.me/api';
    private static $merge_endpoint = 'https://www.webmerge.me/merge';
    private static $route_endpoint = 'https://www.webmerge.me/route';
    private $api_key = null;
    private $api_secret = null;

    public function __construct($api_key, $api_secret) {

        $this->api_key = $api_key;
        $this->api_secret = $api_secret;
        
    }
	
	/*
	*
	*/
	public function createDocument($data){
		return $this->request(self::$api_endpoint.'/documents', $data, 'POST');
	}
	
	
	/*
	*
	*/
	public function updateDocument($id, $data){
		return $this->request(self::$api_endpoint.'/documents/'.$id, $data, 'PUT');
	}
	
	
	
	/*
	*
	*/
	public function deleteDocument($id){
		return $this->request(self::$api_endpoint.'/documents/'.$id, null, 'DELETE');
	}
	
	
	/*
	*
	*/
	public function getDocuments(){
		return $this->request(self::$api_endpoint.'/documents');
	}
	
	
	/*
	* $id = document ID
	*/
	public function getDocument($id){
		return $this->request(self::$api_endpoint.'/documents/'.$id);
	}
	
	
	/*
	* $id = document ID
	*/
	public function getDocumentFields($id){
		return $this->request(self::$api_endpoint.'/documents/'.$id.'/fields');
	}
	
	
	/*
	* $id = document ID
	* $key = document key 
	* $options = array(
	*		'test' => 1
	*		'download' => 1   //this will return the PDF data stream, you will need to save into a file
	* );
	*/
	public function doMerge($id, $key, $data, $options = null){
		$url = self::$merge_endpoint.'/'.$id.'/'.$key;
		if(!empty($options)){
			$url .= '?'.http_build_query($options);	
		}
		
		return $this->request($url, $data, 'POST');
	}
	
	
	/*
	*
	*/
	public function getDataRoutes(){
		return $this->request(self::$api_endpoint.'/routes');
	}
	
	
	/*
	* $id = route ID
	*/
	public function getDataRoute($id){
		return $this->request(self::$api_endpoint.'/routes/'.$id);
	}
	
	
	/*
	* $id = route ID
	*/
	public function getDataRouteFields($id){
		return $this->request(self::$api_endpoint.'/routes/'.$id.'/fields');
	}
	
	
	/*
	* $id = route ID
	* $key = route key
	* $options = array(
	*		'test' => 1,
			'download' => 1
	* );
	*/
	public function doRoute($id, $key, $data, $options = null){
		$url = self::$route_endpoint.'/'.$id.'/'.$key;
		if(!empty($options)){
			$url .= '?'.http_build_query($options);	
		}
		
		return $this->request($url, $data, 'POST');
	}
    
    
    /*
	* $files[] = array(
    *   'name' => The File Name
    *   'url' => URL to the file
    *   'contents' => Base64 encoded file contents (if not using URL)
    * );
	* $options = array(
	*   'test' => 1,
    *   'bookmark' => 1
	* );
	*/
	public function combinePdfs($files, $options = null){
		$url = self::$api_endpoint.'/tools/combine_pdf';
		if(!empty($options)){
			$url .= '?'.http_build_query($options);	
		}
		
		return $this->request($url, array('files' => $files), 'POST');
	}
    
    
    /*
	* $file = array(
    *   'name' => The File Name
    *   'url' => URL to the file
    *   'contents' => Base64 encoded file contents (if not using URL)
    * );
	* $options = array(
	*   'test' => 1,
    *   'bookmark' => 1
	* );
	*/
	public function convertToPdf($file, $options = null){
		$url = self::$api_endpoint.'/tools/convert_to_pdf';
		if(!empty($options)){
			$url .= '?'.http_build_query($options);	
		}
		
		return $this->request($url, array('file' => $file), 'POST');
	}
	
	
	/*
	*
	*/
    private function request($uri, $params = null, $method = 'GET') {
        
        $ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $uri);
        
		if(!empty($params)){
            curl_setopt($ch, CURLOPT_POST, 1);
			curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($params));
		}
		
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $method);
        
        curl_setopt($ch, CURLOPT_USERPWD, $this->api_key.':'.$this->api_secret);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, false);
        curl_setopt($ch, CURLOPT_MAXREDIRS, 1);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json'
        ));

        $res = curl_exec($ch);
		$info = curl_getinfo($ch);
				
        curl_close($ch);
		
		if($info['content_type'] == 'application/json'){
			
			$php_res = json_decode($res, true);
		
			if(!empty($php_res['error'])){
				throw new Exception('Error: '.$php_res['error']);	
			}
			
		}else{
			$php_res = $res;			
		}
		
        
		return $php_res;
    }

}

?>
