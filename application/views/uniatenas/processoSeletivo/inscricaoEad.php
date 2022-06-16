<?php
$mes = date('m');
$ano = date('Y');
if ($mes >= 1 and $mes <= 4):
    $semestre = 1;
endif;
if ($mes > 4 and $mes <= 7):
    $semestre = 2;
endif;
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <link rel="shortcut icon" href="img/favicon.ico" />
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
        <title>UniAtenas - Aqui começa uma nova história.</title>

        <!-- Bootstrap -->
        <link type="text/css" rel="stylesheet" href="<?php echo base_url(); ?>assets/components/bootstrap-3.3.7/css/bootstrap.css" media="all"/>
        <link href="<?php echo base_url(); ?>assets/css/style_cadastro.css" rel="stylesheet">
        <link href="<?php echo base_url(); ?>assets/font-awesome/css/font-awesome.css"  type="text/css" rel="stylesheet">

        <script type='text/javascript' src='//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js'></script>

        <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
          <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
          <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <![endif]-->
    </head>
    <body>  
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12 topo ">
                    <div class="container">
                        <div class="col-md-2">
                            <a href="http://www.faculdadeatenas.edu.br/Faculdade/">
                                <img src="<?php echo base_url(); ?>assets/img/logo.png" class="img-responsive"/>
                            </a>
                        </div>

                        <div class="col-md-10">
                            <h1>Vestibular - <?php //echo $semestre;?>º Semestre de <?php //aecho $ano;?></h1>
                            <div class="info"><a href="" target="_blank"><p> UniAtenas -  Aqui começa uma nova história. </p></a></div>
                        </div>
                    </div>
                </div>

            </div> 
            <div class="container">
                <div class="row">

                    <div class="col-md-12">
                        {conteudo}
                    </div>
                </div>
            </div>
        </div>


        <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
        <!-- Include all compiled plugins (below), or include individual files as needed -->
        <script src="<?php echo base_url(); ?>assets/js/bootstrap.min.js"></script>
    </body>
</html>