<?php

namespace App\Controllers;

use App\Models\FilePathDokumentacijeSmestajaModel;
use App\Models\SmestajModel;
use App\Models\RezervacijaModel;
use App\Models\RecenzijaModel;
use App\Models\ObavestenjeModel;
use App\Models\KorisniciModel;

//Oglasavac - klasa za korisnika sajta koja je aktivna ako se gost uloguje kao oglasavac i ako je njegov zahtev odobren od strane admina
class Oglasavac extends BaseController {

    //funkcija koja sluzi za prikaz bilo koje stranice unutar ovog kontrolera
    protected function prikaz($page, $data) {
        $data['controller'] = 'Oglasavac';
        $data['oglasavac'] = $this->session->get('oglasavac');
        echo view('sablon/header', $data);
        echo view("stranice/$page", $data);
        echo view('sablon/footer');
    }

    //inicijalna stranica kontrolera
    public function index() {
        $this->prikaz('pocetna_oglasavac', []);
    }

    //funkcija koja otvara stranicu gde se postavlja oglas
    public function postavljanjeOglasa() {
        $this->prikaz('postavljanje_oglasa', []);
    }
    //funkcija koja potvrdjuje postavljanje oglasa i prebacuje na stranicu za prikaz tog oglasa
    public function postavljanje_oglasa_submit() {
        //Validacija unetih oglasa
        if (!$this->validate(
            [
            'naziv' => 'required',
            'room_type' => 'required',
            'kapacitet' => 'required',
            'povrsina' => 'required',
            'cena' => 'required',
            'kitchen_type' => 'required',
            'parking' => 'required',
            'terasa' => 'required',
            'ulica' => 'required',
            'broj' => 'required',
            'grad' => 'required',
            'ptt' => 'required',
            'drzava' => 'required',
            'opis' => 'required|max_length[1500]',
            ],
            [
            'naziv' => ['required' => 'Naziv je obavezan!'],
            'room_type' => ['required' => 'Tip sobe je obavezan!'],
            'kapacitet' => ['required' => 'Kapacitet je obavezan!'],
            'povrsina' => ['required' => 'Povrsina je obavezna!'],
            'cena' => ['required' => 'Cena je obavezna!'],
            'kitchen_type' => ['required' => 'Kuhinja je obavezna!'],
            'parking' => ['required' => 'Parking je obavezan!'],
            'terasa' => ['required' => 'Terasa je obavezna!'],
            'ulica' => ['required' => 'Ulica je obavezna!'],
            'broj' => ['required' => 'Broj je obavezan!'],
            'grad' => ['required' => 'Grad je obavezan!'], 
            'ptt' => ['required' => 'Postanski broj je obavezan!'],
            'drzava' => ['required' => 'Drzava je obavezna!'],
            'opis' => ['required' => 'Opis je obavezan!','max_length'=>'Opis je predugacak!']
            ]
        )) return $this->prikaz('postavljanje_oglasa', ['errors' => $this->validator->getErrors()]);
    

        //Odredjivanje tipa smestaja na osnovu unetih parametara
        $smestajModel = new SmestajModel();
        if ($this->request->getVar('room_type') == 'soba') {
            $room_type = 'Soba';
        } else if ($this->request->getVar('room_type') == 'apartman') {
            $room_type = 'Apartman';
        } else if ($this->request->getVar('room_type') == 'hotelskaSoba') {
            $room_type = 'Hotelska soba';
        } else {
            $room_type = 'Vikendica';
        }
        
        //Provera da li je smestaj sa ovakvim imenom vec psotoji
        $smestaji = $smestajModel->findAll();
        foreach ($smestaji as $smestaj) {
            if ($this->request->getVar('naziv') == $smestaj->naziv) {
                $greska = "Ovo ime je vec zauzeto.";
                return $this->prikaz('postavljanje_oglasa', ['greska' => $greska]);
            }
        }
        echo $this->request->getVar('lat');
        echo $this->request->getVar('lon');

        $smestajModel->save([
            'naziv' => $this->request->getVar('naziv'),
            'opis' => $this->request->getVar('opis'),
            'drzava' => $this->request->getVar('drzava'),
            'grad' => $this->request->getVar('grad'),
            'ulica' => $this->request->getVar('ulica'),
            'broj' => $this->request->getVar('broj'),
            'cena' => (int) $this->request->getVar('cena'),
            'idVlasnik' => $this->session->get('oglasavac')->id,
            'tipSmestaja' => $this->request->getVar('room_type'),
            'kapacitet' => (int) $this->request->getVar('kapacitet'),
            'povrsina' => (int) $this->request->getVar('povrsina'),
            'kuhinja' => $this->request->getVar('kitchen_type') === 'da' ? true : false,
            'terasa' => $this->request->getVar('terasa') === 'da' ? true : false,
            'parking' => $this->request->getVar('parking') === 'da' ? true : false,
            'lat' => $this->request->getVar('lat'),
            'lon' => $this->request->getVar('lon')
        ]);

        $slikeModel = new FilePathDokumentacijeSmestajaModel();
        //napravi nov direktorijum u public/slike koji se zove kao naziv smestaja
        $ime = $this->request->getVar('naziv');
        mkdir("slike/" . $ime . "/");

        $count = count($_FILES["fileToUpload"]["name"]);
        $target_dir = "slike/" . $ime . "/";
        $uploadOk = 1;
        
        //Provera da li je file odgovarajuceg tipa.
        //Fajlovi se smestaju na server samo ako su png/jpg/jpeg formata.
        for ($i = 0; $i < $count; $i++) {
            $target_dir = "slike/" . $ime . "/";
            $target_file = $target_dir . basename($_FILES["fileToUpload"]["name"][$i]);
            $imageFileType = pathinfo($target_file, PATHINFO_EXTENSION);
            if ($imageFileType == 'png' || $imageFileType == 'jpg' || $imageFileType == 'jpeg' ||
                    $imageFileType == 'PNG' || $imageFileType == 'JPG' || $imageFileType == 'JPEG'
            ) {
                $slikeModel->save([
                    'filepath' => "slike/" . $ime . "/" . $_FILES["fileToUpload"]["name"][$i],
                    'idSmestaj' => $smestajModel->getInsertId()
                ]);
                move_uploaded_file($_FILES["fileToUpload"]["tmp_name"][$i], $target_file);
            }
        }
        return redirect()->to(site_url("Oglasavac/smestajPrikaz/{$smestajModel->getInsertId()}"));
    }
    //funkcija koja prikazuje trazeni smestaj
    public function smestajPrikaz($id) {
        $smestajModel = new SmestajModel();
        $smestaj = $smestajModel->find($id);
        $this->prikaz('smestaj', ['smestaj' => $smestaj]);
    }

