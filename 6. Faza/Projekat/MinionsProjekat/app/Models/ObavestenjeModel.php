<?php namespace App\Models;

use CodeIgniter\Model;
//ova klasa sluzi za rad sa tabelom Obavestenja iz baze podataka

class ObavestenjeModel extends Model
{
    protected $table      = 'obavestenja';
    protected $primaryKey = 'id';
    protected $returnType = 'object';
    protected $allowedFields = ['idKorisnik', 'opis', 'naslov','tip'];
    //dohvata sva obavestenja nekog korisnika ciji je ID prosledjen
    public function dohvObavestenjaKorisnika($id){
        return $this->where('idKorisnik',$id)->findAll();
    }
    //dohvata ukupan broj obavestenja za nekog korisnika ciji je ID prosledjen
    public function dohvBrojObavestenja($id){
        return count($this->where('idKorisnik',$id)->findAll());
    }
    //brise jedno obavestenje na osnovu prosledjenog ID
    public function obrisiObavestenje($id){
        return $this->delete($id);
    }
}