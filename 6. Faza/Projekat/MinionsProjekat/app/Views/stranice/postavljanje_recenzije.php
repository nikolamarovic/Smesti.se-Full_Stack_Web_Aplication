<div class='bodyContent'>
    <div class='row'>
        <div class='col-sm-12'>
            <h2 class='blackTextTitleCenter'>Ostavite vase recenzije. Unapred hvala!</h2>
            <hr>
        </div>
    </div>
    <div class='recenzijeDiv'>
        <div class='row'>
            <div class='offset-sm-1 col-sm-3'>
                <h1 class='blackTextLeft'>Ocenite nas:</h1>
                <?php echo form_open("Korisnik/ostaviRecenzijuSubmit/{$idSmestajRecenzija}","method=post"); ?>
                <table>
                    <tr>
                        <td>Čistoća:</td>
                        <td>
                            <div class='ratings1'>
                                <span class='fa fa-star-o'></span>
                                <span class='fa fa-star-o'></span>
                                <span class='fa fa-star-o'></span>
                                <span class='fa fa-star-o'></span>
                                <span class='fa fa-star-o'></span>
                            </div>
                            <input type='hidden' id='cistoca' name='cistoca'>
                            <script type='text/javascript' src='<?=base_url('js/skripta_zvezdice_cistoca.js');?>'></script>
                            <?php ?>
                        </td>
                    </tr>
                    <tr>
                        <td>Komfor:</td>
                        <td>
                            <div class='ratings3'>
                                <span class='fa fa-star-o'></span>
                                <span class='fa fa-star-o'></span>
                                <span class='fa fa-star-o'></span>
                                <span class='fa fa-star-o'></span>
                                <span class='fa fa-star-o'></span>
                            </div>
                            <input type='hidden' id='komfor' name='komfor'>
                            <script type='text/javascript' src='<?=base_url('js/skripta_zvezdice_komfor.js');?>'></script>
                        </td>
                    </tr>
                    <tr>
                        <td>Kvalitet:</td>
                        <td>
                            <div class='ratings2'>
                                <span class='fa fa-star-o'></span>
                                <span class='fa fa-star-o'></span>
                                <span class='fa fa-star-o'></span>
                                <span class='fa fa-star-o'></span>
                                <span class='fa fa-star-o'></span>
                            </div>
                            <input type='hidden' id='kvalitet' name='kvalitet'>
                            <script type='text/javascript' src='<?=base_url('js/skripta_zvezdice_kvalitet.js');?>'></script>
                        </td>
                    </tr>
                    <tr>
                        <td>Lokacija:</td>
                        <td>
                            <div class='ratings5'>
                                <span class='fa fa-star-o'></span>
                                <span class='fa fa-star-o'></span>
                                <span class='fa fa-star-o'></span>
                                <span class='fa fa-star-o'></span>
                                <span class='fa fa-star-o'></span>
                            </div>
                            <input type='hidden' id='lokacija' name='lokacija'>
                            <script type='text/javascript' src='<?=base_url('js/skripta_zvezdice_lokacija.js');?>'></script>
                        </td>
                    </tr>
                    <tr>
                        <td>Ljubaznost:</td>
                        <td>
                            <div class='ratings4'>
                                <span class='fa fa-star-o'></span>
                                <span class='fa fa-star-o'></span>
                                <span class='fa fa-star-o'></span>
                                <span class='fa fa-star-o'></span>
                                <span class='fa fa-star-o'></span>
                            </div>
                            <input type='hidden' id='ljubaznost' name='ljubaznost'>
                            <script type='text/javascript' src='<?=base_url('js/skripta_zvezdice_ljubaznost.js');?>'></script>
                        </td>
                    </tr>
                </table>
            </div>
            <div class='offset-sm-1 col-sm-3'>
                <h1 class='blackTextLeft'>Opsti utisak:</h1>
                <table>
                    <tr>
                        <td>
                            <input type="radio" name='utisak' value='Sjajno'>
                        </td>
                        <td>Sjajno: 9+</td>
                    </tr>
                    <tr>
                        <td>
                            <input type='radio' name='utisak'value='Dobro'>
                        </td>
                        <td>Dobro: 7-9</td>
                    </tr>
                    <tr>
                        <td>
                            <input type='radio' name='utisak' value='Okej'>
                        </td>
                        <td>Okej: 5-7</td>
                    </tr>
                    <tr >
                        <td>
                            <input type='radio' name='utisak' value='Loše'>
                        </td>
                        <td>Lose: 3-5</td>
                    </tr>
                    <tr>
                        <td>
                            <input type='radio' name='utisak' value='Veoma loše'>
                        </td>
                        <td>Veoma lose: 1-3</td>
                    </tr>
                </table>
            </div>
            <div class='offset-sm-1 col-sm-3'>
                <h1 class='blackTextLeft'>Tip putnika:</h1>
                <table>
                    <tr>
                        <td>
                            <input type="radio" name="tipPutnika" value='Porodica'>
                        </td>
                        <td>Porodica</td>
                    </tr>
                    <tr>
                        <td>
                            <input type='radio' name='tipPutnika' value='Par'>
                        </td>
                        <td>Par</td>
                    </tr>
                    <tr>
                        <td>
                            <input type='radio' name='tipPutnika'value='Grupa prijatelja'>
                        </td>
                        <td>Grupa prijatelja</td>
                    </tr>
                    <tr>
                        <td>
                            <input type='radio' name='tipPutnika' value='Poslovni putnik'>
                        </td>
                        <td>Poslovni putnik</td>
                    </tr>
                    <tr>
                        <td>
                            <input type='radio' name='tipPutnika' value='Solo'>
                        </td>
                        <td>Solo</td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
    <hr>
    <div class='row'>
        <div class='col-sm-12 text-center'>
            <h2 class='blackTextCenter'>Ostavite komentar:</h2>
            <p>
                <textarea name='recenzijaKomentar' id="recenzijaKomentar" rows="5" cols="100" placeholder='Ovde mozete ostaviti vas komentar uz recenziju.' maxlength="250"></textarea>
            </p>
        </div>
    </div>
    <div class='row'>
        <div class='col-sm-12 text-center'>
            <?php echo form_submit("recenzijaSubmit", "Pošalji recenziju", 'class = btn-info'); ?>
            <?php form_close(); ?>
            <hr>
        </div>
    </div>
</div>