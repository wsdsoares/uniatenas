<?php
if(isset($_POST['email']) && !empty($_POST['email'])){
$nome = addcslashes($_POST['name']);
$email =  addcslashes($_POST['email']);
$mensagem =  addcslashes($_POST['messagem']);

$to = "pdo.ha52@gmail.com";
$subject = "Resposta - O NAPP é o NÚCLEO DE APOIO PSICOPEDAGÓGICO,PROFISSIONAL E ACESSIBILIDADE";
$body = "Nome: ".$nome. "\r\n".
        "Email:".$email. "\r\n".
        "Mensagem:" .$mensagem;
 $header =  "From:resposta@uniatenas.edu.br"."\r\n". 
            "Reply-To".$email."\r\n".
            "X=Mailer:PHP/".phpversion(); 
             
 if(mail($to,$subject,$body,$header)){
     echo("Email enviado com sucesso!");
   redirect("");
 } else{
     echo("O Email não pode ser enviado");
 }    
}
?>