<?php namespace App\Models;

use CodeIgniter\Model;
//ova klasa sluzi za rad sa tabelom FilePathDokumentacijeSmestaja iz baze podataka
//koristi se za rad sa slikama smestaja

class FilePathDokumentacijeSmestajaModel extends Model
{
    protected $table      = 'filepathdokumentacijesmestaja';
    protected $primaryKey = 'id';
    protected $returnType = 'object';
    protected $allowedFields = ['filepath', 'idSmestaj'];
    //dohvata sve slike za odredjeni oglas Smestaja ciji je ID prosledjen
    public function dohvSlikeSmestaja($id){
        return $this->where('idSmestaj',$id)->findAll();
    }
}