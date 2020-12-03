<div class='bodyContent'>
    <?php if(!empty($trazeno)){ 
        echo "<div class='row'>";
        echo    "<div class='col-sm-12 blackTextCenter'>";
        echo        "<p>Rezultat pretrage za ". $trazeno . " je:</p>";
        echo   "</div>";
        echo "</div>"; 
    }else{
        echo "<div class='row'>";
        echo    "<div class='col-sm-7' align='right'>";
        echo        "<img src= " .base_url('slike/search.png')." style='width:30'>";             
        echo   "</div>";
        echo    "<div class='col-sm-5 blackTextLeft' align='right' id='search'>";
        echo form_open("Admin/pretraga","method=post"); 
        echo form_input("kljucPretrage",set_value("kljucPretrage")); 
        echo form_submit("pretragaBtn2", "Pretrazi"); 
        echo form_close(); 
        echo "</div>";    
        echo "</div>";
    }
    if(count($smestaji)>0){
        $slikeModel = new App\Models\FilePathDokumentacijeSmestajaModel();
        foreach($smestaji as $smestaj){
            echo "<div class='oglas'>";
            echo    "<div class='row col-sm-12 gallery'>";
            $slike = $slikeModel->dohvSlikeSmestaja($smestaj->id);
            foreach($slike as $slika){
                echo        "<div class='rowImages'>";
                echo            "<img src=". base_url("{$slika->filepath}") ." style='width:100%'>";
                echo        "</div>";
            }
            echo    "</div>";
            echo    "<div class='row col-sm-12'>";
            echo        "<div class='col-sm-6 blackTextLeft' >";
            echo            "<h3>{$smestaj->naziv}</h3>";
            echo        "</div>";
            echo        "<div class='col-sm-6 blackTextRight' id='oglasOpcije'>";
            echo            "<h5>{$smestaj->cena}e | ". anchor("Admin/smestajPrikaz/{$smestaj->id}" , "Pregledaj oglas") ." | " . anchor("Admin/obrisiSmestaj/{$smestaj->id}" , "Obriši")."</h5>";
            echo        "</div>";
            echo    "</div>";  
            echo    "<div class='row col-sm-12 blackTextLeft textSize15'>";       
            echo        "<p>";
            echo            "{$smestaj->opis}";
            echo        "</p>";
            echo    "</div>";
            echo    "&nbsp";
            echo "</div>";
        }
    }else echo "<div class='row col-sm-12 blackTextCenter'>Ni jedan smestaj niste jos uvek oglasili.</div>"  
    ?>
</div>