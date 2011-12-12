<?php
require_once 'lib/ctTemplate.class.php';

$html = ctTemplate::loadTemplate('templates/hello', array(
  'name'=>'Me'
));
echo $html; //do whatever you want to it, output or even embed it to another template




<?php

//main PHP script
require 'lib/ctTemplate.class.php';

ctTemplate::setBaseDir('./templates'); 
$html = ctTemplate::loadTemplate('layout', array(
  'title'=>'Test Template Page',
  'content'=>ctTemplate::loadTemplate('hello', array('name'=>'Me'))
));

echo $html;
