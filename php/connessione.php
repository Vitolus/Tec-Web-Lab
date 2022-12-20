<?php
class DBAccess {
    private const HOST_DB= "127.0.0.1";
    private const DATABASE_NAME=  "dvitagli";
    private const USERNAME= "dvitagli";
    private const PASSWORD= "theeng2sohh6aQui";
    private $conn;

    public function openDBConnection(){
        mysqli_report(MYSQLI_REPORT_ERROR);
        $this->conn= mysqli_connect(DBAccess::HOST_DB,DBAccess::USERNAME,DBAccess::PASSWORD,
            DBAccess::DATABASE_NAME);
        /*if(mysqli_connect_errno()){
          return false;
        }else{
          return true;
        }*/
      return !mysqli_connect_errno();
    }

    public function closeDBConnection(){
        mysqli_close($this->conn);
    }

    public function getList(){
        $query= "SELECT * FROM giocatori ORDER BY ID";
        $queryResult= mysqli_query($this->conn, $query) or die("Errore in openDBConnection: ". mysqli_error($this->conn));
        if(mysqli_num_rows($queryResult)==0){
            return null;
        }else{
            $result= array();
            while($riga= mysqli_fetch_assoc($queryResult)){
                $result[] = $riga;
            }
            $queryResult->free();
            return $result;
        }
    }

}