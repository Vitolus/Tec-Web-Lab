<?php
require_once "connessione.php";
$paginaHTML = file_get_contents(".." . DIRECTORY_SEPARATOR . "html" . DIRECTORY_SEPARATOR . "squadra.html");
$conn = new DBAccess();
$connOk = $conn->openDBConnection();
$strGiocatori = "";
$giocatori = "";
if ($connOk) {
  $giocatori = $conn->getList();
  $conn->closeDBConnection();
  if ($giocatori != null) {
    $strGiocatori .= '<dl id="giocatori">';
    foreach ($giocatori as $giocatore) {
      $strGiocatori .= '<dt>' . $giocatore['nome'];
      if ($giocatore['capitano']) {
        $strGiocatori .= ' - <em>Capitano</em>';
      }
      $strGiocatori .= '</dt>'
          . '<dd><img scr="'. $giocatore['immagine'] .'" alt="ciao"/>'
          . '<dl class="giocatore"><dt>Data di nascita:</dt>'
          . '<dd>' . $giocatore['dataNascita'] . '</dd>'
          . '<dt>Luogo:</dt>'
          . '<dd>' . $giocatore['luogo'] . '</dd>'
          . '<dt>Squadra:</dt>'
          . '<dd>' . $giocatore['squadra'] . '</dd>'
          . '<dt>Ruolo:</dt>'
          . '<dd>' . $giocatore['ruolo'] . '</dd>'
          . '<dt>Altezza:</dt>'
          . '<dd>' . $giocatore['altezza'] . '</dd>'
          . '<dt>Maglia:</dt>'
          . '<dd>' . $giocatore['maglia'] . '</dd>'
          . '<dt>Maglia in nazionale:</dt>'
          . '<dd>' . $giocatore['magliaNazionale'] . '</dd>';
      if ($giocatore['ruolo'] != 'libero') {
        $strGiocatori .= '<dt>Punti totali:</dt>';
      } else {
        $strGiocatori .= '<dt>Ricezioni:</dt>';
      }
      $strGiocatori .= '<dd>' . $giocatore['punti'] . '</dd>';
      if ($giocatore['riconoscimenti']) {
        $strGiocatori .= '<dt class="riconoscimenti">Riconoscimenti:</dt>'
            . '<dd>' . $giocatore['riconoscimenti'] . '</dd>';
      }
      if ($giocatore['note']) {
        $strGiocatori .= '<dt class="note">Note:</dt>'
            . '<dd>' . $giocatore['note'] . '</dd>';
      }
      $strGiocatori.= '</dl></dd>';
    }
    $strGiocatori.= '</dl>';
  } else {
    $strGiocatori .= "<p>Nessun giocatore presente</p>";
  }
} else {
  $strGiocatori = "<p>Sistemi momentaneamente fuori servizio, ci scusiamo per il disagio.</p>";
}
echo str_replace("<listaGiocatori />", $strGiocatori, $paginaHTML);