    //funkcija koja brise smestaj, samim tim i rezervacije i recenzije za taj smestaj
    public function obrisiSmestaj($id) {
        $smestajModel = new SmestajModel();
        $smestajModel->obrisiSmestaj($id);
        return redirect()->to(site_url("Oglasavac/smestajiOglasavaca/"));
    }

    //prikazuje sve recenzije za trazeni oglas
    public function sveRecenzijeOglasa($id) {
        $smestajModel = new SmestajModel();
        $smestaj = $smestajModel->dohvSmestaj($id)[0];
        $this->prikaz('spisak_recenzija', ['smestaj' => $smestaj]);
    }

    //prikazuje stranicu sa svim recenzijama za oglasavaca
    public function sveRecenzijeOglasavaca() {
        $this->prikaz('spisak_recenzija', ['idOglasavaca' => $this->session->get('oglasavac')->id]);
    }

    //prikazuje stranicu pretraga
    public function pretraga() {
        $kljucPretrage = $this->request->getVar('kljucPretrage');
        $smestajModel = new SmestajModel();
        $smestaji = $smestajModel->pretrazi($kljucPretrage);
        $this->prikaz('pocetna', ['smestaji' => $smestaji, 'trazeno' => $kljucPretrage]);
    }

    //prikazuje stranicu sa nepotvrdjenim rezervacijama oglasavaca
    public function rezervacije() {
        $rezervacijaModel = new \App\Models\RezervacijaModel();
        $nepotvrdjeneRezervacije = $rezervacijaModel->dohvSveNepotrvrdjene($this->session->get('oglasavac')->id);
        $this->prikaz('nepotvrdjene_rezervacije_oglasavac', ['nepotvrdjeneRezervacije' => $nepotvrdjeneRezervacije]);
    }

