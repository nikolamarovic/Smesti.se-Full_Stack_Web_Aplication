<div class='bodyContent'>
    <div class='row'>
        <div class='col-sm-12 text-center'>
            <h2 class='pocetnaTextNaslov'>Postavite Vaš oglas:</h2>
        </div>
    </div>
    <div class='adPlacingDiv'>
        <form action="postavljanje_oglasa_submit" method="post" enctype="multipart/form-data">
            <table class='table table-borderless'>
                <tr>
                    <td></td>
                    <td>
                        <font color='red'>
                        <?php if (!empty($errors['naziv'])) echo $errors['naziv']; ?>
                        <?php
                        if (isset($greska)) {
                            echo $greska;
                        }
                        ?>
                        </font>
                    </td>
                    <td></td>
                    <td>
                        <font color='red'>
                        <?php if (!empty($errors['room_type'])) echo $errors['room_type']; ?>
                        </font>
                    </td>
                </tr>
                <tr>
                    <td>Naziv smestaja</td>
                    <td>
                        <?php
                        echo form_input("naziv", set_value("naziv"));
                        ?>
                    </td>
                    <td>Tip smestaja:</td>
                    <td>
                        <?php
                        $options = [
                            'soba' => 'Soba',
                            'apartman' => 'Apartman',
                            'hotelskaSoba' => 'Hotelska soba',
                            'vikendica' => 'Vikendica',
                        ];
                        echo form_dropdown('room_type', $options);
                        ?>
                    </td>
                </tr>
                <tr>
                    <td></td>
                    <td>
                        <font color='red'>
                        <?php if (!empty($errors['kapacitet'])) echo $errors['kapacitet']; ?>
                        </font>
                    </td>
                    <td></td>
                    <td>
                        <font color='red'>
                        <?php if (!empty($errors['povrsina'])) echo $errors['povrsina']; ?>
                        </font>
                    </td>
                </tr>
                <tr>
                    <td>Kapacitet:</td>
                    <td>
                        <?php echo form_input("kapacitet", set_value("kapacitet")); ?>
                    </td>
                    <td>Povrsina [m<sup>2</sup>]:</td>
                    <td>
                        <?php echo form_input('povrsina', set_value('povrsina')); ?>
                    </td>
                </tr>
                <tr>
                    <td></td>
                    <td>
                        <font color='red'>
                        <?php if (!empty($errors['cena'])) echo $errors['cena']; ?>
                        </font>
                    </td>
                    <td></td>
                    <td>
                        <font color='red'>
                        <?php if (!empty($errors['kitchen_type'])) echo $errors['kitchen_type']; ?>
                        </font>
                    </td>
                </tr>
                <tr>
                    <td>Cena:</td>
                    <td>
                        <?php echo form_input("cena", set_value("cena")); ?>
                    </td>
                    <td>Kuhinja:</td>
                    <td>
                        <?php
                        $data1 = [
                            'name' => 'kitchen_type',
                            'value' => 'da',
                            'checked' => FALSE,
                        ];
                        echo form_radio($data1);
                        echo "Da";
                        $data2 = [
                            'name' => 'kitchen_type',
                            'value' => 'ne',
                            'checked' => FALSE,
                        ];
                        echo form_radio($data2);
                        echo " Ne";
                        ?>
                    </td>
                </tr>
                <tr>
                    <td></td>
                    <td>
                        <font color='red'>
                        <?php if (!empty($errors['parking'])) echo $errors['parking']; ?>
                        </font>
                    </td>
                    <td></td>
                    <td>
                        <font color='red'>
                        <?php if (!empty($errors['terasa'])) echo $errors['terasa']; ?>
                        </font>
                    </td>
                </tr>
                <tr>
                    <td>Parking:</td>
                    <td>
                        <?php
                        $data1 = [
                            'name' => 'parking',
                            'value' => 'da',
                            'checked' => FALSE,
                        ];
                        echo form_radio($data1);
                        echo "Da";
                        $data2 = [
                            'name' => 'parking',
                            'value' => 'ne',
                            'checked' => FALSE,
                        ];
                        echo form_radio($data2);
                        echo " Ne";
                        ?>
                    </td>
                    <td>Terasa:</td>
                    <td>
                        <?php
                        $data1 = [
                            'name' => 'terasa',
                            'value' => 'da',
                            'checked' => FALSE,
                        ];
                        echo form_radio($data1);
                        echo "Da";
                        $data2 = [
                            'name' => 'terasa',
                            'value' => 'ne',
                            'checked' => FALSE,
                        ];
                        echo form_radio($data2);
                        echo " Ne";
                        ?>
                    </td>
                </tr>

                <tr>                    <td></td>
                    <td>
                        <font color='red'>
                        <?php if (!empty($errors['ulica'])) echo $errors['ulica']; ?>
                        </font>
                    </td>

                    <td></td>
                    <td>
                        <font color='red'>
                        <?php if (!empty($errors['broj'])) echo $errors['broj']; ?>
                        </font>
                    </td>
                </tr>
                <tr>
                    <td>Ulica:</td>
                    <td>
                        <input type="text" name="ulica" value="" id="ulica">
                    </td>
                    <td>Broj:</td>
                    <td>
                        <input type="number" name="broj" value="" id="broj">
                    </td>
                </tr>
                <tr>
                    <td></td>
                    <td>
                        <font color='red'>
                        <?php if (!empty($errors['grad'])) echo $errors['grad']; ?>
                        </font>
                    </td>
                    <td></td>
                    <td>
                        <font color='red'>
                        <?php if (!empty($errors['ptt'])) echo $errors['ptt']; ?>
                        </font>
                    </td>
                </tr>
                <tr>
                    <td>Grad:</td>
                    <td>
                        <input type="text" name="grad" value="" id="grad">
                    </td>
                    <td>Postanski broj:</td>
                    <td>
                        <?php
                        echo form_input('ptt', set_value('ptt'));
                        ?>
                    </td>
                </tr>
                <tr>
                    <td></td>
                    <td>
                        <font color='red'>
                        <?php if (!empty($errors['drzava'])) echo $errors['drzava']; ?>
                        </font>
                    </td>
                    <td></td>
                    <td>
                        <font color='red'>
                        <?php if (!empty($errors['fileToUpload'])) echo $errors['fileToUpload']; ?>
                        </font>
                    </td>
                </tr>
                <tr>
                    <td>Drzava:</td>
                    <td>
                        <?php
                        echo form_input('drzava', set_value('drzava'));
                        ?>
                    </td>
                    <td>Slike smestaja:</td>
                    <td>
                        <input type="file" name="fileToUpload[]" id="fileToUpload" multiple accept='image/*'>
                    </td>
                </tr>
                <tr>
                    <td></td>
                    <td colspan='3'>
                        <font color='red'>
                        <?php if (!empty($errors['opis'])) echo $errors['opis']; ?>
                        </font>
                    </td>
                </tr>
                <tr>
                    <td>Opis:</td>
                    <td colspan='3'>
                        <?php
                        $data = [
                            'id' => 'opis',
                            'name' => 'opis',
                            'rows' => '5',
                            'cols' => '80',
                            'placeholder' => 'Kompletan opis smestaja'
                        ];
                        echo form_textarea($data);
                        ?>
                    </td>
                </tr>
            </table>
            <div id = "mapa">
                <input type="hidden" name="lat" id="lat" size=12 value="">
                <input type="hidden" name="lon" id="lon" size=12 value="">

                <div id="search" class='text-center'>
                    <button type="button" class='btn btn-success' onclick="addr_pretraga();">Lociraj</button>
                    <div id="results"></div>
                </div>

                <div id="map"></div>
                <br>
                <script type="text/javascript">
                    // Beograd
                    var startlat = 44.818611;
                    var startlon = 20.468056;

                    var options = {
                        center: [startlat, startlon],
                        zoom: 7
                    }

                    document.getElementById('lat').value = startlat;
                    document.getElementById('lon').value = startlon;

                    var map = L.map('map', options);
                    var nzoom = 12;

                    L.tileLayer('https://api.mapbox.com/styles/v1/{id}/tiles/{z}/{x}/{y}?access_token={accessToken}', {
                        attribution: 'Map data &copy; <a href="https://www.openstreetmap.org/">OpenStreetMap</a> contributors, <a href="https://creativecommons.org/licenses/by-sa/2.0/">CC-BY-SA</a>, Imagery © <a href="https://www.mapbox.com/">Mapbox</a>',
                        maxZoom: 18,
                        id: 'mapbox/streets-v11',
                        tileSize: 512,
                        zoomOffset: -1,
                        accessToken: 'pk.eyJ1IjoibW9tY2lsbzk4IiwiYSI6ImNrYXN0bXdhNjB2dW4yc3BydDBoNW52NmYifQ.tHLATCsFxq1eRPKR0d0aBA'
                    }).addTo(map);

                    var myMarker = L.marker([startlat, startlon], {
                        title: "Coordinates",
                        alt: "Coordinates",
                        draggable: true
                    }).addTo(map);

                    function chooseAddr(lat1, lng1) {
                        myMarker.closePopup();
                        map.setView([lat1, lng1], 7);
                        myMarker.setLatLng([lat1, lng1]);
                        lat = lat1.toFixed(8);
                        lon = lng1.toFixed(8);
                        document.getElementById('lat').value = lat;
                        document.getElementById('lon').value = lon;
                        myMarker.bindPopup("Lat " + lat + "<br />Lon " + lon).openPopup();
                    }

                    function parsirajAdrese(arr) {
                        var out = "<br />";
                        var i;
                        if (arr.length > 0) {
                            for (i = 0; i < arr.length; i++) {
                                out += "<div class='address' title='Show Location and Coordinates' onclick='chooseAddr(" + arr[i].lat + ", " + arr[i].lon + ");return false;'>" + arr[i].display_name + "</div>";
                            }
                            document.getElementById('results').innerHTML = out;
                        } else {
                            document.getElementById('results').innerHTML = "Zao name je nema rezultata pretrage...";
                        }
                    }

                    function addr_pretraga() {
                        var grad = document.getElementById("grad");
                        var ulica = document.getElementById("ulica");
                        var broj = document.getElementById("broj");

                        var xmlhttp = new XMLHttpRequest();
                        var url = "https://nominatim.openstreetmap.org/search?format=json&limit=3&q=" + grad.value + " " + ulica.value + " " + broj.value;
                        xmlhttp.onreadystatechange = function () {
                            if (this.readyState == 4 && this.status == 200) {
                                var myArr = JSON.parse(this.responseText);
                                parsirajAdrese(myArr);
                            }
                        };
                        xmlhttp.open("GET", url, true);
                        xmlhttp.send();
                    }
                </script>
            </div>
            <div class='text-center'>
                <input type="submit" class='btn btn-dark col-6' value="Postavi oglas" name="submit">
            </div>
        </form>
    </div>
</div>
