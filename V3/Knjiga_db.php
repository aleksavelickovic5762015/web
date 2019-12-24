<?php
/*
 * Klasa za CRUD operacije nad tabelom "Knjiga"
 */
class Knjiga_db {
// Konstante
    const ime_hosta = 'localhost';
    const korisnik = 'root';
    const sifra = '';
    const ime_baze = "wp2019";
    // Atributi
    private $dbh; // konekcija prema bazi
    // Metode
    // Zadatak konstruktora je otvaranje konekcije prema bazi
    function  __construct() {
        try {
            $konekcioni_string  = "mysql:host=".self::ime_hosta.";dbname=".self::ime_baze;
            $this->dbh = new PDO($konekcioni_string, self::korisnik, self::sifra);
        }
        catch(PDOException $e) {
            echo "GRESKA: ";
            echo $e->getMessage();
        }
    }
    // Zadatak destruktora je zatvaranje konekcije prema bazi
    function  __destruct() {
        $this->dbh = null;
    }
    /**
     * Metoda koja stampa tabelu knjiga po kriterijumu pretrage za naslov
     * ukoliko je kriterijum zadat.
     */
    public function stampaj_tabelu_knjiga($naslov_kriterijum=NULL) {
        try {
            $sql = "SELECT id, naslov, autor, godina FROM knjiga";
            // Ako je zadat kriterijum dodaj ga u upit
            if ( isset ($naslov_kriterijum) ) {
                $sql.=" WHERE NASLOV LIKE '%$naslov_kriterijum%'";
            }
            $pdo_izraz = $this->dbh->query($sql);
            $niz = $pdo_izraz->fetchALL(PDO::FETCH_ASSOC);
            echo "<table cellpadding='5' border='1'>";
            echo  "<tr><th>Naslov</th><th>Autor</th><th>Godina  izdanja</th><th colspan='2'>&nbsp;</th></tr>";
            foreach($niz as $knjiga) {
                echo "<tr><td><b>".$knjiga['naslov']."</b></td>";
                echo "<td>".$knjiga['autor']."</td>";
                echo "<td>".$knjiga['godina']."</td>";
                echo "<td><input type='button' id='".$knjiga['id']."' value='brisi' onclick='brisi(this.id)'></td>";
                echo "<td><input type='button' id='".$knjiga['id']."' value='izmeni' onclick='izmeni(this.id)'></td></tr>";
            }
            echo "</table>";
        }
        catch(PDOException $e) {
            echo "GRESKA: ";
            echo $e->getMessage();
        }
    }
    /*
     * Metoda dodaje knjigu sa datim parametrima u bazu.
     * Nema potrebe da se setuje $id jer ga baza dodeljuje automatski.
     */
    public function dodaj($naslov, $autor, $godina) {
        try {
            $sql = "INSERT INTO knjiga(id, naslov, autor, godina) ";
            $sql.= "VALUES ('', '$naslov', '$autor', '$godina')";
            $pdo_izraz = $this->dbh->exec($sql);
            return true;
        }
        catch(PDOException $e) {
            echo "GRESKA: ";
            echo $e->getMessage();
            return false;
        }
    }
    /*
     * Metoda koja brise knjigu sa ID-om $id iz baze
     */
    public function brisi($id) {
        try {
            $sql = "DELETE FROM knjiga WHERE id=$id";
            $pdo_izraz = $this->dbh->exec($sql);
            return true;
        }
        catch(PDOException $e) {
            echo "GRESKA: ";
            echo $e->getMessage();
            return false;
        }
    }
    /*
     * Metoda koja za knjigu sa ID-om $id postavlja naslov, autora i godinu
     */
    public function izmeni($id, $naslov, $autor, $godina) {
        try {
            $sql = "UPDATE knjiga SET naslov=:naslov, ";
            $sql.= "autor=:autor, godina=:godina ";
            $sql.= "WHERE id=:id";
            $pdo_izraz = $this->dbh->prepare($sql);
            $pdo_izraz->bindParam(':id', $id);
            $pdo_izraz->bindParam(':naslov', $naslov);
            $pdo_izraz->bindParam(':autor', $autor);
            $pdo_izraz->bindParam(':godina', $godina);
            $pdo_izraz->execute();
            return true;
        }
        catch(PDOException $e) {
            echo "GRESKA: ";
            echo $e->getMessage();
            return false;
        }
    }
    /*
     * Metoda koja uzima iz baze podatke (id, naslov, autor, godina) o knjizi
     * sa ID-om $id i vraca ih u obliku asocijativnog niza
     */
    public function uzmi_podatke_o_knjizi($id) {
        try {
            $sql = "SELECT * FROM knjiga WHERE id=$id";
            $pdo_izraz = $this->dbh->query($sql);
            $obj = $pdo_izraz->fetch(PDO::FETCH_ASSOC);
            return $obj;
        }
        catch(PDOException $e) {
            echo "GRESKA: ";
            echo $e->getMessage();
        }
    }
} // Kraj klase Knjiga_db
?>