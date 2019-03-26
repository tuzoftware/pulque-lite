<?php
class ResponseMessage{
  /* messageType:OK,ERROR,WARNING,INFORMATION,CONFIRMATION
     responseType: DATATABLE, REDIRECTION, MESSAGE, MESSAGES
  */
  static function message($message,$messageType="OK",$status=200){
   $data = array();
   $data['status'] = $status;
   $data['message']=$message;  
   $data['responseType']='MESSAGE';
   $data['messageType']=$messageType;
   echo json_encode($data);
   header('Content-type: application/json');
   exit();
  } 
  static function messageAdditionalData($message,$additionalData,$messageType="OK",$status=200){
   $data = array();
   $data['status'] = $status;
   $data['message']=$message;  
   $data['responseType']='MESSAGE';
   $data['messageType']=$messageType;
   $data["additionalData"]=$additionalData;
   echo json_encode($data);
   header('Content-type: application/json');
   exit();
  } 
  
  static function messages($messages,$messageType="OK",$status=200){
   $data = array();
   $data['status'] = $status;
   $data['messages']=$messages;  
   $data['responseType']='MESSAGES';
   $data['messageType']=$messageType;
   echo json_encode($data);
   header('Content-type: application/json');
   exit();
  }

    static function errorMessages($messages,$status=200){
        $data = array();
        $data['status'] = $status;
        $data['messages']=$messages;
        $data['responseType']='MESSAGES';
        $data['messageType']="ERROR";
        echo json_encode($data);
        header('Content-type: application/json');
        exit();
    }

    static function errorMessage($message,$status=200){
        $data = array();
        $data['status'] = $status;
        $data['message']=$message;
        $data['responseType']='MESSAGE';
        $data['messageType']='ERROR';
        echo json_encode($data);
        header('Content-type: application/json');
        exit();
    }

    static function dataTableResponse($draw,$total,$data=array()){
    $json_data = [
          "draw"            => intval($draw),
          "recordsTotal"    => intval( $total ),
          "recordsFiltered" => intval( $total ),
          "data"            => $data,
		  "status"          => 200,
		  "responseType"    => "DATATABLE"
          ];
      echo json_encode($json_data);
	  header('Content-type: application/json');
	  exit();
  }  

  static function redirection($url,$status=200){
   $data = array();
   $data['status'] = $status;
   $data['url']=$url;  
   $data['responseType']='REDIRECTION';  
   header('Content-type: application/json');
   echo json_encode($data);
   if($status==408){
       die();
   }else{
       exit();
   }
  }

    static function jsonData($additionalData,$messageType="OK",$status=200){
        $data = array();
        $data['status'] = $status;
        $data['message']="";
        $data['responseType']='MESSAGE';
        $data['messageType']=$messageType;
        $data["additionalData"]=$additionalData;
        echo json_encode($data);
        header('Content-type: application/json');
        exit();
    }

}