<div class='bodyContent'>
    <div class='recenzijeDiv'>
        <br>
            <?php 
                 $recenzijaModel = new \App\Models\RecenzijaModel();
                 if($controller == 'Admin'){
                     $recenzije = $recenzijaModel->dohvSveRecenzije();
                 }else if($controller=='Oglasavac'){
                     if(isSet($idOglasavaca)){
                        $recenzije = $recenzijaModel->dohvSveRecenzijeOglasavaca($idOglasavaca);
                        if(count($recenzije)==0){
                            echo "<p class='textCenter pocetnaTextNaslov'>Nema recenzija.</p>";
                        }
                     }else $recenzije = $recenzijaModel->dohvSveRecenzijeOglasa($smestaj->id);
                 }else{
                    $recenzije = $recenzijaModel->dohvSveRecenzijeOglasa($smestaj->id);
                    echo "<div class='row '>";
                    echo "<div class='col-sm-12 pocetnaTextNaslov textCenter' >";
                    echo "Recenzije za smeštaj: " . $smestaj->naziv ;
                    echo "<br>";
                    echo "</div>";
                    echo "</div>";
                 }
                foreach($recenzije as $recenzija){
                    $korisniciModel = new \App\Models\KorisniciModel();
                    $korisnik = $korisniciModel->dohvKorisnika($recenzija->idKorisnik);
            ?>
            <div class='row pocetnaTextNaslov'>                
                <?php
                if($controller == 'Admin' || $controller=='Oglasavac'){
                    $smestajModel = new App\Models\SmestajModel();                            
                    $smestaj = $smestajModel->dohvSmestaj($recenzija->idSmestaj)[0];
                    echo "<div class='col-sm-6 textLeft'>";
                    echo "Recenzija za smeštaj: " . $smestaj->naziv; 
                    echo "</div>";
                    if($controller=='Admin'){
                        echo "<div class='col-sm-6 textRight'>";
                        echo anchor("{$controller}/obrisiRecenziju/{$recenzija->id}", "<p id='oglasOpcije'>Obriši recenziju</p>");
                        echo "</div>";
                    }
                }
                ?>
            </div>
            <table class='table table-dark table-striped tableText'>
                <tr>
                    <td>Korisnik:</td>
                    <td>
                      <?php echo $korisnik->ime." ".$korisnik->prezime;?>
                    </td>
                </tr>
                <tr>
                    <td>Recenzija</td>
                    <td>
                      <?php echo "#". $recenzija->id;?>  
                    </td>
                </tr>
                <tr>
                    <td class='tableText'>Cistoca:</td>
                    <td>
                        <div class='ratings1'>
                            <?php 
                            for($i=0;$i<$recenzija->cistoca;$i++)
                                echo "<span class='fa fa-star'></span>";
                            for($i=$recenzija->cistoca;$i<5;$i++)
                                echo "<span class='fa fa-star-o'></span>";
                            ?>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td class='tableText'>Komfor:</td>
                    <td>
                        <div class='ratings1'>
                            <?php 
                            for($i=0;$i<$recenzija->komfor;$i++)
                                echo "<span class='fa fa-star'></span>";
                            for($i=$recenzija->komfor;$i<5;$i++)
                                echo "<span class='fa fa-star-o'></span>";
                            ?>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td class='tableText'>Kvalitet:</td>
                    <td>
                        <div class='ratings1'>
                            <?php 
                            for($i=0;$i<$recenzija->kvalitet;$i++)
                                echo "<span class='fa fa-star'></span>";
                            for($i=$recenzija->kvalitet;$i<5;$i++)
                                echo "<span class='fa fa-star-o'></span>";
                            ?>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td class='tableText'>Lokacija:</td>
                    <td>
                        <div class='ratings1'>
                            <?php 
                            for($i=0;$i<$recenzija->lokacija;$i++)
                                echo "<span class='fa fa-star'></span>";
                            for($i=$recenzija->lokacija;$i<5;$i++)
                                echo "<span class='fa fa-star-o'></span>";
                            ?>
                        </div>
                    </td>

                </tr>
                <tr>
                    <td class='tableText'>Ljubaznost:</td>
                    <td>
                        <div class='ratings1'>
                            <?php 
                            for($i=0;$i<$recenzija->ljubaznost;$i++)
                                echo "<span class='fa fa-star'></span>";
                            for($i=$recenzija->ljubaznost;$i<5;$i++)
                                echo "<span class='fa fa-star-o'></span>";
                            ?>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td>Prosecna Ocena:</td>
                    <td><?php echo ($recenzija->komfor+$recenzija->kvalitet+$recenzija->ljubaznost+$recenzija->cistoca+$recenzija->lokacija)/5; ?></td>
                </tr>
                <tr>
                    <td>Opšti utisak:</td>
                    <td><?php echo $recenzija->opstiUtisak;?></td>
                </tr>
                <tr>
                    <td class='tableText'>Tip putnika:</td>
                    <td><?php echo $recenzija->tip;?></td>
                </tr>
                <tr>
                    <td class='tableText' style="width:100px">Komentar:</td>
                    <td style="width:450px"><?php echo $recenzija->komentar;?></td>
                </tr>
                <?php
                    if($controller=='Oglasavac'){
                        if($recenzija->odgovor!=null){
                ?>    
                        <tr>
                            <td class='tableText'  style="width:100px">Odgovor:</td>
                            <td class='tableText' style="width:450px"><?php echo $recenzija->odgovor;?></td>
                        </tr>
                <?php
                        }else{
                            echo "<tr>";
                            echo "<td class='tableText' style='width:100px'>Odgovor:</td>";
                            echo "<td style='width:450px'>". anchor("{$controller}/odgovorNaRecenziju/{$recenzija->id}", "<p id='tabelaLinkovi'>Odgovori</p>") . "</td>";
                            echo "</tr>";
                        }
                    }
                ?>
                <?php if($controller=='Gost' || $controller=='Korisnik'){ ?>
                <tr>
                    <td class='tableText' style="width:100px">Odgovor:</td>
                    <td style="width:450px">
                    <?php 
                    if($recenzija->odgovor) echo $recenzija->odgovor;
                    else echo "Još uvek ne postoji odgovor.";
                    ?>
                    </td>
                </tr>
                <?php } ?>
            </table>
            <?php
            }
            ?>
        </div>
    </div>
</div>
