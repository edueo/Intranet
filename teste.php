<?php
setlocale(LC_ALL,'pt_BR.UTF8');
header('Content-Type: text/html; charset=UTF-8');
// mb_internal_encoding('UTF8'); 
// mb_regex_encoding('UTF8');
// require_once("assets/php/class/class.seg.php");
session_start();
// proteger();

$host="10.0.0.2";
$service="//10.0.0.2:1521/orcl";
$id=$_SESSION['usuarioId'];
$conn= new \PDO("oci:host=$host;dbname=$service","INTRANET","ifnefy6b9");

$query1 = "SELECT * FROM VW_PERFIL WHERE ID=:id";
$query3 = "SELECT USR.EMAIL, USR.IMG_PERFIL, IMG.IMAGEM AS FOT FROM IN_USUARIOS USR, IN_IMAGENS IMG WHERE USR.IMG_PERFIL = IMG.ID AND USR.SETOR =:setor AND USR.ID != 1";
// $query3 = "SELECT IMG.ID, IMG.IMAGEM, USR.ID AS ID_USR, USR.IMG_PERFIL, USR.EMAIL FROM IN_IMAGENS IMG INNER JOIN IN_USUARIOS USR ON IMG.ID = USR.IMG_PERFILWHERE USR.SETOR =:setor AND USR.ID !=1";

//#1
$stmt1 = $conn->prepare($query1);
$stmt1->bindValue(':id',$id);
$stmt1->execute();
$result1=$stmt1->fetch(PDO::FETCH_ASSOC);



//#3
$stmt3 = $conn->prepare($query3);
$stmt3->bindValue(':setor',$result1['SETOR']);
$stmt3->bindValue(':id',$result1['ID']);
$stmt3->execute();
$result3=$stmt3->fetchAll();


?>

<html>
  <head>
    <title>Aniger - Home</title>
    <meta http-equiv="content-type" content="text/html;charset=UTF-8" />
    <meta charset=utf-8 />
  </head>
  <body>
<?php
echo '<br/>';
echo '<br/>';
var_dump($result1);


echo '<br/>';
echo '<br/>';
var_dump($result3);


echo '<br/>';
echo '<br/>';
foreach ($result3 as $key => $value) {
  
    var_dump[0]($key).'<br/>'.print_r[0]($value);
}


echo '<br/>';
echo '<br/>';
?>
  </body>
</html>