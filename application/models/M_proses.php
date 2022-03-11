<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_proses extends CI_Model {
	
	public function __construct(){
        parent::__construct();
        $this->load->database();
    }

    public function list_pengajuan(){
		$this->db->select("kn.*, ds.nama AS namaDosen, hs.idHasilAnalisa, psd1.psd_name AS psd_asal, psd2.psd_name AS psd_tujuan, fa1.fa_name AS fa_asal, fa2.fa_name AS fa_tujuan,  hs.nilaiWPM");
		$this->db->from("kandidat AS kn");
		$this->db->where("hs.isApprove",'0');
		$this->db->join("dosen AS ds","ds.id = kn.idDosen");
		$this->db->join("hasilanalisa AS hs","hs.idKandidat = kn.idKandidat");
		$this->db->join("institusi AS fa1","fa1.fa_ID=kn.fa_asal","left");
		$this->db->join("institusi AS fa2","fa2.fa_ID=kn.fa_tujuan","left");
		$this->db->join('program_study AS psd1',"psd1.psd_ID = kn.psd_asal","left");
		$this->db->join("program_study AS psd2","psd2.psd_ID = kn.psd_tujuan","left");
		$query		= $this->db->get();
		$result 	= $query->result_array();
		return $result;
	}

	public function list_approval(){
		$this->db->select("kn.*, ptg.namaPetugas, ds.nama AS namaDosen, psd1.psd_name AS psd_asal, psd2.psd_name AS psd_tujuan, hs.idHasilAnalisa, fa1.fa_name AS fa_asal, fa2.fa_name AS fa_tujuan,  hs.nilaiWPM");
		$this->db->from("kandidat AS kn");
		$this->db->where("hs.isApprove",'1');
		$this->db->join("dosen AS ds","ds.id = kn.idDosen");
		$this->db->join("hasilanalisa AS hs","hs.idKandidat = kn.idKandidat");
		$this->db->join("petugas AS ptg","ptg.idPetugas=hs.approveBy");
		$this->db->join("institusi AS fa1","fa1.fa_ID=kn.fa_asal","left");
		$this->db->join("institusi AS fa2","fa2.fa_ID=kn.fa_tujuan","left");
		$this->db->join('program_study AS psd1',"psd1.psd_ID = kn.psd_asal","left");
		$this->db->join("program_study AS psd2","psd2.psd_ID = kn.psd_tujuan","left");
		$query		= $this->db->get();
		$result 	= $query->result_array();
		return $result;
	}

	public function list_rejection(){
		$this->db->select("kn.*, ptg.namaPetugas, ds.nama AS namaDosen, psd1.psd_name AS psd_asal, psd2.psd_name AS psd_tujuan, hs.idHasilAnalisa, fa1.fa_name AS fa_asal, fa2.fa_name AS fa_tujuan, hs.nilaiWPM");
		$this->db->from("kandidat AS kn");
		$this->db->where("hs.isApprove",'2');
		$this->db->join("dosen AS ds","ds.id = kn.idDosen");
		$this->db->join("hasilanalisa AS hs","hs.idKandidat = kn.idKandidat");
		$this->db->join("petugas AS ptg","ptg.idPetugas=hs.approveBy");
		$this->db->join("institusi AS fa1","fa1.fa_ID=kn.fa_asal","left");
		$this->db->join("institusi AS fa2","fa2.fa_ID=kn.fa_tujuan","left");
		$this->db->join('program_study AS psd1',"psd1.psd_ID = kn.psd_asal","left");
		$this->db->join("program_study AS psd2","psd2.psd_ID = kn.psd_tujuan","left");
		$query		= $this->db->get();
		$result 	= $query->result_array();
		return $result;
	}

	public function dataKandidat($par){
		$this->db->select("kn.*, psd1.psd_name AS psd_asal, psd2.psd_name AS psd_tujuan, fa1.fa_name AS faAsal, fa2.fa_name AS faTujuan, ds.nama AS namaDosen, ds.nip AS nipDosen");
		$this->db->from("kandidat AS kn");
		$this->db->join("institusi AS fa1","fa1.fa_ID=kn.fa_asal","left");
		$this->db->join("institusi AS fa2","fa2.fa_ID=kn.fa_tujuan","left");
		$this->db->join("dosen AS ds","ds.id = kn.idDosen");
		$this->db->join('program_study AS psd1',"psd1.psd_ID = kn.psd_asal","left");
		$this->db->join("program_study AS psd2","psd2.psd_ID = kn.psd_tujuan","left");
		$this->db->where("kn.idKandidat",$par);
		$query	= $this->db->get();
		$result = $query->result_array();
		return $result[0];
	}

	public function list_fakultas(){
		$this->db->select("*");
		$this->db->from("institusi");
		$query		= $this->db->get();
		$result		= $query->result_array();
		return $result;
	}
	public function list_progstudi(){
		$this->db->select("*");
		$this->db->from("program_study");
		$query	= $this->db->get();
		$result = $query->result_array();
		return $result;
	}

	public function list_kriteria($is_upload){
		$this->db->select("*");
		$this->db->from("kriteria");
		//$this->db->where("is_upload",$is_upload);
		$this->db->where("is_delete",0);
		$query		= $this->db->get();
		$result 	= $query->result_array();
		return $result;
	}

	public function list_AllKriteria(){
		$this->db->select("*");
		$this->db->from("kriteria");
		$this->db->where("is_delete",0);
		$query		= $this->db->get();
		$result 	= $query->result_array();
		return $result;
	}

	public function list_sub_kriteria($par,$par2){
		$this->db->select("*");
		$this->db->from("detilkandidat AS dtk");
		$this->db->join("subkriteria AS sub","sub.idSubKriteria = dtk.idSubKriteria");
		$this->db->join("kriteria as krit","krit.idKriteria = sub.idKriteria");
		$this->db->where("dtk.idKandidat",$par);
		$this->db->where("krit.idKriteria",$par2);
		$query		= $this->db->get();
		$result 	= $query->result_array();
		return $result;
	}

	public function list_sub_kriteria2($par){
		$this->db->select("sub.*");
		$this->db->from("subkriteria AS sub");
		$this->db->join("detilkandidat as dtk","dtk.idSubKriteria = sub.idSubKriteria","left");
		$this->db->where("sub.idKriteria",$par);
		$query		= $this->db->get();
		$result 	= $query->result_array();
		return $result;
	}

	public function getDosenName($par){
		$this->db->select("nama,nip");
		$this->db->from("dosen");
		$this->db->where("id",$par);
		$query	= $this->db->get();
		$result = $query->row_array();
		return $result;
	}

	public function getDeosenEmail($par){
		$this->db->select("email");
		$this->db->from("dosen");
		$this->db->where("id",$par);
		$query	= $this->db->get();
		$result = $query->row()->email;
		return $result;
	}

}