    //potvrdjuje da se korisnik koji je rezervisao smestaj pojavio i samim tim uvecava broj u tabli brojRecenzija
    public function potvrdiRezervaciju($idRezervacija) {
        $brojRecenzijaModel = new \App\Models\BrojRecenzijaModel();
        $brojRecenzijaModel->povecaj($_SESSION['idKorisnikRezervacija'], $_SESSION['idSmestajRezervacija']);
        $rezervacijaModel = new RezervacijaModel();
        $rezervacijaModel->potvrdiRezervaciju($idRezervacija);
        $rezervacija = $rezervacijaModel->dohvRezervaciju($idRezervacija);

        $obavestenjeModel = new ObavestenjeModel();
        $smestajModel = new SmestajModel();
        $smestaj = $smestajModel->dohvSmestaj($rezervacijaModel->dohvSmestajId($idRezervacija))[0];
        $korisniciModel = new KorisniciModel();
        $korisnik = $korisniciModel->dohvKorisnika($smestaj->idVlasnik);
        $data = [
            'idKorisnik' => $rezervacijaModel->dohvIdKorisnika($idRezervacija),
            'naslov' => 'Uspešna rezervacija!',
            'opis' => "Vlasnik smeštaja " . $korisnik->ime . " " . $korisnik->prezime . " je potvrdio Vaš boravak u smeštaju " . $smestaj->naziv . " od " . $rezervacija->datumOd . " do " . $rezervacija->datumDo . ". Molimo Vas da ostavite recenziju.",
            'tip' => 'success',
        ];
        $obavestenjeModel->save($data);
        return redirect()->to(site_url('Oglasavac/rezervacije'));
    }

    //odbija rezervaciju zato sto se korisnik nije pojavio u smestaju u rezervisanom terminu i samim tim
    //smanjuje broj u tabeli brojRecenzija
    public function odbijRezervaciju($idRezervacija) {
        $brojRecenzijaModel = new \App\Models\BrojRecenzijaModel();
        $brojRecenzijaModel->smanji($_SESSION['idKorisnikRezervacija'], $_SESSION['idSmestajRezervacija']);
        $rezervacijaModel = new RezervacijaModel();
        $rezervacijaModel->odbijRezervaciju($idRezervacija);

        $rezervacija = $rezervacijaModel->dohvRezervaciju($idRezervacija);

        $obavestenjeModel = new ObavestenjeModel();
        $smestajModel = new SmestajModel();
        $smestaj = $smestajModel->dohvSmestaj($rezervacijaModel->dohvSmestajId($idRezervacija))[0];
        $korisniciModel = new KorisniciModel();
        $korisnik = $korisniciModel->dohvKorisnika($smestaj->idVlasnik);
        $data = [
            'idKorisnik' => $rezervacijaModel->dohvIdKorisnika($idRezervacija),
            'naslov' => 'Neuspešna rezervacija!',
            'opis' => "Vlasnik smeštaja " . $korisnik->ime . " " . $korisnik->prezime . " nije potvrdio Vaš boravak u smeštaju " . $smestaj->naziv . " od " . $rezervacija->datumOd . " do " . $rezervacija->datumDo . ". Ne možete da ostavite recenziju.",
            'tip' => 'danger',
        ];
        $obavestenjeModel->save($data);

        return redirect()->to(site_url('Oglasavac/rezervacije'));
    }

    //prikazuje stranicu za odgovor na recenziju
    public function odgovorNaRecenziju($idRecenzije) {
        $this->prikaz('odgovor_na_recenziju', ['idRecenzije' => $idRecenzije]);
    }

