<?php
// $permissionCampusArray = $_SESSION['permissionCampus'];
?>
<li>
  <a href="javascript:void(0);" class="menu-toggle">
    <i class="material-icons">attach_money</i>
    <span>Aba - Financeiro</span>
  </a>

  <ul class="ml-menu">
    <li>
      <?php
            echo anchor('Painel_home/financeiro/lista', '<span>Financeiro</span>');
            ?>
    </li>
  </ul>
</li>