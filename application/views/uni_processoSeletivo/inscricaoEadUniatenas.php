<?php
$tipo = $this->uri->segment(3);
$curso = $this->uri->segment(4);
/*echo '<pre>';
print_r($cursoEad);
echo '</pre>';
*/

?>
<div class="image-container set-full-height" style="background-image: url('./../../../assets/images/img_wizard/wizard.jpg')">

    <!--   Big container   -->
    <div class="container">

        <div class="row">
            <div class="col-sm-8 col-sm-offset-2">

                <!--      Wizard container        -->
                <div class="wizard-container">

                    <div class="card wizard-card" data-color="orange" id="wizardProfile">
                        <?php
                        echo form_open('Site/InscricaoEad/' . $tipo . '/' . $curso);
                        ?>

                        <div class="wizard-header">
                            <?php
                            if ($msg = getMsg()):
                                echo $msg;
                            endif;
                            ?>
                            <h4>
                                Conte-nos mais sobre você<br>

                                </h3>
                                </div>

                                <div class="wizard-navigation">
                                    <ul>
                                        <li><a href="#about" data-toggle="tab">Sobre Você</a></li>
                                        <li><a href="#account" data-toggle="tab">Curso</a></li>
                                        <li><a href="#address" data-toggle="tab">Endereço</a></li>

                                    </ul>

                                </div>

                                <div class="tab-content">
                                    <div class="tab-pane" id="about">
                                        <div class="row">
                                            <h4 class="info-text"> Vamos dar início ao preenchimento dos seus dados para Inscrição.</h4>

                                            <div class="col-sm-10 col-sm-offset-1">
                                                <div class="form-group">
                                                    <label>Nome Completo<small>(Obrigatório)</small></label>
                                                    <?php echo form_input(array('name' => 'nome', 'class' => 'form-control', 'placeholder' => "Nome Completo..."), set_value('nome')); ?>
                                                </div>
                                                <div class="form-group">
                                                    <label>CPF<small>(Obrigatório)</small></label>
                                                    <?php echo form_input(array('name' => 'cpf', 'class' => 'form-control', 'placeholder' => "CPF"), set_value('cpf')); ?>

                                                </div>
                                                <div class="form-group">
                                                    <label>Telefone Fixo</label>
                                                    <?php echo form_input(array('name' => 'telefone', 'class' => 'form-control', 'placeholder' => "(XX)xxxxx-xxxx"), set_value('telefone')); ?>
                                                </div>
                                                <div class="form-group">
                                                    <label>Celular <small>(Obrigatório)</small></label>
                                                    <?php echo form_input(array('name' => 'celular', 'class' => 'form-control', 'placeholder' => "(XX)xxxxx-xxxx"), set_value('celular')); ?>
                                                </div>
                                                <div class="form-group">
                                                    <label>Email <small>(Obrigatório)</small></label>
                                                    <?php echo form_input(array('name' => 'email', 'class' => 'form-control', 'placeholder' => "seu@email.com"), set_value('email')); ?>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                    <div class="tab-pane" id="account">
                                        <div class="row">
                                            <div class="col-sm-12">
                                                <h4 class="info-text"> Qual curso em EaD deseja fazer? </h4>
                                            </div>


                                            <div class="col-sm-12">
                                                <div class="form-group">
                                                    <label>Curso EaD UniAtenas</label><br>
                                                    <select name="courses_id" class="form-control">
                                                        <?php
                                                        $display = "style='display:none;'";
                                                        if (isset($curso)) {
                                                            ?>
                                                            <option value = "<?php echo $cursoEad->id; ?>" selected = "selected"> <?php echo $cursoEad->name; ?></option>
                                                            <?php
                                                        } else {
                                                            ?>
                                                            <option value="0" selected="selected">-- Selecione --</option>
                                                            <?php
                                                        }
                                                        foreach ($cursos as $item) {
                                                            if ($dados_curso->id == $item->id) {
                                                                echo '<option value="' . $item->id . '" ' . set_select('courses_id', $item->id) . ' ' . $display . '>' . $item->name . '</option>';
                                                            } else {
                                                                echo '<option value="' . $item->id . '" ' . set_select('courses_id', $item->id) . '>' . $item->name . '</option>';
                                                            }
                                                        }
                                                        ?>

                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="tab-pane" id="address">
                                        <div class="row">
                                            <div class="col-sm-12">
                                                <h4 class="info-text"> Você mora onde? </h4>
                                            </div>
                                            <div class="col-sm-7 col-sm-offset-1">
                                                <div class="form-group">
                                                    <label>Endereço</label>
                                                    <?php echo form_input(array('name' => 'endereco', 'class' => 'form-control', 'placeholder' => "Qual seu endereço?"), set_value('endereco')); ?>
                                                </div>
                                            </div>
                                            <div class="col-sm-3">
                                                <div class="form-group">
                                                    <label>Número</label>
                                                    <?php echo form_input(array('name' => 'numero', 'class' => 'form-control', 'placeholder' => "Número?"), set_value('numero')); ?>
                                                </div>
                                            </div>

                                            <div class="col-sm-4 col-sm-offset-1">
                                                <div class="form-group">
                                                    <label>Bairro</label>
                                                    <?php echo form_input(array('name' => 'bairro', 'class' => 'form-control', 'placeholder' => "Qual seu bairro ?"), set_value('bairro')); ?>
                                                </div>
                                            </div>
                                            <div class="col-sm-4 ">
                                                <div class="form-group">
                                                    <label>Cidade</label>
                                                    <?php echo form_input(array('name' => 'cidade', 'class' => 'form-control', 'placeholder' => "Qual a cidade onde mora ?"), set_value('cidade')); ?>
                                                </div>
                                            </div>
                                            <div class="col-sm-4 col-sm-offset-1">
                                                <div class="form-group">
                                                    <label>CEP</label>
                                                    <?php echo form_input(array('name' => 'cep', 'class' => 'form-control', 'placeholder' => "Você sabe seu CEP? Informe-o"), set_value('cep')); ?>
                                                </div>
                                            </div>
                                            <div class="col-sm-3 ">
                                                <div class="form-group">
                                                    <label>Estado</label><br>
                                                    <select name="uf" class="form-control">
                                                        <option value="0" selected="selected">-- Selecione --</option>
                                                        <option value="AC">Acre</option>
                                                        <option value="AL">Alagoas</option>
                                                        <option value="AP">Amapá</option>
                                                        <option value="AM">Amazonas</option>
                                                        <option value="BA">Bahia</option>
                                                        <option value="CE">Ceará</option>
                                                        <option value="DF">Distrito Federal</option>
                                                        <option value="ES">Espírito Santo</option>
                                                        <option value="GO">Goiás</option>
                                                        <option value="MA">Maranhão</option>
                                                        <option value="MT">Mato Grosso</option>
                                                        <option value="MS">Mato Grosso do Sul</option>
                                                        <option value="MG">Minas Gerais</option>
                                                        <option value="PA">Pará</option>
                                                        <option value="PB">Paraíba</option>
                                                        <option value="PR">Paraná</option>
                                                        <option value="PE">Pernambuco</option>
                                                        <option value="PI">Piauí</option>
                                                        <option value="RJ">Rio de Janeiro</option>
                                                        <option value="RN">Rio Grande do Norte</option>
                                                        <option value="RS">Rio Grande do Sul</option>
                                                        <option value="RO">Rondônia</option>
                                                        <option value="RR">Roraima</option>
                                                        <option value="SC">Santa Catarina</option>
                                                        <option value="SP">São Paulo</option>
                                                        <option value="SE">Sergipe</option>
                                                        <option value="TO">Tocantins</option>
                                                        <option value="ES">Estrangeiro</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>


                                <div class="wizard-footer height-wizard">
                                    <div class="pull-right">
                                        <input type='button' class='btn btn-next btn-fill btn-warning btn-wd btn-sm' name='next' value='Próximo'/>
                                        <input type='submit' class='btn btn-finish btn-fill btn-warning btn-wd btn-sm' value='Finalizar' />

                                    </div>

                                    <div class="pull-left">
                                        <input type='button' class='btn btn-previous btn-fill btn-default btn-wd btn-sm' name='previous' value='Anterior' />
                                    </div>
                                    <div class="clearfix"></div>
                                </div>

                        </div>
                    </div> <!-- wizard container -->
                </div>
            </div><!-- end row -->
        </div> <!--  big container -->



    </div>