    //potvrdjuje odgovor na recenziju
    public function odgovorNaRecenzijuSubmit($idRecenzije) {
        $odgovor = $this->request->getVar('recenzijaOdgovor');
        $recenzijaModel = new RecenzijaModel();
        $recenzijaModel->unesiOdgovor($idRecenzije, $odgovor);

        $obavestenjeModel = new ObavestenjeModel();
        $smestajModel = new SmestajModel();
        $smestaj = $smestajModel->dohvSmestaj($recenzijaModel->dohvSmestajId($idRecenzije))[0];
        $korisniciModel = new KorisniciModel();
        $korisnik = $korisniciModel->dohvKorisnika($recenzijaModel->dohvKorisnikId($idRecenzije));

        $data = [
            'idKorisnik' => $korisnik->id,
            'naslov' => 'Odgovor na recenziju!',
            'opis' => "Vlasnik smeštaja " . $this->session->get('oglasavac')->ime . " " . $this->session->get('oglasavac')->prezime . " je odgovorio na Vašu recenziju za smeštaj " . $smestaj->naziv,
            'tip' => 'success',
        ];
        $obavestenjeModel->save($data);

        return redirect()->to(site_url('Oglasavac/sveRecenzijeOglasavaca'));
    }

    //prikazuje sve smestaje oglasavaca 
    public function smestajiOglasavaca() {
        $smestajModel = new SmestajModel();
        $smestaji = $smestajModel->dohvOglaseOglasavaca($this->session->get('oglasavac')->id);
        $this->prikaz('pocetna', ['sviSmestaji' => $smestaji]);
    }

    //prikazuje stranicu sa obavestenjima oglasavaca
    public function obavestenja() {
        $obavestenjeModel = new ObavestenjeModel();
        $obavestenja = $obavestenjeModel->dohvObavestenjaKorisnika($this->session->get('oglasavac')->id);
        $this->prikaz('obavestenja', ['obavestenja' => $obavestenja]);
    }

    //brise obavestenje
    public function obrisiObavestenje($id) {
        $obavestenjeModel = new ObavestenjeModel();
        $obavestenjeModel->obrisiObavestenje($id);
        return redirect()->to(site_url('Oglasavac/obavestenja'));
    }
    //odjavljuje oglasavaca i vraca na pocetnu stranu gosta
    public function logout() {
        $this->session->destroy();
        return redirect()->to(site_url('/'));
    }

    //funkcija koja se aktivira klikom na naziv sajta na vrhu ekrana ili na logo u gornjem levom uglu
    //vraca trenutnog kontrolera na njegovu pocetnu stranicu
    public function backToHome() {
        return redirect()->to(site_url('Oglasavac'));
    }

    //funkcija koja se poziva putem ajaksa i koja prikazuje broj obavestenja koje ima oglasavac
    public function dohvBrojObavestenja() {
        if ($this->session->get('oglasavac')) {
            $obavestenjeModel = new ObavestenjeModel();
            $data = [
                'broj' => $obavestenjeModel->dohvBrojObavestenja($this->session->get('oglasavac')->id),
            ];
            header("Content-Type: application/json");
            echo json_encode($data);
        }
    }

    //funkcija koja se poziva putem ajaksa i koja dohvata broj rezervacija koje ima korisnik
    public function dohvNepotvrdjeneRezervacijeOglasavac() {
        $rezervacijaModel = new \App\Models\RezervacijaModel();
        $nepotvrdjeneRezervacije = $rezervacijaModel->dohvSveNepotrvrdjene($this->session->get('oglasavac')->id);

        $data = [
            'brojNovih' => count($nepotvrdjeneRezervacije),
        ];

        header("Content-Type: application/json");
        echo json_encode($data);
    }

    //poziva se takodje putem ajaksa i dohvata ukupan broj smestaja, recenzija i rezervacija oglasavaca
    public function dohvUkupanBrojOglasavac(){
        $recenzijaModel = new RecenzijaModel();
        $smestajModel = new SmestajModel();
        $rezervacijaModel = new \App\Models\RezervacijaModel();
        
        $smestajBroj = $smestajModel->dohvBrojSmestajaOglasavaca($this->session->get('oglasavac')->id);
        $recenzijeBroj = $recenzijaModel->dohvBrojRecenzijaOglasavaca($this->session->get('oglasavac')->id);
        $rezervacijeBroj = $rezervacijaModel->dohvBrojRezervacijaOglasavaca($this->session->get('oglasavac')->id);
        
        $data = [
            'smestajBroj' => $smestajBroj,
            'recenzijeBroj' => $recenzijeBroj,
            'rezervacijeBroj' => $rezervacijeBroj,
        ];

        header("Content-Type: application/json" );
        echo json_encode($data);
    }
}
