<?php

setlocale(LC_ALL, 'pt_BR', 'pt_BR.utf-8', 'pt_BR.utf-8', 'portuguese');
date_default_timezone_set('America/Sao_Paulo');
require_once("../assets/php/class/class.seg.php");
session_start();
proteger();

$host="10.0.0.2";
$service="//10.0.0.2:1521/orcl";
$id=$_SESSION['usuarioId'];
$email=$_SESSION['usuarioEmail'];
$conn= new \PDO("oci:host=$host;dbname=$service","INTRANET","ifnefy6b9");

$status=$_GET['status'];
$id=$_GET['id'];

$query3="UPDATE IN_PROJETOS SET STATUS = :status WHERE ID = :id";
$stmt3 = $conn->prepare($query3);
$stmt3->bindValue(':status',$status);
$stmt3->bindValue(':id',$id); 
$stmt3->execute();
header("Location: projetos.php");


?>