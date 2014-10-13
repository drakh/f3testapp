<?php
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
?>