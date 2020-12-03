<div class='bodyContent'>    
    <div class='row'>
        <div class='col-sm-12'>
            <h2 class='pocetnaTextNaslov text-center'>
                Dobrodošli!
            </h2>
        </div>
    </div>
    <div class='row col-sm-12'>
        <div class='col-sm-3' align='center'>
            <?= anchor("Oglasavac/smestajiOglasavaca", "<img class='imgAvatar' src= " . base_url('slike/houseAvatar.jpg') . " width='80%' height='170' alt='Avatar'>") ?>
            <p class='pocetnaTextNaslov text-center'>Vaši smeštaji</p>
            <p class="pocetnaTextOpis">Ukupan broj smeštaja: <span id="ukBrSmestajaOglasavac"></span></p> 
        </div>
        <div class='col-sm-3'align='center'>
            <?= anchor("Oglasavac/sveRecenzijeOglasavaca", "<img class='imgAvatar' src= " . base_url('slike/recenzijeAvatar.jpg') . " width='80%' height='170' alt='Avatar'>") ?>
            <p class='pocetnaTextNaslov text-center'>Recenzije</p>
            <p class="pocetnaTextOpis">Broj recenzija za Vaše smeštaje: <span id="ukBrRecenzijaOglasavac"></span></p> 
        </div>
        <div class='col-sm-3' align='center'>
            <?= anchor("Oglasavac/postavljanjeOglasa", "<img class='imgAvatar' src= " . base_url('slike/homeAvatar.jpg') . " width='80%' height='170' alt='Avatar'>") ?>
            <p class='pocetnaTextNaslov text-center'>Postavite nov oglas</p> 
        </div>
        <div class='col-sm-3' align='center'>
            <?= anchor("Oglasavac/rezervacije", "<img class='imgAvatar' src=" . base_url('slike/reservation.png') . " width='80%' height='170' alt='Avatar'>") ?> 
            <p class='pocetnaTextNaslov text-center'>Nove rezervacije</p>
            <p class="pocetnaTextOpis">Broj svih rezervacija: <span id="ukBrRezervacijaOglasavac"></span></p> 
        </div>
    </div>    
</div>

<script>
    function update(){
        $.ajax({
            url: "<?= site_url('Oglasavac/dohvUkupanBrojOglasavac');?>",
            success:function(response){
                response = JSON.parse(response);
                let smestajBroj = response['smestajBroj'];
                let recenzijeBroj = response['recenzijeBroj'];
                let rezervacijebroj = response['rezervacijeBroj'];
                $("#ukBrSmestajaOglasavac").text(smestajBroj);
                $("#ukBrRecenzijaOglasavac").text(recenzijeBroj);
                $("#ukBrRezervacijaOglasavac").text(rezervacijebroj);
            }    
        });
    }
    $(document).ready(function (){
        update();
        setInterval(update, 5000);
    });
</script>