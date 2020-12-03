<div class='bodyContent'>
<div class='row'>
        <div class='col-sm-12'>    
            <p class='pocetnaTextNaslov text-left' style='color:green'><span id='novaRezervacija'></span></p>
        </div>
    </div>
    <div class='row'>
        <div class='col-sm-12'>
            <h1 class='pocetnaTextNaslov text-center'>Spisak nepotvredjenih rezervacija:</h1>
        </div>
    </div>
    <div class='row'>
        <div class='zahteviDiv'>
            <table class='table table-striped table-dark'>
                <thead>
                    <th>#</th>
                    <th>Datum od</th>
                    <th>Datum do</th>
                    <th>Smeštaj</th>
                    <th>Status</th>
                    <th>Korisnik</th>
                    <th>Potvrda</th>
                </thead>
                <tbody>
                <?php
                if(count($nepotvrdjeneRezervacije)>0){
                   // foreach($nepotvrdjeneRezervacije as $rezervacijaKey => $rezervacijaValue){
                        foreach($nepotvrdjeneRezervacije as $rezKey=>$rezValue){
                            echo "<tr>";
                            echo    "<td>". $rezValue->id ."</td>";
                            echo    "<td>". $rezValue->datumOd ."</td>";
                            echo    "<td>". $rezValue->datumDo ."</td>";
                            echo    "<td>". $rezValue->idSmestaj ."</td>";
                            echo    "<td>". $rezValue->status ."</td>";
                            echo    "<td>". $rezValue->idKorisnika ."</td>";
                            $_SESSION['idKorisnikRezervacija'] = $rezValue->idKorisnika;
                            $_SESSION['idSmestajRezervacija']=$rezValue->idSmestaj;
                            echo    "<td>";
                            echo    "<p id='tabelaLinkovi'>" . anchor("Oglasavac/potvrdiRezervaciju/{$rezValue->id}", "Gost se pojavio")."</p>";
                            echo    "</td>";
                            echo    "<td>";
                            echo    "<p id='tabelaLinkovi'>" . anchor("Oglasavac/odbijRezervaciju/{$rezValue->id}", "Gost se nije pojavio")."</p>";
                            echo    "</td>";
                            echo "</tr>";
                        } 
                   // }
                }
                ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
    function update(){
        $.ajax({
            url: "<?= site_url('Oglasavac/dohvNepotvrdjeneRezervacijeOglasavac');?>",
            success:function(response){
                response = JSON.parse(response);
                let brojNovihRezervacija = response['brojNovih'];
                if( typeof update.counter == 'undefined' ) {
                    update.counter = brojNovihRezervacija;
                    return;
                }
                
                if(brojNovihRezervacija>update.counter){
                    update.counter = brojNovihRezervacija - update.counter;
                    $("#novaRezervacija").text("Broj novih rezervacija je:" + update.counter);

                    if(confirm("Nova rezervacija! Da li želite da pogledate?")) location.reload();   
                }
            }    
        });
    }
    $(document).ready(function (){
        update();
        setInterval(update, 6400);
    });
</script>