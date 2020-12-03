<div class='bodyContent'>
    <div class='row '>
        <div class='col-sm-12'>
            <h1 class='pocetnaTextNaslov text-center'>Spisak svih zahteva za clanstvo oglašavača:</h1>
        </div>
    </div>
    &nbsp;
    <div class='row'>
        <div class='zahteviDiv'>
            <table class='table table-striped table-dark'>
                <thead>
                    <th>ID</th>
                    <th>Ime</th>
                    <th>Prezime</th>
                    <th>Korisnicko ime</th>
                    <th>E-mail</th>
                    <th colspan="2">Prihvati zahtev</th>
                </thead>
                <?php 
                $korisniciModel = new App\Models\KorisniciModel();
                $korisnici = $korisniciModel->dohvSveZahteve();
                if(count($korisnici)>0){
                    foreach($korisnici as $korisnik){
                        echo "<tr class='darkTextLight'>";
                        echo    "<td>#".$korisnik->id."</td>";
                        echo    "<td>". $korisnik->ime ."</td>";
                        echo    "<td>". $korisnik->prezime. "</td>";
                        echo    "<td>". $korisnik->username ."</td>";
                        echo    "<td>". $korisnik->email ."</td>";
                        echo    "<td>";
                        echo    "<p class='myTextLeft textSize15' id='tabelaLinkovi'>" . anchor("Admin/odobriZahtev/{$korisnik->id}", "Da")."</p>";
                        echo    "</td>";
                        echo    "<td>";
                        echo    "<p class='myTextLeft textSize15' id='tabelaLinkovi'>" . anchor("Admin/odbijZahtev/{$korisnik->id}", "Ne")."</p>";
                        echo    "</td>";
                        echo "</tr>";
                    }
                }
                ?>
            </table>
        </div>
    </div>
</div>