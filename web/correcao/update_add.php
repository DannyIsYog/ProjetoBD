<html>
    <body>
<?php

    $email = $_REQUEST['email'];
    $num = $_REQUEST['num'];
    $anomalia_id = $_REQUEST['anomalia_id'];
    
    try
    {
        
        $host = "db.ist.utl.pt";
        $user ="ist193608";
        $password = "candeeiros";
        $dbname = $user;
        $db = new PDO("pgsql:host=$host;dbname=$dbname", $user, $password);
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $sql = "INSERT INTO correcao (email, nmr, anomalia_id) VALUES(:email, :nmr, :anomalia_id);";
        echo("<p>$sql</p>");

        $result = $db->prepare($sql);
        $result->execute([':email' => $email, ':nmr' => $num, ':anomalia_id' => $anomalia_id]);
        
        $db = null;
    }
    catch (PDOException $e)
    {
        echo("<p>ERROR: {$e->getMessage()}</p>");
    }
?>
    </body>
</html>
