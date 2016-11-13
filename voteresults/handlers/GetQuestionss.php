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
	
				$a_db->Query("SELECT ROUND(100*SUM(DISTINCT share_numerator*area_rosreestr/share_denominator)/ 
							(SELECT ROUND(SUM(DISTINCT share_numerator*area_rosreestr/share_denominator),2) 
							FROM Answer,`Owner`,Property_rights, Premise, Building, Question
							WHERE Owner.id_owner=Answer.id_owner AND 
							Owner.id_owner=Property_rights.id_owner AND 
							Property_rights.id_premise=Premise.id_premise AND 
							Premise.id_building=Building.id_building AND 
							Answer.id_question=".$question['id_question']." AND 
							Building.id_building=".$_POST['id_building']." AND 
							Question.id_meeting=".$_POST['id_meeting']."),2) 
							FROM Answer,`Owner`,Property_rights, Premise, Building, Question 
							WHERE Owner.id_owner=Answer.id_owner AND 
							Owner.id_owner=Property_rights.id_owner AND 
							Property_rights.id_premise=Premise.id_premise AND 
							Premise.id_building=Building.id_building AND 
							Answer.id_question=".$question['id_question']." AND 
							Building.id_building=".$_POST['id_building']." AND 
							Question.id_meeting=".$_POST['id_meeting']." AND 
							id_answer_type=1;");
				$percentYes = $a_db->FetchRow(); //number_format( $a_db->FetchRow() , 2 );
				
				$a_db->Query("SELECT ROUND(100*SUM(DISTINCT share_numerator*area_rosreestr/share_denominator)/ 
							(SELECT ROUND(SUM(DISTINCT share_numerator*area_rosreestr/share_denominator),2) 
							FROM Answer,`Owner`,Property_rights, Premise, Building, Question 
							WHERE Owner.id_owner=Answer.id_owner AND 
							Owner.id_owner=Property_rights.id_owner AND 
							Property_rights.id_premise=Premise.id_premise AND 
							Premise.id_building=Building.id_building AND 
							Answer.id_question=".$question['id_question']." AND 
							Building.id_building=".$_POST['id_building']." AND 
							Question.id_meeting=".$_POST['id_meeting']."),2) 
							FROM Answer,`Owner`,Property_rights, Premise, Building, Question 
							WHERE Owner.id_owner=Answer.id_owner AND 
							Owner.id_owner=Property_rights.id_owner AND 
							Property_rights.id_premise=Premise.id_premise AND 
							Premise.id_building=Building.id_building AND 
							Answer.id_question=".$question['id_question']." AND 
							Building.id_building=".$_POST['id_building']." AND 
							Question.id_meeting=".$_POST['id_meeting']." AND 
							id_answer_type=2;");
				$percentNo = $a_db->FetchRow(); //number_format( $a_db->FetchRow() , 2 );

				$a_db->Query("SELECT ROUND(100*SUM(DISTINCT share_numerator*area_rosreestr/share_denominator)/ 
							(SELECT ROUND(SUM(DISTINCT share_numerator*area_rosreestr/share_denominator),2) 
							FROM Answer,`Owner`,Property_rights, Premise, Building, Question 
							WHERE Owner.id_owner=Answer.id_owner AND 
							Owner.id_owner=Property_rights.id_owner AND 
							Property_rights.id_premise=Premise.id_premise AND 
							Premise.id_building=Building.id_building AND 
							Answer.id_question=".$question['id_question']." AND 
							Building.id_building=".$_POST['id_building']." AND 
							Question.id_meeting=".$_POST['id_meeting']."),2) 
							FROM Answer,`Owner`,Property_rights, Premise, Building, Question 
							WHERE Owner.id_owner=Answer.id_owner AND 
							Owner.id_owner=Property_rights.id_owner AND 
							Property_rights.id_premise=Premise.id_premise AND 
							Premise.id_building=Building.id_building AND 
							Answer.id_question=".$question['id_question']." AND 
							Building.id_building=".$_POST['id_building']." AND 
							Question.id_meeting=".$_POST['id_meeting']." AND 
							id_answer_type=3;");				
				$persentUnknown = $a_db->FetchRow(); //number_format( $a_db->FetchRow() , 2 );
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