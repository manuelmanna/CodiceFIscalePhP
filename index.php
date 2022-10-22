<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Controllo Codice Fiscale</title>
</head>
<body>
    <h1>Controllo Codice Fiscale</h1>
    <form action="index.php" method="post">
        <div>
            <label for="">Nome</label>
            <input type="text" name="nome" required>
        </div>
        <div>
            <label for="">Cognome</label>
            <input type="text" name="cognome" required>
        </div>
        <div>
            <label for="">Sesso</label>
            <select name="sesso" required>
                <option value="M">M</option>
                <option value="F">F</option>
            </select>
        </div>
        <div>
            <label for="">Luogo</label>
            <input type="text" name="luogo">
        </div>
        <div>
            <label for="">Provincia (sigla)</label>
            <input type="text" name="sigla"  minlength="2" maxlength="2" size="2" required>
        </div>
        <div>
            <label for="">Data di nascita</label>
            <input type="date" name="datanascita" required>
        </div>
        <div>
            <label for="">Codice fiscale</label>
            <input type="text" name="codicefiscale" minlength="16" maxlength="16" size="16" required>
        </div>
        <div>
            <button type="submit">Invia</button>
        </div>
    </form>
    <?php 
    if(isset($_POST['nome']) && isset($_POST['cognome']) && isset($_POST['sesso']) && isset($_POST['luogo']) && isset($_POST['sigla']) && isset($_POST['datanascita']) && isset($_POST['codicefiscale'])){
    $nome = strtoupper($_POST['nome']);
    $cognome = strtoupper($_POST['cognome']);
    $sesso = strtoupper($_POST['sesso']);
    $luogo = strtoupper($_POST['luogo']);
    $sigla = strtoupper($_POST['sigla']);
    $datanascita = $_POST['datanascita'];
    $codicefiscale = strtoupper($_POST['codicefiscale']);
    $newcf = "";
    $cflength = strlen($codicefiscale);
    $lettere = ['A', 'B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z','0','1','2','3','4','5','6','7','8','9'];
    $parival = [1,0,5,7,9,13,15,17,19,21,2,4,18,20,11,3,6,8,12,14,16,10,22,25,24,23,1,0,5,7,9,13,15,17,19,21];
    $disparival = [0,1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23,24,25,0,1,2,3,4,5,6,7,8,9];
    $somma = 0;
    $numvocali = 0;
    $cognomecons = "";
    $cognomevoc = "";
    $nomecons = "";
    $nomevoc = "";
    $mesenascita = "";
    $csvfile = './static/csv/Elenco-comuni-italiani.csv';

    for ($i = 0; $i < strlen($cognome); $i++) {
        if ($cognome[$i] == 'A' || $cognome[$i] == 'E' || $cognome[$i] == 'I' || $cognome[$i] == 'O' || $cognome[$i] == 'U') {   
            $cognomevoc .= $cognome[$i];
            
        }else{
            $cognomecons .= $cognome[$i];
        }
    }
    for ($i = 0; $i < strlen($nome); $i++) {
        if ($nome[$i] == 'A' || $nome[$i] == 'E' || $nome[$i] == 'I' || $nome[$i] == 'O' || $nome[$i] == 'U') {   
            $nomevoc .= $nome[$i];
            
        }else{
            $nomecons .= $nome[$i];
        }
    }

   
    if(strlen($cognome) > 3){
        if(strlen($cognomecons) == 3){
            $newcf .= $cognomecons; 
        }else if(strlen($cognomecons) == 2){
            $newcf .= $cognomecons[0] . $cognomecons[1] . $cognomevoc[0];
        }else if(strlen($cognomecons) == 1){
            $newcf .= $cognomecons[0] . $cognomevoc[0] . $cognomevoc[1];
        }else if(strlen($cognomecons) == 0){
            $newcf .= $cognomevoc[0] . $cognomevoc[1] . $cognomevoc[2];
        }
    }else{
        if(strlen($cognome) == 1){
            $newcf .= $cognome . "X" . "X";
        }else if(strlen($cognome) == 2){
            $newcf .= $cognome[0] . $cognome[1] . "X";
        }else if(strlen($cognome) == 3){
            $newcf .= $cognome;
        }
    }

    if(strlen($nome) > 3){
        if(strlen($nomecons) == 3){
            $newcf .= $nomecons; 
        }else if(strlen($nomecons) > 4){
            $newcf .= $nomecons[0] . $nomecons[1] . $nomecons[3]; 
        }else if(strlen($nomecons) == 2){
            $newcf .= $nomecons[0] . $nomecons[1] . $nomevoc[0];
        }else if(strlen($nomecons) == 1){
            $newcf .= $nomecons[0] . $nomevoc[0] . $nomevoc[1];
        }else if(strlen($nomecons) == 0){
            $newcf .= $nomevoc[0] . $nomevoc[1] . $nomevoc[2];
        }
    }else{
        if(strlen($nome) == 1){
            $newcf .= $nome . "X" . "X";
        }else if(strlen($nome) == 2){
            $newcf .= $nome[0] . $nome[1] . "X";
        }else if(strlen($nome) == 3){
            $newcf .= $nome;
        }
    }

    $newcf .= $datanascita[2] . $datanascita[3];

    $mesenascita .= $datanascita[5] . $datanascita[6];

    switch($mesenascita){
        case 1:
            $newcf .= 'A';
            break;
        case 2:
            $newcf .= 'B';
            break; 
        case 3:
            $newcf .= 'C';
            break;
        case 4:
            $newcf .= 'D';
            break;
        case 5:
            $newcf .= 'E';
            break; 
        case 6:
            $newcf .= 'H';
            break;        
        case 7:
            $newcf .= 'L';
            break;
        case 8:
            $newcf .= 'M';
            break;
        case 9:
            $newcf .= 'P';
            break;
        case 10:
            $newcf .= 'R';
            break; 
        case 11:
            $newcf .= 'S';
            break;
        case 12:
            $newcf .= 'T';
            break;         
    }
    
    if($sesso == "F"){
        $dataprovv =  intval($datanascita[strlen($datanascita) -2] . $datanascita[strlen($datanascita) -1]) + 40;
        $newcf .=  $dataprovv;
    }else{
        $newcf .=   $datanascita[strlen($datanascita) -2] . $datanascita[strlen($datanascita) -1];
    }
    
    if(!is_readable($csvfile)){
        echo "File non leggibile o insistente";
    }else{
        $righe = file($csvfile);
        foreach ( $righe as $row ) {
            
        $columns = explode( ';', $row );

            
        if(strtoupper($columns[0]) == $luogo && strtoupper($columns[1]) == $sigla){
            $newcf .= $columns[2];
        }           
        }    
    }
    
    $pos = 0;

    for ($i = 0; $i < strlen($newcf); $i++) {
        if ($i % 2 == 0) {
            $pos = array_search($newcf[$i], $lettere);
            $somma += $parival[$pos];
        } else {
            $pos = array_search($newcf[$i], $lettere);
            $somma += $disparival[$pos];
        }
        
    }
    $resto = $somma % 26;


    $newcf .= $lettere[$resto];

    if($newcf == $codicefiscale){
        echo "Codice Fiscale Valido";
    }else{
        echo "Codice Fiscale Non Valido";
    }
    }


?>
</body>
</html>