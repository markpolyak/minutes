<?php 
	date_default_timezone_set('Europe/Moscow');
	error_reporting(E_ALL | E_STRICT);
	ini_set('display_errors', 'Off');
	
	# Автоподгрузка классов
	function __autoload($name){ include("classes/_class.".$name.".php");}
	
	# Класс конфига 
	$config = new config;
	
	# База данных
	$db = new db($config->HostDB, $config->UserDB, $config->PassDB, $config->BaseDB);
?>	

<html>

<head>
	<title>Система результатов голосования жильцов дома</title>
	<script src="js/general.js"></script>
	<script src="js/jquery-1.9.1.js"></script>
	<link type="text/css" rel="stylesheet" href="styles/style.css" />
</head>


<body class="page">

	<div id="wrap">
	
		<div id="header"> 
			<img src="images/log.png" />
		</div>

		<div class="page-headline">Система результатов голосования жильцов дома</div>
		
		<div id="main">
			<form action="#" method="get">	
				<table  align="left" >
					<tr>
						<td>
							<div class="1" style="display:inline-flex">		
							</div>
						</td>
					
						<td>
						
							<p>Выберите адрес дома:<br />
								<select name="address_id" id="address_id" class="StyleSelectBox" onChange="GetMeetings(this.value)">
									<option value="0">- выберите адрес -</option>
									
									<?PHP

										$db->Query("SELECT id_building,address FROM Building;");

											if( $db->NumRows() > 0 ){

												while($arr = $db->FetchArray()){

									?>
									
									<option value="<?=$arr["id_building"]; ?>"><?=$arr["address"]; ?></option>
									
									<?PHP

												}
											}

									?>
									
								</select>
							</p>
						</td>
						<td>
							
							<p>Выберите собрание:<br />
								<select name="meeting_id" id="meeting_id" class="StyleSelectBox" onChange="GetMeetingInfo(this.value)">
									<option value="0">- выберите собрание -</option>
								</select>
							</p>
						</td>
					</tr>	
				</table><br />	
			</form>	
			
		</div>
		
		<h2 style="color:#181513;display:none;" id="meeting_title">
			Собрание N1 ( 24.10.2016 18:00 - 24.10.2016 19:00 )<hr>
		</h2>
				
		<div id="question" style="display:none;">		
			<h3>
				Вопрос №1 - Тема вопроса<br>
			</h3>
			<p>
				Проголосовали: За ... % Против ... % Воздержались ... %<br>
			</p>
		</div>	
	</div>
  

	<div id="footer">
		<p class="copyright">Copyright &copy; <a href="">***</a> - All Rights Reserved</p>
	</div>



</body>

<script>

	function GetMeetings(id_building){
		
		var params = {
			m : 'GetMeetings', 
			id_building : id_building
		}
		
		$("div[id='question']").css("display", "none");
		$("h2[id='meeting_title']").css("display", "none");
		
		sender(
			function(responce)
			{
				php_err = responce;

				try
				{
					$("select[id='meeting_id']").html(responce);
				}
				catch(e)
				{
					console.log( php_err );
				}
			},
			function()
			{
				// error
			},
			params
		);					
	}

	function GetMeetingInfo(id_meeting){
		
		$("div[id='question']").css("display", "none");
		$("h2[id='meeting_title']").css("display", "none");
		
		if( id_meeting < 1 ) return;
		
		var params = {
			m : 'GetMeetingInfo', 
			id_meeting : id_meeting
		}

		sender(
			function(responce)
			{
				php_err = responce;

				try
				{
					$("h2[id='meeting_title']").html(responce);
					$("h2[id='meeting_title']").css("display", "inline");
					
					GetQuestions(id_meeting);
				}
				catch(e)
				{
					console.log( php_err );
				}
			},
			function()
			{
				// error
			},
			params
		);					
	}	
	
	function GetQuestions(id_meeting){
		
		$("div[id='question']").css("display", "none");
		
		if( id_meeting < 1 ) return;
		
		var params = {
			m : 'GetQuestions', 
			id_meeting : id_meeting
		}

		sender(
			function(responce)
			{
				php_err = responce;

				try
				{
					console.log( responce );
					$("div[id='question']").html(responce);
					$("div[id='question']").css("display", "inline");
				}
				catch(e)
				{
					console.log( php_err );
				}
			},
			function()
			{
				// error
			},
			params
		);					
	}	
	
</script>

</html>