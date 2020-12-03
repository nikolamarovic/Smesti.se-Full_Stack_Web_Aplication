<div class='bodyContent'>
    <div class='row'>
        <div class='col-sm-12'>
            <h2 class='pocetnaTextNaslov text-center'>
                Dobrodošli!
            </h2>
        </div>
    </div>
    <div class='row col-sm-12'>
        <div class = 'col-sm-3' align='center'>
            <?= anchor("Admin/pregledSvihSmestaja", "<img class='imgAvatar' src=" . base_url('slike/houseAvatar.jpg') . " width='70%' height='190' alt='Avatar'>") ?> 
            <p class='pocetnaTextNaslov text-center'>Pregled svih smeštaja</p>
            <p class="pocetnaTextOpis">Ukupan broj smeštaja: <span id="ukBrSmestajaAdmin"></span></p>
        </div>
        <div class ='col-sm-3' align='center'>
            <?= anchor("Admin/pregledSvihKorisnika", "<img class='imgAvatar' src=" . base_url('slike/userAvatar.jpg') . " width='70%' height='190' alt='Avatar'>") ?> 
            <p class='pocetnaTextNaslov text-center'>Pregled svih korisnika</p>
            <p class="pocetnaTextOpis">Ukupan broj korisnika: <span id="ukBrKorisnikaAdmin"></span></p>
        </div>
        <div class='col-sm-3' align='center'>
            <?= anchor("Admin/pregledSvihRecenzija", "<img class='imgAvatar' src=" . base_url('slike/recenzijeAvatar.jpg') . " width='70%' height='190' alt='Avatar'>") ?>
            <p class='pocetnaTextNaslov text-center'>Pregled svih recenzija</p>
            <p class="pocetnaTextOpis">Ukupan broj recenzija: <span id="ukBrRecenzijaAdmin"></span></p>
        </div>
        <div class='col-sm-3' align='center'>
            <?= anchor("Admin/pregledSvihZahteva", "<img class='imgAvatar' src=" . base_url('slike/member.jpg') . " width='70%' height='190' alt='Avatar'>") ?> 
            <p class='pocetnaTextNaslov text-center'>Pregled svih zahteva oglašavača</p>
            <p class="pocetnaTextOpis">Ukupan broj zahteva: <span id="ukBrZahtevaAdmin"></span></p>
        </div>
    </div>
</div>
<script>
    function update(){
        $.ajax({
            url: "<?= site_url('Admin/dohvUkupanBrojAdmin');?>",
            success:function(response){
                response = JSON.parse(response);
                let smestajBroj = response['smestajBroj'];
                let zahteviBroj = response["zahteviBroj"];
                let recenzijeBroj = response["recenzijeBroj"];
                let korisniciBroj = response["korisniciBroj"];
                $("#ukBrSmestajaAdmin").text(smestajBroj);
                $("#ukBrKorisnikaAdmin").text(korisniciBroj);
                $("#ukBrRecenzijaAdmin").text(recenzijeBroj);
                $("#ukBrZahtevaAdmin").text(zahteviBroj);
            }    
        });
    }
    $(document).ready(function (){
        update();
        setInterval(update, 5000);
    });
</script>