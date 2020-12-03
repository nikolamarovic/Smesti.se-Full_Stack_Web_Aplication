<div class='bodyContent'>
    <div class='recenzijeDiv'>
        <br>
        <div class='row pocetnaTextNaslov'>
            <div class='col-sm-12'>
                <?php
                    $recenzijaModel = new \App\Models\RecenzijaModel(); 
                    $recenzija = $recenzijaModel->dohvRecenziju($idRecenzije);
                    $smestajModel = new App\Models\SmestajModel();
                    $korisniciModel = new App\Models\KorisniciModel();
                    $korisnik = $korisniciModel->dohvKorisnika($recenzija->idKorisnik);
                    $smestaj = $smestajModel->dohvSmestaj($recenzija->idSmestaj)[0];
                    echo "<p>Recenzija za smeštaj: " . $smestaj->naziv . "</p>"; 
                ?>
            </div>
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
        </table>
    </div>
    <?php echo form_open("Oglasavac/odgovorNaRecenzijuSubmit/{$recenzija->id}","method=post"); ?>
    <div class='row'>
        <div class='col-sm-12 textCenter'>
            <p class='pocetnaTextNaslov'>Odgovorite na recenziju:</p>
            <textarea name='recenzijaOdgovor' id="recenzijaOdgovor" rows="5" cols="100" placeholder='Ovde možete ostaviti Vaš odgovor.' maxlength="250"></textarea>
        </div>
    </div>
    <div class='row'>
        <div class='col-sm-12 textCenter pocetnaTextNaslov'>
            <br>
            <?php echo form_submit("odgovorNaRecenziju", "Odgovori"); ?>
            <?php form_close(); ?>
        </div>
    </div>
</div>
