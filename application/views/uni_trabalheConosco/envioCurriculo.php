<section>
    <?php
    $uricampus =  $this->uri->segment(3);
    //$vagaTipo = !empty($this->uri->segment(4)) ? 'Trabalhe Conosco' : 'Envio de Currículo';

    $numberVaga = $this->uri->segment(4);

    ?>

    <div class="container">
        <h3>
            <?php
            if($numberVaga == 1){
                echo 'Envio de currículo';
            }else{
                echo 'Trabalhe Conosco - Envio de currículo para vaga específica';

            }
            ?>
        </h3>
        <?php
        if ($msg = getMsg()) :
            echo $msg;
        endif;
        $vaga = $this->uri->segment(3);

        if($vaga != NULL){

        }else{
            $vaga ='1';
        }
        ?>
        <?php
        echo form_open_multipart("site/envioCurriculo/$uricampus/$numberVaga");
        ?>
        <span>Dados Pessoais</span>
        <div class="row">
            <div class="col-md-8 col-xs-12">
                <div class="dados_pessoais-vagas">
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="name" class="form-label">Nome</label>
                                <?php echo form_input(array('name' => 'name', 'class' => 'form-control', 'placeholder' => 'Nome Completo...'), set_value('name')); ?>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label class="control-label" for="email">Email:</label>
                                <?php echo form_input(array('name' => 'email', 'type' => 'email', 'class' => 'form-control', 'placeholder' => 'E-mail principal.'), set_value('email')); ?>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-3">
                            <div class="form-group">
                                <label class="control-label" for="sexo">Gênero</label>
                                <div class="checkbox">
                                    <div>
                                        <?php echo form_radio('gender', 'm', set_radio('gender', 'm')); ?>
                                        Masculino
                                    </div>
                                    <div>
                                        <?php echo form_radio('gender', 'f', set_radio('gender', 'f')); ?>
                                        Feminino
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-5">
                            <div class="form-group">
                                <div class="col-sm-4">
                                    <label class="control-label" for="email">DDD</label>
                                    <?php echo form_input(array('name' => 'areacodecelphone', 'class' => 'form-control', 'placeholder' => 'DDD'), set_value('areacodecelphone')); ?>
                                </div>
                                <div class="col-sm-8">
                                    <label class="control-label" for="email">Celular</label>
                                    <?php echo form_input(array('name' => 'celphone', 'class' => 'form-control', 'placeholder' => 'Nº Telefone..'), set_value('celphone')); ?>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-md-12">
                                    <div class="checkbox">
                                        <label>
                                            <?php echo form_checkbox('whatsapp', '1', set_checkbox('whatsapp', '1')); ?>
                                            * Esse é meu número do Whatsapp
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <div class="col-sm-4">
                                    <label class="control-label" for="email">DDD</label>
                                    <?php echo form_input(array('name' => 'areacode', 'class' => 'form-control', 'placeholder' => 'DDD'), set_value('areacode')); ?>
                                </div>
                                <div class="col-sm-8">
                                    <label class="control-label" for="email">Telefone Fixo</label>
                                    <?php echo form_input(array('name' => 'phone', 'class' => 'form-control', 'placeholder' => 'Nº Telefone..'), set_value('phone')); ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-inline">
                                <label>Escolaridade</label>

                                <?php
                                foreach ($escolaridades as $category) {
                                    $option[$category->id] = $category->name;
                                }
                                echo form_dropdown('schoolingid', $option, set_value('schoolingid'), array('class' => 'form-control'));
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4 col-xs-12">
                <div class="dados_pessoais-vagas">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group">

                                <label class="control-label" for="endereco">Endereço</label>

                                <?php echo form_input(array('name' => 'address', 'class' => 'form-control', 'placeholder' => 'Endereço...'), set_value('address')); ?>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group">

                                <label class="control-label" for="email">Cidade</label>

                                <?php echo form_input(array('name' => 'city', 'class' => 'form-control', 'placeholder' => 'Cidade...'), set_value('city')); ?>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group">

                                <label class="control-label" for="state">Estado</label>
                                <?php
                                $estados = array(
                                    '0' => '-- Selecione --',
                                    'AC' => 'Acre',
                                    'AL' => 'Alagoas',
                                    'AP' => 'Amapá',
                                    'AM' => 'Amazonas',
                                    'BA' => 'Bahia',
                                    'CE' => 'Ceará',
                                    'DF' => 'Distrito Federal',
                                    'ES' => 'Espírito Santo',
                                    'GO' => 'Goiás',
                                    'MA' => 'Maranhão',
                                    'MT' => 'Mato Grosso',
                                    'MS' => 'Mato Grosso do Sul',
                                    'MG' => 'Minas Gerais',
                                    'PA' => 'Pará',
                                    'PB' => 'Paraíba',
                                    'PR' => 'Paraná',
                                    'PE' => 'Pernambuco',
                                    'PI' => 'Piauí',
                                    'RJ' => 'Rio de Janeiro',
                                    'RN' => 'Rio Grande do Norte',
                                    'RS' => 'Rio Grande do Sul',
                                    'RO' => 'Rondônia',
                                    'RR' => 'Roraima',
                                    'SC' => 'Santa Catarina',
                                    'SP' => 'São Paulo',
                                    'SE' => 'Sergipe',
                                    'TO' => 'Tocantins',
                                );
                                ?>
                                <?php
                                echo form_dropdown('state', $estados, set_value('state'), array('class' => 'form-control'));
                                ?>

                            </div>
                        </div>

                    </div>
                </div>

            </div>
        </div>
        <?php
        if ($numberVaga == 1) {
            ?>
            <div class="row">
                <span>Informações sobre seu interesse</span>
                <div class="infvagas">

                    <div class="row">
                        <label class="col-sm-2" for="campusid">Campus de Interesse</label>
                        <div class="col-sm-4">
                            <?php
                            $optionLocal[0] = '-- Selecione --';
                            $optionLocal[99] = 'Todos os campus';
                            foreach ($localidades as $local) {
                                $optionLocal[$local->id] = $local->city;
                            }
                            echo form_dropdown('campusid', $optionLocal, set_value('campusid'), array('class' => 'form-control')); ?>
                        </div>
                        <div class="col-md-6">
                            <label class="col-sm-2" for="typeResume">Tipo de Currículo</label>
                            <div class="checkbox">
                                <label>
                                    <?php echo form_radio('typeResume', 'corpoDocente', set_radio('typeResume', 'corpoDocente')); ?>
                                    Corpo Docente
                                </label>
                                <label>
                                    <?php echo form_radio('typeResume', 'corpoTecnicoAdministativo', set_radio('typeResume', 'corpoTecnicoAdministativo')); ?>
                                    Corpo Técnico Administrativo
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <?php } else { ?>
            <div class="row">
                <span>Informações sobre a Vaga</span>
                <div class="infvagas">
                    <div class="row">

                        <div class="col-sm-9">
                            Você está se candidando à vaga de <b>
                                <?php echo $infoVaga->name; ?></b>, para a área/setor <b>
                                <?php echo $infoVaga->name_area; ?></b>, do campus <b>
                                <?php echo $infoVaga->campus_name; ?></b>.
                        </div>
                        <?php
                        if ($infoVaga->files != null) { ?>
                            <div class="col-sm-3">
                                <?php
                                echo anchor(base_url() . $infoVaga->files, '<span class="btnEdital">Edital</span></a>', array('target' => '_blank'));
                                ?>
                            </div>
                            <?php

                        } ?>

                    </div>
                </div>
            </div>
            <?php

        }
        ?>

        <div class="row">
            <span>Currículo</span>
            <div class="infvagasCurriculo">
                <div class="form-group">
                    <label for="">Arquivos</label>
                    <?php echo form_upload(array('name' => 'files', 'class' => 'input-group', 'accept' => 'application/pdf'), set_value('arquivo')); ?>

                    <p class="help-block">Envie-nos o seu currículo em PDF.</p>
                </div>
            </div>
            <div class="catagoriesBtn">
            <?php echo form_submit('enviar', 'enviar', array('class' => 'btns ','type'=>'button')); ?>
            </div>
            <?php
            echo form_close();
            ?>

        </div>
    </div>
</section>
<br/>

<style>

    .catagoriesBtn a {
        text-align: center;
        font-weight: 500;
        color: #696969;
        text-transform: capitalize;
    }


    .catagoriesBtn:hover a {
        color: #f4630b;
    }
</style>