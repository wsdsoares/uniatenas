<?php
$uricampus = $this->uri->segment(3);
?>
<section id="contact">
    <div class="container">
        <div class="section-header">
            <h4>Formulário <?php echo $campus->name . ' - ' . $campus->city . ' (' . $campus->uf . ')'; ?></h4>
        </div>

        <div class="row">
            <div class="col-md-6 col-sm-6 col-xs-12">
                <div class="row">
                   
                    <div class="col-xs-12">
                        <div class="well well-sm">
                            <h3><strong>INFORMAÇÕES NAPP</strong></h3>
                        </div>
                        <div class="row iconesFa">
                           
                            <div class="form-group" style="text-align: justify;">
                              O NAPP é o NÚCLEO DE APOIO PSICOPEDAGÓGICO,PROFISSIONAL E ACESSIBILIDADE 
                              que pautado em uma escuta acolhedora, um acompanhamento personalizado, o setor
                              te ajuda a enfrentar os desafios relacionados ao seu curso de graduação, além de
                              estar sempre disponível com o setor de orientação e de psicologia para te aconselhar e
                              acompanhar seu processo de ensino-aprendizagem.
                            </div>
                            
                        </div>
 <div class="col-xs-9">
                        <div class="embed-responsive embed-responsive-16by9">
                            <iframe class="embed-responsive-item" src="<?php echo $campus->mapsFrame ?>"  frameborder="0" style="border:0" allowfullscreen></iframe>
                        </div>
                    </div>
                    </div>
                </div>
            </div>

            <div class="col-md-6 col-sm-6 col-xs-12">
                <?php
                if ($msg = getMsg()):
                    echo $msg;
                endif;
                ?>

                <?php
                echo form_open("Site/contatonapp/$uricampus");
                ?>
                <div class="form-group">
                    <span>Nome</span>
                    <?php
                    echo form_input(array('name' => 'name', 'class' => 'form-control', 'placeholder' => "Nome"), set_value('name'));
                    ?>

                </div>
                <div class="form-group">
                    <span>Email</span>
                    <?php
                    echo form_input(array('name' => 'email', 'type' => 'email', 'class' => 'form-control', 'placeholder' => "E-mail"), set_value('email'));
                    ?>

                </div>
                <div class="form-group">
                    <span>Telefone</span>
                    <?php
                    echo form_input(array('name' => 'phone', 'class' => 'form-control', 'placeholder' => "Telefone"), set_value('phone'));
                    ?>
                </div>
                <div class="form-group">
                    <span>Mensagem</span>
                    <?php
                    echo form_textarea(array('name' => 'message', 'class' => 'form-control', 'placeholder' => "Mensagem"), set_value('message'));
                    ?>
                </div>
                <button class="btn btn-default" type="submit" name="button">
                    <i class="fa fa-paper-plane-o" aria-hidden="true"></i> Enviar
                </button>
                <?php
                echo form_close();
                ?>
            </div>
        </div>

    </div>
</section>