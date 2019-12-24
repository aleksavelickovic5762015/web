<html>
    <head>
        <title>Brisanje knjige</title>
    </head>
    <body>
        <h1>Brisanje knjige</h1>
       
        <?php
        require_once 'Knjiga_db.php';
        $id = $_GET["id"];
        $knjige = new Knjiga_db();
        if ($knjige->brisi($id))
            echo "Knjiga uspesno obrisana.";
        else
            echo "Doslo je do greske u brisanju.";
        ?>
        <p><a href="index.php">Indeks knjiga</a></p>
    </body>
</html>