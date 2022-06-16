<?php
// $permissionCampusArray = $_SESSION['permissionCampus'];
?>

<li>
  <a href="javascript:void(0);" class="menu-toggle">
    <i class="material-icons">school</i>
    <span>Vestibular</span>
  </a>

  <ul class="ml-menu">
    <li>
      <?php
            echo anchor('Painel_vestibular/informacoesVestibular', '<span>Informações Vestibular</span>');
            ?>
    </li>
    <li>
      <?php
            echo anchor('Painel_vestibular/vestfiles/provaGab', '<span>Provas/Gabaritos</span>');
            ?>
    </li>
    <li>
      <?php
            echo anchor('Painel_vestibular/vestfiles/files', '<span>Arquivos</span>');
            ?>
    </li>
  </ul>
</li>