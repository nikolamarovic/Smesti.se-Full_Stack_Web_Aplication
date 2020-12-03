<!DOCTYPE>
<html lang="en">
<head>
  <title>Smesti.se</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">    
  <link rel="stylesheet" href="<?=base_url('css/psiStyle.css');?>">
  <link rel="icon" href="<?=base_url('slike/logo2.png')?>" type="image/gif">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
  <script src="https://code.jquery.com/jquery-3.5.1.min.js" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
  <link href='https://fonts.googleapis.com/css?family=Montserrat' rel='stylesheet'>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <!--mapa-->
  <link rel="stylesheet" href="https://unpkg.com/leaflet@1.6.0/dist/leaflet.css"
   integrity="sha512-xwE/Az9zrjBIphAcBb3F6JVqxf46+CDLwfLMHloNu6KEQCAWi6HcDUbeOfBIptF7tcCzusKFjFw2yuvEpDL9wQ=="
   crossorigin=""/>
    <!-- Make sure you put this AFTER Leaflet's CSS -->
 <script src="https://unpkg.com/leaflet@1.6.0/dist/leaflet.js"
   integrity="sha512-gZwIG9x3wUXg2hdXF6+rVkLF/0Vi9U8D2Ntg4Ga5I5BZpVkVxlJWbSQtXPSiUTtC0TjtGOmxa1AJPuV0CPthew=="
   crossorigin="">
</script>
</head>
<body>
<header>
    <nav class="navbar navbar-expand-xl navbar-expand-lg bg-dark navbar-dark">
        <div class='col-sm-6 col-md-6 col-lg-2 myTextLeft'>
            <?= anchor("{$controller}","<img class='navbar-brand' src=" . base_url('slike/logo2.png') . " width='100' height='100'>")?>
        </div>
        <div class='col-sm-6 col-md-6 col-lg-2 myTextRight'>
            <button class="navbar-toggler myTextRight" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
        </div>
        <div class='col-sm-4 visible-xs-block visible-sm-block'>
            <span class="d-none d-lg-block" id="mainTitle">    
                <?= anchor("{$controller}/backToHome", "<h1 id='mainTitle'>Smesti.se</h1>") ?>
            </span>
            <span class='d-none d-lg-block' id='pocetnaTextNaslov'>
            <?php
                if(isSet($oglasavac)) echo "<h4 class='text-center logReg'>Oglašavač: " . $oglasavac->ime . " " . $oglasavac->prezime . "</h4>"; 
                if(isSet($admin)) echo "<h4 class='text-center logReg'>Admin: " . $admin->ime . " " . $admin->prezime . "</h4>"; 
                if(isSet($korisnik)) echo "<h4 class='text-center logReg'>Korisnik: " . $korisnik->ime . " " . $korisnik->prezime . "</h4>"; 
                ?>
            </span>
        </div>
        <div class="col-sm-4 collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav textRight">
              <?php if($controller == 'Gost'){
                        echo "<li class='nav-item'>";
                        echo anchor("{$controller}/pretraga", "<span class='logReg px-1' id='logRegStyle'>Pretraži</span>");
                        echo "</li>";
                        echo "<li class='nav-item'>";
                        echo anchor("{$controller}/login", "<span class='logReg px-1' id='logRegStyle'>Uloguj se</span>");
                        echo "</li>";
                        echo "<li class='nav-item'>";
                        echo anchor("{$controller}/register", "<span class='logReg px-1' id='logRegStyle'>Registruj se</span>");
                        echo "</li>";
                    }else if($controller=='Korisnik'){
                        echo "<li class='nav-item'>";
                        echo anchor("{$controller}/pretraga", "<span class='logReg px-1' id='logRegStyle'>Pretraži</span>");
                        echo "</li>";
                        echo "<li class='nav-item'>";
                        $obavestenjaModel = new \App\Models\ObavestenjeModel();
                        echo anchor("{$controller}/obavestenja","<span class='logReg notification'>Obaveštenja</span><span class='badge' id='brojObavestenjaKorisnik'>{$obavestenjaModel->dohvBrojObavestenja($korisnik->id)}</span>");
                        echo "</li>";
                        echo "<li class='nav-item'>";
                        echo anchor("{$controller}/logout", "<span class='logReg px-1' id='logRegStyle'>Odjavi se</span>");
                        echo "</li>";
                    }else if($controller=='Oglasavac'){
                        echo "<li class='nav-item'>";
                        echo anchor("{$controller}/smestajiOglasavaca", "<span class='logReg px-1' id='logRegStyle'>Smeštaji</span>");
                        echo "</li>";
                        echo "<li class='nav-item'>";
                        $obavestenjaModel = new \App\Models\ObavestenjeModel();
                        echo anchor("{$controller}/obavestenja","<span class='logRegOglasavac notification'>Obaveštenja</span><span class='badge' id='brojObavestenjaOglasavac'>{$obavestenjaModel->dohvBrojObavestenja($oglasavac->id)}</span>");
                        echo "</li>";
                        echo "<li class='nav-item'>";
                        echo anchor("{$controller}/sveRecenzijeOglasavaca", "<span class='logRegOglasavac px-1' id='logRegStyle'>Recenzije</span>");
                        echo "</li>";
                        echo "<li class='nav-item'>";
                        echo anchor("{$controller}/postavljanjeOglasa", "<span class='logRegOglasavac px-1' id='logRegStyle'>Nov oglas</span>");
                        echo "</li>";
                        echo "<li class='nav-item'>";
                        echo anchor("{$controller}/rezervacije", "<span class='logRegOglasavac px-1' id='logRegStyle'>Rezervacije</span>");
                        echo "</li>";
                        echo "<li class='nav-item'>";
                        echo anchor("{$controller}/logout", "<span class='logRegOglasavac px-1' id='logRegStyle'>Odjavi se</span>");
                        echo "</li>";
                    }else {
                        echo "<li class='nav-item'>";
                        echo anchor("{$controller}/pregledSvihSmestaja", "<span class='logReg px-1' id='logRegStyle'>Smeštaji</span>");
                        echo "</li>";
                        echo "<li class='nav-item'>";
                        echo anchor("{$controller}/pregledSvihKorisnika", "<span class='logReg px-1' id='logRegStyle'>Korisnici</span>");
                        echo "</li>";
                        echo "<li class='nav-item'>";
                        echo anchor("{$controller}/pregledSvihRecenzija", "<span class='logReg px-1' id='logRegStyle'>Recenzije</span>");
                        echo "</li>";
                        echo "<li class='nav-item'>";
                        echo anchor("{$controller}/pregledSvihZahteva", "<span class='logReg px-1' id='logRegStyle'>Zahtevi</span>");
                        echo "</li>";
                        echo "<li class='nav-item'>";
                        echo anchor("{$controller}/logout", "<span class='logReg px-1' id='logRegStyle'>Odjavi se</span>");
                        echo "</li>";
                    }
              ?>
            </ul>
        </div>
    </nav>       
</header>
<body>

<script>
    function update(){
        $.ajax({
            url: "<?= site_url("$controller/dohvBrojObavestenja"); ?>",
            success:function(response){
                let broj = JSON.parse(response);
                $("#brojObavestenja<?php echo $controller;?>").text(broj['broj']);
            }    
        });
    }
    $(document).ready(function (){
        update();
        setInterval(update, 5000);
    });
</script>
