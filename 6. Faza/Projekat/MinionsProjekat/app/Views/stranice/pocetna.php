<div class='bodyContent'>
    <br>
    <?php if(!empty($trazeno)){ 
        echo "<div class='row'>";
        echo    "<div class='col-sm-12 blackTextCenter'>";
        echo        "<p>Rezultat pretrage:</p>";
        echo   "</div>";
        echo "</div>";
    }
    use App\Models\FilePathDokumentacijeSmestajaModel;
    if(count($sviSmestaji)>0){
        $slikeModel = new FilePathDokumentacijeSmestajaModel();
        foreach($sviSmestaji as $smestaj){
            echo "<div class='oglas'>";
            echo    "<div class='row col-sm-12 gallery'>";
            echo "<div class='col-sm-12'>";
            $slike = $slikeModel->dohvSlikeSmestaja($smestaj->id);
            foreach($slike as $slika){
                echo        "<div class='rowImages'>";
                echo            "<img src=". base_url("{$slika->filepath}") ." style='width:100%'>";
                echo        "</div>";
            }
            echo "</div>";
            echo    "</div>";
            echo    "<div class='row col-sm-12'>";
            echo        "<div class='col-sm-6' >";
            echo            "<h3 class='pocetnaTextNaslov'>{$smestaj->naziv}</h3>";
            echo        "</div>";
            echo        "<div class='col-sm-6 textRight' id='oglasOpcije'>";
            echo            "<h5>{$smestaj->cena}e | ". anchor("{$controller}/smestajPrikaz/{$smestaj->id}", "Pregledaj oglas") . ($controller=='Admin'? " | " .anchor("Admin/obrisiSmestaj/{$smestaj->id}","Obriši") : "" ) . ($controller=='Oglasavac'? " | " .anchor("Oglasavac/obrisiSmestaj/{$smestaj->id}","Obriši") : "" ) . "</h5>";
            echo        "</div>";
            echo    "</div>";  
            echo    "<div class='row col-sm-12 textLeft'>";  
            echo    "<div class='col-sm-12'>";
            echo        "<h5 class='pocetnaTextOpis'>";
            echo            "{$smestaj->opis}";
            echo        "</h5>";
            echo     "</div>";
            echo    "</div>";
            echo    "&nbsp";
            echo "</div>";
        }
    }else echo "<div class='row col-sm-12 blackTextCenter'>Nema oglasa.</div>"
    ?>
</div>
