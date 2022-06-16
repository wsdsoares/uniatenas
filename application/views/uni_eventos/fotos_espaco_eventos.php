<?php
$uricampus = $this->uri->segment(3);
?>
<script src="//code.jquery.com/jquery-3.3.1.min.js"></script>
<?php
//TO-DO import the fancybox@3 in the project
?>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/fancyapps/fancybox@3.5.7/dist/jquery.fancybox.min.css" />
<script src="https://cdn.jsdelivr.net/gh/fancyapps/fancybox@3.5.7/dist/jquery.fancybox.min.js"></script>
<div class="container">
    <div class="section-header text-center">
        <h3>Espaço para eventos - Galeria de Fotos</h3>
    </div>
    <div class="btn-back">
        <?php echo anchor('site/espaco_eventos/' . $uricampus, '
            Voltar', array('class' => "btn btn-danger"));
        ?>
    </div>
    <br/>
    <div class="row">
        <div class='list-group gallery'>
            <?php
            for ($i = 0; $i < count($dados['fotosEspaco'][0]['photos']); $i++) {
                ?>
                <div class='col-sm-4 col-xs-6 col-md-3 col-lg-3'>
                    <a class="thumbnail fancybox" data-fancybox="gallery" href="<?php echo base_url($dados['fotosEspaco'][0]['photos'][$i]->files); ?>">
                        <img class="img-responsive" alt="" src="<?php echo base_url($dados['fotosEspaco'][0]['photos'][$i]->files); ?>" />
                        <div class='text-center'>
                            <small class='text-muted'>Foto  - <?php echo $dados['fotosEspaco'][0]['name']; ?></small>
                        </div> 
                    </a>
                </div> 
                <?php
            }
            ?>
        </div> 
    </div>
</div> 
