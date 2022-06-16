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

    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-169618030-1"></script>
    <script>
        window.dataLayer = window.dataLayer || [];
        function gtag(){dataLayer.push(arguments);}
        gtag('js', new Date());

        gtag('config', 'UA-169618030-1');
    </script>

    <!-- Javosite chat
    <script src="//code.jivosite.com/widget/qqSFWyV4m0" async></script>
-->

    <!-- Facebook Pixel Code -->
    <script>
        !function(f,b,e,v,n,t,s)
        {if(f.fbq)return;n=f.fbq=function(){n.callMethod?
            n.callMethod.apply(n,arguments):n.queue.push(arguments)};
            if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0';
            n.queue=[];t=b.createElement(e);t.async=!0;
            t.src=v;s=b.getElementsByTagName(e)[0];
            s.parentNode.insertBefore(t,s)}(window,document,'script',
            'https://connect.facebook.net/en_US/fbevents.js');
        fbq('init', '1147667018954085');
        fbq('track', 'PageView');
    </script>
    <noscript>
        <img height="1" width="1"
             src="https://www.facebook.com/tr?id=1147667018954085&ev=PageView
&noscript=1"/>
    </noscript>
    <!-- End Facebook Pixel Code -->

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title><?php echo $head['title']; ?></title>

    <link rel="shortcut icon" href="<?php echo base_url(); ?>assets/images/favicon.ico"/>
    <!-- Plugin css -->

    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/Icon-font-7-stroke-PIXEDEN-v-1-2-0/assets/Pe-icon-7-stroke.css" media="all" />
    <!--link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/css/bootstrap.min.css" media="all" /-->
    <link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" media="all" />
    <link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" media="all" />

    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/css/swiper.min.css"    media="all" />
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/css/lightcase.css"     media="all" />

    <!-- own style css -->
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/plugins/lightbox/dist/css/lightbox.min.css"/>


    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/css/responsive.css"    media="all" />
    <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/style.css') . '?' . APP_VERSION_WEB; ?>"    media="all" />

    <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/wil.css') . '?' . APP_VERSION_WEB; ?>" media="all" />
    <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/mega-menu.css') . '?' . APP_VERSION_WEB; ?>" media="all" />
    <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/menuWil.css') . '?' . APP_VERSION_WEB; ?>"    media="all" />


    <script src="<?php echo base_url(); ?>assets/plugins/lightbox/dist/js/lightbox-plus-jquery.min.js"></script>


    <script src="<?php echo base_url(); ?>assets/plugins/vestibular/vendor/jquery/jquery.min.js" type="text/javascript"></script>

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
    <script type="text/javascript" language="javascript">
        $(function () {
            $('.toggle-menu').click(function () {
                $('.exo-menu').toggleClass('display');

            });

        });

    </script>
    <script>
        $(document).ready(function(){
            $(".dropdown").hover(
                function() {
                    $('.dropdown-menu', this).not('.in .dropdown-menu').stop(true,true).fadeIn("400");
                    $(this).toggleClass('open');
                },
                function() {
                    $('.dropdown-menu', this).not('.in .dropdown-menu').stop(true,true).fadeOut("400");
                    $(this).toggleClass('open');
                }
            );
        });
    </script>


    <link href='https://fonts.googleapis.com/css?family=Roboto:400,300,700' rel='stylesheet' type='text/css'>

    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.0/css/all.css" integrity="sha384-lZN37f5QGtY3VHgisS14W3ExzMWZxybE1SJSEsQp9S+oqd12jhcu+A56Ebc1zFSJ" crossorigin="anonymous">
    <?php if (isset($head['css'])) { ?>
    <link rel="stylesheet" href="<?php echo $head['css']?>">
        <?php
    }
    ?>

</head>
