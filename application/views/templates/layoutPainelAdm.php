<!DOCTYPE html>
<html>

<head>
  <title><?php echo $titulo; ?></title>

  <meta charset="UTF-8">
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

  <?php
        $pagina = $this->uri->segment(2);

        if ($dados['tipo'] == 'revistas' or $pagina == 'areasSetores' or $dados['tipo'] == 'tabelaDatatable') {
        // if ($dados['tipo'] === 'tabelaDatatable') {
            $this->load->view('templates/elementsPainel/heads/head_dataTable');
        } else {
            $this->load->view('templates/elementsPainel/head');
        }
        ?>
  <link href="<?php echo base_url(); ?>assets/painel/css/painelWil.css" rel="stylesheet" />

</head>

<body class="theme-red">
  <?php $this->load->view('templates/elementsPainel/header');?>
  <section class="content">
    <?php $this->load->view($conteudo, $dados); ?>
  </section>
  <?php
    if ($dados['tipo'] == 'revistas' or $dados['tipo'] == 'tabelaDatatable') {
    // if ($dados['tipo'] == 'revistas' or $pagina == 'areasSetores') {
        $this->load->view('templates/elementsPainel/footers/footerDatatable');
    }else{
        $this->load->view('templates/elementsPainel/footer'); 
    }
    ?>
</body>

</html>