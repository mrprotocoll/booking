<?php

class BukuKontak_Service
{
	const ENDPOINT = '/bukukontak_service/api.php/';
	
	private $_resource;
	private $_method;
	private $_params;
	private $_handler;
	
	// Database connection
	private $_db;
	
	public function __construct()
	{
		$this->_resource = str_replace(self::ENDPOINT, '', $_SERVER['REQUEST_URI']);
		
		if(strpos($this->_resource, '/') !== false)
		{
			$explode = explode('/', $this->_resource);
			
			$this->_resource = $explode[0];
			
			$this->_params = array_slice($explode, 1);
		}
		
		$this->_method   = $_SERVER['REQUEST_METHOD'];
		
		$this->_handler = strtolower($this->_method . '_' . $this->_resource);
		
		$this->_initDb();
	}
	
	private function _initDb()
	{
		$this->_db = new mysqli('localhost', 'root', '', 'bukukontak_service');
		// Check connection
		if ($this->_db->connect_error)
		    die("Connection failed: " . $conn->connect_error);
	}
	
	private function _readFromDb($sql)
	{
		$query = $this->_db->query($sql);
		
		$results = array();
		
		while($row = $query->fetch_assoc())
			$results[] = $row;
		
		return $results;
	}
	
	private function _writeToDb($sql)
	{
		if($this->_db->query($sql) === true)
			return true;
		
		return false;
	}
	
	public function serve()
	{
		$func = $this->_handler;
		
		$this->$func($this->_params);
	}
	
	public static function main()
	{
		$service = new BukuKontak_Service();
		
		$service->serve();
	}
	
	/*
	* Request Handlers
	*/
	
	private function get_contacts($params)
	{
		$contact1 = array(
			'id' => 19,
			'name' => 'Yoppy Yunhasnawa',
			'phone_number' => '085-755-123-456'
		);
		
		$contact2 = array(
			'id' => 21,
			'name' => 'Rina Dewi Astuti',
			'phone_number' => '081-256-123-456'
		);
		
		$dummyContactList = [$contact1, $contact2];
		
		echo json_encode($dummyContactList);
		
		/*
		$contacts = $this->_readFromDb("SELECT * FROM contact");
		
		echo json_encode($contacts);
		*/
	}
	
	/*
	private function post_contacts($params)
	{
		// Harus pakai ini jika content-type-nya Application/Json
		$rawContent = trim(file_get_contents("php://input"));
		
		// Parse jadi array
		$data = json_decode($rawContent, true);
			
		$id          = $data['id'];
		$name        = $data['name'];
		$phoneNumber = $data['phone_number'];
		
		$inserted = $this->_writeToDb("INSERT INTO contact (name, phone_number) VALUES ('$name', '$phoneNumber')");
		
		if($inserted)
		{
			$insertedContact = array(
				'id' => $id,
				'name' => $name,
				'phone_number' => $phoneNumber
			);
		
			echo json_encode($insertedContact);
		}
	}
	*/
}

BukuKontak_Service::main();
	
?>