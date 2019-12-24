<html>

<head>
    <title>Dodavanje knjige</title>
    <script type="text/javascript">
        // Provera da li je argument unet ceo broj
        function isInteger(val) {
            // Ako nije setovana, vrati false
            if (val == null)
                return false;
            // duzina stringa nula, vrati false
            if (val.length == 0)
                return false;
            for (var i = 0; i < val.length; i++) 
            {
                var ch = val.charAt(i);
                if (i == 0 && ch == "-")
                    continue;
                if (ch < "0" || ch > "9")
                    return false;
            }
            return true
        }
        // Validacija forme za unos
        function validacija_submit() 
        {
            naslov = document.getElementById("naslov").value;
            autor  = document.getElementById("autor").value;
            godina = document.getElementById("godina").value;
            forma  = document.getElementById("forma");
            if (naslov == "" || autor == "" || godina == "") 
            {
                alert("Nije uneto zahtevano polje!");
                return false;
            }
            if (!isInteger(godina) || parseInt(godina) < 1500 || parseInt(godina) > 2300) 
            {
                alert("Pogresna godina!");
                return false;
            }
            // manuelni submit forme
            forma.submit();
        }
    </script>
</head>

<body>
    <h1>Izmena podataka o knjizi</h1>
    <?php
        require_once 'Knjiga_db.php';
        $knjige = new Knjiga_db();
        // Asocijativni niz sa podacima o knjizi "id"
        $podaci = $knjige->uzmi_podatke_o_knjizi($_GET["id"]);
    ?>

    <!-- Ne prikazuj formu ako treba da se obrade podaci -->
    <?php 
    if (!isset ($_GET["naslov"])) 
    { 
    ?>
        <form id="forma" action="<?php $_SERVER["PHP_SELF"] ?>" method="get">
            <input type="hidden" name="id" value="<?php echo $_GET['id']?>" />
            naslov: <input id="naslov" name="naslov" type="text" size="20" value=" <?php echo $podaci['naslov'] ?> "><br />
             autor: <input id="autor"  name="autor"  type="text" size="20" value=" <?php echo $podaci['autor']  ?> "><br />
            godina: <input id="godina" name="godina" type="text" size="10" value=" <?php echo $podaci['godina'] ?> "><br />
            <input type="button" value='Izmeni' onclick="validacija_submit()" />
        </form>
    <?php
    } // zatvoren gornji if
    if (isset ($_GET["naslov"])) 
    {
        $naslov = $_GET["naslov"];
        $autor  = $_GET["autor"];
        $godina = $_GET["godina"];
        if ($knjige->izmeni($_GET["id"], $naslov, $autor, $godina))
            echo "<p><strong>Knjiga uspesno izmenjena</strong></p>";
        else
            echo "<p><strong>Knjiga nije uspesno izmenjena!</strong></p>";
    }
    ?>
    <a href="index.php">Indeks knjiga</a>
</body>

</html>