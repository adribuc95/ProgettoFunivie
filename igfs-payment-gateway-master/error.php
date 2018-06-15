<?php
include_once(dirname(__FILE__) ."/igfs.php");
echo "<html>
    <head>
        <title>TODO supply a title</title>
        <meta charset='UTF-8'>
        <meta name='viewport' content='width=device-width, initial-scale=1.0'>
        <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css'>
        <link href='https://fonts.googleapis.com/css?family=Montserrat' rel='stylesheet'> 
        <link href='../Pagina_iniziale/CSS/CSS.css' rel='stylesheet' type='text/css'>
    </head>
    <body>
    <center>
        <i class='fa fa-times' style='font-size:90px; color: red; margin-top: 20px;'></i> <br>
        <h1 style='color: red; font-size: 50px;'>Qualcosa è andato storto!</h1>
        <p style='font-size: 25px;'> Ti consigliamo di riprovare! Verrai reindirizzato al riepilogo ordine...</p>
    </center>
    </body>
</html>";

$igfs = new Igfs();
if($igfs->ID_ordine != '') {
$ID_ordine=$igfs->ID_ordine;

//aggiorno esito in DB

                        $servername = "localhost";
                        $username = "onlinesales";
                        $password = "Sale0nl1nE";
                        $dbname = "fmc-db-onlinesales";

                        // Create connection
                        $conn = new mysqli($servername, $username, $password, $dbname);
                        // Check connection
                        if ($conn->connect_error) {
                            die("Connection failed: " . $conn->connect_error);
                        } 

                        $sql = " UPDATE `Pagamento` SET `esito`='ERRORE' WHERE `ID_ordine`= '$ID_ordine";


                        if (($conn->query($sql) === TRUE)) {
                            echo "update Pagamento successfully";
                        } else {
                            echo "Error: " . $sql . "<br>" . $conn->error;
                        }

                        $conn->close();
}


header("refresh:3; url= https://www.funiviemadonnacampiglio.it/onlinesale/Pagina_riepilogo/riepilogo_ordine.php");


//mail('richard@123789.org','error',print_r($_REQUEST,true));


