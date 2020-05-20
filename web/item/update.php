<html>
    <body>
<?php
    $id = $_REQUEST['id'];
    $desc = $_REQUEST['desc'];
    $loc = $_REQUEST['loc'];
    $latitude = $_REQUEST['latitude'];
    $longitude = $_REQUEST['longitude'];
    try
    {
        $host = "db.ist.utl.pt";
        $user ="ist193608";
        $password = "candeeiros";
        $dbname = $user;
        $db = new PDO("pgsql:host=$host;dbname=$dbname", $user, $password);
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $sql = "INSERT INTO item (id, descricao, localizacao, latitude, longitude) VALUES(:id, :desc, :loc, :latitude, :longitude);";
        echo("<p>$sql</p>");

        $result = $db->prepare($sql);
        $result->execute([':id' => $id, ':desc' => $desc, ':loc' => $loc, ':latitude' => $latitude, ':longitude' => $longitude]);
        
        $db = null;
    }
    catch (PDOException $e)
    {
        echo("<p>ERROR: {$e->getMessage()}</p>");
    }
?>
    </body>
</html>
