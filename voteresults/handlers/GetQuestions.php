<?php 

	# База данных
	$db = new db($config->HostDB, $config->UserDB, $config->PassDB, $config->BaseDB);
	$a_db = new db($config->HostDB, $config->UserDB, $config->PassDB, $config->BaseDB);

	$db->Query("SELECT * FROM Question WHERE id_meeting =".$_POST['id_meeting'].";");
	
	$questions = "";
	
	if( $db->NumRows() > 0 ){
		while( $question = $db->FetchArray() ){
			
			$a_db->Query("SELECT Count(0) FROM Answer WHERE id_question =".$question['id_question'].";");
			$answers_count = $a_db->FetchRow();
			
			if( $answers_count > 0 ){
	
				$a_db->Query("SELECT Count(id_answer_type) FROM Answer WHERE id_question =".$question['id_question']." AND id_answer_type = 1;");
				$percentYes = number_format( ($a_db->FetchRow() / $answers_count)*100 , 2 );
				
				$a_db->Query("SELECT Count(id_answer_type) FROM Answer WHERE id_question =".$question['id_question']." AND id_answer_type = 2;");
				$percentNo = number_format( ($a_db->FetchRow() / $answers_count)*100 , 2 );

				$persentUnknown = number_format( 100 - $percentNo - $percentYes , 2 );
			}	else
			{
				$percentNo = 0;
				$percentYes = 0;
				$persentUnknown = 0;
			}
			
			$questions .= "
			<h3>
				Вопрос №".$question['sequence_no']." - ".$question['question']."<br>
			</h3>
			<p>
				Проголосовали: За ".$percentYes."% Против ".$percentNo."% Воздержались ".$persentUnknown."%<br>
			</p>";
		}	
	}	
	
	echo $questions;

?>