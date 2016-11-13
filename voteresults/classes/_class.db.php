<?PHP




class db{


	private $con = false; // Идентификатор
	private $Queryes = 0; // Число запросов
	private $MySQLErrors = array(); // Массив с ошибками
	private $TimeQuery = 0; // Всемя запросов
	private $MaxExTime = 0; // Максимальное время за 1 запрос
	private $ListQueryes = ""; // Список запросов
	private $HardQuery = ""; // Самый тяжелый запрос
	private $LastQuery = false; // Ресурс запрос
	private $ConnectData = array(); // Данные соединения
	

	public function __construct($host, $user, $pass, $base){
		$this->Connect($host, $user, $pass, $base);
		$this->query("SET NAMES 'utf8'");
		$this->query("SET CHARACTER SET 'utf8'");
	}
	

	public function Stats(){
		
		$sD = array();
		$sD["TimeQuery"] = $this->TimeQuery;
		$sD["MaxExTime"] = $this->MaxExTime;
		$sD["ListQueryes"] = $this->ListQueryes;
		$sD["HardQuery"] = $this->HardQuery;
		$sD["Queryes"] = $this->Queryes;
		return $sD;
	}

	private function GetError($TextError){
		$this->MySQLErrors[] = $TextError;
		die($TextError);
	}
	
	public function query($query, $FreeMemory = false, $write_last = true){
		
		$TimeA = $this->get_time();
		$xxt_res = mysqli_query($this->con, $query) or $this->GetError(mysqli_error($this->con));
		
		if($write_last) $this->LastQuery = $xxt_res;
		
		$TimeB = $this->get_time() - $TimeA;
		$this->TimeQuery += $TimeB;
		
			if($TimeB > $this->MaxExTime){$this->HardQuery = $query; $this->MaxExTime = $TimeB;}
			
				if( empty($this->ListQueryes) ) $this->ListQueryes = $query; else $this->ListQueryes .= "\n".$query;
			
		$this->Queryes++;
		
		if(!$FreeMemory){
			return $this->LastQuery;
		}else return $this->FreeMemory();
		
		
	}

	
	private function Connect($host, $user, $pass, $base){
		$this->con =  @mysqli_connect($host, $user, $pass, $base) or $this->GetError(mysqli_connect_error());
	} 
	
	
	function MultiQuery($query){
	
		$TimeA = $this->get_time();

		mysqli_multi_query($this->con, $query) or $this->GetError(mysqli_connect_error());
    	$TimeB = $this->get_time() - $TimeA;	
		$ret_data = array();
		$counter = 0;
			do{
        
				if ($result = mysqli_store_result($this->con)) {
					
					while ($row = mysqli_fetch_array($result)) {
					$ret_data[$counter][] = $row;
					}
					mysqli_free_result($result);
					$counter++;
				}

				
    		}while(mysqli_next_result($this->con));

		
		
		$this->TimeQuery += $TimeB;
			
			if($TimeB > $this->MaxExTime){$this->HardQuery = $query; $this->MaxExTime = $TimeB;}
			
				if( empty($this->ListQueryes) ) $this->ListQueryes = $query; else $this->ListQueryes .= "\n".$query;
			
		$this->Queryes++;
		
		return $ret_data;
	}
	
	
	private function get_time()
	{
		list($seconds, $microSeconds) = explode(' ', microtime());
		return ((float) $seconds + (float) $microSeconds);
	}
	

	function __destruct(){
		
		if( !count($this->MySQLErrors) ) mysqli_close($this->con);
	
	}
	
	
	function FreeMemory()
	{
		$tr = ($this->LastQuery) ? true : false;
		@mysqli_free_result($this->LastQuery);
		return $tr;
	}
	
	
	function RealEscape($string)
	{
		if ($this->con) return mysqli_real_escape_string ($this->con, $string);
		else return mysql_escape_string($string);
	}
	
	
	function NumRows()
	{
		return mysqli_num_rows($this->LastQuery);
	}
	

	function FetchArray(){
		//if($this->LastQuery)
		return mysqli_fetch_array($this->LastQuery);
	}
	
	
	function FetchRow(){
		$xres = mysqli_fetch_row($this->LastQuery);
		
		return (count($xres) > 1) ? $xres :  $xres[0];
	}
	

	function LastInsert(){
		
		return @mysqli_insert_id($this->con);
		
	}
	
}
?>