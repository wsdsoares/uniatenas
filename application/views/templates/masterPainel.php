<!DOCTYPE html>
<html>
    <?php
    if (isset($head['head_conteudo']) and $head['head_conteudo'] !== NULL and ! empty($head['head_conteudo'])) {
        $this->load->view($head['head_conteudo'], $head);
    } else {
        $this->load->view('templates/elementsPainel/headPainelMaster', $head);
    }
    ?>
    <body class="theme-red">
        <?php
        if (isset($menu) and $menu !== NULL and ! empty($menu)) {
            $this->load->view("$menu");
        } else {
            $this->load->view("templates/elementsPainel/header");
        }
        ?>
        <section class="content">
            <?php
            $this->load->view($conteudo, $dados);
            ?>
        </section>
        <?php
        if ($js !== NULL) {
            $this->load->view('templates/elementsPainel/jsPainelMaster');
        }
        ?>
    </body>
</html>





