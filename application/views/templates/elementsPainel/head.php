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
    <script>var clicky_site_ids = clicky_site_ids || []; clicky_site_ids.push(101248580);</script>
    <script async src="//static.getclicky.com/js"></script>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!--title><?php //echo $titulo;  ?></title-->

    <title><?php echo $head['title']; ?></title>
    <!-- Favicon-->
    <link rel="icon" href="<?php echo base_url(); ?>assets/images/favicon.ico" type="image/x-icon">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Roboto:400,700&subset=latin,cyrillic-ext" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet" type="text/css">

    <!-- Bootstrap Core Css -->
    <link href="<?php echo base_url(); ?>assets/painel/plugins/bootstrap/css/bootstrap.css" rel="stylesheet">

    <!-- Waves Effect Css -->
    <link href="<?php echo base_url(); ?>assets/painel/plugins/node-waves/waves.css" rel="stylesheet" />

    <!-- Animation Css -->
    <link href="<?php echo base_url(); ?>assets/painel/plugins/animate-css/animate.css" rel="stylesheet" />

    <!-- Bootstrap Material Datetime Picker Css -->
    <link href="<?php echo base_url(); ?>assets/painel/plugins/bootstrap-material-datetimepicker/css/bootstrap-material-datetimepicker.css" rel="stylesheet" />

    <!-- Wait Me Css -->
    <link href="<?php echo base_url(); ?>assets/painel/plugins/waitme/waitMe.css" rel="stylesheet" />


    <!-- JQuery DataTable Css -->
    <link href="<?php echo base_url(); ?>assets/painel/plugins/jquery-datatable/skin/bootstrap/css/dataTables.bootstrap.css" rel="stylesheet">


    <link href="<?php echo base_url(); ?>assets/painel/plugins/bootstrap-select/css/bootstrap-select.css" rel="stylesheet" type="text/css"  />

    <!-- Custom Css -->
    <link href="<?php echo base_url(); ?>assets/painel/css/style.css" rel="stylesheet">


    <!-- AdminBSB Themes. You can choose a theme from css/themes instead of get all themes -->
    <link href="<?php echo base_url(); ?>assets/painel/css/themes/all-themes.css" rel="stylesheet" />


    <link href="<?php echo base_url(); ?>assets/painel/css/painelWil.css" rel="stylesheet">

    <script src='<?php echo base_url(); ?>assets/painel/plugins/ckeditor/ckeditor.js'></script>

    <script type="text/javascript">
        // replace: substitui o formato padrão do textarea (descricao)
        // e aplica as configurações do CKEDitor através do arquivo config.js 
        var editor = CKEDITOR.replace('descrpition', {customConfig: '<?php echo base_url(); ?>assets/painel/plugins/ckeditor/config.js'});
    </script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
    <script src='<?php echo base_url(); ?>assets/painel/plugins-2/ckeditor/ckeditor.js'></script>
    <script src='<?php echo base_url(); ?>assets/painel/plugins-2/ckeditor/adapters/jquery.js'></script>

</head>
