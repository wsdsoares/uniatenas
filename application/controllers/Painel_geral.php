<?php

if (!defined("BASEPATH"))
    exit("No direct script access allowed");

class Painel_geral extends CI_Controller {

  public function __construct() {
      parent::__construct();
      $this->load->model('painel_model', 'painelbd');
      date_default_timezone_set('America/Sao_Paulo');
  }
  
  public function lista_campus_whatsapp() {
      verificaLogin();

      $colunasResultadoCursos = 
          array('campus.id',
          'campus.name',
          'campus.city',
          'campus.uf'
      );
  
      $listagemDosCampus = $this->painelbd->where('*','campus',NULL, array('visible' => 'SIM'))->result();
      $data = array(
          'titulo' => 'UniAtenas',
          'conteudo' => 'paineladm/arquivos_gerais/whatsapp/lista_campus_whatsapp',
          'dados' => array(
              'page' => "Lista - Informações do Whatsapp - Exibido em todo site",
              'campus'=> $listagemDosCampus,
              'tipo'=>''
          )
      );

      $this->load->view('templates/layoutPainelAdm', $data);
  }

  public function lista_dados_integracao_whatsapp($uriCampus=NULL) {
      verificaLogin();

      $colunasCampus = array('campus.id','campus.name','campus.city');
      $campus = $this->painelbd->where($colunasCampus,'campus',NULL, array('campus.id'=>$uriCampus))->row();
      
      $colunasResultadoDados = array(
      'integracao_whatsapp.id',
      'integracao_whatsapp.titulo_botao',
      'integracao_whatsapp.numero_whatsapp',
      'integracao_whatsapp.tempo_interacao_segundos',
      'integracao_whatsapp.created_at',
      'integracao_whatsapp.status',
      'integracao_whatsapp.updated_at',
      'integracao_whatsapp.user_id',

      'campus.city'
      );
      $joinIntegracaoDados = array(
          'campus'=>'campus.id = integracao_whatsapp.id_campus',
      );
      
      $whereDados = array('campus.id'=>$campus->id);
      $dadosIntegracaoWhatsapp = $this->painelbd->where($colunasResultadoDados,'integracao_whatsapp',$joinIntegracaoDados, $whereDados,null)->result();

      $data = array(
          'titulo' => 'UniAtenas',
          'conteudo' => 'paineladm/arquivos_gerais/whatsapp/lista_dados_integracao_whatsapp',
          'dados' => array(
              'dadosIntegracaoWhatsapp'=>$dadosIntegracaoWhatsapp,
              'page' => "Dados integração Whatsapp- <strong><i>Campus - $campus->name ($campus->city) </i></strong>",
              'campus'=>$campus,
              'tipo'=>''
          )
      );

      $this->load->view('templates/layoutPainelAdm', $data);
  }

  public function cadastrar_dados_integracao_whatsapp($uriCampus=NULL) {
      verificaLogin();

      $colunasCampus = array('campus.id','campus.name','campus.city');
      $campus = $this->painelbd->where($colunasCampus,'campus',NULL, array('campus.id'=>$uriCampus))->row();
          //Validaçãoes via Form Validation
      $this->form_validation->set_rules('titulo_botao', 'Titulo do botão', 'required');
      $this->form_validation->set_rules('texto_padrao_mensagem', 'Texto da mensagem inicial', 'required');
      $this->form_validation->set_rules('numero_whatsapp', 'Número do whatsapp', 'required|is_unique[integracao_whatsapp.numero_whatsapp]');
      $this->form_validation->set_rules('tempo_interacao_segundos', 'Tempo duração', 'required');

      if ($this->form_validation->run() == FALSE) {
          if (validation_errors()):
              setMsg(validation_errors(), 'error');
          endif;
      }else {

          $segundos = $this->input->post('tempo_interacao_segundos');

          $dados_form['titulo_botao'] = $this->input->post('titulo_botao');
          $dados_form['texto_padrao_mensagem'] = str_replace(" ","%20",$this->input->post('texto_padrao_mensagem'));
          $dados_form['tempo_interacao_segundos'] = $segundos.'000';
          $dados_form['numero_whatsapp'] = $this->input->post('numero_whatsapp');
          $dados_form['id_campus'] = $campus->id;

          $dados_form['user_id'] = $this->session->userdata('codusuario');
          $dados_form['status'] = $this->input->post('status');
          // //Se o resultado da inserção for igual a TRUE, mostra uma mensagem
          
          if ($this->painelbd->salvar('integracao_whatsapp', $dados_form) == TRUE){
              setMsg('<p>Dados de integração cadastrados com sucesso.</p>', 'success');
              redirect(base_url("Painel_geral/lista_dados_integracao_whatsapp/$campus->id"));
          }else{
              setMsg('<p>Erro! Algo de errado na validação dos dados.</p>', 'error');
          }
      }

      $data = array(
          'titulo' => 'UniAtenas',
          'conteudo' => 'paineladm/arquivos_gerais/whatsapp/cadastrar_dados_integracao_whatsapp',
          'dados' => array(
              'page' => "Cadastro de dados integração do Whatsapp- <strong><i>Campus - $campus->name ($campus->city) </i></strong>",
              'campus'=>$campus,
              'tipo'=>''
          )
      );

      $this->load->view('templates/layoutPainelAdm', $data);
  }

