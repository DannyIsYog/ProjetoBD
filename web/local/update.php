<html>
    <body>
<?php
    $latitude = $_REQUEST['latitude'];
    $longitude = $_REQUEST['longitude'];
    $nome = $_REQUEST['nome'];
    try
    {
        $host = "db.ist.utl.pt";
        $user ="ist193608";
        $password = "candeeiros";
        $dbname = $user;
        $db = new PDO("pgsql:host=$host;dbname=$dbname", $user, $password);
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $sql = "INSERT INTO local_publico (latitude, longitude, nome) VALUES(:latitude, :longitude, :nome);";
        echo("<p>$sql</p>");

        $result = $db->prepare($sql);
        $result->execute([':latitude' => $latitude, ':longitude' => $longitude, ':nome' => $nome]);
        
        $db = null;
    }
    catch (PDOException $e)
    {
        echo("<p>ERROR: {$e->getMessage()}</p>");
    }
?>
    </body>
</html>
