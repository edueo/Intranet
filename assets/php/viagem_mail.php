<?php
 
// Inclui o arquivo class.phpmailer.php
require_once("class/class.phpmailer.php");
 
// Inicia a classe PHPMailer
$mail = new PHPMailer(true);
 
// Define os dados do servidor e tipo de conexão
// =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=
$mail->IsSMTP(); // Define que a mensagem será SMTP

//REQUEST campos
$nome=$_POST['nome'];
$setor=$_POST['setor'];
$endereco=$_POST['endereco'];
$nro=$_POST['nro'];
$bairro=$_POST['bairro'];
$cep=$_POST['cep'];
$cidade=$_POST['cidade'];
$estado=$_POST['estado'];
$fone=$_POST['fone'];
$rg=$_POST['rg'];
$cpf=$_POST['cpf'];
$email=$_POST['email'];
$destino=$_POST['destino'];
$ida=$_POST['ida'];
$ida2=$_POST['ida'];
$ida=date("d/m/Y",strtotime($ida)); //Direto para template formatado
$dtida = new DateTime($ida2); // Transformando em date para cálculo
$volta=$_POST['volta'];
$volta2 = $_POST['volta'];
$volta=date("d/m/Y",strtotime($volta));  //Direto para template formatado
$dtvolta = new DateTime($volta2); // Transformando em date para cálculo
$ausencia = $dtida->diff($dtvolta);
$obs=$_POST['obs'];
$autorizado=$_POST['autorizado'];
$dtAutorizado=$_POST['dtAutorizado'];
$dtAutorizado= date("d/m/Y",strtotime($dtAutorizado));

$mensagem = file_get_contents('viagem_tmp.html');
$dest='gabriel.hipolito@aniger.com.br';
$assunto='Nova viagem - ' . $nome . ' - ' . $destino;

$mensagem = str_replace('%nome%', $nome, $mensagem);
$mensagem = str_replace('%setor%', $setor, $mensagem);
$mensagem = str_replace('%endereco%', $endereco, $mensagem);
$mensagem = str_replace('%nro%', $nro, $mensagem);
$mensagem = str_replace('%bairro%', $bairro, $mensagem);
$mensagem = str_replace('%cep%', $cep, $mensagem);
$mensagem = str_replace('%cidade%', $cidade, $mensagem);
$mensagem = str_replace('%estado%', $estado, $mensagem);
$mensagem = str_replace('%fone%', $fone, $mensagem);
$mensagem = str_replace('%rg%', $rg, $mensagem);
$mensagem = str_replace('%cpf%', $cpf, $mensagem);
$mensagem = str_replace('%email%', $email, $mensagem);
$mensagem = str_replace('%destino%', $destino, $mensagem);
$mensagem = str_replace('%ida%', $ida, $mensagem);
$mensagem = str_replace('%volta%', $volta, $mensagem);
$mensagem = str_replace('%ausencia%', $ausencia->format('%R%a'), $mensagem);
$mensagem = str_replace('%obs%', $obs, $mensagem);
$mensagem = str_replace('%autorizado%', $autorizado, $mensagem);
$mensagem = str_replace('%dtAutorizado%', $dtAutorizado, $mensagem);

 
try {
     $mail->Host = 'mail.aniger.com.br'; // Endereço do servidor SMTP
     $mail->SMTPAuth   = true;  // Usar autenticação SMTP
     $mail->Port       = 587; //  Usar 587 porta SMTP
     $mail->Username = 'gabriel.hipolito'; // Usuário do servidor SMTP
     $mail->Password = 'Rmox@bj6'; // Senha do servidor SMTP
 
     //Define o remetente
     // =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=    
     $mail->SetFrom($email, $nome); //De:
     $mail->AddReplyTo($email, $nome); //Responder para:
     $mail->Subject = '=?utf-8?B?'.base64_encode($assunto).'?=';//Assunto do e-mail com codificação UTF-8
 
 
     //Define os destinatário(s)
     //=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=
     $mail->AddAddress($dest, 'Intranet');
 
     //Campos abaixo são opcionais 
     //=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=
     $mail->AddCC($email, $nome); // Copia para o solicitante
     //$mail->AddBCC('destinatario_oculto@dominio.com.br', 'Destinatario2`'); // Cópia Oculta
     //$mail->AddAttachment('images/phpmailer.gif');      // Adicionar um anexo
 
 
     //Define o corpo do email
    //  $mail->MsgHTML (); 
 
     ////Caso queira colocar o conteudo de um arquivo utilize o método abaixo ao invés da mensagem no corpo do e-mail.
     $mail->MsgHTML($mensagem);
 
     $mail->Send();
     echo "Mensagem enviada com sucesso</p>\n";
 
    //caso apresente algum erro é apresentado abaixo com essa exceção.
    }catch (phpmailerException $e) {
      echo $e->errorMessage(); //Mensagem de erro costumizada do PHPMailer
}
?>