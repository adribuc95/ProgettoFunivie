<!--
////////////////////////////////
AUTHOR: @ADRIANO BUCELLA
adribuc95@gmail.com
///////////////////////////////
-->
<!--FILE CHE VA A SALVARE I DATI NEL DB E REINDERIZZA ALL'INDEX-->
<?php
//INIZIALIZZAZIONE E GESTIONE DELLE VARIABILI E DEI DATI NECESSARI
session_start();

include "../Classi/Cliente.php";
include "../Classi/Foto.php";
include "../Classi/Ordine.php";
$cliente = new Cliente();
$foto = new Foto();
$ordine = new Ordine();

if ((!isset($_SESSION["prima_volta"]))) {
            $_SESSION["prima_volta"] = false;
            $new_ID_cliente_riferimento = $cliente->getNewIDCliente_Riferimento();
            $new_ID_ordine = $ordine->getNewIDOrdine();
            $cliente->setIDCliente_Riferimento($new_ID_cliente_riferimento);
            $ordine->setIDOrdine($new_ID_ordine);
            $_SESSION["ID_ordine"] = $new_ID_ordine;
            $_SESSION["numero_riferimento"] = 0;
        }
        else {
            $cliente->setIDCliente_Riferimento($_SESSION["ID_ordine"]);
            $ordine->setIDOrdine($_SESSION["ID_ordine"]);
            $_SESSION["numero_riferimento"]++;
        }
//imposto l' ID_session --> viene rigenerato al caricamento dell'immagine
$ID_session = session_id();

//creo un nuovo ID_cliente
$new_ID_cliente = $cliente->getNewIDCliente();

//assegno i nuovi ID a Cliente
$cliente->setIDCliente($new_ID_cliente);

//salvo i dati Cliente nel DB e mantengo i dati per l'aggiunta di tessere.
$cliente->salvaDati();
$cliente->mantieniDatiForm();

//assegno gli ID a Ordine e foto
$ordine->setIDCliente($new_ID_cliente);
$ordine->salvaDati();
$foto->setIDCliente($new_ID_cliente);

//gestione del fatto se è stata caricata immagine o no, per ora non utilizzata (va sempre in else)
if (implode($foto->getLastIDFoto()) == $ID_session) {
    $foto->salvaNoFoto();
    echo "no foto";
    echo implode($foto->getLastIDFoto());
}

else {
    $foto->setIDFoto($ID_session);
    $foto->salvaDati();
    echo "foto";
}

header("location: ../index.php");
exit();