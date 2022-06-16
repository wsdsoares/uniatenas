		
<div id="wrapper">
    <div id="login" class="animate form">
        <section class="login_content">
            <?php
            echo form_open('usuarios/login');
            ?>
            <?php
            get_msg('errologin');
            get_msg('logoffok');
            erros_validacao();
            ?>		

            <img src="<?php echo base_url(); ?>assets/img/logo.png">
            <h1>Painel Administrativo</h1>

            <div>
                <?php
                echo form_input(array('name' => 'codusuario', 'class' => 'form-control', 'placeholder' => 'Usuário'), set_value('codusuario'), 'autofocus required');
                ?>
            </div>
            <div>
                <!--input type="password" class="form-control" placeholder="Password" required="" /-->
                <?php
                echo form_password(array('name' => 'password', 'class' => 'form-control', 'placeholder' => 'Senha'), set_value('password'), 'required');
                ?>
            </div>
            <div>
                <!--a class="btn btn-default submit" href="index.html">Log in</a-->
                <?php
                echo form_submit(array('name' => 'logar', 'class' => 'btn btn-success submit'), 'Acessar Sistema');
                echo anchor('usuarios/nova_senha', 'Esqueci minha senha.', array('class' => ''));
                ?>
            </div>
            <div class="clearfix"></div>
            <?php
            echo form_hidden('redirect', $this->session->userdata('redir_para'));
            echo form_close();
            ?>
        </section>
    </div>
</div>




