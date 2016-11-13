<?php 

	# База данных
	$db = new db($config->HostDB, $config->UserDB, $config->PassDB, $config->BaseDB);

	$db->Query("SELECT * FROM Meeting WHERE id_building =".$_POST['id_building'].";");
	
	$meeting_html = "<option value='0'>- выберите собрание -</option>";
	
	if( $db->NumRows() > 0 ){
		while($arr = $db->FetchArray()){
			$meeting_html .= "<option value='".$arr["id_meeting"]."'>Собрание №".$arr['id_meeting']."</option>";
		}	
	}	
	
	echo $meeting_html;

?>