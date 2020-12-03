<?php namespace App\Models;

use CodeIgniter\Model;

//ova klasa sluzi za rad sa tabelom Rezervacija iz baze podataka
class RezervacijaModel extends Model
{
    protected $table      = 'rezervacija';
    protected $primaryKey = 'id';
    protected $returnType = 'object';

    protected $allowedFields = ['datumOd', 
                                'datumDo',
                                'brojOsoba',
                                'napomena',
                                'status',
                                'idSmestaj',
                                'idKorisnika'
                                ];

    //vraca sve rezervacije smestaja ciji je ID prosledjen
    public function pretraziRezervacijeSmestaja($kljuc){
        return $this->where('idSmestaj',$kljuc)->findAll();
    }
    //vraca jednu rezervaciju na osnovu prosledjenog ID rezervacije
    public function dohvRezervaciju($id){
        return $this->where('id',$id)->first();
    }

    //menja status rezervacije u potvrdjena
    public function potvrdiRezervaciju($idRezervacija){
        $this->update($idRezervacija,['status'=>'potvrdjena']);
    }

    //menja status rezervacije u odbijena
    public function odbijRezervaciju($idRezervacija){
        $this->update($idRezervacija,['status'=>'odbijena']);
    }

    //dohvata sve nepotvrdjene rezervacije za smestaj ciji je ID prosledjen
    public function dohvSveNepotrvrdjene($id){
        $smestajModel = new SmestajModel();
        $sviSmestajiOglasavaca = $smestajModel->dohvOglaseOglasavaca($id);
        $cnt=0;

        $rezervacije = array();
        foreach($sviSmestajiOglasavaca as $smestaj){
            if(count($this->where('idSmestaj',$smestaj->id)->findAll())>0){
                $rezervacije[$cnt++] = $this->where('idSmestaj',$smestaj->id)->findAll();
            }
        }

        if(count($rezervacije)>0){
            foreach($rezervacije as $rezervacijaKey=>$rezervacijaValue){
                foreach($rezervacijaValue as $rezKey=>$rezValue){
                    if($rezervacijaValue[$rezKey]->status ==='potvrdjena' || $rezervacijaValue[$rezKey]->status ==='odbijena') unset($rezervacije[$rezervacijaKey][$rezKey]);   
                    if(count($rezervacije[$rezervacijaKey]) == 0) unset($rezervacije[$rezervacijaKey]);
                }
            }
            $cnt = 0;
            $rezervacijaFinal = array();
            foreach($rezervacije as $rezervacijaKey => $rezervacijaValue){
                foreach($rezervacijaValue as $rezKey=>$rezValue){
                    $rezervacijaFinal[$cnt++] = $rezValue;
                }
            }
            return $rezervacijaFinal;
        }
        return $rezervacije;
    }

    //dohvata sve rezervacije svih smestaja odredjenog oglasavaca ciji je ID prosledjen
    public function dohvBrojRezervacijaOglasavaca($id){
        $smestajModel = new SmestajModel();
        $sviSmestajiOglasavaca = $smestajModel->dohvOglaseOglasavaca($id);
        $cnt = 0;
        foreach($sviSmestajiOglasavaca as $smestaj){
            if(count($this->where('idSmestaj',$smestaj->id)->findAll())>0){
                $cnt++;
            }
        }
        return $cnt;
    }

    
    //vraca ID korisnika koji je ostavio recenziju ciji je ID prosledjen
    public function dohvIdKorisnika($id){
        return $this->where('id',$id)->first()->idKorisnika;
    }
    
    //vraca ID smestaja na koji se odnosti rezervacija ciji je ID prosledjen
    public function dohvSmestajId($idRezervacija){
        return $this->where('id',$idRezervacija)->first()->idSmestaj;
    }
    
    //brise sve rezervacije oglasa ciji je ID prosledjen
    public function obrisiRezervacijeZaOglas($id){
        $rezervacije = $this->where('idSmestaj',$id)->findAll();
        foreach($rezervacije as $rezervacija){
            $this->delete($rezervacija->id);
        }
    }
}