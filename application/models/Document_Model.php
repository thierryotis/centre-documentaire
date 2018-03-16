<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Document_Model extends CI_Model{
	public function __construct(){
		parent::__construct();
		// $this->load->helpers('db_helper');
	}
	public function Ajout_Document($data){
		
		if($this->db->insert("doc",$data)){
			return true;
		}
		else{
			return false;
		}
	}
	public function Afficher_Document($field,$where){

		$this->db->select($field);
		$this->db->where($where);
		$requete=$this->db->get("doc");
		return $requete;
	}
	public function Actualiser_Document($where,$data){
		$count_doc=$this->db->count_all("doc");
		if ($where["document_id"]>=1) {
			if($where["document_id"]>$count_doc){
				return false;
			}
			else{
				$this->db->where($where);
				return ($this->db->update("doc",$data))?true:false;				
			}
		}
		else{
			return false;
		}

	}
	public function Supprimer_Document($tables,$where){
		
		return ($this->db->delete($tables,$where))?true:false;
	} 
}