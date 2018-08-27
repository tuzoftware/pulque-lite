<?php

class HelloController extends Controller{

  public function index(){
	$this->response["hello"]="hello world";
    echo $this->render('hello-world.html');
  }
  
}