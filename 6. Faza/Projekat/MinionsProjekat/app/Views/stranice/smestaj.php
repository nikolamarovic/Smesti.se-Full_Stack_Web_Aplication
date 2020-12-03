<div class='bodyContent'>
    <div class='row'>
        <div class='col-sm-12'>
            <h1 class='smestajNaslov textCenter'><?php echo $smestaj->naziv; ?></h1>
            <div class='row'>
                <div class='col-sm-12' style="margin-left: 46%">
                    <div class='ratingsSmestaj'>
                    <?php
                        $recenzijaModel = new App\Models\RecenzijaModel();
                        for($i=0;$i<floor($recenzijaModel->dohvProsecnuOcenu($smestaj->id));$i++)
                            echo "<span class='fa fa-star'></span>";
                        if(floor($recenzijaModel->dohvProsecnuOcenu($smestaj->id))<5) echo "<span class='fa fa-star-half-o'></span>";
                        for($i=floor($recenzijaModel->dohvProsecnuOcenu($smestaj->id)+1);$i<5;$i++)
                            echo "<span class='fa fa-star-o'></span>";
                    ?>
                    </div>
                </div>
            </div>
            <h4 class='textCenter'><i class="fa fa-map-marker textRight"></i><?php echo $smestaj->grad; ?></h4>
        </div>
    </div>
    <script type='text/javascript' src='<?=base_url('js/skripta_galerija.js');?>'></script>
    <div class="row galerijaSmestajDiv">
        <div class='galerijaSmestajSlike'>
            <div class='col-sm-12'>
                <?php 
                    use App\Models\FilePathDokumentacijeSmestajaModel;
                    $slikeModel = new FilePathDokumentacijeSmestajaModel();
                    $slike = $slikeModel->dohvSlikeSmestaja($smestaj->id);
                ?>
                <div class='row prikazSlikeSmestaj'>
                    <?php
                        $cnt = 1;
                        foreach($slike as $slika){
                            echo "<div class='mySlides'>";
                            echo    "<div class='numbertext'>{$cnt}/5</div>";
                            echo    "<img src=". base_url("{$slika->filepath}") ." style='width:100%' onload='currentSlide(1)' align='center'>";
                            echo "</div>";
                            $cnt++;
                        }
                    ?>        
                </div>
                <div class="row ">
                    <?php
                        $cnt = 1;
                        foreach($slike as $slika){
                            echo "<div class='column'>";
                            echo    "<img class='demo cursor' src=". base_url("{$slika->filepath}") ." style='width:100%' onclick='currentSlide({$cnt})'>";
                            echo "</div>";
                            $cnt++;
                        }
                    ?> 
                </div>
            </div>
        </div>
    </div>
    <div class='row height50'>
        <div class='col-sm-12 '>
            <hr>
        </div>
    </div>
    <div class='informacijeSmestaj'>
        <div class='row'>
            <div class='col-sm-12'>
                <h1>Informacije o smeštaju:</h1>
                <hr>
            </div>
        </div>
        <div class="row">
            <div class='col-sm-12 '>
                <table class='table table table-dark table-striped tableText'>
                    <tr>
                        <td>
                            Tip Smestaja:
                        </td>
                        <td>
                            <?php echo $smestaj->tipSmestaja ?>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            Kapacitet:
                        </td>
                        <td>
                            <?php echo $smestaj->kapacitet; ?>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            Povrsina:
                        </td>
                        <td>
                            <?php echo $smestaj->povrsina; ?> m²
                        </td>
                    </tr>
                    <tr>
                        <td>
                            Kuhinja:
                        </td>
                        <td>
                            <?php echo $smestaj->kuhinja==1?'Da':'Ne'; ?>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            Parking:
                        </td>
                        <td>
                            <?php echo $smestaj->parking==1?'Da':'Ne'; ?>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            Terasa:
                        </td>
                        <td>
                            <?php echo $smestaj->terasa==1?'Da':'Ne'; ?>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            Adresa:
                        </td>
                        <td>
                            <?php echo $smestaj->ulica ." ". $smestaj->broj .", ". $smestaj->grad .", ". $smestaj->drzava; ?>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            Opis:
                        </td>
                        <td>
                            <?php echo $smestaj->opis; ?>
                        </td>
                    </tr>
                </table>
            </div>
        </div>
    </div>    
    <div class='row '>
        <div class='col-sm-12 '>
            <hr> &nbsp; <br> &nbsp;
        </div>
    </div>

    <div class='row'>
        <div class='col-sm-6 '>
            <h5 class='pocetnaTextNaslov text-center'>Lokacija smeštaja</h5>
            <div id="map">
                <input type="hidden" name="lat" id="lat" size=12 value="">
                <input type="hidden" name="lon" id="lon" size=12 value="">
                <br>
                <script type="text/javascript">
                    var startlat = "<?php echo $smestaj->lat; ?>";
                    var startlon = "<?php echo $smestaj->lon; ?>";

                    var options = {
                        center: [startlat, startlon],
                        zoom: 9
                    }

                    document.getElementById('lat').value = startlat;
                    document.getElementById('lon').value = startlon;

                    var map = L.map('map', options);
                    var nzoom = 12;

                    L.tileLayer('http://{s}.tile.osm.org/{z}/{x}/{y}.png', {
                        attribution: 'OSM'
                    }).addTo(map);

                    var myMarker = L.marker([startlat, startlon], {
                        title: "Coordinates",
                        alt: "Coordinates",
                        draggable: true
                    }).addTo(map);
                </script>
            </div>
        </div>
        <div class='col-sm-6'>
            <div clas='row'>
                <div class='col-sm-12'>
                    <span class='pocetnaTextNaslov'>Prosecna ocena:</span>
                    <div class='ratings1'>    
                        <?php
                        echo "<span class='pocetnaTextNaslov'>". round($recenzijaModel->dohvProsecnuOcenu($smestaj->id),1) . "</span>";
                        for($i=0;$i<floor($recenzijaModel->dohvProsecnuOcenu($smestaj->id));$i++)
                            echo "<span class='fa fa-star'></span>";
                            if(floor($recenzijaModel->dohvProsecnuOcenu($smestaj->id))<5) echo "<span class='fa fa-star-half-o'></span>";
                        for($i=floor($recenzijaModel->dohvProsecnuOcenu($smestaj->id)+1);$i<5;$i++)
                            echo "<span class='fa fa-star-o'></span>";
                        ?>
                        <p>na osnovu <?php echo (string)$recenzijaModel->dohvBrojRecenzija($smestaj->id); ?> recenzija</p>
                    </div>
                    <table class='table'>
                        <tr>
                            <td>
                                Sjajno:
                            </td>
                            <td>
                                <div class="progress">
                                   <?php
                                        if($recenzijaModel->dohvProsek('Sjajno', $smestaj->id)>0)
                                                $cnt = ((string)$recenzijaModel->dohvProsek('Sjajno', $smestaj->id)) . "%";
                                        else {
                                            echo "Ne postoje ocene ovog tipa.";
                                            $cnt = 0;
                                        }
                                   ?>
                                    <div class="progress-bar bg-success" role="progressbar" style="width: <?php echo $cnt; ?>" aria-valuenow="<?php echo $cnt; ?> " aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td width='15%'>
                                Dobro:
                            </td>
                            <td width='85%'>
                                <div class="progress">
                                    <?php
                                        if($recenzijaModel->dohvProsek('Dobro', $smestaj->id)>0)
                                                $cnt = ((string)$recenzijaModel->dohvProsek('Dobro', $smestaj->id)) . "%";
                                        else {
                                            echo "Ne postoje ocene ovog tipa.";
                                            $cnt = 0;
                                        }
                                    ?>
                                  <div class="progress-bar bg-primary" role="progressbar" style="width: <?php echo $cnt; ?>" aria-valuenow="<?php echo $cnt; ?> " aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td width='15%'>
                                Okej:
                            </td>
                            <td width='85%'>
                                <div class="progress">
                                    <?php
                                        if($recenzijaModel->dohvProsek('Okej', $smestaj->id)>0)
                                                $cnt = ((string)$recenzijaModel->dohvProsek('Sjajno', $smestaj->id)) . "%";
                                        else {
                                            echo "Ne postoje ocene ovog tipa.";
                                            $cnt = 0;
                                        }
                                    ?>
                                  <div class="progress-bar bg-info" role="progressbar" style="width: <?php echo $cnt; ?>" aria-valuenow="<?php echo $cnt; ?> " aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td width='15%'>
                                Loše:
                            </td>
                            <td width='85%'>
                                <div class="progress">
                                    <?php
                                        if($recenzijaModel->dohvProsek('Lose', $smestaj->id)>0)
                                                $cnt = ((string)$recenzijaModel->dohvProsek('Sjajno', $smestaj->id)) . "%";
                                        else {
                                            echo "Ne postoje ocene ovog tipa.";
                                            $cnt = 0;
                                        }
                                    ?>
                                  <div class="progress-bar bg-warning" role="progressbar" style="width: <?php echo $cnt; ?>" aria-valuenow="<?php echo $cnt; ?> "  aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td width='15%'>
                                Veoma loše:
                            </td>
                            <td width='85%'>
                                <div class="progress">
                                    <?php
                                        if($recenzijaModel->dohvProsek('Veoma lose', $smestaj->id)>0)
                                                $cnt = ((string)$recenzijaModel->dohvProsek('Sjajno', $smestaj->id)) . "%";
                                        else {
                                            echo "Ne postoje ocene ovog tipa.";
                                            $cnt = 0;
                                        }
                                    ?>
                                  <div class="progress-bar bg-danger" role="progressbar" style="width: <?php echo $cnt; ?>" aria-valuenow="<?php echo $cnt; ?> "  aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
            <div class="row ">
                <div class="col-sm-12 ">
                <?php echo  anchor("{$controller}/sveRecenzijeOglasa/{$smestaj->id}", "<button class='btn btn-info col-12 skyBackground' role='button'>Sve recenzije</button>"); ?>
                </div>
            </div>
            <div class="row " style="height:25px; "></div>
            <?php if($controller =='Korisnik'){ 
                        echo "<div class='row'>";
                        echo    "<div class='col-sm-12'>";
                        echo       anchor("Korisnik/rezervisi/{$smestaj->id}", "<button class='btn btn-info col-12 skyBackground' role='button'>Rezervisi</button>");
                        echo    "</div>";
                        echo "</div>";
                        echo "<div class='row' style='height:25px'></div>";
                        if($smeDaOstaviRecenziju){
                            echo "<div class='row'>";
                            echo    "<div class='col-sm-12'>";
                            echo       anchor("Korisnik/ostaviRecenziju/{$smestaj->id}", "<button class='btn btn-info col-12 skyBackground' role='button'>Ostavi recenziju</button>");
                            echo    "</div>";
                            echo "</div>";
                        }
                  }
            ?>
        </div>
    </div>
</div>
