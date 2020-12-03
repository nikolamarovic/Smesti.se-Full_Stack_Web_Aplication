<?php

namespace App\Controllers;

use App\Models\SmestajModel;
use App\Models\RezervacijaModel;
use App\Models\RecenzijaModel;
use App\Models\ObavestenjeModel;

//Korisnik - klasa za korisnika sajta koja je aktivna ako se gost uloguje kao korisnik
class Korisnik extends BaseController {

    //funkcija koja sluzi za prikaz bilo koje stranice unutar ovog kontrolera
    protected function prikaz($page, $data) {
        $data['controller'] = 'Korisnik';
        $data['korisnik'] = $this->session->get('korisnik');
        echo view('sablon/header', $data);
        echo view("stranice/$page", $data);
        echo view('sablon/footer');
    }

    //inicijalna stranica kontrolera
    public function index() {
        $smestajModel = new \App\Models\SmestajModel();
        $this->prikaz('pocetna', ['sviSmestaji' => $smestajModel->dohvSveOglase()]);
    }

    //funkcija koja prikazuje stranicu za pretragu
    public function pretraga() {
        $this->prikaz('pretraga', []);
    }

    //Ova funkcija se poziva kada korisnik pritisne dugme "Pretrazi"
    //na stranici pretraga postoji vise kriterijuma pretrage i korisnik
    //moze da bira po kojim kriterijumima ce da pretrazuje smestaje.
    //Funkcija vraca niz smestaja koje prosledjuje dalje na obradu
    public function pretragaSubmit() {
        $smestajModel = new SmestajModel();
        $rezervacijaModel = new RezervacijaModel();
        $sviSmestaji = $smestajModel->dohvOglasPoNazivu($this->request->getVar('naziv'));
        if ($this->request->getVar('naziv') == '') {
            $sviSmestaji = $smestajModel->dohvSveOglase();
        }
        if($this->request->getVar('datumOd') != '' && $this->request->getVar('datumDo') != ''){
          if(strtotime($this->request->getVar('datumOd')) >= strtotime($this->request->getVar('datumDo'))){
              $greska = "Pocetni datum mora biti veci od krajnjeg datuma.";
              return $this->prikaz('pretraga',['greska'=>$greska]);
          }
          //provera da li je pocetni datum veci od trenutnog
          if(strtotime($this->request->getVar('datumOd')) <= strtotime(date("Y-m-d"))){
              $greska = "Pocetni datum mora biti veci od trenutnog.";
              return $this->prikaz('pretraga',['greska'=>$greska]);
          }
        }
        //Ovaj deo koda se izvrsava samo ako su popunjena polja datumOd i datumDo.
        //Za svaki od mestaja proverava da li je slobodan u trazenom terminu i izbacuje ga iz povratnog niza ako nije.
        if ($this->request->getVar('datumOd') != '' && $this->request->getVar('datumDo') != '') {

            foreach ($sviSmestaji as $smestaj => $valSmestaj) {
                $rezervacije = $rezervacijaModel->pretraziRezervacijeSmestaja($valSmestaj->id);
                foreach ($rezervacije as $rezervacija => $valRezervacija) {
                    //Pocetni datum trazene rezervacije se nalazi unutar vec recervisanog termina
                    if (strtotime($valRezervacija->datumOd) <= strtotime($this->request->getVar('datumOd')) &&
                            strtotime($valRezervacija->datumDo) > strtotime($this->request->getVar('datumOd'))) {
                        unset($sviSmestaji[$smestaj]);

                        break;
                    }
                    //Krajnji datum trazene rezervacije se nalazi unutar vec recervisanog termina
                    if (strtotime($valRezervacija->datumOd) < strtotime($this->request->getVar('datumDo')) &&
                            strtotime($valRezervacija->datumDo) >= strtotime($this->request->getVar('datumDo'))) {
                        unset($sviSmestaji[$smestaj]);

                        break;
                    }
                    //Trazeni termin obuhvata neki drugi termin
                    if (strtotime($valRezervacija->datumOd) >= strtotime($this->request->getVar('datumOd')) &&
                            strtotime($valRezervacija->datumDo) <= strtotime($this->request->getVar('datumDo'))) {
                        unset($sviSmestaji[$smestaj]);

                        break;
                    }
                }
            }
        }

        //Ovaj deo koda se izvrsava samo ako je popunjeno polje Kategorija. Za svaki od smestaja proverava da li se trazena kategorija
        //podudara sa kategorijom smestaja i izbacuje ga iz povratnog niza ako do poklapanja ne dodje.
        if ($this->request->getVar('kategorija') != '') {
            foreach ($sviSmestaji as $k => $val) {
                if ($val->tipSmestaja != $this->request->getVar('kategorija')) {
                    unset($sviSmestaji[$k]);
                }
            }
        }
        //Ovaj deo koda se izvrsava samo ako je popunjeno polje Broj osoba.
        //Za svaki do smestaja proverava da li je kapacitet smestaja veci od trazenog
        //kapaciteta i izbacuje ga iz povratnog niza ako uslov nije ispunjen.
        if ($this->request->getVar('brojOsoba') != '') {
            foreach ($sviSmestaji as $k => $val) {
                if ($val->kapacitet <= $this->request->getVar('brojOsoba')) {
                    unset($sviSmestaji[$k]);
                }
            }
            if(intval ($this->request->getVar('brojOsoba'))<0){
              $greska = "Broj gostiju ne moze biti negativan.";
              return $this->prikaz('pretraga',['greska'=>$greska]);
            }
        }

        //Ovaj deo koda se izvrsava samo ako je popunjeno polje Cena.
        //Za svaki do smestaja proverava da li je cena smestaja veca od trazenog i izbacuje ga iz povratnog niza ako uslov nije ispunjen.
        if ($this->request->getVar('cena') != '') {
          if(intval($this->request->getVar('cena'))){
              $greska = "Cena mora biti nenegativna.";
              return $this->prikaz('pretraga',['greska'=>$greska]);
          }
            foreach ($sviSmestaji as $k => $val) {
                if ($val->cena >= $this->request->getVar('cena')) {
                    unset($sviSmestaji[$k]);
                }
            }
        }
        //Ovaj deo koda se izvrsava samo ako je popunjeno polje Grad.
        //U polje grad se ne mora uneti tacan naziv grada vec se moze
        //uneti i deo naziva grada, ako se uneti string poklapa sa nekim
        //delom naziva gradova smestaja sa kojim se poredi taj smestaj
        //ce biti prosledjen dalje na obradu, u suprotnom taj smestaj
        //se izbacuje iz povratnog niza.
        if ($this->request->getVar('grad') != '') {
            foreach ($sviSmestaji as $k => $val) {


                $a = $val->grad;
                $search = $this->request->getVar('grad');
                if (preg_match("/{$search}/i", $a)) {

                } else {
                    unset($sviSmestaji[$k]);
                }
            }
        }
        $this->prikaz('pocetna', ['sviSmestaji' => $sviSmestaji]);
    }

