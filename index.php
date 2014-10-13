<?php
$f3=require('../lib/base.php');
$f3->set('DEBUG',1);
$f3->set('UI','app/');
//$f3->set('AUTOLOAD','app; app/admin; app/frontend');

$f3->route('GET /admin [sync]','Admin->init');
$f3->route('POST|GET /admin/ajax/get_languages [ajax]','Admin->get_languages');
$f3->route('POST|GET /admin/ajax/get_list [ajax]','Admin->get_languages');

$f3->run();

class App{
	function render_template($t)
	{
		$template=new Template;
		echo $template->render($t);
	}
	function json_output($data)
	{
		echo json_encode($data);
	}
}

class Admin extends App{
	function init($f3,$params)
	{
		$this->render_template('admin/views/admin.html');
	}
	function get_setup($f3,$params)
	{
		
	}
	function get_languages($f3,$params)
	{
		$languages=\ISO::instance()->languages();
		//$data=$f3->get('POST');
		$this->json_output($languages);
		//$this->json_output($data);
	}
	function get_list($f3, $params)
	{
	}
}

?>