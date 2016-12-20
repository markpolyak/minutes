<?php
echo "Hello world!";
require_once __DIR__ . '/phpword/bootstrap.php';

use PhpOffice\PhpWord\Settings; 

$phpWord = new \PhpOffice\PhpWord\PhpWord();
$section = $phpWord->addSection();


$fontStyleName = 'oneUserDefinedStyle';
$phpWord->addParagraphStyle("leftRight", array("tabs" => array(
    new \PhpOffice\PhpWord\Style\Tab("right", 8500)
)));
$phpWord->addParagraphStyle("center", array("tabs" => array(
    new \PhpOffice\PhpWord\Style\Tab("center", 4250)
)));
$phpWord->addFontStyle(
    $fontStyleName,
    array('name' => 'Times New Roman', 'size' => 12, 'color' => '1B2232')
);
$section->addText(
    "\tприложение № ___ к протоколу №___ ",
     array('name' => 'Times New Roman', 'size' => 14, 'color' => '1B2232'),
	"leftRight"
);
$section->addText("\r\n");
$section->addText(
    "\tЗАКЛЮЧЕНИЕ СЧЕТНОЙ КОМИССИИ",
     array('name' => 'Times New Roman', 'size' => 14, 'color' => '1B2232', 'bold' => true),
	 "center"
);
$section->addText(
    "\tОБЩЕГО СОБРАНИЯ СОБСТВЕННИКОВ ПОМЕЩЕНИЙ",
     array('name' => 'Times New Roman', 'size' => 14, 'color' => '1B2232', 'bold' => true),
	 "center"
);
$section->addText(
    "\tВ МНОГОКВАРТИРНОМ ДОМЕ ПО АДРЕСУ",
     array('name' => 'Times New Roman', 'size' => 14, 'color' => '1B2232'),
	 "center"
);
$meet_id=$_GET["id_meeting"];
$hostStr = "localhost";
$userName = "mpolyakru_mkd";
$password = "test1234";
$dbName = "mpolyakru_mkd";
$cnn = mysqli_connect($hostStr, $userName, $password, $dbName) or die("Error");
mysqli_query($cnn, "SET NAMES utf8");
$query0 = mysqli_query($cnn, "select * from Building,Meeting where Building.id_building=Meeting.id_building and id_meeting=$meet_id");
while ($row0 = mysqli_fetch_array($query0))
{
$str0=$row0['address'];
$section->addText(
    "\t".$str0,
     array('name' => 'Times New Roman', 'size' => 14, 'color' => '1B2232'),
	 "center");
}
$query777 = mysqli_query($cnn, "select date_start from Meeting where id_building=1 and id_meeting=$meet_id");
while ($row777 = mysqli_fetch_array($query777))
{
$str777=$row777[0];
}
$query778 = mysqli_query($cnn, "select date_end from Meeting where id_building=1 and id_meeting=$meet_id");
while ($row778 = mysqli_fetch_array($query778))
{
$str778=$row778[0];
}
$section->addText("\r\n");
$section->addText(
    "\tпроведенного в форме заочного голосования",
     array('name' => 'Times New Roman', 'size' => 12, 'color' => '1B2232'),
	 "center"
);
$section->addText(
    "\tв период с ".$str777." по ".$str778."",
     array('name' => 'Times New Roman', 'size' => 12, 'color' => '1B2232'),
	 "center"
);
$section->addText(
    "\t(в соответствии со статьей 47 ЖК РФ).",
     array('name' => 'Times New Roman', 'size' => 12, 'color' => '1B2232'),
	 "center"
);
$section->addText("\r\n");
$section->addText("\r\n");
$section->addText(
    "       Настоящее заключение составлено членами счетной комиссии общего собрания собственников помещений в многоквартирном доме, проведенного в форме заочного голосования в период с ".$str777." по ".$str778."",
    $fontStyleName
);
$query2 = mysqli_query($cnn, "select round(sum(area_rosreestr),2) from Premise");
while ($row2 = mysqli_fetch_array($query2))
{
	$str1=$row2[0];
}
$query22 = mysqli_query($cnn, "select round(sum(share_numerator*area_rosreestr/share_denominator),2)
from Answer,Owner,Property_rights, Premise, Building, Question
where Owner.id_owner=Answer.id_owner and
Owner.id_owner=Property_rights.id_owner and
Property_rights.id_premise=Premise.id_premise and
Premise.id_building=Building.id_building and
Answer.id_question=Question.id_question and
Building.id_building=1 and
Question.id_Meeting= $meet_id and
Question.sequence_no=1");
while ($row22 = mysqli_fetch_array($query22))
{
	$str2=$row22[0];
}
$section->addText(
    "       В заключении содержатся результаты подсчета голосов собственников помещений в многоквартирном доме по вопросам повестки дня, полученные из решений собственников. Общая полезная площадь дома составляет ".$str1." кв.м. Всего рассмотрено решений собственников ______, представляющих общую площадь ".$str2." кв.м. ",
    $fontStyleName
);
$query3 = mysqli_query($cnn, "select round(sum(area_rosreestr)/2,2) from Premise");
while ($row3 = mysqli_fetch_array($query3))
{
	$str3=$row3[0];
}
$query4 = mysqli_query($cnn, "select round(sum(area_rosreestr)*2/3,2) from Premise");
while ($row4 = mysqli_fetch_array($query4))
{
	$str4=$row4[0];
}
if ($row4[0]>$row22[0])
{
$section->addText(
    "       В соответствии с п. 3 ст. 45 ЖК РФ пятьдесят процентов голосов собственников МКД составляет ".$str3." кв.м. В соответствии с п. 1. ст. 46 ЖК РФ квалифицированное большинство составляет ".$str4." кв.м. (2/3 от общего числа голосов собственников помещений МКД). Кворум для решения вопросов, не требующих наличия квалифицированного большинства голосов, имеется. Кворум для решения вопросов, требующих наличия квалифицированного большинства голосов, имеется.",
    $fontStyleName
);	
}
else if ($row3[0]>$row22[0])
{
	$section->addText(
    "       В соответствии с п. 3 ст. 45 ЖК РФ пятьдесят процентов голосов собственников МКД составляет ".$str3." кв.м. В соответствии с п. 1. ст. 46 ЖК РФ квалифицированное большинство составляет ".$str4." кв.м. (2/3 от общего числа голосов собственников помещений МКД). Кворум для решения вопросов, не требующих наличия квалифицированного большинства голосов, имеется. Кворум для решения вопросов, требующих наличия квалифицированного большинства голосов, не имеется.",
    $fontStyleName
);
}
else 
{
	$section->addText(
    "       В соответствии с п. 3 ст. 45 ЖК РФ пятьдесят процентов голосов собственников МКД составляет ".$str3." кв.м. В соответствии с п. 1. ст. 46 ЖК РФ квалифицированное большинство составляет ".$str4." кв.м. (2/3 от общего числа голосов собственников помещений МКД). Кворум для решения вопросов, не требующих наличия квалифицированного большинства голосов, не имеется. Кворум для решения вопросов, требующих наличия квалифицированного большинства голосов, не имеется.",
    $fontStyleName
);
}
$section->addText("\r\n");
$section->addText(
    "       По вопросам повестки дня, вынесенным на голосование, получены следующие результаты (суммарное количество голосов, подсчитанное по всем сданным решениям):",
    $fontStyleName
);
$query = mysqli_query($cnn, "select * from Question where id_meeting=$meet_id");
while ($row1 = mysqli_fetch_array($query))
{
	$str=htmlspecialchars($row1['question']);
	$r=$row1['sequence_no'];
$section->addText(
    "".$row1['sequence_no'].". ".$str."",
    $fontStyleName
);
/*$section->addText(''.$row1['question'].'. Здесь будет вопрос'
);*/
//echo $row1['question'];
$res = mysqli_query($cnn, "select round(sum(share_numerator*area_rosreestr/share_denominator),0)
from Answer,Owner,Property_rights, Premise, Building, Question
where Owner.id_owner=Answer.id_owner and
Owner.id_owner=Property_rights.id_owner and
Property_rights.id_premise=Premise.id_premise and
Premise.id_building=Building.id_building and
Answer.id_question=Question.id_question and
Building.id_building=1 and
Question.id_Meeting= $meet_id and
id_answer_type=1 and
Question.sequence_no=$r");
$ress = mysqli_query($cnn, "select round(sum(share_numerator*area_rosreestr/share_denominator),2)
from Answer,Owner,Property_rights, Premise, Building, Question
where Owner.id_owner=Answer.id_owner and
Owner.id_owner=Property_rights.id_owner and
Property_rights.id_premise=Premise.id_premise and
Premise.id_building=Building.id_building and
Answer.id_question=Question.id_question and
Building.id_building=1 and
Question.id_Meeting= $meet_id and
id_answer_type=1 and
Question.sequence_no=$r");
$res2 = mysqli_query($cnn, "select round(sum(share_numerator*area_rosreestr/share_denominator),0)
from Answer,Owner,Property_rights, Premise, Building, Question
where Owner.id_owner=Answer.id_owner and
Owner.id_owner=Property_rights.id_owner and
Property_rights.id_premise=Premise.id_premise and
Premise.id_building=Building.id_building and
Answer.id_question=Question.id_question and
Building.id_building=1 and
Question.id_Meeting= $meet_id and
id_answer_type=2 and
Question.sequence_no=$r");
$ress2 = mysqli_query($cnn, "select round(sum(share_numerator*area_rosreestr/share_denominator),2)
from Answer,Owner,Property_rights, Premise, Building, Question
where Owner.id_owner=Answer.id_owner and
Owner.id_owner=Property_rights.id_owner and
Property_rights.id_premise=Premise.id_premise and
Premise.id_building=Building.id_building and
Answer.id_question=Question.id_question and
Building.id_building=1 and
Question.id_Meeting= $meet_id and
id_answer_type=2 and
Question.sequence_no=$r");
$res3 = mysqli_query($cnn, "select round(sum( share_numerator*area_rosreestr/share_denominator),0)
from Answer,Owner,Property_rights, Premise, Building, Question
where Owner.id_owner=Answer.id_owner and
Owner.id_owner=Property_rights.id_owner and
Property_rights.id_premise=Premise.id_premise and
Premise.id_building=Building.id_building and
Answer.id_question=Question.id_question and
Building.id_building=1 and
Question.id_Meeting= $meet_id and
id_answer_type=3 and
Question.sequence_no=$r");
$ress3 = mysqli_query($cnn, "select round(sum( share_numerator*area_rosreestr/share_denominator),2)
from Answer,Owner,Property_rights, Premise, Building, Question
where Owner.id_owner=Answer.id_owner and
Owner.id_owner=Property_rights.id_owner and
Property_rights.id_premise=Premise.id_premise and
Premise.id_building=Building.id_building and
Answer.id_question=Question.id_question and
Building.id_building=1 and
Question.id_Meeting= $meet_id and
id_answer_type=3 and
Question.sequence_no=$r");
while ($row3 = mysqli_fetch_array($res)){
while ($row33 = mysqli_fetch_array($ress)){
while ($row4 = mysqli_fetch_array($res2)){
while ($row44 = mysqli_fetch_array($ress2)){
while ($row5 = mysqli_fetch_array($res3)){
while ($row55 = mysqli_fetch_array($ress3)){
$newres=(round($row33[0]-floor($row33[0]),2))*100;
$newres2=(round($row44[0]-floor($row44[0]),2))*100;
$newres3=(round($row55[0]-floor($row55[0]),2))*100;
/*$newstr3=$row3[0];
$newstr4=$row4[0];
$newstr5=$row5[0];*/
$section->addText('"за" '.$row3[0].','.$newres.'; "Против" '.$row4[0].','.$newres2.'; "Воздержался" '.$row5[0].','.$newres3.'',
array('name' => 'Times New Roman', 'size' => 12, 'color' => '1B2232', 'bold' => true)
);
}
}
}
}
}
}
}
$section->addText("\r\n");
$section->addText("\r\n");
$section->addText(
    "«___»________20___г.\tСчетная комиссия: ",
     array('name' => 'Times New Roman', 'size' => 12, 'color' => '1B2232'),
	"leftRight"
);
$section->addText(
    "\t_______________________ /                          / ",
     array('name' => 'Times New Roman', 'size' => 12, 'color' => '1B2232'),
	"leftRight"
);
$section->addText(
    "\t_______________________ /                          /\t",
     array('name' => 'Times New Roman', 'size' => 12, 'color' => '1B2232'),
	"leftRight"
);
// Saving the document as OOXML file...
$objWriter = \PhpOffice\PhpWord\IOFactory::createWriter($phpWord, 'Word2007');
$objWriter->save('audit_comission.docx');

// Saving the document as ODF file...
$objWriter = \PhpOffice\PhpWord\IOFactory::createWriter($phpWord, 'ODText');
$objWriter->save('audit_comission.odt');

// Saving the document as HTML file...
$objWriter = \PhpOffice\PhpWord\IOFactory::createWriter($phpWord, 'HTML');
$objWriter->save('audit_comission.html');

echo '<a href="audit_comission.docx">Нажмите сюда, чтобы скачать docx</a>';
//echo '<a href="audit_comission.html">Нажмите сюда, чтобы скачать html</a>';
//echo '<a href="audit_comission.odt">Нажмите сюда, чтобы скачать odf</a>';
/* Note: we skip RTF, because it's not XML-based and requires a different example. */
/* Note: we skip PDF, because "HTML-to-PDF" approach is used to create PDF documents. */
?>