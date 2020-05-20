<html>
    <body>
<?php
    $email = $_REQUEST['email'];
    $num = $_REQUEST['num'];
    $ts = $_REQUEST['ts'];
    $texto = $_REQUEST['texto'];
    try
    {
        $host = "db.ist.utl.pt";
        $user ="ist193608";
        $password = "candeeiros";
        $dbname = $user;
        $db = new PDO("pgsql:host=$host;dbname=$dbname", $user, $password);
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $sql = "UPDATE proposta_de_correcao SET texto=:texto, data_hora=:ts WHERE email=:email and nmr=:nmr;";
        echo($texto);
        echo($ts);
        echo($num);
        echo($email);
        echo("<p>$sql</p>");

        $result = $db->prepare($sql);
        $result->execute(['texto' => $texto, 'ts' => $ts, 'email' => $email, 'nmr' => $num]);
        
        $db = null;
    }
    catch (PDOException $e)
    {
        echo("<p>ERROR: {$e->getMessage()}</p>");
    }
?>
    </body>
</html>
