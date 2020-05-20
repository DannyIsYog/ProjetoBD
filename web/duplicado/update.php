<html>
    <body>
<?php
    $id1 = $_REQUEST['id1'];
    $id2 = $_REQUEST['id2'];

    try
    {
        $host = "db.ist.utl.pt";
        $user ="ist193608";
        $password = "candeeiros";
        $dbname = $user;
        $db = new PDO("pgsql:host=$host;dbname=$dbname", $user, $password);
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $sql = "INSERT INTO duplicado (id1, id2) VALUES(:id1, :id2);";
        echo("<p>$sql</p>");

        $result = $db->prepare($sql);
        $result->execute([':id1' => $id1, ':id2' => $id2]);
        
        $db = null;
    }
    catch (PDOException $e)
    {
        echo("<p>ERROR: {$e->getMessage()}</p>");
    }
?>
    </body>
</html>
