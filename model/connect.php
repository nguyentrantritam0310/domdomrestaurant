<?php
class Database
{
    function connect()
    {
        $conn = new mysqli("localhost", "root", "", "domdom");

        if ($conn->connect_error)
            return $conn->error;
        else return $conn;
    }
    
    function close($conn)
    {
        if ($conn)
            return $conn->close();
    }
}
