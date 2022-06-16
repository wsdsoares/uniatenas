<!DOCTYPE html>
<html>
    <?php
    $this->load->view('templates/vestibularResultado/elements/head', $head);
    $this->load->view('templates/vestibularResultado/elements/js', $head);
    echo '<body id="page-top">';
    
    if ($menu !== NULL) {
       // $this->load->view('templates/vestibular/elements/menu', $menu);
    }
    
    $this->load->view($conteudo, $dados);

    if ($footer !== NULL) {
        $this->load->view('templates/vestibularResultado/elements/footer', $footer);
    }

 
    echo '</body>';
    ?>
</html>