<?php namespace App\Models;

use CodeIgniter\Model;

//ova klasa sluzi za rad sa tabelom BrojRecenzija iz baze podataka

class BrojRecenzijaModel extends Model
{
    protected $table      = 'brojrecenzija';
    protected $primaryKey = 'id';
    protected $returnType = 'object';
    protected $allowedFields = ['idKorisnik', 
                                'idSmestaj',
                                'broj'
                                ];
    //povecava broj recenzija koje moze ostaviti neki korisnik za neki smestaj(sa prosledjenim IDjevima)
    public function povecaj($idKorisnik,$idSmestaj){
        $db = \Config\Database::connect();
        $builder = $db->table('brojrecenzija');
        $res = $builder->getWhere(['idKorisnik'=>$idKorisnik,'idSmestaj'=>$idSmestaj]);
        $result = $res->getResultObject();
        foreach($result as $tmp){
            $this->update($tmp->id,[
               'broj' => ++$tmp->broj
            ]);
        }
    }
    //smanjuje  broj recenzija koje moze ostaviti neki korisnik za neki smestaj(sa prosledjenim IDjevima)
    public function smanji($idKorisnik,$idSmestaj){
        $db = \Config\Database::connect();
        $builder = $db->table('brojrecenzija');
        $res = $builder->getWhere(['idKorisnik'=>$idKorisnik,'idSmestaj'=>$idSmestaj]);
        $result = $res->getResultObject();
        foreach($result as $tmp){
            $this->update($tmp->id,[
               'broj' => (--$tmp->broj<0?0:$tmp->broj)
            ]);
        } 
    }
    
    
    //vraca bool da li je neki Korisnik odseo u nekom smestaju(sa prosledjenim IDjevima)
    public function daLiPostoji($idKorisnik, $idSmestaj){
        $db = \Config\Database::connect();
        $builder = $db->table('brojrecenzija');
        $res = $builder->getWhere(['idKorisnik'=>$idKorisnik,'idSmestaj'=>$idSmestaj]);
        $result = $res->getResultObject();
        if($result) return true;
        else return false;
    }
    //vraca bool da li je neki Korisnik moze da ostavi recenziju za neki smestaj(sa prosledjenim IDjevima)
    public function smeDaOstaviRecenziju($idKorisnik, $idSmestaj){
        $db = \Config\Database::connect();
        $builder = $db->table('brojrecenzija');
        $res = $builder->getWhere(['idKorisnik'=>$idKorisnik,'idSmestaj'=>$idSmestaj]);
        $result = $res->getResultObject();
        foreach($result as $tmp){
            return $tmp->broj>0;
        }
    }    
}