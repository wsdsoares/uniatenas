<script type="text/javascript">
    $(document).ready(function () {
        $('.thumbnail').click(function () {
            $('.modal-body').empty();
            var title = $(this).parent('a').attr("title");
            $('.modal-title').html(title);
            $($(this).parents('div').html()).appendTo('.modal-body');
            $('#myModal').modal({show: true});
        });
    });

</script>
<style type="text/css">

    .modal-dialog {width:600px;}
    .thumbnail {margin-bottom:6px;}

</style>    
<div class="iniciacao_anais_monografia">
    <div class="container">	
        <h3 class="text-center">Núcleo de Prática Jurídica Simulada (NPJS)</h3>

        <div class="col-md-12">
            <p>O Núcleo de Prática Jurídica Simulada é onde os estagiários do curso de Direito do UniAtenas iniciam seu treinamento prático-profissional. Assim, principalmente, a partir do 5º período, recebem casos jurídicos simulados que devem ser analisados e interpretados para a elaboração da medida judicial cabível. Para esta atividade, atuam como advogado do autor, advogado do réu, promotor de justiça e/ou magistrado, sempre sob a supervisão dos orientadores do setor.</p>
            <p>Ademais, são realizadas, semestralmente, graças às atividades já citadas, audiências simuladas de instrução e julgamento cíveis, além de sessões do Tribunal do Júri.</p>
            <p>Ressalta-se que a estrutura física do NPJ Simulada foi construída visando simular uma secretaria forense, onde o aluno realiza diversos atos processuais, como: distribuição da petição inicial, protocolo da contestação e demais peças processuais, carga e devolução dos autos do processo, cumprimento dos despachos judiciais, entre outros. Além disso, a estrutura engloba salas adequadas para orientação e simulação das audiências ao final do processo simulado.</p>
        </div>

    </div>
</div>


<div class="container">
    <div class="row">
        <h1>Veja algumas Audiências ou júris simulados realizados por alunos.</h1>
        <div class="col-lg-3 col-sm-4 col-xs-6"><a title="Image 1" href="#"><img class="thumbnail img-responsive" src="<?php echo base_url(); ?>assets/img/npj/01.jpg"></a></div>
        <div class="col-lg-3 col-sm-4 col-xs-6"><a title="Image 1" href="#"><img class="thumbnail img-responsive" src="<?php echo base_url(); ?>assets/img/npj/02.jpg"></a></div>
        <div class="col-lg-3 col-sm-4 col-xs-6"><a title="Image 1" href="#"><img class="thumbnail img-responsive" src="<?php echo base_url(); ?>assets/img/npj/03.jpg"></a></div>
        <div class="col-lg-3 col-sm-4 col-xs-6"><a title="Image 1" href="#"><img class="thumbnail img-responsive" src="<?php echo base_url(); ?>assets/img/npj/04.jpg"></a></div>
    </div>
</div>



<div tabindex="-1" class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button class="close" type="button" data-dismiss="modal">×</button>
                <h3 class="modal-title">NPJs</h3>
            </div>
            <div class="modal-body">

            </div>
            <div class="modal-footer">
                <button class="btn btn-danger" data-dismiss="modal">Fechar</button>
            </div>
        </div>
    </div>
</div>

