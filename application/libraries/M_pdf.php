<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

require_once  'mpdf/index.php';

class M_pdf
{
    public $param;
    public $pdf;

    public function __construct($param = '"en-GB-x","A4","","",10,10,10,10,6,3')
    {
        $this->param = $param;
        $this->pdf = new mPDF($this->param);
    }
}
