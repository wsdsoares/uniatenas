<?php
$uricampus = $this->uri->segment(3);
?>
<script src="//code.jquery.com/jquery-3.3.1.min.js"></script>
<?php
//TO-DO import the fancybox@3 in the project
?>
<style>
    .thumbnail {
        min-height: 210px !important;
    }
    .fancybox img{
        max-height: 150px;
    }
</style>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/fancyapps/fancybox@3.5.7/dist/jquery.fancybox.min.css" />
<script src="https://cdn.jsdelivr.net/gh/fancyapps/fancybox@3.5.7/dist/jquery.fancybox.min.js"></script>
<div class="container">
    <div class="section-header text-center">
        <h3> Galeria de fotos do curso de <?php echo $cursos->name;?> </h3>
    </div>
    <div class="btn-back">
        <?php echo anchor('graduacao/presencial/' . $uricampus.'/'.$cursos->idCourseCampus, '
            Voltar', array('class' => "btn btn-danger"));
        ?>
    </div>
    <br/>
    <div class="row">
        <div class='list-group gallery'>
            <?php

            for ($i = 0; $i < count($dados['photos']); $i++) {
                ?>
                <div class='col-sm-4 col-xs-6 col-md-3 col-lg-3'>
                    <a class="thumbnail fancybox" data-fancybox="gallery" href="<?php echo base_url($dados['photos'][$i]->files); ?>">
                        <img class="img-responsive" alt="" src="<?php echo base_url($dados['photos'][$i]->files); ?>" />
                        <div class='text-center'>
                            <small class='text-muted'>Foto  - <?php echo $dados['photos'][$i]->title; ?></small>
                        </div> 
                    </a>
                </div>
                <?php
            }


            ?>
            <br>
        </div> 
    </div>
</div> 
