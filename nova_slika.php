<!DOCTYPE html>
<html>
<head>
    <title>Obajvljujemo sliku</title>
</head>
<body>
    <?php
        $ime = $_POST["ime"];
        $slika = addslashes(file_get_contents($_FILES['slika']['tmp_name']));

        $veza = mysqli_connect("localhost", "root", "", "kol_slike");
        if(mysqli_connect_errno())
            die("Greska pri povezivanju sa bazom: ".mysqli_connect_errno());
        
        $upit = "INSERT INTO slike (korisnik, slika)
                 VALUES ('{$ime}', '{$slika}')";
        $rezul = mysqli_query($veza, $upit) or die("Greska pri izvrsavanju upita: ".mysqli_error($veza));

        if($rezul)
            echo "Uspesan unos slike";
        else
            echo "Neuspesano";
            
        mysqli_close($veza);
    ?>
</body>
</html>