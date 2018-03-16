<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Document_Controller extends CI_Controller{
	public function __construct(){
		parent::__construct();
		$this->load->database();
		$this->load->helpers('url');
		$this->load->helper('array');
		$this->load->library("upload");
	}
/*
*@ Date de création 05/02/2018
*@ Auteur : Cédrico Gaelo, cedricgaelo@gmail.com
*@ param titre du document: string,
*@ param intro document: string,
*@ param droit d'auteur document: string,
*@ param consultation document: string,
*@ param isbn document: string,
*@ param durée du document: string,
*@ param type de document: string,
*@ param document theme: string,
*@ param identifiant usage fais: int,
*@ param identifiant ajustement: int,
*@ param identifiant demande ajustement: int,
*@ param document theme : string,
*@ return true
*/

// just for the test
	public $form_upload='

		<form method="post" enctype="multipart/form-data">

		<input type="file" name="userfile" size="20" />

		<br /><br />

		<input type="submit" value="upload" />

		</form>

		';
	public function upload_path($type){
		if(isset($type)){
			switch ($type) {
				case 'image/gif':
					return "../centre-documentaire-master/uploads/images";
					break;
				case 'image/jpeg':
					return "../centre-documentaire-master/uploads/images";
					break;
				case 'image/png':
					return "../centre-documentaire-master/uploads/images";
					break;
				case 'application/pdf':
					return "../centre-documentaire-master/uploads/documents";
					break;
				case 'application/vnd.openxmlformats-officedocument.wordprocessingml.document':
					return "../centre-documentaire-master/uploads/documents";
					break;
				case 'text/plain':
					return "../centre-documentaire-master/uploads/documents";
					break;
				case 'video/mp4':
					return "../centre-documentaire-master/uploads/videos";
					break;
				default:
					return "../centre-documentaire-master/uploads";
					break;
			}
		}
	}
	public function Ajout_Document(){

	    echo $this->form_upload;
	    // $a="toto";
	    $b=&$a;
	    echo $b;
	    if(isset($_FILES['userfile']['type'])){

			$config['upload_path']=$this->upload_path($_FILES['userfile']['type']);
		}
		$config['allowed_types']="jpg|png|gif|pdf|docx|mp4|avi";
		$this->upload->initialize($config);
		if ($this->upload->do_upload("userfile")) {
 
			$data= Array(
				"document_title"=>$this->upload->data("raw_name"),
				"document_intro"=>"EVELYNE MPOUDI NGOLLE",
				"document_rights"=>"tous droits réservé",
				"document_consultation"=>"1",
				"document_isbn"=>"238940",
				"document_duree"=>"12 heurs",
				"document_type"=>$this->upload->data("file_ext"),
				"use_id"=>"1",
				"ajustment_id"=>"2",
				"request_id"=>"1",
				"document_theme"=>"littérature"
			);
			$data=$this->security->xss_clean($data);
				
			$this->load->model('document_model','doc');
			// $this->doc->Ajout_Document($data);
			if($this->doc->Ajout_Document($data)){
				echo "enregistrement réussi";
			}
			else{
				echo "Erreur l'hors de l'enregistrement du document";
			}
		}
		else{
			echo $this->upload->display_errors();
		}
	}
	public function Afficher_Document(){
		$where= array("document_id"=>2);
		$field= array("document_intro");
		//  chargement du modèle
		$this->load->model('document_model','doc'); 
		$r=$this->doc->Afficher_Document($field,$where);
 /*
	déclaration du tableau qui contiendra le résulat de la requête.
	initialisation du compteur
 */
		$data_result= array();
		$i=0;
		foreach ($r->result() as $row) {
			// preparation de la variable pour la vue
			$data_result[$i]=$row->document_intro;
			$i++;
		}
		$data= array(
			"data"=>$data_result
		);
		$this->load->view('welcome_message',$data);
	}
	public function Actualiser_Document(){

			$data= Array(
				"document_title"=>"Trois prétendant un mari",
				"document_intro"=>"EVELYNE",
				"document_rights"=>"tous droits réservé",
				"document_consultation"=>"1",
				"document_isbn"=>"238940",
				"document_duree"=>"12 heurs",
				"document_type"=>"pdf",
				"use_id"=>"1",
				"ajustment_id"=>"2",
				"request_id"=>"1",
				"document_theme"=>"littérature"
			);
		$where= array("document_id"=>3);
		$this->load->model("document_model","doc");
		if ($this->doc->Actualiser_Document($where,$data)){

			echo "Success update";
		}
		else{
			echo "Unexpected error when we have try to update";
		}
	}
	public function Supprimer_Document(){

		$tables= array("doc");
		$where= array("document_id"=>7);
		$this->load->model("document_model","doc");
		if ($this->doc->Supprimer_Document($tables,$where)){
			echo "Success delete";
		}
		else{
			echo "Unexpected error when we have try to delete";
		}
	} 
}