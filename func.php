<?php
function magic_folder(){
	$carpetas = array("98w0brcq382yrn0x38yr0xp384rycnq03yr0fpx8043f3", "9283b3q87rtbx837tfb874qtc8bo7rnxrynqixury3b9rynqf8y", "78w3rbqx9837trbx83tf7wqeyctr7qytf7qx");
	$date = time();
	return $carpetas[$date%3];
}

?>
