<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Provincia extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('Provincia_model');
        $this->load->library('form_validation');        
	$this->load->library('datatables');
    }

    public function index()
    {
        $this->load->view('provincia/provincia_list');
    } 
    
    public function json() {
        header('Content-Type: application/json');
        echo $this->Provincia_model->json();
    }

    public function read($id) 
    {
        $row = $this->Provincia_model->get_by_id($id);
        if ($row) {
            $data = array(
		'id' => $row->id,
		'nome' => $row->nome,
	    );
            $this->load->view('provincia/provincia_read', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('provincia'));
        }
    }

    public function create() 
    {
        $data = array(
            'button' => 'Create',
            'action' => site_url('provincia/create_action'),
	    'id' => set_value('id'),
	    'nome' => set_value('nome'),
	);
        $this->load->view('provincia/provincia_form', $data);
    }
    
    public function create_action() 
    {
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->create();
        } else {
            $data = array(
		'nome' => $this->input->post('nome',TRUE),
	    );

            $this->Provincia_model->insert($data);
            $this->session->set_flashdata('message', 'Create Record Success');
            redirect(site_url('provincia'));
        }
    }
    
    public function update($id) 
    {
        $row = $this->Provincia_model->get_by_id($id);

        if ($row) {
            $data = array(
                'button' => 'Update',
                'action' => site_url('provincia/update_action'),
		'id' => set_value('id', $row->id),
		'nome' => set_value('nome', $row->nome),
	    );
            $this->load->view('provincia/provincia_form', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('provincia'));
        }
    }
    
    public function update_action() 
    {
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->update($this->input->post('id', TRUE));
        } else {
            $data = array(
		'nome' => $this->input->post('nome',TRUE),
	    );

            $this->Provincia_model->update($this->input->post('id', TRUE), $data);
            $this->session->set_flashdata('message', 'Update Record Success');
            redirect(site_url('provincia'));
        }
    }
    
    public function delete($id) 
    {
        $row = $this->Provincia_model->get_by_id($id);

        if ($row) {
            $this->Provincia_model->delete($id);
            $this->session->set_flashdata('message', 'Delete Record Success');
            redirect(site_url('provincia'));
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('provincia'));
        }
    }

    public function _rules() 
    {
	$this->form_validation->set_rules('nome', 'nome', 'trim|required');

	$this->form_validation->set_rules('id', 'id', 'trim');
	$this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
    }

    public function excel()
    {
        $this->load->helper('exportexcel');
        $namaFile = "provincia.xls";
        $judul = "provincia";
        $tablehead = 0;
        $tablebody = 1;
        $nourut = 1;
        //penulisan header
        header("Pragma: public");
        header("Expires: 0");
        header("Cache-Control: must-revalidate, post-check=0,pre-check=0");
        header("Content-Type: application/force-download");
        header("Content-Type: application/octet-stream");
        header("Content-Type: application/download");
        header("Content-Disposition: attachment;filename=" . $namaFile . "");
        header("Content-Transfer-Encoding: binary ");

        xlsBOF();

        $kolomhead = 0;
        xlsWriteLabel($tablehead, $kolomhead++, "No");
	xlsWriteLabel($tablehead, $kolomhead++, "Nome");

	foreach ($this->Provincia_model->get_all() as $data) {
            $kolombody = 0;

            //ubah xlsWriteLabel menjadi xlsWriteNumber untuk kolom numeric
            xlsWriteNumber($tablebody, $kolombody++, $nourut);
	    xlsWriteLabel($tablebody, $kolombody++, $data->nome);

	    $tablebody++;
            $nourut++;
        }

        xlsEOF();
        exit();
    }

}

/* End of file Provincia.php */
/* Location: ./application/controllers/Provincia.php */
/* Please DO NOT modify this information : */
/* Generated by Harviacode Codeigniter CRUD Generator 2018-08-11 23:37:56 */
/* http://harviacode.com */