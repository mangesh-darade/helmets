<?php
defined('BASEPATH') OR exit('No direct script access allowed');

echo "\nDatabase error: ",
	$heading,
	"\n\n",
	$message,
	"\n\n";	$errorUrl = "http://".$_SERVER[HTTP_HOST].$_SERVER[REQUEST_URI];$logger = array("\nERROR: ".$heading."\n\n".$message."\n\n" , $errorUrl); 