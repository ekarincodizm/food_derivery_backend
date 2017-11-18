<?php
/**
 * Created by PhpStorm.
 * User: boonprakit
 * Date: 7/2/2017
 * Time: 2:58 PM
 */

class Model
{
    protected $conn;
    function __construct()
    {

        $servername = 'localhost';

        $username = 'root';

        $password = '';

        $database = 'food_delivery';

        $port = '3306';

        // Create connection
        $this->conn = mysqli_connect($servername, $username, $password, $database, $port);

        // Check connection
        if (!$this->conn) {
            die("Connection failed: " . mysqli_connect_error());
        }
        mysqli_set_charset($this->conn, "utf8");
    }

    public function get_data()
    {

    }
}
