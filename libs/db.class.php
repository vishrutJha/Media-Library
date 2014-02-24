<?php

class db
{
	private $connection;
	private $selectdb;
	private $lastQuery;
	private $config;

	function __construct($config)
	{
		$this->config = $config;
	}
	
	function __destruct()
	{
		
	}

	public function openConnection()
	{
		try
		{
			if($this->config->connector == "mysql")
			{
				$this->connection = mysql_pconnect($this->config->hostname, $this->config->username, $this->config->password);
				$this->selectdb = mysql_select_db($this->config->database);
			}
			elseif($this->config->connector == "mysqli")
			{
				$this->connection = mysqli_pconnect($this->config->hostname, $this->config->username, $this->config->password);
				$this->selectdb = mysqli_select_db($this->connection, $this->config->database);
			}
		}
		catch(exception $e)
		{
			return $e;
		}
	}

	public function closeConnection()
	{
		try
		{
			if($this->config->connector == "mysql")
			{
				if (!empty ($this->connection)){
					mysql_close($this->connection);
				}
			}
			elseif($this->config->connector == "mysqli")
			{
				mysqli_close($this->connection);
			}
			unset ($this->connection);
		}
		catch(exception $e)
		{
			return $e;
		}
	}
	
	public function ecapeString($string)
	{
		return addslashes($string);
	}

	public function escape($query){
		if(empty($this->connection)){
			$this->openConnection();
		}
		$query = mysql_real_escape_string($query);
		$this->closeConnection();
		return $query;	
	}

	public function query($query)
	{
		$query = str_replace("}", "", $query);
		$query = str_replace("{", $this->config->prefix, $query);
		try
		{
			if(empty($this->connection))
			{
				$this->openConnection();
				
				if($this->config->connector == "mysql")
				{
					$this->lastQuery = mysql_query($query);
				}
				elseif($this->config->connector == "mysqli")
				{
					$this->lastQuery = mysqli_query($this->connection, $query);
				}
			
				return $this->lastQuery;
			}
			else
			{
				if($this->config->connector == "mysql")
				{
					$this->lastQuery = mysql_query($query);
				}
				elseif($this->config->connector == "mysqli")
				{
					$this->lastQuery = mysqli_query($this->connection, $query);
				}
				return $this->lastQuery;
			}
		}
		catch(exception $e)
		{
			return $e;
		}
	}

	public function lastQuery()
	{
		return $this->lastQuery;
	}

	public function pingServer()
	{
		try
		{
			if($this->config->connector == "mysql")
			{
				if(!mysql_ping($this->connection))
				{
					return false;
				}
				else
				{
					return true;
				}
			}
			elseif($this->config->connector == "mysqli")
			{
				if(!mysqli_ping($this->connection))
				{
					return false;
				}
				else
				{
					return true;
				}
			}
		}
		catch(exception $e)
		{
			return $e;
		}
	}
	
	public function hasRows($result)
	{
		try
		{
			if($this->config->connector == "mysql")
			{
				if(mysql_num_rows($result)>0)
				{
					return true;
				}
				else
				{
					return false;
				}
			}
			elseif($this->config->connector == "mysqli")
			{
				if(mysqli_num_rows($result)>0)
				{
					return true;
				}
				else
				{
					return false;
				}
			}
		}
		catch(exception $e)
		{
			return $e;
		}
	}
	
	public function countRows($result)
	{
		try
		{
			if($this->config->connector == "mysql")
			{
				return mysql_num_rows($result);
			}
			elseif($this->config->connector == "mysqli")
			{
				return mysqli_num_rows($result);
			}
		}
		catch(exception $e)
		{
			return $e;
		}
	}
	
	public function fetchAssoc($result)
	{
		try
		{
			if (! $result){
				print_r (mysql_error());
			}
			if($this->config->connector == "mysql")
			{
				return mysql_fetch_assoc($result);
			}
			elseif($this->config->connector == "mysqli")
			{
				return mysqli_fetch_assoc($result);
			}
		}
		catch(exception $e)
		{
			return $e;
		}
	}
	
	public function fetchArray($result)
	{
		try
		{
			if($this->config->connector == "mysql")
			{
				return mysql_fetch_array($result);
			}
			elseif($this->config->connector == "mysqli")
			{
				return mysqli_fetch_array($result);
			}
		}
		catch(exception $e)
		{
			return $e;
		}
	}
}

class config
{
	public $hostname;
	public $username;
	public $password;
	public $database;
	public $prefix;
	public $connector;
	
	function __construct($hostname = NULL, $username = NULL, $password = NULL, $database = NULL, $prefix = NULL, $connector = NULL)
	{
		$this->hostname = !empty($hostname) ? $hostname : "";
		$this->username = !empty($username) ? $username : "";
		$this->password = !empty($password) ? $password : "";
		$this->database = !empty($database) ? $database : "";
		$this->prefix = !empty($prefix) ? $prefix : "";
		$this->connector = !empty($connector) ? $connector : "mysqli";
	}
	
	function __destruct()
	{
		
	}
}
?>
