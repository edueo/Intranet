<?php

setlocale(LC_ALL, 'pt_BR', 'pt_BR.utf-8', 'pt_BR.utf-8', 'portuguese');
date_default_timezone_set('America/Sao_Paulo');
// require_once("../assets/php/class/class.seg.php");
session_start();
// proteger();

$host="10.0.0.2";
$service="//10.0.0.2:1521/orcl";
$id=$_SESSION['usuarioId'];
$email=$_SESSION['usuarioEmail'];
$conn= new \PDO("oci:host=$host;dbname=$service","INTRANET","ifnefy6b9");

$titulo = $_POST['titulo'];
$inicio = $_POST['inicio'];
$hora_ini = $_POST['hora_ini'];
$fim = $_POST['fim'];
$hora_fim = $_POST['hora_fim'];
// $cor = $_POST['cor'];
$sala = $_POST['sala'];

$query3="INSERT INTO IN_AGENDA (titulo, inicio, hora_ini, fim, hora_fim, sala, usuario) values (:titulo, TO_DATE(:inicio, 'dd/mm/yyyy'), :hora_ini, TO_DATE(:fim, 'dd/mm/yyyy'), :hora_fim, :sala, :usuario)";


$stmt3 = $conn->prepare($query3);
$stmt3->bindValue(':titulo',$titulo);
$stmt3->bindValue(':inicio',$inicio);
$stmt3->bindValue(':hora_ini',$hora_ini);
$stmt3->bindValue(':fim',$fim);
$stmt3->bindValue(':hora_fim',$hora_fim);
// $stmt3->bindValue(':cor',$cor);   
$stmt3->bindValue(':sala',$sala);   
$stmt3->bindValue(':usuario',$id);   
$stmt3->execute();

header('Location: ' . $_SERVER['HTTP_REFERER']);


?>

