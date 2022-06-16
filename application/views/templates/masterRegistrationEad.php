<?php


if ($this->uri->segment(3) != NULL) {
    $uricampus = $this->uri->segment(3);
} else {
    $uricampus = 'paracatu';
}


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title><?php echo $head['title']; ?></title>

    <link rel="shortcut icon" href="<?php echo base_url(); ?>assets/images/favicon.ico"/>

    <link rel="stylesheet" type="text/css"
          href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" media="all"/>
    <link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css"
          media="all"/>

    <meta name="description" content="Wizard Form with Validation - Responsive">
    <link rel="shortcut icon" href="http://www.atenas.edu.br/uniatenas/assets/images/favicon.ico">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="<?php echo base_url('assets/ws_wizard') ?>/css/bootstrap.min.css">
    <!-- Fontawesome CSS -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.9/css/all.css">
    <!-- Fonts and icons -->
    <link href="https://fonts.googleapis.com/css?family=Montserrat:100,200,300,400,500,600,700" rel="stylesheet">
    <!-- Reset CSS -->
    <link rel="stylesheet" href="<?php echo base_url('assets/ws_wizard') ?>/css/reset.css">
    <!-- Style CSS -->
    <link rel="stylesheet" href="<?php echo base_url('assets/ws_wizard') ?>/css/style.css">
    <!-- Responsive  CSS -->
    <link rel="stylesheet" href="<?php echo base_url('assets/ws_wizard') ?>/css/responsive.css">
    <style>
        .box {
            width: 400px;
            margin: 0 auto;
        }

        .active_tab1 {
            background-color: #fff;
            color: #333;
            font-weight: 600;
        }

        .inactive_tab1 {
            background-color: #f5f5f5;
            color: #333;
            cursor: not-allowed;
        }

        .has-error {
            border-color: #cc0000;
            background-color: #ffff99;
        }

        .information {
            font-size: 11px;
        }

        .logooficialInscreva-se {
            text-align: center;
            margin-bottom: 15px;
        }

        .logooficialInscreva-se img {
            width: 200px;
        }
    </style>
</head>
<body>

<?php
if ($dados['campus']->id == 1) {
    $logo = 'logoUniatenas.png';
}else{
    $logo = 'big_logo.png';
}
?>
<div class="wizard-main">
    <div id="particles-js"></div>
    <div class="container">
        <div class="row">
            <div class="col-xs-4">
                <div class="logooficialInscreva-se">
                    <?php echo anchor("/graduacao/ead/$uricampus", '<img src="' . base_url() . 'assets/images/'.$logo.'" alt="logo" class="img-responsive logoPrincipal" />', array('class' => 'logooficial')); ?>
                    <!-- Coloquei para voltar na pagina de graduação paracatu, sem usar a $uricampus, devido ela retorna ead e não a city do campus -->
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-6 banner-sec">
                <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
                    <ol class="carousel-indicators">
                        <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
                    </ol>
                    <div class="carousel-inner" role="listbox">
                        <div class="carousel-item active">
                            <img class="d-block img-fluid"
                                 src="<?php echo base_url('assets/ws_wizard') ?>/images/wizard_ead.png"
                                 alt="First slide">
                            <div class="carousel-caption d-none d-md-block">
                                <div class="banner-text">
                                    <h2>Venha fazer sua graduação EaD.</h2>
                                    <p>O grupo UniAtenas conta com uma infraestrutura de excelência, para possibilitar
                                        ao docente e ao discente um ambiente favorável ao aprendizado.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
            <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
            <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet"/>

            <div class="col-lg-6 login-sec">
                <div class="row">
                    <div class="container box">
                        <br/>
                        <h2 align="center">Pré-inscrição graduação EaD - Uniatenas <br>

                        </h2>
                        <?php
                        if ($msg = getMsg()):
                            echo $msg;
                        endif;
                        ?>
                        <br/>
                        <?php echo form_open('graduacao/inscricaoEad/' . $uricampus, array('id' => "register_form")); ?>
                        <ul class="nav nav-tabs">
                            <li class="nav-item">
                                <a class="nav-link active_tab1" style="border:1px solid #ccc"
                                   id="list_login_details">Dados pessoais</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link inactive_tab1" id="list_personal_details"
                                   style="border:1px solid #ccc">Curso EaD </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link inactive_tab1" id="list_contact_details"
                                   style="border:1px solid #ccc">Resumo EaD</a>
                            </li>
                        </ul>
                        <div class="tab-content" style="margin-top:16px;">
                            <div class="tab-pane active" id="login_details">
                                <div class="panel panel-default">
                                    <div class="panel-heading">Dados</div>
                                    <div class="panel-body">
                                        <div class="form-group">
                                            <label>Nome Completo</label>
                                            <?php
                                            echo form_input(array('name' => 'user', 'data-rule' => "required", 'id' => 'user', 'class' => 'form-control'), set_value('user'));
                                            ?>
                                            <span id="error_user" class="text-danger"></span>
                                        </div>
                                        <div class="form-group">
                                            <label>Email</label>
                                            <?php
                                            echo form_input(array('name' => 'emailUser', 'data-rule' => "required", 'id' => 'email', 'class' => 'form-control'), set_value('emailUser'));
                                            ?>
                                            <span id="error_email" class="text-danger"></span>
                                        </div>
                                        <div class="form-group">
                                            <label>Telefone</label>
                                            <?php
                                            echo form_input(array('name' => 'phone', 'data-rule' => "required", 'id' => 'phone', 'class' => 'form-control'), set_value('phone'));
                                            ?>
                                            <span id="error_phone" class="text-danger"></span>
                                        </div>
                                        <br/>
                                        <div align="center">
