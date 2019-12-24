<!DOCTYPE html>
<html>
<head>
    <title>Brisanje slike</title>
</head>
<body>
    <?php
        $id = $_POST["id"];

        $veza = mysqli_connect("localhost", "root", "", "kol_slike");
        if(mysqli_connect_errno())
            die("Greska pri povezivanju sa bazom: ".mysqli_connect_errno());

        $upit = "DELETE
                 FROM slike
                 WHERE id='{$id}'";
        $rezul = mysqli_query($veza, $upit) or die("Greska pri izvrsavanju upita: ".mysqli_error($veza));

        if($rezul)
            echo "Uspesno brisanje slike";
        else
            echo "Neuspesno brisanje";
        
        mysqli_close($veza);
    ?>
</body>
</html>