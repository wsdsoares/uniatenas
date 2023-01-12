<?php

if (!defined("BASEPATH"))
    exit("No direct script access allowed");

class Vestibular_model extends CI_Model {

    public function getQuery($sql = NULL) {
        $DB2 = $this->load->database('dbVest', TRUE);
        if ($sql != NULL):
            return $DB2->query($sql);
        endif;
    }


    public function getWhere($table = NULL, $where = NULL, $order = NULL, $limit= NULL)
    {
        $DB2 = $this->load->database('dbVest', TRUE);
        if (isset($where)) {
            foreach($where as $key => $value){
                $DB2->where($key,  $value);
            }
        }
        if ($order != NULL) {
            $DB2->order_by($order['campo'], $order['ordem']);
        }
        if ($limit != NULL) {
            $DB2->limit($limit);
        }
        return $DB2->get($table);
    }

    public function salvar($tabela = NULL, $dados = NULL)
    {
        $DB2 = $this->load->database('dbVest', TRUE);
        if (isset($dados['id'])) {
            $DB2->where('id', $dados['id']);
            unset($dados['id']);
            $DB2->update("$tabela", $dados);
            return TRUE;
        } else {
            $DB2->insert("$tabela", $dados);
            return TRUE;
        }
    }

    public function where($fields = NULL, $table = NULL, $dataJoin = NULL, $where = NULL, $order = NULL, $limit = NULL)
    {
        $DB2 = $this->load->database('dbVest', TRUE);
        if ($fields != NULL) {
            if ($fields == '*') {
                $DB2->select('*');
            } else {
                foreach ($fields as $key => $value) {
                    $DB2->select($value);
                }
            }
        }

        if (isset($where)) {
            $DB2->where($where);
        }
        /*if ($order != NULL) {
            $DB2->order_by($order['campo'], $order['ordem']);
        }
        if ($limit != NULL) {
            return $DB2->get($table, $limit);
        }
        if ($dataJoin != NULL) {
            foreach ($dataJoin as $key => $value) {
                $DB2->join($key, $value);
            }
        }*/
        return $DB2->get($table);
    }



}