<!--                                            <button type="button" name="btn_login_details" id="btn_login_details"
                                                    class="btn btn-info btn-lg">Próximo
                                            </button>-->
                                        </div>
                                        <br/>
                                    </div>
                                </div>
                            </div>

                            <div class="tab-pane fade" id="personal_details">
                                <div class="panel panel-default">
                                    <div class="panel-heading">Informe-nos o curso EaD que deseja.</div>
                                    <div class="panel-body">

                                        <div class="form-group">
                                            <label>Qual seu interesse?</label>

                                            <?php

                                            ?>
                                            <select class="form-control" name="courses_id" id="courses_id">
                                                <?php
                                                if ($dados['courseEspecific'] != '') {
                                                    echo '<option value="' . $dados['courseEspecific']->name . '">' . $dados['courseEspecific']->name . '</option>';
                                                } else {
                                                    echo "<option value='default'>Escolha o curso EaD.</option>";
                                                }

                                                foreach ($dados['cursos'] as $curso) {
                                                    if ($curso->name == $dados['courseEspecific']->name) {
                                                        $class = "style='display:none'";
                                                    } else {
                                                        $class = '';
                                                    }
                                                    echo "<option value='$curso->name' $class> $curso->name (EaD)</option>";
                                                }
                                                ?>
                                            </select>
                                            <span id="error_course" class="text-danger"></span>

                                            <br/>
                                            <label>Escolha abaixo um de nossos polos.</label>

                                            <select class="form-control" name="polo_id" id="polo_id">
                                                <?php
                                                echo "<option value='default'>Escolha um de nossos polos EaD.</option>";
                                                foreach ($dados['polos'] as $polo) {
                                                    echo "<option value='$polo->city'>$polo->city</option>";
                                                }
                                                ?>
                                            </select>
                                            <span id="error_polo" class="text-danger"></span>
                                        </div>


                                        <br/>
                                        <div align="center">
