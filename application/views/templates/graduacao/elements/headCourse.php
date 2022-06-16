<!-- Muito pequeno até 750 
        pequeno 750 até 970px
        médio 970 até 1170px
        grande acima de 1170px;
        lg - Dispositivos grandes (desktops, >= 1200px)
        md - Dispositivos médios (desktops, >= 992px && < 1200px)
        sm - Dispositivos pequenos (tablets, >= 768px && < 992px)
        xs - Dispositivos extra pequenos (smartphones, < 768px)
-->

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!--title><?php //echo $titulo; ?></title-->
    
    <title><?php echo $head['title'];?></title>
    
    <link rel="shortcut icon" href="<?php echo base_url(); ?>assets/images/favicon.ico"/>
    <!-- Plugin css -->
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/font-awesome-4.7.0/css/font-awesome.min.css" media="all" />
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/Icon-font-7-stroke-PIXEDEN-v-1-2-0/assets/Pe-icon-7-stroke.css" media="all" />
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/css/bootstrap.min.css" media="all" />

    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/css/swiper.min.css"    media="all" />
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/css/lightcase.css"     media="all" />

    <!-- own style css -->
    <link rel="stylesheet" href="<?php echo base_url();?>assets/plugins/lightbox/dist/css/lightbox.min.css"/>
    
    
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/css/responsive.css"    media="all" />
    <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/style.css') . '?' . APP_VERSION_WEB; ?>"    media="all" />
    <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/wil.css') . '?' . APP_VERSION_WEB; ?>" media="all" />
    
    
    <script src="<?php echo base_url();?>assets/plugins/lightbox/dist/js/lightbox-plus-jquery.min.js"></script>
    
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js" type="text/javascript"></script>

    <script type="text/javascript" language="javascript">
        $(document).ready(function () {

            var _containerBtn = $('[data-container="botao-voltar"]');
            var _containerMenu = $('[data-container="menu"]');
            var _containerLink = $('[data-container="link"]');

            //Evento Scrool do menu
            _containerLink.click(function () {

                var _sessao = $(this).data('link');

                function Posicao(Seletor) {

                    var _alturaMenu = parseInt(109);
                    var _posicao = parseInt(($('[data-container="' + Seletor + '"]').position().top) - _alturaMenu);

                    return _posicao;
                }

                //Evento Animação
                $('html,body').animate({scrollTop: Posicao(_sessao)}, 10);

                return false;
            });




            $('#link').on('change', function () {
                var url = $(this).val();
                if (url) {
                    window.open(url, "_self");
                }
                return false;
            });



        });

    </script>
</head>