    //funkcija koja prikazuje trazeni smestaj
    public function smestajPrikaz($id) {
        $smestajModel = new SmestajModel();
        $smestaj = $smestajModel->find($id);
        $smeDaOstavi = $this->smeDaOstaviRecenziju($id);

        $this->prikaz('smestaj', ['smestaj' => $smestaj, 'smeDaOstaviRecenziju' => $smeDaOstavi]);
    }

    //Prikazuje stranicu za ostavljenje rezervacije
    public function rezervisi($id) {
        $smestajModel = new SmestajModel();
        $smestaj = $smestajModel->dohvatiSmestajSaId($id);
        $this->session->set('id', $id);
        $this->prikaz('rezervacija_smestaja', []);
    }

    //Ova metoda se poziva nekon sto se popune sva polja na stranici
    //za ostavljanje rezervacije pritiskom na dugme "Rezervisi".
    //Ova metoda vrsi provere vezanu za rezervacije i
    //ubacuje u bazu sve podatke o rezervaciji ako su sve provere prosle.
    public function rezervisiSubmit() {
        if (!$this->validate(
            [
            'datumOd' => 'required',
            'datumDo' => 'required',
            'brojOsoba' => 'required',
            'napomena' => 'required'
            ],
            [
            'datumOd' => ['required' => "Morate uneti Datum Od!",],
            'datumDo' => ['required' => "Morate uneti Datum Do!",], 'brojOsoba' => ['required' => "Morate uneti broj osoba!",], 'napomena' => ['required' => "Morate uneti napomenu!",]
            ]
        )) return $this->prikaz('rezervacija_smestaja',['errors' => $this->validator->getErrors()]);

        //provera da li je pocetni datum manji od krajnjeg
        if(strtotime($this->request->getVar('datumOd')) >= strtotime($this->request->getVar('datumDo'))){
            $greska = "Pocetni datum mora biti veci od krajnjeg datuma.";
            return $this->prikaz('rezervacija_smestaja',['greska'=>$greska]);
        }
        //provera da li je pocetni datum veci od trenutnog
        if(strtotime($this->request->getVar('datumOd')) <= strtotime(date("Y-m-d"))){
            $greska = "Pocetni datum mora biti veci od trenutnog.";
            return $this->prikaz('rezervacija_smestaja',['greska'=>$greska]);
        }


        //provera da li je zadati smestaj razervisan u trazenom terminu
        $rezervacijaModel = new RezervacijaModel();
        $smestajModel = new SmestajModel();
        $rezervacije = $rezervacijaModel->pretraziRezervacijeSmestaja($this->session->get('id'));
        $greska = "Termin koji ste odabrali nije dostupan.";
        $smestaj = $smestajModel->find($this->session->get('id'));
        foreach ($rezervacije as $value) {
            //Pocetni datum trazene rezervacije se nalazi unutar vec recervisanog termina
            if (strtotime($value->datumOd) <= strtotime($this->request->getVar('datumOd')) &&
                    strtotime($value->datumDo) > strtotime($this->request->getVar('datumOd'))) {

                return $this->prikaz('rezervacija_smestaja', ['greska' => $greska]);
            }
            //Krajnji datum trazene rezervacije se nalazi unutar vec recervisanog termina
            else if (strtotime($value->datumOd) < strtotime($this->request->getVar('datumDo')) &&
                    strtotime($value->datumDo) >= strtotime($this->request->getVar('datumDo'))) {

                return $this->prikaz('rezervacija_smestaja', ['greska' => $greska]);
            }
            //Trazeni termin obuhvata neki drugi termin
            else if (strtotime($value->datumOd) >= strtotime($this->request->getVar('datumOd')) &&
                    strtotime($value->datumDo) <= strtotime($this->request->getVar('datumDo'))) {

                return $this->prikaz('rezervacija_smestaja', ['greska' => $greska]);
            }
        }

        //proverava da li smestaj ima dovljan kapacitet
        if ($smestaj->kapacitet < $this->request->getVar('brojOsoba')) {
            $greska = "Ovaj smestaj nema dovoljan kapacitet.";
            return $this->prikaz('rezervacija_smestaja', ['greska' => $greska]);
        }

        $rezervacijaModel->save([
            'datumOd' => $this->request->getVar('datumOd'),
            'datumDo' => $this->request->getVar('datumDo'),
            'brojOsoba' => $this->request->getVar('brojOsoba'),
            'napomena' => $this->request->getVar('napomena'),
            'status' => 'nepotvrdjena',
            'idSmestaj' => $this->session->get('id'),
            'idKorisnika' => $this->session->get('korisnik')->id
        ]);

        $brojRecenzijaModel = new \App\Models\BrojRecenzijaModel();
        if (!($brojRecenzijaModel->daLiPostoji($this->session->get('korisnik')->id, $this->session->get('id')))) {
            $brojRecenzijaModel->save([
                'idKorisnik' => $this->session->get('korisnik')->id,
                'idSmestaj' => $this->session->get('id'),
                'broj' => '0',
            ]);
        }

        return redirect()->to(site_url('Korisnik'));
    }

