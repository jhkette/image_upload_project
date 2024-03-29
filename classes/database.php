<?php
/* 
This class connects to the database. The errors in the appropriate language are passed into 
the __construct function when the class is instantitated, as are the Database credentials. They are also accessible in the model and controller class 
- as they are sub classes of the database class. I'm creating a connection to the database in this class. 
It can then be accessed using the protected $conn variable. This is accessed in the Model class - a sub class of the Database
class. 
*/

class Database
{
    protected $config;
    protected $conn;
    protected $phrases;

    /**
    * @param Array $config
    * @param Array $phrases
    * contructor function takes language and database config as parameter
    * and sets protected variables
    */

    public function __construct($config, $phrases)
    {
        $this->config = $config;
        $this->phrases = $phrases;
    }
    // connect method
    public function connect()
    {
        try {
            $this->host = $this->config['DB_HOST'];
            $this->username = $this->config['DB_USER'];
            $this->password = $this->config['DB_PASS'];
            $this->db = $this->config['DB_NAME'];

            $this->conn = new mysqli(
                $this->host,
                $this->username,
                $this->password,
                $this->db
            );
        } catch (mysqli_sql_exception $ex) {
            echo $this->phrases['mysql-error'] . $ex->getMessage();
            exit();
        } catch (Exception $ex) {
            echo $this->phrases['general-exception'] . $ex->getMessage();
            exit();
        }
    }
    // close database connection
    public function disconnect()
    {
        if (isset($this->conn)) {
            $this->conn->close();
        }
    }
}
?>
