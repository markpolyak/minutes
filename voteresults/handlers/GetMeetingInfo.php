<?php 

	date_default_timezone_set('Europe/Moscow');
	
	# База данных
	$db = new db($config->HostDB, $config->UserDB, $config->PassDB, $config->BaseDB);

	$db->Query("SELECT * FROM Meeting WHERE id_meeting =".$_POST['id_meeting'].";");
	
	$meeting_info = $db->FetchArray();

	if( strtotime($meeting_info['date_end']) < time() ){
		$meeting_title = "Собрание №".$meeting_info['id_meeting']."( ".$meeting_info['date_start']." - ".$meeting_info['date_end']." )<hr>";
	} else $meeting_title = "<font color='Green'>Собрание №".$meeting_info['id_meeting']."( ".$meeting_info['date_start']." - ".$meeting_info['date_end']." )</font><hr>";
	
	echo $meeting_title;

?>
