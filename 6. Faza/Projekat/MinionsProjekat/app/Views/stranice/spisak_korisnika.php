<div class='bodyContent'>
    <div class='row '>
        <div class='col-sm-12'>
            <h1 class='pocetnaTextNaslov text-center'>Spisak svih korisnika na sajtu:</h1>
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
                    <th>Tip</th>
                    <th></th>
                </thead>
                <tbody>
                    <?php 
                    $korisniciModel = new App\Models\KorisniciModel();
                    $korisnici = $korisniciModel->dohvSveKorisnike();
                    if(count($korisnici)>0){
                        foreach($korisnici as $korisnik){
                            echo "<tr>";
                            echo    "<td>#".$korisnik->id."</td>";
                            echo    "<td>". $korisnik->ime ."</td>";
                            echo    "<td>". $korisnik->prezime. "</td>";
                            echo    "<td>". $korisnik->username ."</td>";
                            echo    "<td>". $korisnik->email ."</td>";
                            echo    "<td>". $korisnik->tip ."</td>";
                            echo    "<td>";
                            echo    "<p class='myTextLeft textSize15' id='tabelaLinkovi'>" . anchor("Admin/ukloniKorisnika/{$korisnik->id}", "Ukloni")."</p>";
                            echo    "</td>";
                            echo "</tr>";
                        }
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>