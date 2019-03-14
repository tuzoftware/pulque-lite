<?php

class HelloController extends Controller{

  public function index(){
	  $this->response("hello","hello world");
      $this->render('hello-world.html');
  }
  
}