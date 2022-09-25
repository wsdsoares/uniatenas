<?php


$permissionCampusArray = '';
echo '<pre>';
//print_r($_SESSION);
//print_r($_SESSION['arrayPermissoes']);
//echo hash('sha256', '123456');
echo '</pre>';
 $cadastrarCampus = in_array('incluirCampus',$_SESSION['arrayPermissoes']) ? 'Cadastrar' : '';
 $editarCampus = in_array('editarCampus',$_SESSION['arrayPermissoes']) ? 'Editar' : '';
 $deletarCampus = in_array('deletarCampus',$_SESSION['arrayPermissoes']) ? 'Deletar' : '';

 


/*
echo '<pre>';
print_r($permissionCampusArray);
echo '</pre>';

/*
$campusPermission = $_SESSION['permissoes'];

for ($i = 0; $i < count($campusPermission); $i++) {
    $permissionsCampus['campus-' . $campusPermission[$i]['campus']] = array_column($campusPermission[$i]['permissoesFilial'], 'permissiontitle');
}

//created in time of session variable $permissionsCampus for listening permission user
$this->session->set_userdata('permissionCampus', $permissionsCampus);

echo '<pre>';

print_r($campusPermission);
print_r($permissionsCampus);
echo '</pre>';

if (in_array("regfotoscursos", $permissionsCampus['campus-1'])) {
    echo 'teste campus paracatu';
}*/
?>
<!-- <table class="table table-hover">
  <thead>
    <tr>
      <th>Firstname</th>
      <th>Lastname</th>
      <th>Email</th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <td>John</td>
      <td>Doe</td>
      <td>john@example.com</td>
    </tr>
    <tr>
      <td>Mary</td>
      <td>Moe</td>
      <td>mary@example.com</td>
    </tr>
    <tr>
      <td>July</td>
      <td>Dooley</td>
      <td>july@example.com</td>
    </tr>
  </tbody>
</table> -->
<div class="col-md-4">
  <div class="alert alert-info" role="alert">
    <strong>Olá!</strong> Seja bem vindo ao painel administrativo do Site <span>. No menu lateral, você verá as funções
      a quais tem acesso. <br>
      <br>Caso tenha um problema, <a class="alert-link"
        href="http://177.69.195.6:5000/app/login?redirect=%2Fapp%2Fatendimento%2F">Clique aqui</a> para abrir um
      chamado.</span>.
  </div>
</div>
<style>
.cardsDash {
  background: #00FF7F;
  padding: 15px;
  margin-bottom: 20px;
}
</style>
<div class="col-md-4">
  <div class="cardsDash">
    <strong>Gestão de usuários!</strong> Cadastro de usuários e vinculo de usuários ao campus. <br>
    <br>
    <?php echo anchor(base_url("Painel_usuarios/lista_usuarios"),'
      <div class="item btn btn-primary">
        <span><i class="material-icons">face</i> <span>Cadastro de Usuários</span>
      </div>');
      ?>
    </a>
  </div>
</div>
<!-- <div class="modal fade" id="exemplomodal" tabindex="-1" role="dialog" aria- labelledby="myLargeModalLabel">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header alert alert-warning">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
            aria-hidden="true">&times;</span></button>
        <h1 class="modal-title" id="gridSystemModalLabel">⚠Aviso⚠</h1>
      </div>
      <div class="modal-body">
        <div class="modal-body">
          <div class="jumbotron">
            <h3>O painel do site, ira sofrer alterações em breve, entre em contato com o ramal 1130. 😁😊</h3>
          </div>

        </div>

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">fechar</button>
      </div>
    </div>
  </div>
  <!-- jquery -->
<script src="//code.jquery.com/jquery-1.11.0.min.js"></script>
<!-- bootstrap -->
<script type="text/javascript" src="js/bootstrap.js"></script>
<!-- chamada da função -->
<script type="text/javascript">
$(window).load(function() {
  //$('#exemplomodal').modal('show');
});
</script> -->