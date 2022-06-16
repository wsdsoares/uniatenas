<body class="bg-dark">
    <div class="container">
        <img src="<?php echo base_url('/assets/img/logo_branca.png'); ?>" class="logoLogin" />
        <div class="card card-login centralizar">
            <div class="card-header text-center">Restaurar a Senha</div>
            <div class="card-body">
                <div class="text-center mt-4 mb-5">
                    <h4>Esqueceu sua senha?</h4>
                    <p>Digite o seu e-mail e iremos te enviar as instruções para restaurar sua senha.</p>
                </div>
                <form>
                    <div class="form-group">
                        <input class="form-control" id="inputEmail" type="email" placeholder="Digite seu e-mail">
                    </div>
                    <a class="btn btn-primary btn-block" href="login.html">Restaurar Senha</a>
                </form>
                <div class="text-center" style="margin-top: 10px">
                    <a class="d-block small" href="<?php echo base_url(); ?>">Login Page</a>
                </div>
            </div>
        </div>
    </div>
</body>