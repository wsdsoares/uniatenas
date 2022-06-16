<!DOCTYPE html>
<html>
    <?php $this->load->view('templates/elements/head', $titulo); ?>
    <body>
        <?php $this->load->view('templates/elements/header', $dados); ?>
        <?php $this->load->view($conteudo, $dados); ?>
        <?php $this->load->view('templates/elements/footer', $dados); ?>
    </body>

</html>