  public function editar_dados_integracao_whatsapp($uriCampus=NULL,$integracaoId) {
      verificaLogin();

      $colunasCampus = array('campus.id','campus.name','campus.city');
      $campus = $this->painelbd->where($colunasCampus,'campus',NULL, array('campus.id'=>$uriCampus))->row();

      $colunasResultadoDados = array(
          'integracao_whatsapp.id',
          'integracao_whatsapp.titulo_botao',
          'integracao_whatsapp.numero_whatsapp',
          'integracao_whatsapp.tempo_interacao_segundos',
          'integracao_whatsapp.created_at',
          'integracao_whatsapp.status',
          'integracao_whatsapp.updated_at',
          'integracao_whatsapp.user_id',
  
          'campus.city'
          );
      $joinIntegracaoDados = array(
          'campus'=>'campus.id = integracao_whatsapp.id_campus',
      );
      
      $whereDados = array('campus.id'=>$campus->id,'integracao_whatsapp.id'=>$integracaoId);

      $dadosIntegracaoWhatsapp = $this->painelbd->where($colunasResultadoDados,'integracao_whatsapp',$joinIntegracaoDados, $whereDados)->row();

          //Validaçãoes via Form Validation
      $this->form_validation->set_rules('titulo_botao', 'Titulo do botão', 'required');
      $this->form_validation->set_rules('texto_padrao_mensagem', 'Texto da mensagem inicial', 'required');
      $this->form_validation->set_rules('numero_whatsapp', 'Número do whatsapp', 'required|is_unique[integracao_whatsapp.numero_whatsapp]');
      $this->form_validation->set_rules('tempo_interacao_segundos', 'Tempo duração', 'required');

      if ($this->form_validation->run() == FALSE) {
          if (validation_errors()):
              setMsg(validation_errors(), 'error');
          endif;
      }else {

          $segundos = $this->input->post('tempo_interacao_segundos');

          $dados_form['titulo_botao'] = $this->input->post('titulo_botao');
          $dados_form['texto_padrao_mensagem'] = str_replace(" ","%20",$this->input->post('texto_padrao_mensagem'));
          $dados_form['tempo_interacao_segundos'] = $segundos.'000';
          $dados_form['numero_whatsapp'] = $this->input->post('numero_whatsapp');
          $dados_form['id_campus'] = $campus->id;
          $dados_form['id'] = $dadosIntegracaoWhatsapp->id;
          $dados_form['updated_at'] = date('Y-m-d H:i:s');
          $dados_form['user_id'] = $this->session->userdata('codusuario');
          $dados_form['status'] = $this->input->post('status');
          // //Se o resultado da inserção for igual a TRUE, mostra uma mensagem
          
          if ($this->painelbd->salvar('integracao_whatsapp', $dados_form) == TRUE){
              setMsg('<p>Dados de integração editado com sucesso.</p>', 'success');
              redirect(base_url("Painel_geral/lista_dados_integracao_whatsapp/$campus->id"));
          }else{
              setMsg('<p>Erro! Algo de errado na validação dos dados.</p>', 'error');
          }
      }

      $data = array(
          'titulo' => 'UniAtenas',
          'conteudo' => 'paineladm/arquivos_gerais/whatsapp/editar_dados_integracao_whatsapp',
          'dados' => array(
              'dadosIntegracaoWhatsapp'=>$dadosIntegracaoWhatsapp,
              'page' => "Edição de Informações - Integração do Whatsapp - <strong><i>Campus - $campus->name ($campus->city) </i></strong>",
              'campus'=>$campus,
              'tipo'=>''
          )
      );

      $this->load->view('templates/layoutPainelAdm', $data);
  }


