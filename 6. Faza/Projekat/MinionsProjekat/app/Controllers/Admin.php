<?php namespace App\Controllers;

use App\Models\KorisniciModel;
use App\Models\SmestajModel;
use App\Models\RecenzijaModel;

//Admin - klasa za admina koja je aktivna kada se gost uloguje kao admin
class Admin extends BaseController
{   
    //sluzi za prikaz stranice unutar kontrolera 
    protected function prikaz($page,$data){
        $data['controller']='Admin';
        $data['admin']=$this->session->get('admin');
        echo view('sablon/header',$data);
        echo view("stranice/$page",$data);
        echo view('sablon/footer');
    }

    //inicijalna stranica kontrolera
    public function index(){
        $this->prikaz('pocetna_admin',[]);
    }
    
    //prikazuje stranicu za pretragu
    public function pretraga(){
        $kljucPretrage = $this->request->getVar('kljucPretrage');
        $smestajModel = new SmestajModel();
        $smestaji = $smestajModel->pretrazi($kljucPretrage);
        $this->prikaz('pocetna',['smestaji'=>$smestaji,'trazeno'=>$kljucPretrage]);
    }
    
    //prikazuje stranicu gde se nalaze svi smestaji, to je pocetna stranica gosta i korisnika i sluzi
    //da prikaze smestaje
    public function pregledSvihSmestaja(){
        $smestajModel = new SmestajModel();
        $smestaji = $smestajModel->dohvSveOglase();
        $this->prikaz('pocetna',['sviSmestaji'=>$smestaji]);
    }
    
    //brise trazeni smestaj samim tim i recenzije i rezervacije vezane za njega
    public function obrisiSmestaj($id){
        $smestajModel = new SmestajModel();
        $smestajModel->obrisiSmestaj($id);
        $recenzijaModel = new \App\Models\RecenzijaModel();
        $recenzijaModel->obrisiRecenzijeZaOglas($id);
        $rezervacijaModel = new \App\Models\RezervacijaModel();
        $rezervacijaModel->obrisiRezervacijeZaOglas($id);
        return redirect()->to(site_url("Admin/pregledSvihSmestaja/"));
    }
    
    //prikazuje sve recenzije na sajtu
    public function pregledSvihRecenzija(){
        $this->prikaz('spisak_recenzija',[]);
    }
    
    //prikazuje stranicu sa svim korisnicima na sajtu
    public function pregledSvihKorisnika(){
        $this->prikaz('spisak_korisnika',[]);
    }
    
    //uklanja trazenog korisnika iz baze samim tim i sve njegove smestaje
    public function ukloniKorisnika($id){
        $korisniciModel = new KorisniciModel();
        $korisniciModel->obrisiKorisnika($id);
        $smestajModel = new SmestajModel();
        $smestajModel->obrisiSmestajeKorisnika($id);
        return redirect()->to(site_url("Admin/pregledSvihKorisnika/"));
    }
    
    //prikazuje zahteve za oglasavaca
    public function pregledSvihZahteva(){
        $this->prikaz('spisak_zahteva',[]);
    }
    
    //potvrdjuje zahtev oglasavaca i salje mejl korisniku sa njegovim podacima 
    public function odobriZahtev($id){
        $korisniciModel = new KorisniciModel();
        $korisniciModel->odobriZahtev($id);
        $korisnik = $korisniciModel->dohvKorisnika($id);

        $telo_poruke = "    
                  <html>
                  <body>
                  <h1 style=\"color:blue;\">Podaci o korisniku</h1>
                  <p>Ime: {$korisnik->ime}</p>     
                  <p>Prezime: {$korisnik->prezime}</p>
                  <p style=\"color:red;\">Korisnicko ime: {$korisnik->username}</p>
                  <p style=\"color:red;\"><b><u>Sifra: {$korisnik->password}</u></b></p>
                  <p>E-mail adresa: {$korisnik->email}</p>
                  <p>Adresa: {$korisnik->adresa}</p>
                  <p>Tip korisnika: {$korisnik->tip}</p>
                  <p>Datum Rodjenja: {$korisnik->datumRodjenja}</p>
                  <p>Status: {$korisnik->status}</p>
                  </html> ";
        $promenljiva = $korisnik->ime . " " . $korisnik->prezime;
        Gost::mail($promenljiva, $korisnik->email, "Podaci o registrovanom oglašavaču na sajtu \"Smesti.se\"", $telo_poruke);

        return redirect()->to(site_url("Admin/pregledSvihZahteva/"));
    }

    //odbija zahtev oglasavaca
    public function odbijZahtev($id){
        $korisniciModel = new KorisniciModel();
        $korisniciModel->odbijZahtev($id);
        return redirect()->to(site_url("Admin/pregledSvihZahteva/"));
    }
    
    //prikazuje trazeni smestaj
    public function smestajPrikaz($id){
        $smestajModel = new SmestajModel();
        $smestaj = $smestajModel->find($id);
        $this->prikaz('smestaj',['smestaj'=>$smestaj]);
    }

    //brise trazenu recenziju
    public function obrisiRecenziju($idRecenzije){
        $recenzijaModel = new RecenzijaModel();
        $recenzijaModel->obrisiRecenziju($idRecenzije);
        return redirect()->to(site_url("Admin/pregledSvihRecenzija/")); 
    }

    //odjavljuje korisnika i vraca na pocetnu stranu gosta
    public function logout(){
        $this->session->destroy();
        return redirect()->to(site_url('/'));
    }

    //funkcija koja se aktivira klikom na naziv sajta na vrhu ekrana ili na logo u gornjem levom uglu
    //vraca trenutnog kontrolera na njegovu pocetnu stranicu
    public function backToHome(){
        return redirect()->to(site_url('Admin')); 
    }

    //prikazuje sve recenzije za dati oglas
    public function sveRecenzijeOglasa($id){
        $smestajModel = new SmestajModel();
        $smestaj = $smestajModel->dohvSmestaj($id)[0];
        $this->prikaz('spisak_recenzija',['smestaj'=>$smestaj]);
    }
    

    //metoda koja se poziva pomocu ajaksa, sluzi da dohvati ukupan broj smestaja, korisnika, zahteva i recenzija na sajtu
    public function dohvUkupanBrojAdmin(){
        $recenzijaModel = new RecenzijaModel();
        $smestajModel = new SmestajModel();
        $korisniciModel = new KorisniciModel();
        
        $smestajBroj = $smestajModel->dohvBrojSmestaja();
        $zahteviBroj = $korisniciModel->dohvBrojZahteva();
        $recenzijeBroj = $recenzijaModel->dohvBrojSvihRecenzija();
        $korisniciBroj = $korisniciModel->dohvBrojKorisnika();
        
        $data = [
            'smestajBroj' => $smestajBroj,
            'zahteviBroj' => $zahteviBroj,
            'recenzijeBroj' => $recenzijeBroj,
            'korisniciBroj' => $korisniciBroj,
        ];
        header("Content-Type: application/json" );
        echo json_encode($data);
    }
    
    //funkcija koja se koristi u ajax metodi za dohvatanje broja obavestenja
    //s obzirom da je ovo kontroler koji nema funkcionalnost za primanje obavestenja, ova funkcija nema efekta
    public function dohvBrojObavestenja(){
        $data = ["broj"=>0];
        header("Content-Type: application/json");
        echo json_encode($data);
    }
}
