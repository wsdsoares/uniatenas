<?php
$uricampus = $this->uri->segment(3);
?>
<html>
<div name='dados' style="display: none"><?php echo json_encode($phones); ?></div>
<div class="container">
    <div class="row">
        <div class="col-sm-12">
            <div class="row">
                <div class="section-header text-center">
                    <h3>Telefones Úteis</h3>
                </div>
            </div>
            <div class="form-group input-group">
                <input name="consulta" id="txt_consulta" placeholder="Consultar Setor" type="text" class="form-control">
                <span class="input-group-addon"><i class="glyphicon glyphicon-search"></i></span>
            </div>
            <div class="btn-back">
                <a href="<?php echo base_url("/site/inicio/$uricampus") ?>" class="btn btn-danger">
                    Voltar</a>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col">
            <div class="panel-body">
                <!--table class="table table-hover table-bordered"-->
                <table id="tabela" class="table table-hover table-borderless table-striped">
                    <thead>
                    <tr>
                        <!--th scope="col">#</th-->
                        <th scope="col">RESPONSÁVEL</th>
                        <th scope="col">Setor</th>
                        <th scope="col">Telefone</th>
                        <th scope="col">Ramal</th>
                    </tr>
                    </thead>
                    <tbody>
                    
                    </tbody>
                </table>
            </div>
            <div class="btn-back">
                <a href="<?php echo base_url("/site/inicio/$uricampus") ?>" class="btn btn-danger">
                    Voltar</a></div>
        </div>
    </div>
</div>
</div>
<script>
    var dadosJson = document.querySelector("div[name=dados]").innerHTML

    var dados = JSON.parse(dadosJson)


    var inputElement = document.getElementById('txt_consulta')
    var tableElements = document.querySelector("table#tabela tbody")
    const render = (dados) => {
        tableElements.innerHTML = ''
        for (let dado of dados) {
            let trElementes = document.createElement("tr")
            //let thID = document.createElement('th')
            //thID.setAttribute('scope', 'row')
            //thID.textContent = dado[0]
            let tdResponsible = document.createElement("td")
            tdResponsible.textContent = dado[1]
            let tdSetor = document.createElement("td")
            tdSetor.textContent = dado[2]
            let tdPhone = document.createElement("td")
            tdPhone.textContent = dado[3]
            let tdRamal = document.createElement("td")
            tdRamal.textContent = dado[4]
            //trElementes.appendChild(thID)
            trElementes.appendChild(tdResponsible)
            trElementes.appendChild(tdSetor)
            trElementes.appendChild(tdPhone)
            trElementes.appendChild(tdRamal)
            tableElements.appendChild(trElementes)
        }
    }
    render(dados)

    function pesquisaTabela() {
        // Declare variables
        let filter, table, tr, td, i;
        filter = inputElement.value.toUpperCase();
        if (filter !== "") {
            tr = tableElements.getElementsByTagName("tr");
            // Loop through all table rows, and hide those who don't match the search query
            for (i = 0; i < tr.length; i++) {
                var match = tr[i].innerHTML.toUpperCase().indexOf(filter) > -1;
                tr[i].style.display = match ? " table row block" : "none";
            }
        } else {
            render(dados)
        }
    }

    inputElement.onkeydown = () => render(dados)
    inputElement.onkeyup = () => pesquisaTabela()


</script>
</html>
