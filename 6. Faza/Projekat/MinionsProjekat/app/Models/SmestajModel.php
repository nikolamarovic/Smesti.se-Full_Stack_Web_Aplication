<?php namespace App\Models;

use CodeIgniter\Model;

//ova klasa sluzi za rad sa tabelom Smestaj iz baze podataka
class SmestajModel extends Model
{
    protected $table      = 'smestaj';
    protected $primaryKey = 'id';
    protected $returnType = 'object';
    protected $allowedFields = ['naziv',
                                'opis', 
                                'cena',
                                'idVlasnik',
                                'drzava',
                                'grad',
                                'ulica',
                                'broj',
                                'tipSmestaja',
                                'kapacitet',
                                'povrsina',
                                'cena',
                                'kuhinja',
                                'terasa',
                                'parking',
                                'lat',
                                'lon'
                               ];
    //dohvata sve oglasa oglasavaca sa datim IDjem
    public function dohvOglaseOglasavaca($idOglasavaca){
        return $this->where('idVlasnik',$idOglasavaca)->findAll();
    }
    //dohvata sve oglase iz baze
    public function dohvSveOglase(){
        return $this->findAll();
    }
    //sluzi za dohvatanje svih smestaja koji imaju u sebi dati kljuc,koristi se za pretragu
    public function pretrazi($kljuc){
        return $this->like('naziv',$kljuc)->orLike('drzava',$kljuc)->orLike('grad',$kljuc)->orLike('ulica',$kljuc)->findAll();
    }
    //brise sve smestaje korisnika ciji je ID prosledjen,prvo ih sve dohvati pa ih brise u petlji
    public function obrisiSmestajeKorisnika($id){
        $smestajiKorisnika = $this->where('idVlasnik',$id)->findAll();
        foreach($smestajiKorisnika as $smestaj){
            $this->obrisiSmestaj($smestaj->id);
        }
    }
    //brise smestaj sa prosledjenim IDjem,takodje brise sve recenzije i sve rezervacije datog oglasa
    public function obrisiSmestaj($id){
        $recenzijaModel = new \App\Models\RecenzijaModel();
        $recenzijaModel->obrisiRecenzijeZaOglas($id);
        $rezervacijaModel = new \App\Models\RezervacijaModel();
        $rezervacijaModel->obrisiRezervacijeZaOglas($id);
        return $this->delete($id);
    }
    //dohvata sve oglase sa datim kjucem u naslovu,sluzi za pretragu
    public function dohvOglasPoNazivu($naziv){
        return $this->like('naziv',$naziv)->findAll();
    }
    //dohvata jedan oglas sa prosledjenim IDjem
    public function dohvSmestaj($id){
        return ($this->where('id',$id)->find());
    }
    //dohvata jedan oglas sa prosledjenim IDjem
    public function dohvatiSmestajSaId($id) {
        return $this->where('id', $id)->find();
    }
    //dohvata ukupan broj oglasa nekog oglasavaca ciji je ID prosledjen
    public function dohvBrojSmestajaOglasavaca($id){
        return count($this->where('idVlasnik',$id)->findAll());
    }
    //dohvata ukupan broj oglasa
    public function dohvBrojSmestaja(){
        return count($this->findAll());
    }
}