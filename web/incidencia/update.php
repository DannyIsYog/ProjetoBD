<html>
    <body>
<?php
    $iid = $_REQUEST['iid'];
    $aid = $_REQUEST['aid'];
    $email = $_REQUEST['email'];

    try
    {
        $host = "db.ist.utl.pt";
        $user ="ist193608";
        $password = "candeeiros";
        $dbname = $user;
        $db = new PDO("pgsql:host=$host;dbname=$dbname", $user, $password);
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $sql = "INSERT INTO incidencia (anomalia_id, item_id, email) VALUES(:iid, :aid, :email);";
        echo("<p>$sql</p>");

        $result = $db->prepare($sql);
        $result->execute([':iid' => $iid, ':aid' => $aid, ':email' => $email]);
        
        $db = null;
    }
    catch (PDOException $e)
    {
        echo("<p>ERROR: {$e->getMessage()}</p>");
    }
?>
    </body>
</html>
