<body class="bg-dark fontAmerika" id="page-top">
    <div class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top centralizaObjetos" id="mainNav">
        <span class="tituloAvaliacao"><img src="<?php echo base_url('assets/img/logo.png'); ?>" height="60">Sistema de Avaliações EAD</span>
    </div>
    <div class="card centralizarAvaliacao" style="min-width: 520px">
        <div class="card-header labelSemana bg-danger">
            <div class="text-center" style="padding-top: 11.5px"><strong>Erro 404 - Página não encontrada</strong></div>
        </div>
        <div class="card-body">
            <div class="erro404">
                <p>Desculpe mas a página que você está procurando não foi encontrada.</p>
                <p>Volte para a <a href="<?php echo base_url(); ?>">Página Inicial</a>.</p>
            </div>
        </div>
    </div>
    <?php $this->load->view('templates/default/elements/js'); ?>
</body>