  public function deletar_item_whatsapp($uriCampus=NULL,$id = NULL)
  {
      verifica_login();
  
      $item = $this->painelbd->where('*','integracao_whatsapp', NULL, array('integracao_whatsapp.id' => $id))->row(); 

      if ($this->painelbd->deletar('integracao_whatsapp', $item->id)) {
          setMsg('<p>O Arquivo foi deletado com sucesso.</p>', 'success');
          redirect(base_url("Painel_geral/lista_dados_integracao_whatsapp/$uriCampus"));
      } else {
          setMsg('<p>Erro! O Arquivo foi não deletado.</p>', 'error');
          redirect(base_url("Painel_geral/lista_dados_integracao_whatsapp/$uriCampus"));
      }
  }


    public function lista_campus_elementos_site() {
      verificaLogin();

      $colunasResultadoCursos = 
          array('campus.id',
          'campus.name',
          'campus.city',
          'campus.uf'
      );
  
      $listagemDosCampus = $this->painelbd->where('*','campus',NULL, array('visible' => 'SIM'))->result();
      $data = array(
          'titulo' => 'UniAtenas',
          'conteudo' => 'paineladm/arquivos_gerais/elementos_site/lista_campus_elementos',
          'dados' => array(
              'page' => "Lista - Elementos do site TOPO- Exibido em todo site",
              'campus'=> $listagemDosCampus,
              'tipo'=>''
          )
      );

      $this->load->view('templates/layoutPainelAdm', $data);
  }

  public function lista_dados_elementos_site($uriCampus=NULL) {
    verificaLogin();

    $colunasCampus = array('campus.id','campus.name','campus.city');
    $campus = $this->painelbd->where($colunasCampus,'campus',NULL, array('campus.id'=>$uriCampus))->row();
    
    $colunasResultadoDadosElementos = array(
    'gerais_elementos_site.id',
    'gerais_elementos_site.nome',
    'gerais_elementos_site.link',
    'gerais_elementos_site.cor_hexadecimal',
    'gerais_elementos_site.tipo',
    'gerais_elementos_site.status',
    'gerais_elementos_site.created_at',
    'gerais_elementos_site.updated_at',
    'gerais_elementos_site.user_id',
    

    'campus.city'
    );
    $joinIntegracaoDados = array(
        'campus'=>'campus.id = gerais_elementos_site.id_campus',
    );
    
    $whereDadosElementos = array('campus.id'=>$campus->id);
    $dadosElementosSite = $this->painelbd->where($colunasResultadoDadosElementos,'gerais_elementos_site',$joinIntegracaoDados, $whereDadosElementos)->result();

    $data = array(
        'titulo' => 'UniAtenas',
        'conteudo' => 'paineladm/arquivos_gerais/elementos_site/lista_dados_elementos_site',
        'dados' => array(
            'dadosElementosSite'=>$dadosElementosSite,
            'page' => "Dados Elementos Site- <strong><i>Campus - $campus->name ($campus->city) </i></strong>",
            'campus'=>$campus,
            'tipo'=>'tabelaDatatable'
        )
    );

    $this->load->view('templates/layoutPainelAdm', $data);
  }
  
  public function cadastrar_dados_elemento_site($uriCampus=NULL) {
    verificaLogin();

    $colunasCampus = array('campus.id','campus.name','campus.city');
    $campus = $this->painelbd->where($colunasCampus,'campus',NULL, array('campus.id'=>$uriCampus))->row();
       //Validaçãoes via Form Validation
   $this->form_validation->set_rules('nome', 'Nome do item', 'required');
   $this->form_validation->set_rules('tipo', 'Tipo do item', 'required');
   
   if ($this->form_validation->run() == FALSE) {
       if (validation_errors()):
           setMsg(validation_errors(), 'error');
       endif;
   }else {
        $dados_form['nome'] = $this->input->post('nome');
        $dados_form['tipo'] = $this->input->post('tipo');
        $dados_form['link'] = !empty($this->input->post('link')) ? $this->input->post('link') : NULL ;
        $dados_form['id_campus'] = $campus->id;
        $dados_form['user_id'] = $this->session->userdata('codusuario');
        $dados_form['status'] = $this->input->post('status');
        // //Se o resultado da inserção for igual a TRUE, mostra uma mensagem
        
        if ($this->painelbd->salvar('gerais_elementos_site', $dados_form) == TRUE){
            setMsg('<p>Elemento do site cadastrado com sucesso.</p>', 'success');
            redirect(base_url("Painel_geral/lista_dados_elementos_site/$campus->id"));
        }else{
            setMsg('<p>Erro! Algo de errado na validação dos dados.</p>', 'error');
        }
   }

    $data = array(
        'titulo' => 'UniAtenas',
        'conteudo' => 'paineladm/arquivos_gerais/elementos_site/cadastrar_dados_elemento_site',
        'dados' => array(
            'page' => "Cadastro de dados elementos site (Topo e/ou rodapé)- <strong><i>Campus - $campus->name ($campus->city) </i></strong>",
            'campus'=>$campus,
            'tipo'=>''
        )
    );

    $this->load->view('templates/layoutPainelAdm', $data);
  }

