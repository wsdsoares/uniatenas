<?php

if (!defined("BASEPATH"))
  exit("No direct script access allowed");

class Painel_portais extends CI_Controller
{

  public function __construct()
  {
    parent::__construct();
    $this->load->model('painel_model', 'painelbd');
    date_default_timezone_set('America/Sao_Paulo');
  }

  public function lista_campus_servicos($tipoPagina)
  {
    verificaLogin();

    $colunasResultadoCursos =
      array(
        'campus.id',
        'campus.name',
        'campus.city',
        'campus.uf'
      );

    $listagemDosCampus = $this->painelbd->where('*', 'campus', NULL, array('visible' => 'SIM'))->result();
    $data = array(
      'titulo' => 'UniAtenas',
      'conteudo' => 'paineladm/servicos/lista_campus_servicos',
      'dados' => array(
        'page' => "Informações Menu Serviços ($tipoPagina)",
        'tipoPagina' => $tipoPagina,
        'campus' => $listagemDosCampus,
        'tipo' => ''
      )
    );

    $this->load->view('templates/layoutPainelAdm', $data);
  }



  public function lista_informacoes_servicos($uriCampus = NULL, $tipoPagina = null)
  {
    verificaLogin();

    $colunasCampus = array('campus.id', 'campus.name', 'campus.city');
    $campus = $this->painelbd->where($colunasCampus, 'campus', NULL, array('campus.id' => $uriCampus))->row();

    $joinContatoPagina = array(
      'pages' => 'pages.id = page_contents.pages_id',
      'campus' => 'campus.id= pages.campusid'
    );

    $colunaResultadoContatoPagina = array(
      'page_contents.id',
      'page_contents.title',
      'page_contents.tipo_pagina',
      'page_contents.status',
      'page_contents.description',
      'page_contents.order',
      'page_contents.created_at',
      'page_contents.updated_at',
      'page_contents.user_id',
      'campus.city'
    );

    $listaInformmacoesPaginaServicos =  $this->painelbd->where('*', 'pages', null, array('pages.campusid' => $uriCampus, 'pages.tipo_pagina' => $tipoPagina))->result();

    //$contatosPaginaFinanceiro = $this->painelbd->where($colunaResultadoContatoPagina,'page_contents',$joinContatoPagina, $whereContatosPagina,null)->result();

    $data = array(
      'titulo' => 'UniAtenas',
      'conteudo' => 'paineladm/servicos/lista_informacoes_servicos',
      'dados' => array(
        'conteudosPaginaServicos' => $listaInformmacoesPaginaServicos,
        'page' => "Informações do menu Serviço ($tipoPagina) - <strong><i>Campus - $campus->name ($campus->city) </i></strong>",
        'campus' => $campus,
        //'paginaFinanceiro'=> $verificaExistePaginaFinanceiro = isset($verificaExistePaginaFinanceiro) ? $verificaExistePaginaFinanceiro : '',
        'tipo' => ''
      )
    );

    $this->load->view('templates/layoutPainelAdm', $data);
  }
  