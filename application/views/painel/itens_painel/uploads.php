<?php 
	$arquivo = $this->uri->segment(3);

	$data = file_get_contents(base_url('assets/uploads/'.$arquivo)); // Read the file's contents
	$name = $arquivo;
	
	force_download($name, $data);

?>