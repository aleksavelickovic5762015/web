<!DOCTYPE html>
<html>
<head>
    <title>Pocetna</title>
    <script>
        function brisi()
        
    </script>
</head>
<body>
    <?php        
        $veza = mysqli_connect("localhost", "root", "", "wp2019");
        if(mysqli_connect_errno())
            die("Greska pri povezivanju sa bazom: ".mysqli_connect_errno());
        $upit = "SELECT *
                 FROM knjiga";
        $rezul = mysqli_query($veza, $upit) or die("Greska pri izvsavanju upita 1:".mysqli_error($veza));
        if(mysqli_num_rows($rezul)>0)
        {
            echo "<table border=1>
                    <tr>
                        <th>Naslov</th>
                        <th>Autor</th>
                        <th>Godina izdanja</th>
                        <th colspan=2></th>
                    </tr>";
            while($red = mysqli_fetch_assoc($rezul))
            {
                echo "<tr>
                        <td>'{$red['naslov']}'</td>
                        <td>'{$red['autor']}'</td>
                        <td>'{$red['godina']}'</td>
                      </tr>";
            }
            echo "</table>";
        }
        else
            echo "Upit nije vratio nista - nema knjiga u bazi";
        
        mysqli_free_result($rezul);
        mysqli_close($veza);
    ?>
</body>
</html>