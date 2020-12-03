<?php namespace App\Models;

use CodeIgniter\Model;

//ova klasa sluzi za rad sa tabelom Korisnici iz baze podataka

class KorisniciModel extends Model
{
    protected $table      = 'korisnici';
    protected $primaryKey = 'id';
    protected $returnType = 'object';
    protected $allowedFields = ['ime', 'prezime','username','password','email','adresa','tip','datumRodjenja','status'];
    //dohvata sve zahteve za clanstvo Oglasavaca koji nisu jos odobreni
    public function dohvSveZahteve(){
        return $this->where('status','cekanje')->findAll();
    }
    
    //odobrava zahtev za clanstvo jednom Oglasavacu na osnovu prosledjenog IDja zahteva
    public function odobriZahtev($id){
       $data = [
           'status' => 'aktivan'
       ];
       return $this->update($id,$data); 
    }
    //odbija zahtev za clanstvo jednom Oglasavacu na osnovu prosledjenog IDja zahteva
    public function odbijZahtev($id){
       $data = [
           'status' => 'odbijen'
       ];
       return $this->update($id,$data);
    }
    //dohvata sve Korisnike
    public function dohvSveKorisnike(){
      return $this->like('tip','oglasavac')->orLike('tip','korisnik')->findAll(); 
    }
    //Brise odredjenog korisnika ciji je ID prosledjen
    public function obrisiKorisnika($id){
      return $this->delete($id);
    }
    //Dohvata odredjenog korisnika ciji je ID prosledjen
    public function dohvKorisnika($id){
        return $this->where('id',$id)->findAll()[0];
    }
    //Dohvata broj svih korisnika 
    public function dohvBrojKorisnika(){
        return count($this->findAll());
    }
    //Dohvata broj svih zahtev za clanstvo Oglasavaca
    public function dohvBrojZahteva(){
       return count($this->where('status','cekanje')->findAll()); 
    }
}