<?php
// Ha nem nyomta meg a submit gombot visszairányít az index.html oldalra
if (!isset($_GET['submit'])) {
    header('location: index.html');
} else {
    // Ha valamelyik adat nem lett megadva, akkor szintén visszairányít az index.html oldalra
    if(!isset($_GET['szelesseg']) || !isset($_GET['magassag'])){
        header('location: index.html');
    } else{
        // Bekéri a szélességet és a magasságot a $_GET[''] szuperglobál változó segítségével
        $szelesseg = $_GET['szelesseg'];
        $magassag = $_GET['magassag'];
    
        // Kiszámítja az ablak kerületét
        $osszhossz = 2*($szelesseg + $magassag);
    
        // Egy léc hossza = 200 cm
        $lechossz = 200;

        // Kimaradó léchossz kiszámítása: A teljes léchosszból kivonjuk a szélességet és a magasságot és beszorzozzuk 2-vel.
        $kimarado = (($lechossz - $szelesseg) + ($lechossz - $magassag)) * 2;

        // Kerek százasok: Jelentősségük a lécszám kiszámításánál vannak
        $nem_kimaradok = [100, 200, 300, 400, 500, 600, 700, 800];

        // Ha a kimaradó nem kerek százas, és az összhossz nagyobb mint 200, továbbá a szélesség és a magasság nagyobb, mint 100, akkor a lécszámot úgy határozzuk meg, hogy az összhosszt összeadjuk a kimaradóval és elosztjuk a léc hosszával.
        if(!in_array($kimarado, $nem_kimaradok) && $osszhossz > 200 && $szelesseg > 100 && $magassag > 100){
            $lecszam = ($osszhossz + $kimarado) / $lechossz;
        // Ha az összhossz kisebb mint a léchossz akkor a lécszám minden esetben 1 lesz.
        } else if($osszhossz < $lechossz){
            $lecszam = 1;
        // Minden más esetben az összhosszt elosztjuk a léchosszal és felfelé kerekítjük a ceil() függvénnyel.
        } else{
            $lecszam = ceil($osszhossz / $lechossz);
        }

        // Az üveg felületének meghatározása: A szélességet és a magasságot elosztjuk 100-al, utána beszorozzuk egymással.
        $uveg = ($szelesseg/100) * ($magassag/100);

    }
}

?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="stilus.css">
    <style>
        body {text-align: center}
        caption {font-size: x-large; margin: 5px;}
        table {border-collapse: collapse; margin: auto; background-color: lightgoldenrodyellow; width: 60%;}
        td {border: 2px solid green; width: 50%;}
    </style>
</head>

<body>
    <h1>A választott keret mérete:
        <?php echo "$szelesseg cm x $magassag cm" ?>
    </h1>
    <table>
        <caption>Anyagszükséglet<caption>
            <tr>
                <td>Kerethez szükséges lécek:</td>
                <td>
                    <?php
                        echo "
                            2 db - $szelesseg cm hosszú
                            2 db - $magassag cm hosszú
                        "
                    ?>
                </td>
            </tr>
        <tr>
            <td>Lécek összhossza:</td>
            <td>
                <?php echo "$osszhossz cm." ?>
            </td>
        </tr>
        <tr>
            <td>Szükséges lécek száma:</td>
            <td>
                <?php  echo "$lecszam";  ?>
            </td>

        </tr>
        <tr>
            <td>Üveg:</td>
            <td>
                <?php echo "$uveg nm" ?>
            </td>
        </tr>
    </table>
</body>

</html>