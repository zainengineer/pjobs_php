<?php

function getDomain() {
	if ( isset($_SERVER['HTTP_HOST']) ) {
	// Get domain
	$dom = $_SERVER['HTTP_HOST'];
	// Strip www from the domain
	if (strtolower(substr($dom, 0, 4)) == 'www.') { $dom = substr($dom, 4); }
	// Check if a port is used, and if it is, strip that info
	$uses_port = strpos($dom, ':');
	if ($uses_port) { $dom = substr($dom, 0, $uses_port); }
	// Add period to Domain (to work with or without www and on subdomains)
	$dom = '.' . $dom;
	} else {
	$dom = false;
	}
	return $dom;
}

	
?>
