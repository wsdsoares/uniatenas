<!DOCTYPE html>
<html>
    <?php
    $this->load->view('templates/graduacao/elements/headCourse', $head);
    ?>
    <body id="page-top">
        
        <?php
        if ($menu !== NULL) {
            $this->load->view('templates/graduacao/elements/menu' . $menu);
        }

        $this->load->view($conteudo, $dados);
        if ($js !== NULL) {
            $this->load->view('templates/graduacao/elements/jsCourse'  );
        }
        
        if ($footer !== NULL) {
            //$this->load->view('templates/graduacao/elements/footer', $footer);
        }
        ?>
    </body>
</html>