<?php namespace App\Models;

use CodeIgniter\Model;

//ova klasa sluzi za rad sa tabelom Recenzija iz baze podataka
class RecenzijaModel extends Model
{
    protected $table      = 'recenzija';
    protected $primaryKey = 'id';
    protected $returnType = 'object';
    protected $allowedFields = ['cistoca','komfor','kvalitet','lokacija','ljubaznost','opstiUtisak','tip','idSmestaj','idKorisnik','idOglasavac','komentar','odgovor'];
    
    //dohvata sve recenzije oglasa ciji je ID prosledjen
    public function dohvSveRecenzijeOglasa($id){
        return $this->where('idSmestaj',$id)->findAll();
    }
    //vraca ID smestaja za koji je ostavljena recenzija ciji je ID prosledjen
    public function dohvSmestajId($id){
        return $this->where('id',$id)->first()->idSmestaj;
    }
    //vraca ID korisnika koji je ostavio recenziju ciji je ID prosledjen
    public function dohvKorisnikId($id){
        return $this->where('id',$id)->first()->idKorisnik; 
    }
    //dohvata sve recenzije svih oglasa nekog oglasavaca ciji je ID prosledjen
    public function dohvSveRecenzijeOglasavaca($id){
        return $this->where('idOglasavac',$id)->findAll();
    }
    //vraca ukupan broj recenzija svih oglasa nekog oglasavaca ciji je ID prosledjen
    public function dohvBrojRecenzijaOglasavaca($id){
        return count($this->where('idOglasavac',$id)->findAll()); 
    }
    //dohvata SVE recenzije
    public function dohvSveRecenzije(){
        return $this->findAll();
    }
    //dohvata odredjenu recenziju ciji je id prosledjen
    public function dohvRecenziju($id){
        return $this->where('id',$id)->findAll()[0];
    }
    //upisuje odgovor na odredjenu recenziju ciji se ID prosledjuje
    public function unesiOdgovor($id,$odgovor){
       $data = [
           'odgovor' => $odgovor
       ];
       return $this->update($id,$data); 
    }
    //brise recenziju sa prosledjenim ID recenzije
    public function obrisiRecenziju($id){
        return $this->delete($id);
    }
    
    //brise sve recenzije za oglas ciji je ID prosledjen
    public function obrisiRecenzijeZaOglas($id){
        $recenzije = $this->where('idSmestaj',$id)->findAll();
        foreach($recenzije as $recenzija){
            $this->delete($recenzija->id);
        }
    }
    
    //dohvata porosek za odredjeni smestaj ciji je ID prosledjen
    public function dohvProsek($kljuc,$idSmestaj){
        $data = [
            'opstiUtisak'=>$kljuc,
            'idSmestaj'=>$idSmestaj,
        ];
        $res1 =  count($this->where('opstiUtisak',$kljuc)->where('idSmestaj',$idSmestaj)->findAll());
        $res2 =  count($this->where('idSmestaj',$idSmestaj)->findAll());
        if($res1 == 0 || $res2 == 0) return 0; 
        return 100*($res1/$res2);//0.66667 ceil  je 1
    }
    
    //dohvata porosek ocene za odredjeni smestaj ciji je ID prosledjen
    public function dohvProsecnuOcenu($idSmestaj){
        $recenzije = $this->where('idsmestaj',$idSmestaj)->findAll();
        $sum = 0;
        $cnt=0;
        foreach($recenzije as $recenzija){
            $cnt++;
            $sum+=($recenzija->komfor+$recenzija->kvalitet+$recenzija->ljubaznost+$recenzija->cistoca+$recenzija->lokacija)/5;
        }
        if($sum==0 || $cnt==0) return 0;
        return $sum/$cnt;
    }
    //dohvata ukupan broj recenzija za neki smestaj ciji je ID prosledjen
    public function dohvBrojRecenzija($idSmestaj){
        return count($this->where('idSmestaj',$idSmestaj)->findAll());
    }
    //dohvata broj SVIH recenzija
    public function dohvBrojSvihRecenzija(){
        return count($this->findAll());
    }
}