<!--                                            <button type="button" name="previous_btn_personal_details"
                                                    id="previous_btn_personal_details"
                                                    class="btn btn-default btn-lg">Anterior
                                            </button>
                                            <button type="button" name="btn_personal_details"
                                                    id="btn_personal_details" class="btn btn-info btn-lg">Próximo
                                            </button>-->
                                        </div>
                                        <br/>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="contact_details">
                                <div class="panel panel-default">
                                    <div class="panel-heading">Detalhes da sua pré-inscrição para o EaD.</div>
                                    <div class="panel-body">
                                        <p>Olá, você realizou sua inscrição no processo seletivo do <b>EaD -
                                                UniAtenas </b>,
                                            por meio dos seguintes dados:</p>
                                        <div class="alert alert-warning">
                                            <div id="campoUser"></div>
                                        </div>
                                        <div class="alert alert-info">
                                            <p class="information">Caso os dados apresentados não estejam corretos,
                                                use a opção <strong>Anterior</strong> para voltar e corrigir seus
                                                dados.</p>
                                        </div>
                                        <div class="form-group">
                                            <label>Caso tenha alguma dúvida deixe-nos uma mensagem. </label>
                                            <?php
                                            echo form_textarea('description', to_html(set_value('description')), array('class' => 'form-control'));
                                            ?>
                                        </div>

                                        <br/>
                                        <div align="center">
                                            <button type="button" name="previous_btn_contact_details"
                                                    id="previous_btn_contact_details"
                                                    class="btn btn-default btn-lg">Anterior
                                            </button>

                                          <!--  --><?php
/*                                            $data = array(
                                                'type' => 'submit',
                                                'value' => 'Cadastrar',
                                                'class' => 'btn btn-success btn-lg',
                                                'id' => 'btn_contact_details'
                                            );
                                            echo form_submit($data);
                                            */?>
                                        </div>
                                        <br/>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php echo form_close(); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>

    var user = document.getElementById("user");
    var email = document.getElementById("email");
    var phone = document.getElementById("phone");
    var courses_id = document.getElementById("courses_id");
    var polo_id = document.getElementById("polo_id");

    var dados = document.getElementById("campoUser")
    var dadosEmail = document.getElementById("campoEmail")

    polo_id.onblur = function () {
        dados.innerHTML = "<p> Nome:  <strong> " + user.value + "</strong><br/>Email <strong>"
            + email.value + " </strong> <br>Telefone  <strong>"
            + phone.value + "</strong>. <br> o curso de <strong>"
            + courses_id.value + "</strong> <br> para o polo de <strong>"
            + polo_id.value + "</strong></p>";
    }

