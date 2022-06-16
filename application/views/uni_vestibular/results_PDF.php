<!DOCTYPE HTML>
<html lang="pt-br">

<style>
    @page {
        margin: 0in;
    }
    .corpo {
        background: url('<?php echo $dados['img_fundo'];?>') no-repeat;
        background-size: cover;
        height: 100%;
        padding-left: 100px;
        padding-right: 100px;
    }

    .corpo p {
        background: #ffffff;
        padding: 20px;
    }

    .nameCandidato {
        color: #000000;
        font-weight: bold;
        font-size: 23px;
        text-align: center;
    }

    span.autentication {
        font-size: 12px;
        color: #446a7b;
        text-align: center;
    }
</style>
<head>
    <meta charset="UTF-8">
    <link rel="shortcut icon" href="http://www.atenas.edu.br/uniatenas/assets/images/favicon.ico"/>
    <title><?php echo $dados['titulo']; ?></title>
</head>
<body>
<div class="corpo">
    <br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>
    <p class="nameCandidato" style="text-align: center;">
        <span><?php echo $dados['infoCandidado']; ?> <br> <?php echo $dados['nome']; ?></span>
    </p>
    <br>
    <br><br>
    <span class="autentication">
    <?php
    $str = $dados['posicaoInscricaoCpf'];
    echo base64_encode($str);

    ?>
    </span>
</div>

</body>
</html>