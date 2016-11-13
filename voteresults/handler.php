<?php

	# Автоподгрузка классов
	function __autoload($name){ include("classes/_class.".$name.".php");}
	
	# Класс конфига 
	$config = new config;
	
switch( @$_POST['m'] )
{
	case 'GetMeetings';
		require 'handlers/GetMeetings.php';
		break;
	case 'GetMeetingInfo';
		require 'handlers/GetMeetingInfo.php';
		break;
	case 'GetQuestions';
		require 'handlers/GetQuestions.php';
		break;
}

?>