</script>
<script>
    $(document).ready(function () {

        $('#btn_login_details').click(function () {

            var error_user = '';
            var error_email = '';
            var error_phone = '';

            var filter = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;

            var error_mobile_no = '';
            var mobile_validation = /^\d{10}$/;

            if ($.trim($('#user').val()).length == 0) {
                error_user = 'Por favor, você precisa informar seu nome completo.';
                $('#error_user').text(error_user);
                $('#user').addClass('has-error');
            }
            else {
                error_first_name = '';
                $('#error_user').text(error_first_name);
                $('#user').removeClass('has-error');
            }

            if ($.trim($('#email').val()).length == 0) {
                error_email = 'Por favor, informe um email de contato. :)';
                $('#error_email').text(error_email);
                $('#email').addClass('has-error');
            }
            else {
                if (!filter.test($('#email').val())) {
                    error_email = 'Email Inválido';
                    $('#error_email').text(error_email);
                    $('#email').addClass('has-error');
                } else {
                    error_email = '';
                    $('#error_email').text(error_email);
                    $('#email').removeClass('has-error');
                }
            }

            if ($.trim($('#mobile_no').val()).length == 0) {
                error_mobile_no = 'Mobile Number is required';
                $('#error_mobile_no').text(error_mobile_no);
                $('#mobile_no').addClass('has-error');
            }
            else {
                if (!mobile_validation.test($('#mobile_no').val())) {
                    error_mobile_no = 'Invalid Mobile Number';
                    $('#error_mobile_no').text(error_mobile_no);
                    $('#mobile_no').addClass('has-error');
                } else {
                    error_mobile_no = '';
                    $('#error_mobile_no').text(error_mobile_no);
                    $('#mobile_no').removeClass('has-error');
                }
            }
            if ($.trim($('#phone').val()).length == 0) {
                error_phone = 'Por favor, informe um número de telefone, para falarmos com você. :)';
                $('#error_phone').text(error_phone);
                $('#phone').addClass('has-error');
            }
            else {
                error_phone = '';
                $('#error_phone').text(error_phone);
                $('#phone').removeClass('has-error');
            }

            if (error_user != '' || error_email != '' || error_phone != '') {
                return false;
            }
            else {
                $('#list_login_details').removeClass('active active_tab1');
                $('#list_login_details').removeAttr('href data-toggle');
                $('#login_details').removeClass('active');
                $('#list_login_details').addClass('inactive_tab1');
                $('#list_personal_details').removeClass('inactive_tab1');
                $('#list_personal_details').addClass('active_tab1 active');
                $('#list_personal_details').attr('href', '#personal_details');
                $('#list_personal_details').attr('data-toggle', 'tab');
                $('#personal_details').addClass('active in');
            }
        });

        $('#previous_btn_personal_details').click(function () {
            $('#list_personal_details').removeClass('active active_tab1');
            $('#list_personal_details').removeAttr('href data-toggle');
            $('#personal_details').removeClass('active in');
            $('#list_personal_details').addClass('inactive_tab1');
            $('#list_login_details').removeClass('inactive_tab1');
            $('#list_login_details').addClass('active_tab1 active');
            $('#list_login_details').attr('href', '#login_details');
            $('#list_login_details').attr('data-toggle', 'tab');
            $('#login_details').addClass('active in');
        });

        $('#btn_personal_details').click(function () {
            var error_course = '';
            var error_polo = '';

            if ($.trim($('#courses_id').val()) == 'default') {
                error_course = 'Você precisa selecionar um curso';
                $('#error_course').text(error_course);
                $('#courses_id').addClass('has-error');
            } else {
                error_course = '';
                $('#error_course').text(error_course);
                $('#course').removeClass('has-error');
            }


            if ($.trim($('#polo_id').val()) == 'default') {
                error_polo = 'Você precisa selecionar um polo';
                $('#error_polo').text(error_polo);
                $('#polo_id').addClass('has-error');
            } else {
                error_polo = '';
                $('#error_polo').text(error_polo);
                $('#polo').removeClass('has-error');
            }

            if (error_course != '' ||  error_polo != '') {
                return false;
            } else {
                $('#list_personal_details').removeClass('active active_tab1');
                $('#list_personal_details').removeAttr('href data-toggle');
                $('#personal_details').removeClass('active');
                $('#list_personal_details').addClass('inactive_tab1');
                $('#list_contact_details').removeClass('inactive_tab1');
                $('#list_contact_details').addClass('active_tab1 active');
                $('#list_contact_details').attr('href', '#contact_details');
                $('#list_contact_details').attr('data-toggle', 'tab');
                $('#contact_details').addClass('active in');
            }
        });

        $('#previous_btn_contact_details').click(function () {
            $('#list_contact_details').removeClass('active active_tab1');
            $('#list_contact_details').removeAttr('href data-toggle');
            $('#contact_details').removeClass('active in');
            $('#list_contact_details').addClass('inactive_tab1');
            $('#list_personal_details').removeClass('inactive_tab1');
            $('#list_personal_details').addClass('active_tab1 active');
            $('#list_personal_details').attr('href', '#personal_details');
            $('#list_personal_details').attr('data-toggle', 'tab');
            $('#personal_details').addClass('active in');
        });
    });
</script>

<!-- jquery latest version -->
<script src="<?php echo base_url('assets/ws_wizard') ?>/js/jquery.min.js"></script>
<!-- popper.min.js -->
<script src="<?php echo base_url('assets/ws_wizard') ?>/js/popper.min.js"></script>
<!-- bootstrap js -->
<script src="<?php echo base_url('assets/ws_wizard') ?>/js/bootstrap.min.js"></script>
<!-- jquery.steps js -->
<script src='https://ajax.aspnetcdn.com/ajax/jquery.validate/1.15.0/jquery.validate.js'></script>
<script src="<?php echo base_url('assets/ws_wizard') ?>/js/jquery.steps.js"></script>
<!-- particles js -->
<script src="<?php echo base_url('assets/ws_wizard') ?>/js/particles.js"></script>


</body>
</html>