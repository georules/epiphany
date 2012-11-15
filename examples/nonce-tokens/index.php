<?php
chdir('..');
include_once '../src/Epi.php';
Epi::setPath('base', '../src');
Epi::init('route');
Epi::init('token');
getRoute()->get('/', 'hi');
getRoute()->post('/','hipost');
getRoute()->run(); 

function hi()	{
	print_r($_POST);
	echo "<form action=\".\" method=\"post\">";
	getToken()->addToken();
	echo "<input type=\"submit\" value=\"Submit Token\">";
	echo "</form>";
}
function hipost()	{
	print_r($_POST);
	echo "<br/><br/>";
	if(getToken()->validateForm($_POST))	{
		echo "ohhh yeah";
	}
	else	{
		echo "get out of here.";
	}

}
