<!DOCTYPE html>
<html>
<head>
    <title>Osnovna strana</title>
</head>
<body>
    <?php
        $ime = $_POST["ime"];
        $sifra = $_POST["sifra"];

        $veza = mysqli_connect("localhost", "root", "", "kol_slike");
        if(mysqli_connect_errno())
        {
            die("Neuspesno povezivanje sa bazom: ".mysqli_connect_errno());
        }

        $upit = "SELECT sifra
                 FROM korisnici
                 WHERE ime='{$ime}'";
        $rezul = mysqli_query($veza, $upit) or die("Greska pri izvrsavanju upita 1: ".mysqli_error($veza));
        
        if(mysqli_num_rows($rezul) > 0)
        {
            $red = mysqli_fetch_assoc($rezul);
            $sifra_baza = $red["sifra"];

            if($sifra == $sifra_baza)
            {
                echo "Dobrodosli, $ime<br>";
                //izbor slike
                if($ime != "admin")
                {
                    echo"<form action='nova_slika.php' method='POST' enctype='multipart/form-data'>
                            Izaberi sliku:
                            <input type='hidden' name='ime' value='{$ime}'>
                            <input type='file' name='slika'>
                            <input type='submit' value='Objavi sliku'>
                         </form>";
                }
                echo "<br>Slike:<br>";
                $upit = "SELECT *
                         FROM slike";
                $rezul = mysqli_query($veza, $upit) or die("Greska pri izvrsavanju upita 2: ".mysqli.error());
                if(mysqli_num_rows($rezul))
                {
                    while($red = mysqli_fetch_assoc($rezul))
                    {
                        echo "Okacio ".$red["korisnik"]."<br>";
                        echo '<img src="data:image/jpeg;base64,'.base64_encode( $red['slika'] ).'"/>';
                        if($ime == "admin")
                        {
                            echo "<form action='brisi.php' method='POST'>
                                    <input type='hidden' name='id' value='{$red['id']}'>
                                    <input type='submit' value='Obrisi sliku'>
                                  </form>";
                        }
                        echo "<br><br>";
                    }
                }
                else
                    echo "Nema slika u bazi";
            }
            else
                echo "Pogresna sifra<br>";
        }
        else
            echo "Korisnik sa datim imenom ne postoji<br>";
        

        mysqli_free_result($rezul);
        mysqli_close($veza);        
    ?>
</body>
</html>