    //funkcija koja prikazuje sve recenzije za trazeni oglas
    public function sveRecenzijeOglasa($id) {
        $smestajModel = new SmestajModel();
        $smestaj = $smestajModel->dohvSmestaj($id)[0];
        $this->prikaz('spisak_recenzija', ['smestaj' => $smestaj]);
    }

    //funkcija koja provera da li korisnik koji je poziva sme da ostavi recenziju za dati smestaj
    //uslov za ostavljanje recenzije je da je oglasavac smestaja potvrdio boravak korisnika u smestaju koji je rezervisao
    //implementirano je pomocu dodatne tabele koja se zove brojRecenzija i koja simulira semafora, povecava vrednost kada oglasavac potvrdi rezervaciju, a smanjuje kada ne potvrdi
    //dokle god je vrednost za tog korisnika i taj oglas veca od nule korisnik ce imati mogucnost ostavljanja recenzije za taj oglas
    public function smeDaOstaviRecenziju($idSmestaj) {
        $brojRecenzijaModel = new \App\Models\BrojRecenzijaModel();
        if ($brojRecenzijaModel->smeDaOstaviRecenziju($this->session->get('korisnik')->id, $idSmestaj))return true;
        else false;
    }

    //prikazuje se stranica gde se ostavlja recenzija za smestaj
    public function ostaviRecenziju($id) {
        $this->prikaz('postavljanje_recenzije', ['idSmestajRecenzija' => $id]);
    }

