<?php

namespace App\Controllers;

//include za modele koji komuniciraju sa bazom
use App\Models\KorisniciModel;
use App\Models\SmestajModel;
use App\Models\RezervacijaModel;

//include biblioteka potrebnih za slanje mejla
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require APPPATH . 'ThirdParty/PHPMailer/src/Exception.php';
require APPPATH . 'ThirdParty/PHPMailer/src/PHPMailer.php';
require APPPATH . 'ThirdParty/PHPMailer/src/SMTP.php';

//Gost - klasa za korisnika sajta koji se ponasa kao gost (nije potrebno logovanje/registracija)
class Gost extends BaseController {

    //za prikaz bilo koje stranice unutar ovog kontrolera
    protected function prikaz($page, $data) {
        $data['controller'] = 'Gost';
        echo view('sablon/header', $data);
        echo view("stranice/$page", $data);
        echo view('sablon/footer');
    }

    //inicijalna stranica kontrolera
    public function index() {
        $smestajModel = new SmestajModel();
        $this->prikaz('pocetna', ['sviSmestaji' => $smestajModel->dohvSveOglase()]);
    }

    //funkcija koja prikazuje stranicu za pretragu smestaja
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
        if ($this->request->getVar('datumOd') != '' && $this->request->getVar('datumDo') != ''){
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
                    if (strtotime($valRezervacija->datumOd) <= strtotime($this->request->getVar('datumOd')) &&
                            strtotime($valRezervacija->datumDo) > strtotime($this->request->getVar('datumOd'))) {
                        unset($sviSmestaji[$smestaj]);

                        break;
                    }
                    if (strtotime($valRezervacija->datumOd) < strtotime($this->request->getVar('datumDo')) &&
                            strtotime($valRezervacija->datumDo) >= strtotime($this->request->getVar('datumDo'))) {
                        unset($sviSmestaji[$smestaj]);

                        break;
                    }
                    if (strtotime($valRezervacija->datumOd) >= strtotime($this->request->getVar('datumOd')) &&
                            strtotime($valRezervacija->datumDo) <= strtotime($this->request->getVar('datumDo'))) {
                        unset($sviSmestaji[$smestaj]);

                        break;
                    }
                }
            }
        }

        //Ovaj deo koda se izvrsava samo ako je popunjeno polje Kategorija.
        //Za svaki do smestaja proverava da li se trazena kategorija podudara
        //sa kategorijom smestaja i izbacuje ga iz povratnog niza ako do
        //poklapanja ne dodje.
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
                if ($val->kapacitet < $this->request->getVar('brojOsoba')) {
                    unset($sviSmestaji[$k]);
                }
            }
            if(intval ($this->request->getVar('brojOsoba'))<0){
              $greska = "Broj gostiju ne moze biti negativan.";
            return $this->prikaz('pretraga',['greska'=>$greska]);
          }
        }

        //Ovaj deo koda se izvrsava samo ako je popunjeno polje Cena.
        //Za svaki do smestaja proverava da li je cena smestaja veca od trazenoge i
        //izbacuje ga iz povratnog niza ako uslov nije ispunjen.
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
                if (!preg_match("/{$search}/i", $a)) unset($sviSmestaji[$k]);
            }
        }
        $this->prikaz('pocetna', ['sviSmestaji' => $sviSmestaji]);
    }

    //funkcija koja prikazuje stranicu za registraciju korisnika
    public function register($poruka = null) {
        $this->prikaz('register', ['poruka' => $poruka]);
    }

    //funkcija koja potvrdjuje registraciju korisnika
    public function registerCommit() {
        /* Validacija unetih polja */
        if (!$this->validate(
                ['ime' => 'required|min_length[2]|max_length[45]',
                'prezime' => 'required|min_length[5]|max_length[45]',
                'username'=> 'required|min_length[2]|max_length[12]',
                'email' =>'required',
                'registration_password' => 'required|min_length[8]|max_length[45]',
                'registration_password_confirm' => 'required|min_length[8]|max_length[45]|matches[registration_password]',
                'datum_rodjenja' => 'required',
                'adresa' => 'required|max_length[70]',
                'registration_type' => 'required'],
                ['ime' => ['required' => 'Ime ne sme biti prazno!','min_length' => 'Ime mora biti duze od 1 karaktera!','max_length'=>'Ime mora biti krace od 46 karaktera!'],
                'prezime' => ['required' => 'Prezime ne sme biti prazno!','min_length' => 'Prezime mora biti duze od 4 karaktera!','max_length'=>'Prezime mora biti krace od 46 karaktera!'],
                'username' => ['required' => 'Korisnicko ime ne sme biti prazno!','min_length' => 'Korisnicko mora biti duze od 1 karaktera!','max_length'=>'Korisnicko mora biti krace od 13 karaktera!'],
                'email' => ['required' => 'Email je obavezan!'],
                'registration_password' => ['required' => 'Lozinka ne sme biti prazna!','min_length' => 'Lozinka mora biti duza od 7 karaktera!','max_length'=>'Lozinka mora biti kraca od 46 karaktera!',],
                'registration_password_confirm' => ['required' => 'Lozinka ne sme biti prazna!','min_length' => 'Lozinka mora biti duza od 7 karaktera!','max_length'=>'Lozinka mora biti kraca od 46 karaktera!','matches'=>'Lozinke se moraju poklapati!'],
                'datum_rodjenja' => ['required' => 'Datum rodjenja je obavezan!'],
                'adresa' => ['required' => 'Adresa ne sme biti prazna!','max_length'=>'Adresa mora biti kraca od 70 karaktera!',] ,
                'registration_type' =>['required'=>'Morate odabrati tip korisnika pre registracije!'   ] ]
            )) return $this->prikaz('register',['errors' => $this->validator->getErrors()]);

        $korisniciModel = new KorisniciModel();
        if ($this->request->getVar('registration_type') == 'oglasavacReg') {
            $tip = 'oglasavac';
            $status = 'cekanje';
        } else {
            $tip = 'korisnik';
            $status = 'aktivan';
        }

        $korisniciModel->save([
            'ime' => $this->request->getVar('ime'),
            'prezime' => $this->request->getVar('prezime'),
            'tip' => $tip,
            'username' => $this->request->getVar('username'),
            'password' => $this->request->getVar('registration_password'),
            'email' => $this->request->getVar('email'),
            'datumRodjenja' => $this->request->getVar('datum_rodjenja'),
            'adresa' => $this->request->getVar('adresa'),
            'status' => $status
        ]);
        if($tip == 'korisnik'){
            $telo_poruke = "
                  <html>
                  <body>
                  <h1 style=\"color:blue;\">Podaci o korisniku</h1>
                  <p>Ime: {$this->request->getVar('ime')}</p>
                  <p>Prezime: {$this->request->getVar('prezime')}</p>
                  <p style=\"color:red;\">Korisnicko ime: {$this->request->getVar('username')}</p>
                  <p style=\"color:red;\"><b><u>Sifra: {$this->request->getVar('registration_password')}</u></b></p>
                  <p>E-mail adresa: {$this->request->getVar('email')}</p>
                  <p>Adresa: {$this->request->getVar('adresa')}</p>
                  <p>Tip korisnika: {$tip}</p>
                  <p>Datum Rodjenja: {$this->request->getVar('datum_rodjenja')}</p>
                  <p>Status: {$status}</p>
                  </html> ";

            $promenljiva = $this->request->getVar('ime') . " " . $this->request->getVar('prezime');
            Gost::mail($promenljiva, $this->request->getVar('email'), "Podaci o registrovanom korisniku na sajtu \"Smesti.se\"", $telo_poruke);
        }

        return redirect()->to(site_url("Gost/login/"));
    }

    //funkcija koja prikazuje stranicu za logovanje korisnika
    public function login($poruka = null) {
        $this->prikaz('login', ['poruka' => $poruka]);
    }

    //funkcija koja potvrdjuje logovanje korisnika
    public function loginSubmit() {
        if (!$this->validate(['login_username' => 'required|min_length[2]', 'login_password' => 'required'],
            ['login_username' => ['required' => 'Korisničko ime ne sme biti prazno!','min_length'=>'Korisničko ime mora imati vise od jednog karaktera!'],
                        'login_password' => [
                            'required' => 'Lozinka ne sme biti prazna!'
                        ],
                    ]
            )) {
            return $this->prikaz('login',
                            ['errors' => $this->validator->getErrors()]);
        }

        $korisniciModel = new KorisniciModel();
        $korisnik = $korisniciModel->where('username', $this->request->getVar('login_username'))->first();
        if ($korisnik == null) {//ne postoji korisnicko ime
            return $this->login('Korisnik ne postoji');
        }
        if ($korisnik->password != $this->request->getVar('login_password'))
            return $this->login('Pogresna lozinka');

        if ($korisnik->tip == 'oglasavac') {
            if ($korisnik->status == 'cekanje')
                return $this->login('Zahtev na cekanju.');
            else if ($korisnik->status == 'odbijen')
                return $this->login('Zahtev je odbijen.');

            $this->session->set('oglasavac', $korisnik);
            return redirect()->to(site_url('Oglasavac'));
        } else if ($korisnik->tip == 'korisnik') {
            $this->session->set('korisnik', $korisnik);
            return redirect()->to(site_url('Korisnik'));
        } else {
            $this->session->set('admin', $korisnik);
            return redirect()->to(site_url('Admin'));
        }
    }

    //funkcija koja prikazuje trazeni smestaj
    public function smestajPrikaz($id) {
        $smestajModel = new SmestajModel();
        $smestaj = $smestajModel->find($id);
        $this->prikaz('smestaj', ['smestaj' => $smestaj]);
    }

    //funkcija koja prikazuje sve recenzije za neki smestaj
    public function sveRecenzijeOglasa($id) {
        $smestajModel = new SmestajModel();
        $smestaj = $smestajModel->dohvSmestaj($id)[0];
        $this->prikaz('spisak_recenzija', ['smestaj' => $smestaj]);
    }

    //funkcija koja se aktivira klikom na naziv sajta na vrhu ekrana ili na logo u gornjem levom uglu
    //vraca trenutnog kontrolera na njegovu pocetnu stranicu
    public function backToHome() {
        return redirect()->to(site_url('Gost/index'));
    }

    //Ova metoda iz LogIn forme otvara stranicu sa formom za resetovanje sifre.
    //Klikom na dugme povrati poziva se metoda ispod.
    public function password_recovery($poruka = null) { //
        $this->prikaz('password_recovery.php', ['poruka' => $poruka]);
    }


    //Ova metoda se poziva kada korisnik stisne dugme za povrat sifre
    //u slucaju da korisnik ne unese korisnicko ime verifikacijom se vrati na tu istu formu uz obavestenje
    //u slucaju da korisnik sa uneim korisnickim imenom ne postoji vraca se na formu uz prikladno obavestenje
    //ako korisnik postoji salje se automatski mail na email adresu tog korisnika a metoda autoatski
    //redirektuje na pocetnu stranu Gosta.
    public function password_recoverySubmit() { //
        if (!$this->validate(['recovery_username' => 'required'],
                        [//prikaz srpskih gresaka
                            //ovde se prave nase poruke koje se pokazuju ako neko polje ne prodje validaciju
                            'recovery_username' => [
                                'required' => 'Korisničko ime ne sme biti prazno!'
                            ]
                        ]
                )) {
            return $this->prikaz('password_recovery',
                            ['errors' => $this->validator->getErrors()]);
        }

        $korisniciModel = new KorisniciModel();
        $korisnik = $korisniciModel->where('username', $this->request->getVar('recovery_username'))->first();
        if ($korisnik != NULL) {//postoji korisnik sa tim imenom
            //ovde se pravi sadrzaj Emaila
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
            Gost::mail($promenljiva, $korisnik->email, "Podaci za prijavu na sajt \"Smesti.se\"", $telo_poruke);
            return redirect()->to(site_url('Gost/index'));
        } else {//postoji korisnik sa tim imenom
            return $this->prikaz('password_recovery',['poruka' => "Greska: Još ne postoji korisnik sa unetim korisničkim imenom!"]);
        }
    }

    //Ova metoda koristi PHPMailer biblioteku skinutu sa zvanicnog gihuba
    //prima podatke(ime i prezime primaoca,adresu,naslov i sadrzinu emaila)
    public static function mail($imeprezime, $eadresa, $subject, $body) {
        $mail = new PHPMailer(false);
        //Server settings
        //$mail->SMTPDebug = SMTP::DEBUG_SERVER;                      // Enable verbose debug output    -> !!!!ovo je pravilo veliki problem
        $mail->isSMTP();                                            // Send using SMTP
        $mail->Host = 'smtp.gmail.com';                    // Set the SMTP server to send through
        $mail->SMTPAuth = true;                                   // Enable SMTP authentication
        $mail->Username = 'forg.iserekes7@gmail.com';                     // SMTP username
        $mail->Password = 'odciprijanapodnokarpata';                               // SMTP password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;         // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged
        $mail->Port = 587;                                    // TCP port to connect to, use 465 for `PHPMailer::ENCRYPTION_SMTPS` above
        //Posaljilac
        $mail->setFrom('forg.iserekes7@gmail.com', 'Smesti.se');
        //Recipients
        $mail->addAddress($eadresa, $imeprezime);               // Name is optional
        //$mail->addReplyTo('info@example.com', 'Information');
        //$mail->addCC('cc@example.com');
        //$mail->addBCC('bcc@example.com');
        //Attachments
        //$mail->addAttachment('/var/tmp/file.tar.gz');         // Add attachments
        //$mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name
        // sadrzina emaila
        $mail->isHTML(true);                                  // Set email format to HTML
        $mail->Subject = $subject;
        $mail->Body = $body;

        $mail->AltBody = 'Vas email sistem ne podrzava prikaz HTML sadrzaja ovog emaila.';

        if (!$mail->send()) {
            //echo 'Message could not be sent.';
            //echo 'Mailer Error: ' . $mail->ErrorInfo;
        } else {
            //echo 'Message has been sent';
        }
    }

    //funkcija koja se koristi u ajax metodi za dohvatanje broja obavestenja
    //s obzirom da je ovo kontroler koji nema funkcionalnost za primanje obavestenja, ova funkcija nema efekta
    public function dohvBrojObavestenja(){
        $data = ["broj"=>0];
        header("Content-Type: application/json");
        echo json_encode($data);
    }
}
