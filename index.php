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
	function render_template($t,$data)
	{
		$template=new Template;
		return $template->render($t,'text/html',$data);
	}
	function html_output($data)
	{
		echo $data;
	}
	function json_output($data)
	{
		echo json_encode($data);
	}
}

class Admin extends App{
	function init($f3,$params)
	{
		$items='{"1":{"title":"Lorem ipsum"},"2":{"title":"Lorem ipsum"},"3":{"title":"Lorem ipsum"},"4":{"title":"Lorem ipsum"},"5":{"title":"Lorem ipsum"},"6":{"title":"Lorem ipsum"},"7":{"title":"Lorem ipsum"},"8":{"title":"Lorem ipsum"},"9":{"title":"Lorem ipsum"},"10":{"title":"Lorem ipsum"}} ';
		$tree='[{"i_id":1,"childs":[{"i_id":2,"childs":[{"i_id":5,"childs":[{"i_id":6,"childs":[]},{"i_id":7,"childs":[]}]}]},{"i_id":3,"childs":[{"i_id":4,"childs":[]}]}]},{"i_id":10,"childs":[]}] ';
		$l=json_decode($items,true);
		$t=json_decode($tree,true);
		$tree=$this->draw_tree($t,$l);
		$this->html_output($this->render_template('admin/views/admin.html', array('tree'=>$tree)));
	}
	function draw_tree($tree,$list)
	{
		$leafs=array();
		foreach($tree as $leaf)
		{
			$id=$leaf['i_id'];
			$leafs[]=$this->draw_tree_element($list,$id,$leaf['childs']);
		}
		return $this->render_template('fragments/tree.html', array('leafs'=>$leafs));
	}
	function draw_tree_element($list,$id,$childs)
	{
		$subtree='';
		if(count($childs)>0)
		{
			$subtree=$this->draw_tree($childs,$list);
		}
		return $this->render_template('fragments/tree_element.html', array('id'=>$id,'title'=>$list[$id]['title'],'subtree'=>$subtree));
	}
	function get_setup($f3,$params)
	{
		
	}
	function get_languages($f3,$params)
	{
		$languages=\ISO::instance()->languages();
		$this->json_output($languages);
	}
	function get_list($f3, $params)
	{
	}
}

?>