    //potvrda ostavljanja recenzije
    public function ostaviRecenzijuSubmit($id) {
        $smestajModel = new SmestajModel();
        $smestaj = $smestajModel->dohvSmestaj($id)[0];

        $recenzijaModel = new RecenzijaModel();
        $recenzijaModel->save([
            'cistoca' => $this->request->getVar('cistoca'),
            'kvalitet' => $this->request->getVar('kvalitet'),
            'ljubaznost' => $this->request->getVar('ljubaznost'),
            'lokacija' => $this->request->getVar('lokacija'),
            'opstiUtisak' => $this->request->getVar('utisak'),
            'komfor' => $this->request->getVar('komfor'),
            'tip' => $this->request->getVar('tipPutnika'),
            'komentar' => $this->request->getVar('recenzijaKomentar'),
            'idSmestaj' => $id,
            'idOglasavac' => $smestaj->idVlasnik,
            'idKorisnik' => $this->session->get('korisnik')->id,
        ]);

        $obavestenjeModel = new ObavestenjeModel();
        $smestajModel = new SmestajModel();
        $smestaj = $smestajModel->dohvSmestaj($id)[0];

        $data = [
            'idKorisnik' => $smestaj->idVlasnik,
            'naslov' => 'Nova recenzija!',
            'opis' => "Korisnik " . $this->session->get('korisnik')->ime . " " . $this->session->get('korisnik')->prezime . " je ostavio recenziju za boravak u Vašem smeštaju " . $smestaj->naziv,
            'tip' => 'success',
        ];
        $obavestenjeModel->save($data);

        $brojRecenzijaModel = new \App\Models\BrojRecenzijaModel();
        $brojRecenzijaModel->smanji($this->session->get('korisnik')->id, $id);
        return redirect()->to(site_url('Korisnik'));
    }

    //funkcija koja prikazuje obavestenja koja je korisnik dobio
    public function obavestenja() {
        $obavestenjeModel = new ObavestenjeModel();
        $obavestenja = $obavestenjeModel->dohvObavestenjaKorisnika($this->session->get('korisnik')->id);
        $this->prikaz('obavestenja', ['obavestenja' => $obavestenja]);
    }

    //brise trazeno obavestenje
    public function obrisiObavestenje($id) {
        $obavestenjeModel = new ObavestenjeModel();
        $obavestenjeModel->obrisiObavestenje($id);
        return redirect()->to(site_url('Korisnik/obavestenja'));
    }

    //odjavljuje korisnika i vraca na pocetnu stranu gosta
    public function logout() {
        $this->session->destroy();
        return redirect()->to(site_url('/'));
    }

    //funkcija koja se aktivira klikom na naziv sajta na vrhu ekrana ili na logo u gornjem levom uglu
    //vraca trenutnog kontrolera na njegovu pocetnu stranicu
    public function backToHome() {
        return redirect()->to(site_url('Korisnik'));
    }

    //funkcija koja se poziva putem ajaksa i koja prikazuje broj obavestenja koje ima korisnik
    public function dohvBrojObavestenja() {
        if ($this->session->get('korisnik')) {
            $obavestenjeModel = new ObavestenjeModel();
            $data = [
                'broj' => $obavestenjeModel->dohvBrojObavestenja($this->session->get('korisnik')->id),
            ];
            header("Content-Type: application/json");
            echo json_encode($data);
        }
    }
}