  public function editar_dados_elemento_site($uriCampus=NULL,$idElemento=NULL) {
    verificaLogin();

    $colunasCampus = array('campus.id','campus.name','campus.city');
    
    $campus = $this->painelbd->where($colunasCampus,'campus',NULL, array('campus.id'=>$uriCampus))->row();
    $colunasResultadoElemento = array(
      'gerais_elementos_site.id',
      'gerais_elementos_site.nome',
      'gerais_elementos_site.link',
      'gerais_elementos_site.cor_hexadecimal',
      'gerais_elementos_site.tipo',
      'gerais_elementos_site.status',
      'gerais_elementos_site.created_at',
      'gerais_elementos_site.updated_at',
      'gerais_elementos_site.user_id',
      

      'campus.city'
      );

    $joinIntegracaoDados = array(
      'campus'=>'campus.id = gerais_elementos_site.id_campus',
    );
  
    $whereDadosElementos = array('gerais_elementos_site.id'=>$idElemento);
    $elementoSite = $this->painelbd->where($colunasResultadoElemento,'gerais_elementos_site',$joinIntegracaoDados, $whereDadosElementos)->row();
       //Validaçãoes via Form Validation
   $this->form_validation->set_rules('nome', 'Nome do item', 'required');
   $this->form_validation->set_rules('tipo', 'Tipo do item', 'required');
   
   if ($this->form_validation->run() == FALSE) {
       if (validation_errors()):
           setMsg(validation_errors(), 'error');
       endif;
   }else {
        $dados_form['nome'] = $this->input->post('nome');
        $dados_form['tipo'] = $this->input->post('tipo');
        $dados_form['link'] = !empty($this->input->post('link')) ? $this->input->post('link') : NULL ;
        $dados_form['id_campus'] = $campus->id;
        
        $dados_form['user_id'] = $this->session->userdata('codusuario');
        $dados_form['status'] = $this->input->post('status');
        $dados_form['id'] = $elementoSite->id;
        // //Se o resultado da inserção for igual a TRUE, mostra uma mensagem
        if ($this->painelbd->salvar('gerais_elementos_site', $dados_form) == TRUE){
            setMsg('<p>Elemento do site editado com sucesso.</p>', 'success');
            redirect(base_url("Painel_geral/lista_dados_elementos_site/$campus->id"));
        }else{
            setMsg('<p>Erro! Algo de errado na validação dos dados.</p>', 'error');
        }
   }

    $data = array(
        'titulo' => 'UniAtenas',
        'conteudo' => 'paineladm/arquivos_gerais/elementos_site/editar_dados_elemento_site',
        'dados' => array(
            'page' => "Edição de dados elemento site (Topo e/ou rodapé) - <strong><i>Campus - $campus->name ($campus->city) </i></strong>",
            'campus'=>$campus,
            'elementoSite'=>$elementoSite,
            'tipo'=>''
        )
    );

    $this->load->view('templates/layoutPainelAdm', $data);
  }

  public function deletar_item_elemento_site($uriCampus=NULL,$id = NULL)
  {
      verifica_login();
  
      $item = $this->painelbd->where('*','gerais_elementos_site', NULL, array('gerais_elementos_site.id' => $id))->row(); 

      if ($this->painelbd->deletar('gerais_elementos_site', $item->id)) {
          setMsg('<p>O item foi deletado com sucesso.</p>', 'success');
          redirect(base_url("Painel_geral/lista_dados_elementos_site/$uriCampus"));
      } else {
          setMsg('<p>Erro! O item foi não deletado.</p>', 'error');
          redirect(base_url("Painel_geral/lista_dados_elementos_site/$uriCampus"));
      }
  }

}