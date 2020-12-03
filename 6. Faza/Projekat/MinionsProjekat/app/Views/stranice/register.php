<div class='bodyContent'>
    <div class='row'>
        <div class = 'col-sm-12 myTextCenter'>
            <h2 class='blackTextTitleCenter'>Registrujte se:</h2>
        </div>
    </div>
    <div class = 'row'>
        <div class = 'registerDiv'>
            <?php echo form_open("Gost/registerCommit","method=post"); ?>
                <table class='table table-striped'>
                    <tr>
                        <td>
                            <?php echo "Ime:"; ?>
                        </td>
                        <td>
                            <?php echo form_input("ime",set_value("ime")); ?>
                        </td>
                        <td>
                            <font color='red'>
                                <?php if(!empty($errors['ime'])) echo $errors['ime'];?>
                            </font>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <?php echo "Prezime:"; ?>
                        </td>
                        <td>
                            <?php echo form_input("prezime",set_value("prezime")); ?>
                        </td>
                        <td>
                            <font color='red'>
                                <?php if(!empty($errors['prezime'])) echo $errors['prezime'];?>
                            </font>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <?php echo "Korisnicko ime:" ?>
                        </td>
                        <td>
                            <?php echo form_input("username",set_value("username")); ?>
                        </td>
                        <td>
                            <font color='red'>
                                <?php if(!empty($errors['username'])) echo $errors['username'];?>
                            </font>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <?php echo "E-mail:" ?>
                        </td>
                        <td>
                             <?php echo form_input('email', set_value("email"), ['placeholder' => 'Email...'], 'email');?>
                        </td>
                        <td>
                            <font color='red'>
                                <?php if(!empty($errors['email'])) echo $errors['email'];?>
                            </font>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <?php echo "Lozinka:" ?>
                        </td>
                        <td>
                            <input type="password" name="registration_password"/>
                        </td>
                        <td>
                            <font color='red'>
                                <?php if(!empty($errors['registration_password'])) echo $errors['registration_password'];?>
                            </font>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <?php echo "Ponovite lozinku:" ?>
                        </td>
                        <td>
                            <input type="password" name="registration_password_confirm"/>
                        </td>
                        <td>
                            <font color='red'>
                                <?php if(!empty($errors['registration_password_confirm'])) echo $errors['registration_password_confirm'];?>
                            </font>
                        </td>
                    </tr>
                    <tr>
                        <td>Datum rodjenja:</td>
                        <td>
                            <input type="date" name="datum_rodjenja">
                        </td>
                        <td>
                            <font color='red'>
                                <?php if(!empty($errors['datum_rodjenja'])) echo $errors['datum_rodjenja'];?>
                            </font>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <?php echo "Adresa:" ?>
                        </td>
                        <td>
                            <?php echo form_input("adresa",set_value("adresa")); ?>
                        </td>
                        <td>
                            <font color='red'>
                                <?php if(!empty($errors['adresa'])) echo $errors['adresa'];?>
                            </font>
                        </td>
                    </tr>
                    <tr>
                        <td>Vrsta registracija:</td>
                        <td>
                            <?php
                                $data1 = [
                                    'name'    => 'registration_type',
                                    'value'      => 'oglasavacReg',
                                    'checked' => FALSE,
                                ];
                                echo form_radio($data1); 
                                echo "Oglasavac:";
                                $data2 = [
                                    'name'    => 'registration_type',
                                    'value'   => 'korisnikReg',
                                    'checked' => FALSE,
                                ];
                                echo form_radio($data2);
                                echo "Korisnik";
                            ?>
                        </td>
                        <td>
                            <font color='red'>
                                <?php if(!empty($errors['registration_type'])) echo $errors['registration_type'];?>
                            </font>
                        </td>
                    </tr>
                </table>
            <div class='myTextCenter'>
                <?php echo form_submit("registerSubmit", "Registruj se"); ?>
                <?php form_close(); ?>
            </div>
        </div>
    </div>
</div>