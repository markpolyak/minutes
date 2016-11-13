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
    "\tЭкз. №_____",
     array('name' => 'Times New Roman', 'size' => 14, 'color' => '1B2232', 'bold' => true),
	"leftRight"
);
$section->addText("\r\n");
$section->addText(
    "\tПРОТОКОЛ",
     array('name' => 'Times New Roman', 'size' => 14, 'color' => '1B2232', 'bold' => true),
	 "center"
);
$section->addText(
    "\tОБЩЕГО СОБРАНИЯ СОБСТВЕННИКОВ ПОМЕЩЕНИЙ ",
     array('name' => 'Times New Roman', 'size' => 14, 'color' => '1B2232', 'bold' => true),
	 "center"
);
$section->addText(
    "\tВ МНОГОКВАРТИРНОМ ДОМЕ",
     array('name' => 'Times New Roman', 'size' => 14, 'color' => '1B2232', 'bold' => true),
	 "center"
);
$section->addText("\r\n");
$section->addText(
    "Протокол № _________\tот «___» ____________ 20___ г.",
     array('name' => 'Times New Roman', 'size' => 12, 'color' => '1B2232'),
	"leftRight"
);
$section->addText("\r\n");
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
}
$section->addText(
    "       Общее собрание собственников помещений в многоквартирном доме по адресу: ".$str0.", проводилось в период с «___» ______________ 20___г. по «___» _____________ 20__г. путем заочного голосования в порядке, предусмотренном ст. 47 Жилищного кодекса Российской Федерации. Оформленные в письменной форме решения собственников помещений в многоквартирном доме передавались по адресу: ".$str0."",
    $fontStyleName
);
$section->addText("\r\n");
$section->addText(
    "\tПротокол внеочередного общего собрания собственников многоквартирного дома, ",
     array('name' => 'Times New Roman', 'size' => 10, 'color' => '1B2232', 'bold' => true),
	 "center"
);
$section->addText(
    "\tрасположенного по адресу ".$str0."",
     array('name' => 'Times New Roman', 'size' => 10, 'color' => '1B2232', 'bold' => true),
	 "center"
);
$section->addText(
    "\tпроведенного в форме заочного голосования ",
     array('name' => 'Times New Roman', 'size' => 10, 'color' => '1B2232', 'bold' => true),
	 "center"
);
$section->addText(
    "\t(в соответствии со статьей 47 ЖК РФ). ",
     array('name' => 'Times New Roman', 'size' => 10, 'color' => '1B2232', 'bold' => true),
	 "center"
);
$section->addText("\r\n");
$section->addText(
    "Председатель общего собрания: ",
    $fontStyleName
);
$section->addText(
    "____________________________ ",
    $fontStyleName
);
$section->addText(
    "Секретарь общего собрания: ",
    $fontStyleName
);
$section->addText(
    "____________________________ ",
    $fontStyleName
);
$section->addText("\r\n");
$query2 = mysqli_query($cnn, "select round(sum(area_rosreestr),2) from Premise");
while ($row2 = mysqli_fetch_array($query2))
{
	$str2=$row2[0];
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
	$str22=$row22[0];
}
$query3 = mysqli_query($cnn, "select round(100*sum(share_numerator*area_rosreestr/share_denominator)/sum(area_rosreestr),2)
from Answer,Owner,Property_rights, Premise, Building, Question
where Owner.id_owner=Answer.id_owner and
Owner.id_owner=Property_rights.id_owner and
Property_rights.id_premise=Premise.id_premise and
Premise.id_building=Building.id_building and
Answer.id_question=Question.id_question and
Building.id_building=1 and
Question.id_Meeting= $meet_id and
Question.sequence_no=1");
while ($row3 = mysqli_fetch_array($query3))
{
	$str3=$row3[0];
}
$section->addText(
    "       Инициатором общего собрания является                    , собственник помещения (квартиры) №     на основании свидетельства о государственной регистрации права                        от                .",
    $fontStyleName
);
$section->addText(
    "       Общая полезная площадь дома (площадь жилых и нежилых помещений, находящихся в собственности физических и юридических лиц) составляет ".$str2." кв. м.",
    $fontStyleName
);
$section->addText(
    "       При подсчете голосов принято следующее правило: 1 квадратный метр общей площади помещения равен 1 голосу. В протоколе отражено процентное соотношение голосов «за», «против» и «воздержался» по каждому из вопросов от общего числа голосов принявших участие в собрании собственников и их представителей.",
    $fontStyleName
);
$section->addText(
    "       В собрании приняли участие собственники помещений или их представители, согласно списку участников собрания, подкрепленному сданными решениями собственников. Решения собственников переданы счетной комиссии для подсчета голосов и оформления заключения счетной комиссии (приложение № 1 к данному протоколу). Результаты голосования, отраженные в протоколе, подтверждены заключением счетной комиссии.",
    $fontStyleName
);
if ($row3[0]>50)
{
	$section->addText(
    "       Согласно заключению счетной комиссии, проголосовавшие представляют интересы собственников помещений общей площадью ".$str22." кв. м., что составляет ".$str2."% от общей полезной площади многоквартирного дома. Кворум имеется. Собрание правомочно.",
    $fontStyleName
);
}
else
{
	$section->addText(
    "       Согласно заключению счетной комиссии, проголосовавшие представляют интересы собственников помещений общей площадью ".$str22." кв. м., что составляет ".$str3."% от общей полезной площади многоквартирного дома. Кворум не имеется. Собрание неправомочно.",
    $fontStyleName
);
}
$section->addText(
    "       Вопросы повестки дня общего собрания, по которым проводилось заочное голосование:",
    $fontStyleName
);
$query = mysqli_query($cnn, "select * from Question where id_meeting=$meet_id");
while ($row = mysqli_fetch_array($query))
{
	$str=htmlspecialchars($row['question']);
	$section->addText(
	''.$row['sequence_no'].'. '.$str.'',
    $fontStyleName);
}
$section->addText("\r\n");
$section->addText("\r\n");
$query11 = mysqli_query($cnn, "select * from Question where id_meeting=$meet_id");
while ($row11 = mysqli_fetch_array($query11))
{
	$str=htmlspecialchars($row11['question']);
	$section->addText(
    ''.$row11['sequence_no'].'. '.$str.'',
    $fontStyleName);
	$r=$row11['sequence_no'];

$res = mysqli_query($cnn, "select round(100*sum(share_numerator*area_rosreestr/share_denominator)/
(select sum((p.area_rosreestr*r.share_numerator)/r.share_denominator) 
      from Question as q, Answer as a, Property_rights as r, Premise as p
            where q.id_meeting = $meet_id and q.id_question = a.id_question
        and r.id_owner = a.id_owner and r.id_premise = p.id_premise  and q.sequence_no =$r),2)
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
$res2 = mysqli_query($cnn, "select round(100*sum(share_numerator*area_rosreestr/share_denominator)/
(select sum((p.area_rosreestr*r.share_numerator)/r.share_denominator) 
      from Question as q, Answer as a, Property_rights as r, Premise as p
            where q.id_meeting = $meet_id and q.id_question = a.id_question
        and r.id_owner = a.id_owner and r.id_premise = p.id_premise  and q.sequence_no =$r),2)
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
$res3 = mysqli_query($cnn, "select round(100*sum(share_numerator*area_rosreestr/share_denominator)/
(select sum((p.area_rosreestr*r.share_numerator)/r.share_denominator) 
      from Question as q, Answer as a, Property_rights as r, Premise as p
            where q.id_meeting = $meet_id and q.id_question = a.id_question
        and r.id_owner = a.id_owner and r.id_premise = p.id_premise  and q.sequence_no =$r),2)
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
while ($row4 = mysqli_fetch_array($res2)){
while ($row5 = mysqli_fetch_array($res3)){	
$section->addText('"за" '.$row3[0].'; "против" '.$row4[0].'; "воздержался" '.$row5[0].'',
array('name' => 'Times New Roman', 'size' => 12, 'color' => '1B2232', 'bold' => true)
);
}
}
}
}
$section->addText('Приложения к протоколу:',
array('name' => 'Times New Roman', 'size' => 12, 'color' => '1B2232', 'bold' => true)
);
$section->addText("\r\n");
$section->addText(
    " 1.	Заключение счетной комиссии.",
    $fontStyleName
);
$section->addText(
    "2.	Сообщение о проведении общего собрания.",
    $fontStyleName
);
$section->addText(
    "3.	Реестр собственников помещений в многоквартирном доме.",
    $fontStyleName
);
$section->addText(
    "4.	Список собственников помещений в многоквартирном доме, присутствовавших на общем собрании.",
    $fontStyleName
);
$section->addText(
    "5.	Решения собственников помещений в многоквартирном доме.",
    $fontStyleName
);
$section->addText("\r\n");
$section->addText("\r\n");
$section->addText(
    "\tПредседатель собрания: ______________ /                        /",
     array('name' => 'Times New Roman', 'size' => 12, 'color' => '1B2232'),
	"leftRight"
);
$section->addText(
    "\tСекретарь собрания: _________________ /                        /",
     array('name' => 'Times New Roman', 'size' => 12, 'color' => '1B2232'),
	"leftRight"
);
// Saving the document as OOXML file...
$objWriter = \PhpOffice\PhpWord\IOFactory::createWriter($phpWord, 'Word2007');
$objWriter->save('protocol.docx');

// Saving the document as ODF file...
$objWriter = \PhpOffice\PhpWord\IOFactory::createWriter($phpWord, 'ODText');
$objWriter->save('protocol.odt');

// Saving the document as HTML file...
$objWriter = \PhpOffice\PhpWord\IOFactory::createWriter($phpWord, 'HTML');
$objWriter->save('protocol.html');
echo '<a href="protocol.docx">Нажмите сюда, чтобы скачать docx </a>';
/* Note: we skip RTF, because it's not XML-based and requires a different example. */
/* Note: we skip PDF, because "HTML-to-PDF" approach is used to create PDF documents. */
?>