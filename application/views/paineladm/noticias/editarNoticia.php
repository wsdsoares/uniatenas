<?php
$id = $this->uri->segment(3);

?>
<div class="row clearfix">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <div class="card">
            <div class="header">
                <h2>
                    Cadastro de Notícias
                </h2>

            </div>
            <div class="body">
                <?php
                if ($msg = get_msg()):
                    echo $msg;
                endif;
                ?>
                <?php
                echo form_open_multipart('Noticias/editar/'.$id);
                ?>

                <div class="row clearfix">
                </div>
                <div class="row clearfix">
                    <div class="col-sm-12">
                        <div class="form-group">
                            <div class="form-line">
                                <label for="title">Título</label>
                                <?php
                                echo form_input(array('name' => "title", 'type' => 'text', 'class' => 'form-control', 'placeholder' => 'Titúlo da notícia'), set_value('title', toHtml($news->title)), 'autofocus required');
                                ?>
                            </div>
                        </div>
                    </div>


                </div>


                <div class="row clearfix">
                    <div class="col-sm-5">
                        <label for="campusid">Campus</label>

                        <?php
                        $optionLocal[0] = '-- Selecione --';
                        foreach ($campus as $local) {
                            $optionLocal[$local->id] = $local->city;
                        }
                        echo form_dropdown('campusid', $optionLocal, set_value('campusid',$news->campusid), array('class' => 'form-control show-tick')); ?>
                    </div>
                    <div class="col-sm-7">
                        <div class="form-group">
                            <div class="form-line">
                                <label for="keywords">Palavras-chave </label>
                                <small>Ex. (Educação;Evento;UniAtenas)</small>
                                <?php
                                echo form_input(array('name' => "keywords", 'type' => 'text', 'class' => 'form-control', 'placeholder' => 'Coloque as palavras chave separadas por ponto e vírgula'), set_value('keywords', $news->keywords), 'required');
                                ?>
                            </div>
                        </div>
                    </div>

                </div>

                <div class="row clearfix">
                    <div class="col-sm-2">
                        <div class="form-group">
                            <div class="form-line ">
                                <label for="title ">Capa Atual</label>
                                <img src="<?php echo base_url(verifyImg($news->img_destaque)); ?>" class="thumbnail" id="myImg<?php echo $news->id; ?>"/>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-5">
                            <span> Caso, deseje trocar a imagem destaque, selecione a imagem.</span>
                        </div>
                        <div class="col-sm-7">
                            <div class="form-group">
                                <div class="form-line">
                                    <?php echo form_upload(array('name' => 'files', 'class' => 'input-group'), set_value('files')); ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-sm-12">
                    <?php
                    echo form_textarea('description', to_html(set_value('description', toHtml($news->description))));
                    ?>
                </div>
                <script type="text/javascript">
                    // replace: substitui o formato padrão do textarea (descricao)
                    // e aplica as configurações do CKEDitor através do arquivo config.js
                    var editor = CKEDITOR.replace('description', {customConfig: 'config.js'});
                </script>


                <div class="row clearfix">
                    <div class="col-md-12">
                        <?php echo form_submit(array('name' => 'submit', 'class' => 'btn btn-lg btn-primary m-t-15 m-r-15 waves-effect'), 'SALVAR'); ?>
                        <?php
                        echo anchor('Noticias/noticias', '
                            <i class = "material-icons">
                            assignment_return
                            </i> <span>Voltar</span>', array('class' => 'btn btn-warning m-t-15 waves-effect'));
                        ?>
                    </div>
                </div>

                <?php
                echo form_close();
                ?>
            </div>
        </div>
    </div>
</div>
<div id="myModal" class="modal">
    <span class="close">Fechar</span>
    <img class="modal-content thumbnail" id="img01">
    <div id="caption"></div>
</div>
<style>
    /* Style the Image Used to Trigger the Modal */
    #myImg {
        border-radius: 5px;
        cursor: pointer;
        transition: 0.3s;
    }

    #myImg:hover {
        opacity: 0.7;
    }

    /* The Modal (background) */
    .modal {
        display: none; /* Hidden by default */
        /*        position: fixed; /* Stay in place */
        z-index: 1; /* Sit on top */
        padding-top: 100px; /* Location of the box */
        left: 0;
        top: 0;
        width: 100%; /* Full width */
        height: 100%; /* Full height */
        overflow: auto; /* Enable scroll if needed */
        background-color: rgb(0, 0, 0); /* Fallback color */
        background-color: rgba(0, 0, 0, 0.9); /* Black w/ opacity */
    }

    /* Modal Content (Image) */
    .modal-content {
        margin: auto;
        display: block;
        width: 80%;
        max-width: 700px;
    }

    /* Caption of Modal Image (Image Text) - Same Width as the Image */
    #caption {
        margin: auto;
        display: block;
        width: 80%;
        max-width: 700px;
        text-align: center;
        color: #ccc;
        padding: 10px 0;
        height: 150px;
    }

    /* Add Animation - Zoom in the Modal */
    .modal-content, #caption {
        animation-name: zoom;
        animation-duration: 0.6s;
    }

    @keyframes zoom {
        from {
            transform: scale(0)
        }
        to {
            transform: scale(1)
        }
    }

    /* The Close Button */
    .close {
        /*position: absolute;*/
        margin-right: 30px;
        top: 15px;
        /*left: 50px;*/
        color: red;
        font-size: 40px;
        font-weight: bold;
        transition: 0.3s;
    }

    .close:hover,
    .close:focus {
        color: #ffffff;
        text-decoration: none;
        cursor: pointer;
    }

    /* 100% Image Width on Smaller Screens */
    @media only screen and (max-width: 700px) {
        .modal-content {
            width: 100%;
        }
    }
</style>

<script>
    // Get the modal
    var modal = document.getElementById('myModal');

    // Get the image and insert it inside the modal - use its "alt" text as a caption
    var img = document.getElementById('myImg');
    var modalImg = document.getElementById("img01");
    var captionText = document.getElementById("caption");
    img.onclick = function () {
        modal.style.display = "block";
        modalImg.src = this.src;
        captionText.innerHTML = this.alt;
    }

    // Get the <span> element that closes the modal
    var span = document.getElementsByClassName("close")[0];

    // When the user clicks on <span> (x), close the modal
    span.onclick = function () {
        modal.style.display = "none";
    }
</script>








