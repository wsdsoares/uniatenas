<?php
if (!defined("BASEPATH"))
	exit("No direct script access allowed");
	$perfilUserLogado = $this -> session -> userdata('user_perfil');

switch ($tela) :
	case 'login' :
		include_once ('itens_usuarios/login_usuarios.php');
	break;

	case 'nova_senha' :
		include_once ('itens_usuarios/nova_senha.php');
	break;


	case 'cadastrar' :
		include_once ('itens_usuarios/cadastrar_usuarios.php');
	break;

	/*******************
	 * ITENS GERAIS - GERENCIAR USERS SITE
	 * *****************/
	case 'gerenciar' :
		include_once ('itens_usuarios/usuarios.php');
	break;


	case 'alterar_dados' :
		include_once ('itens_usuarios/alterar_dados.php');
	break;
	//============================================================ALTERAR SENHA===============================================================
	case 'alterar_senha' :
		include_once ('itens_usuarios/alterar_senha.php');
	break;
	// ===========================================================EDITAR DADOS =================================================================================================================

	case 'editar' :
		include_once ('itens_usuarios/editar_usuarios.php');
	break;
	// ===========================================================EXCLUIR DADOS =================================================================================================================

	case 'excluir_usuario' :
		include_once ('itens_usuarios/excluir_usuario.php');
	break;
	// ===========================================================DOCUMENTOS DO ALUNO =================================================================================================================
	case 'documentos' :
		include_once ('itens_usuarios/documentos.php');
	break;
	
	default :
		echo '<div class="alert-box alert"><p>A tela solicitada não existe</p></div>';
		break;
endswitch;


	/********************************************************************************************************************************************
	 *
	 * Modificado por: Willian Soares Damasceno
	 * email:wilhaods@gmail.com
	 * modificação: 06-05-2015
	 * funçao: Tela de login
	 *
	 ********************************************************************************************************************************************
	 */
	 /********************************************************************************************************************************************
	 *
	 * Modificado por: Ricardo Maciel
	 * email:analista.ti2015@gmail.com	
	 * modificação: 17-08-2015
	 * funçao: Menu Usuário
	 *
	 ********************************************************************************************************************************************
	 */