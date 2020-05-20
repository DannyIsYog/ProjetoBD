<html>
    <body>
<?php
    $email = $_REQUEST['email'];
    $nmr = $_REQUEST['nmr'];
    $aid = $_REQUEST['aid'];
    try
    {
        $host = "db.ist.utl.pt";
        $user ="ist193608";
        $password = "candeeiros";
        $dbname = $user;
        $db = new PDO("pgsql:host=$host;dbname=$dbname", $user, $password);
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $sql = "DELETE FROM correcao WHERE email = :email AND nmr = :nmr AND anomalia_id = :aid";
        echo("<p>$sql</p>");

        $result = $db->prepare($sql);
        $result->execute([':email' => $email, ':nmr' => $nmr, ':aid' => $aid]);
        
        $db = null;
    }
    catch (PDOException $e)
    {
        echo("<p>ERROR: {$e->getMessage()}</p>");
    }
?>
    </body>
</html>