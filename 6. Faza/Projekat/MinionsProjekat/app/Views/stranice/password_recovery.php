<div class='bodyContent'>
    <div class = 'row'>
        <div class = 'registerDiv alignCenter'>
            <?php if(isset($poruka)) echo "<span> <font color='red'>$poruka</font><br> </span>"; ?>
            <?php echo form_open("Gost/password_recoverySubmit","method=post"); ?>
            <table class='table mainText' align='center'>
                <tr>
                    <td>
                        
                    </td>
                    <td>
                         <?php echo "Unesite Vaše podatke:" ?>
                    </td>
                </tr>
                <tr>
                    <td>
                        <?php echo "Korisničko ime:" ?>
                    </td>
                    <td>
                        <?php echo form_input("recovery_username"); ?>
                    </td>
                    <td>
                        <font color='red'>
                            <?php if(!empty($errors['recovery_username'])) echo $errors['recovery_username'];?>
                        </font>
                    </td>
                </tr>
                <tr>
                    <td>
                    </td>
                    <td >
                        <?php echo form_submit("password_recoverySubmit", "Povrati šifru"); ?>
                    </td>
                </tr>
            </table>
            <?php form_close(); ?>
        </div>
    </div>
</div>