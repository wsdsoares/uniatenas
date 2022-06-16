<?php

if (!defined("BASEPATH")) {
    exit("No direct script access allowed");
}

class Inicio_model extends CI_Model {

    public function do_insert($tabela = NULL, $dados = NULL, $redir = TRUE) {
        if ($dados != NULL):
            $this->db->insert("$tabela", $dados);
            if ($this->db->affected_rows() > 0):
                //auditoria('Inclusão de página', 'Nova página cadastrada no sistema');
                set_msg('msgok', '<div class="alert alert-success"><strong>Cadastro efetuado com sucesso</strong>!</div>', 'erro');
            else:
                set_msg('msgerro', '<div class="alert alert-danger"><strong>Erro ao inserir dados</strong>.</div>', 'erro');
            endif;
            if ($redir) {
                redirect(current_url());
            }
        endif;
    }

    public function get_all($table = NULL, $status = NULL, $ordem = NULL, $curso = NULL) {
        if ($table != NULL):
            //if($status!=NULL) $this->db->where('status', $status);
            if ($ordem != NULL) {
                $this->db->order_by("nome", 'asc');
            }
            if ($curso != NULL) {
                $this->db->where("idcourse", $curso);
            }
            return $this->db->get($table);
        else:
            return FALSE;
        endif;
    }

    public function get_matrizes($curso = NULL, $periodo_semestre = NULL, $tipo = NULL) {
        $table = "matrizes";
        if ($table != NULL):
            $this->db->where("cursos_id", $curso);
            $this->db->where("semestre", $periodo_semestre);
            if ($tipo != NULL) {
                $this->db->where("tipo", $tipo);
            }
            return $this->db->get($table);
        else:
            return FALSE;
        endif;
    }

    public function get_min($table = NULL, $condicao = NULL) {
        $this->db->select_min($condicao);
        return $this->db->get($table);
    }

    public function get_byid($tabela = NULL, $id = NULL) {
        if ($id != NULL && $tabela != NULL):
            $this->db->where('id', $id);
            $this->db->limit(1);
            return $this->db->get("$tabela");


        else:
            return FALSE;
        endif;
    }

    public function getCursoById($tabela = NULL, $id = NULL) {
        if ($id != NULL && $tabela != NULL):
            $this->db->where('idcourse', $id);
            $this->db->limit(1);
            return $this->db->get("$tabela");
        else:
            return FALSE;
        endif;
    }

    public function getCategoriaById($tabela = NULL, $id = NULL) {
        if ($id != NULL && $tabela != NULL):
            $this->db->where('idcategory', $id);
            $this->db->limit(1);
            return $this->db->get("$tabela");
        else:
            return FALSE;
        endif;
    }

    public function getCursoEmCategoria($category = NULL) {
        $this->db->where('category', $category);
        return $this->db->get("course");
    }

    public function getCursosPorDataCadastro() {
        $this->db->order_by("data_cadastro", 'desc');
        $this->db->where("status", 1);
        return $this->db->get('course');
    }

    public function getProfessoresDeCurso($idCurso) {
        $this->db->select('*')
                ->from('curso_professor')
                ->join('course', 'curso_professor.idCurso = course.idcourse')
                ->join('users', 'users.user_id = curso_professor.idUser')
                ->where('idcourse', $idCurso)
                ->order_by('idCursoProfessor');

        $result = $this->db->get();

        if ($result->num_rows() > 0):
            return $result->result();
        else:
            return array();
        endif;
    }

}

/* End of file paginas_model.php */
/* Location: ./application/models/paginas_model.php */