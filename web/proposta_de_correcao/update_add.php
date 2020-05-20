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

        $sql = "INSERT INTO proposta_de_correcao (email, nmr, data_hora, texto) VALUES(:email, :nmr, :data_hora, :texto);";
        echo("<p>$sql</p>");

        $result = $db->prepare($sql);
        $result->execute(['email' => $email, 'nmr' => $num, 'data_hora' => $ts, 'texto' => $texto]);
        
        $db = null;
    }
    catch (PDOException $e)
    {
        echo("<p>ERROR: {$e->getMessage()}</p>");
    }
?>
    </body>
</html>
