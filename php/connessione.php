<?php
namespace DB;
class DBAccess {
    private const HOST_DB= "localhost:8080";
    private const DATABASE_NAME=  "dvitagli";
    private const USERNAME= "dvitagli";
    private const PASSWORD= "theeng2sohh6aQui";
    private $conn;

    public function openDBConnection(){
        mysqli_report(MYSQLI_REPORT_ERROR);
        $this->conn= mysqli_connect(DBAccess::HOST_DB,DBAccess::USERNAME,DBAccess::PASSWORD,
            DBAccess::DATABASE_NAME);
        return (bool)mysqli_connect_errno();
    }

    public function closeDBConnection(){
        mysqli_close($this->conn);
    }

    public function getList(){
        $query= "SELECT * FROM Giocatori ORDER BY ID";
        $queryResult= mysqli_query($this->conn, $query) or die("Errore in openDBConnection: ". mysqli_error($this->conn));
        if(mysqli_num_rows($queryResult)==0){
            return null;
        }else{
            $result= array();
            while($riga= mysqli_fetch_assoc($queryResult)){
                $result[] = $riga;
            }
            return $result;
        }
    }

}