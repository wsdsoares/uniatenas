<!DOCTYPE html>
<html>
    <?php
    $this->load->view('templates/vestibular/elements/head', $head);
    ?>
    <body id="page-top">
        <?php
        if ($menu !== NULL) {
            $this->load->view('templates/vestibular/elements/menu' . $menu);
        }
        
        $this->load->view($conteudo, $dados);

        if ($footer !== NULL) {
            $this->load->view('templates/vestibular/elements/footer', $footer);
        }
        
        $this->load->view('templates/vestibular/elements/'.$js);
        ?>
    </body>
</html>