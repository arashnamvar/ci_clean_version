<?php 
if(!empty($this->session->flashdata("errors")))
{
	foreach ($this->session->flashdata("errors") as $key => $value) 
	{
		echo $value . "<br>";
	}
} 
?>