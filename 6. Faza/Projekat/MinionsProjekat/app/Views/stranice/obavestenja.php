<div class='bodyContent'>
    <div class='recenzijeDiv'>
        <div class='row'>
            <div class='col-sm-12 pocetnaTextNaslov text-left'>
                <p>Nova obaveštenja:</p> 
            </div>
        </div>
        <div class='row'>
            <div class='col-sm-12'>
                <?php foreach($obavestenja as $obavestenje){?>
                    <div class="alert alert-<?php echo $obavestenje->tip; ?> alert-dismissible fade show" role="alert">
                        <strong><?php echo $obavestenje->naslov; ?></strong> <?php echo $obavestenje->opis; ?>
                        <?php echo anchor("{$controller}/obrisiObavestenje/{$obavestenje->id}", "<p class='close'  aria-label='Close'>&times;</p> "); ?>
                    </div>
                <?php } ?>
            </div>
        </div>
    </div>
</div>