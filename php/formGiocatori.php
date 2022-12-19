<?php
require_once "connessione.php";
$paginaHTML = file_get_contents(".." . DIRECTORY_SEPARATOR . "html" . DIRECTORY_SEPARATOR . "formGiocatori.html");

$tagPermessi = '<em><strong><ul><li><span>';
$messaggiPerForm = '';
$nome = '';
$capitano = '';
$data = '';
//eccetera
function pulisciInput($value)
{
  $value = trim($value);//toglie spazi prima e dopo
  $value = strip_tags($value);//toglie tag
  return htmlentities($value);//converte cose tipo '>' in '&gt'
}

function pulisciNote($value)
{
  global $tagPermessi;
  $value = trim($value);
  return strip_tags($value, $tagPermessi);
}

if (isset($_POST['submit'])) {
  $nome = pulisciInput($_POST['nome']);
  if (strlen($nome) == 0) {
    $messaggiPerForm .= '<li>Nome e Cognome non presenti</li>';
  } else {
    if (preg_match("/\d/", $nome)) {
      $messaggiPerForm .= '<li>Nome e Cognome non possono contenere numeri</li>';
    }
  }

  $capitano = pulisciInput($_POST['capitano']);

  $data = pulisciInput($_POST['dataNascita']);
  if (strlen($data) == 0) {
    $messaggiPerForm .= '<li>Data i nascita non inserita</li>';
  } else {
    if (preg_match("/\d{4}\-\d{2]\-\d{2}/", $data)) {
      $messaggiPerForm .= '<li>La data non è nel formato corretto</li>';
    }
  }
  //eccetera
}
$paginaHTML = str_replace('<messagiForm />', $messaggiPerForm, $paginaHTML);
$paginaHTML = str_replace('<valoreNome />', $nome, $paginaHTML);
$paginaHTML = str_replace('<valData />', $data, $paginaHTML);
//eccetera
echo $paginaHTML;