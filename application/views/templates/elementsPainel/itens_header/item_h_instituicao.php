<?php
// $permissionCampusArray = $_SESSION['permissionCampus'];
?>
<a href="javascript:void(0);" class="menu-toggle">
  <i class="material-icons">account_balance</i>
  <span>Aba - Instituição</span>
</a>
<ul class="ml-menu">
  <li>
    <?php
        echo anchor('Painel_campus/lista_campus', '<span>História</span>');
      ?>
  </li>
  <li>
    <?php
        echo anchor('Painel_campus/lista_campus', '<span>Dirigentes</span>');
      ?>
  </li>
  <li>
    <?php
        echo anchor('Painel_campus/lista_campus', '<span>Infraestrutura</span>');
      ?>
  </li>


</ul>
<ul class="ml-menu">
  <li>
    <a href="javascript:void(0);" class="menu-toggle">
      <span>Principal - Inicial</span>
    </a>
    <ul class="ml-menu">
      <!--li>
                <a href="javascript:void(0);">
                    <span>Fotos</span>
                </a>
                <ul class="ml-menu">
                    <li>
                        <a href="javascript:void(0);">'
                            <span>Fotos</span>
                        </a>
                    </li>
                </ul>
            </li-->
      <li>
        <?php
                //if (in_array("paginasSite", $permissionCampusArray['campus-1'])) {
                    echo anchor('Painel_Instituicao/dirigentes', '<span>Dirigentes</span>');
                //}
                ?>
      </li>
    </ul>
  </li>
</ul>