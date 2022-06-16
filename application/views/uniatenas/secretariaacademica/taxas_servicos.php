<div class="container">
    <div class="alert alert-success">
        <!--
        Para os itens 1 até 19 a emissão do documento em 1ª via no semestre será isenta do pagamento de taxas.
        -->
    </div>
</div>
<table class="table">
    <?php
    //$taxa_servico = 1 corresponde aos demais serviços da faculdade
    $taxa_servico = 1;
    if ($taxa_servico == 1):
        ?>
        <thead>
            <tr>
                <th>Nº</th>
                <th>Descriminação</th>
                <th>Valor</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $query = $this->divulgacao->get_all_taxas('taxas_servicos')->result();
            $i = 1;
            foreach ($query as $linha):
                echo '<tr>';
                //printf('<td>%s</td>', $i);
                //printf('<td>%s</td>', $linha->descriminacao);
                //printf('<td>%s</td>', 'R$ ' . number_format($linha->valor, 2, '.', ''));
                $i = $i + 1;
                echo '</tr>';
            endforeach;
            ?>
        </tbody>
        <?php
    endif;
    ?>                                                    
</table>

<div class="container">
    <p class="data_atualizacao">Atualizado em janeiro/2017.</p>
</div>
