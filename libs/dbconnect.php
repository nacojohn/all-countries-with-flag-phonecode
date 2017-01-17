<?php
class dbconnect extends PDO
{
    private $dns="";
    
    public function __construct($file = 'my_setting.ini')
    {
        if (!$settings = parse_ini_file($file, TRUE)) 
            throw new Exception('Unable to open connection file');
        
        try {
            switch($settings['database']['driver'])
			{
				case "sqlite":
                    $settings['database']['driver'] . ':' . $settings['database']['dbpath'];
					break;
					
				case "mysql":
                    $this->dns = $settings['database']['driver'] . ':host=' . $settings['database']['host'] .
                    ((!empty($settings['database']['port'])) ? (';port=' . $settings['database']['port']) : '') .
                    ';dbname=' . $settings['database']['schema'];
					break;
					
				case "postg":
                    $this->dns = $settings['database']['driver'] . ':host=' . $settings['database']['host'] . ';dbname=' . $settings['database']['schema'];
					break;
					
				case "odbc":
                    $this->dns = $settings['database']['driver'] . ':Driver={Microsoft Access Driver (*.mdb)};Dbq='. $settings['database']['dbpath'] .';Uid=Admin';
				break;
			}
            
            parent::__construct($this->dns, $settings['database']['username'], $settings['database']['password']);
        }
        catch(Exception $e) {
            echo $e->getMessage();
        }
        
    }
}

/*class dbconnect
{
	var $dbtype="mysql";
	var $dbhost="localhost";
	var $dbuser="root";
	var $dbpassword="";
	var $dbpath="C:\xampp\htdocs\works\pdotest\database.mdb";
	var $dbname="catchup";
	var $dbconn="";
	public $conn;

	public function __construct()
	{
		try
		{
			switch($this->dbtype)
			{
				case "sqlite":
					$this->dbconn="sqlite:".$this->dbpath;
					break;
					
				case "mysql":
					$this->dbconn="mysql:host=".$this->dbhost."; dbname=".$this->dbname;
					break;
					
				case "postgresql":
					$this->dbconn="postg:host=".$this->dbhost." dbname=".$this->dbname;
					break;
					
				case "odbc":
					$this->dbconn="odbc:Driver={Microsoft Access Driver (*.mdb)};Dbq=".$this->dbpath.";Uid=Admin";
					break;
			}
			
			$this->conn=new PDO($this->dbconn,$this->dbuser,$this->dbpassword);
			$this->createTables();
		}
		catch(PDOException $error)
		{
			die("There was an error connecting to database, Reason: ".$error->getMessage());
		}
	}
}*/
?>