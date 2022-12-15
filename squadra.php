<?php
require_once "connessione.php"; //"..".DIRECORY_SEPARATOR."connessione.php"
$paginaHTML= file_get_contents("squadra.html");
$conn= new DBAccess();
$connOk= $conn->openDBConnection();
$strGiocatori= "";
$giocatori= "";
if ($connOk){
    $giocatori= $conn->getList();
    $conn->closeDBConnection();
    if($giocatori!=null) {
        $strGiocatori .= '<dl id="giocatori>';
        foreach ($giocatori as $giocatore){
            //creare i cvari dt e dd
        }
        $strGiocatori .= '</dl>';
    }else{
        $strGiocatori.="<p>Nessun giocatore presente</p>";
    }
}else{
    $strGiocatori= "<p>Sistemi momentaneamente fuori servizio, ci scusiamo per il disagio.</p>";
}
echo str_replace("<listaGiocatori/>", $strGiocatori, $paginaHTML);