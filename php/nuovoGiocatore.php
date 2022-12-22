<?php
require_once "." . DIRECTORY_SEPARATOR . "connessione.php";
use DB\DBAccess;

$paginaHTML = file_get_contents("../html/nuovoGiocatore.html");
$tagPermessi = '<em><strong><ul><li>'; //se ci fosse un tag non permesso, lo rimuove fino alla fine e si ha codice non valido
$messaggiPerForm = ''; //messaggi di errore per la form
$connessione = new DBAccess();
$nome = '';
$capitano = '';
$dataNascita = '';
$luogo = '';
$altezza = '';
$squadra = '';
$maglia = '';
$ruolo = '';
$magliaNazionale = '';
$punti = '';
$riconoscimenti = '';
$note = '';

function pulisciInput($value)
{
    $value = trim($value);
    $value = strip_tags($value);
    $value = htmlentities($value);
    return $value;
}

function pulisciNote($value)
{
    global $tagPermessi;
    $value = trim($value);
    $value = strip_tags($value, $tagPermessi);
    return $value;
}

if(isset($_POST['submit'])){
    $nome=pulisciInput($_POST['nome']);
    if(strlen($nome) == 0){
        $messaggiPerForm .= '<li>Nome e cognome non inseriti</li>';
    }else{
        if(preg_match("/\d/",$nome)){
            $messaggiPerForm .= '<li>Nome e cognome non possono contenere numeri.</li>';
        }
    }
    $dataNascita=pulisciInput($_POST['dataNascita']);
    if(strlen($dataNascita) == 0){
        $messaggiPerForm .= '<li>Data di nascita non inserita</li>';
    }else{
        if(!preg_match("/\d{4}\-\d{2}\-\d{2}/",$dataNascita)){
            $messaggiPerForm .= '<li>Data di nascita formato non corretto.</li>';
        }
    }
    $capitano=pulisciInput($_POST['capitano']);
    $luogo = pulisciInput($_POST['luogo']);
    if(strlen($luogo) == 0){
        $messaggiPerForm .= '<li>Luogo di nascita non inserita</li>';
    }else if(preg_match("/\d/",$luogo)){
        $messaggiPerForm .= '<li>Luogo di nascita non può contenere numeri.</li>';
    }
    $altezza = pulisciInput($_POST['altezza']);
    if(strlen($altezza) == 0){
        $messaggiPerForm .= '<li>Altezza non inserita</li>';
    }else if(preg_match("/\D/",$altezza) && $altezza<130){
        $messaggiPerForm .= '<li>Altezza deve essere un numero maggiore di 130.</li>';
    }
    $squadra = pulisciInput($_POST['squadra']);
    if(strlen($squadra) == 0){
        $messaggiPerForm .= '<li>Squadra non inserita</li>';
    }
    $maglia = pulisciInput($_POST['maglia']);
    if(strlen($maglia) == 0){
        $messaggiPerForm .= '<li>Maglia non inserita</li>';
    }else if(preg_match("/\D/",$maglia)){
        $messaggiPerForm .= '<li>Maglia deve contenere solo numeri.</li>';
    }

    $ruolo = pulisciInput($_POST['ruolo']);
    if(strlen($ruolo) == 0){
        $messaggiPerForm .= '<li>Ruolo non inserito</li>';
    }else if(preg_match("/^(Palleggiatore|Libero|Centrale|Schiacciatore|Opposto)$/",$ruolo)){
        $messaggiPerForm .= '<li>Ruolo non tra quelli selezionabili</li>';
    }

    $magliaNazionale = pulisciInput($_POST['magliaNazionale']);
    if(strlen($magliaNazionale) == 0){
        $messaggiPerForm .= '<li>Maglia nazionale non inserita</li>';
    }else if(preg_match("/\D/",$magliaNazionale)){
        $messaggiPerForm .= '<li>Maglia nazionale deve contenere solo numeri.</li>';
    }

    $punti = pulisciInput($_POST['punti']);
    if(strlen($punti) == 0){
        $messaggiPerForm .= '<li>Punti non inseriti</li>';
    }else if(preg_match("/\D/",$punti)){
        $messaggiPerForm .= '<li>Punti deve contenere solo numeri.</li>';
    }

    $riconoscimenti = pulisciInput($_POST['riconoscimenti']);
    if(strlen($riconoscimenti) == 0){
        $messaggiPerForm .= '<li>Riconoscimenti non inseriti</li>';
    }

    $note = pulisciNote($_POST['note']);
    if(strlen($note) == 0){
        $messaggiPerForm .= '<li>Note non inserite</li>';
    }

}
if ($messaggiPerForm == "") {
    $connessione = new DBAccess();
    $connOK = $connessione->openDBConnection();
    if ($connOK) {
        $queryOK = $connessione->insertNewPlayer($nome, $capitano, $dataNascita, $luogo, $squadra, $ruolo, $altezza, $maglia, $magliaNazionale, $punti,
            $riconoscimenti,
            $note);
        if ($queryOK) {
            $messaggiPerForm = '<div id="greetings"><p>Inserimento avvenuto con successo.</p></div>';
        } else {
            $messaggiPerForm = '<div id="messageError"><p>Problema nell\'inserimento dei dati, controlla se hai usato caratteri speciali.</p></div>';
        }
    } else {
        $messaggiPerForm = '<div id="messageError"><p>I nostri sistemi sono al momento non funzionanti, ci scusiamo per il disagio.</p></div>';
    }
} else {
    $messaggiPerForm = '<div id="messageError"><ul>' . $messaggiPerForm . '</ul></div>';
}

$paginaHTML = str_replace("<messaggiForm />", $messaggiPerForm, $paginaHTML); //sostituisce il valore del segnaposto con il codice corrispondente
$paginaHTML = str_replace("<valoreNome />", $nome, $paginaHTML); //sostituisce il valore del segnaposto con il codice corrispondente
$paginaHTML = str_replace("<valData />", $dataNascita, $paginaHTML);
$paginaHTML = str_replace("<valLuogo />", $luogo, $paginaHTML);
$paginaHTML = str_replace("<valoreAltezza />", $altezza, $paginaHTML);
$paginaHTML = str_replace("<valoreSquadra />", $squadra, $paginaHTML);
$paginaHTML = str_replace("<valoreRuolo />", $ruolo, $paginaHTML);
$paginaHTML = str_replace("<valoreMagliaNazionale />", $magliaNazionale, $paginaHTML);
$paginaHTML = str_replace("<valorePunti />", $punti, $paginaHTML);

echo $paginaHTML;
