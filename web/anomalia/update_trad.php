<html>
    <body>
<?php    
    $id = $_REQUEST['id'];
    $x1 = $_REQUEST['x1'];
    $y1 = $_REQUEST['y1'];
    $x2 = $_REQUEST['x2'];
    $y2 = $_REQUEST['y2'];
    $imagem = $_REQUEST['imagem'];
    $lingua = $_REQUEST['lingua'];
    $ts = $_REQUEST['ts'];
    $descricao = $_REQUEST['descricao'];
    
    $x3 = $_REQUEST['x3'];
    $y3 = $_REQUEST['y3'];
    $x4 = $_REQUEST['x4'];
    $y4 = $_REQUEST['y4'];
    $lingua2 = $_REQUEST['lingua2'];
    
    try
    {
        
        $host = "db.ist.utl.pt";
        $user ="ist193608";
        $password = "candeeiros";
        $dbname = $user;
        $db = new PDO("pgsql:host=$host;dbname=$dbname", $user, $password);
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $sql = "INSERT INTO anomalia (id, x1, y1, x2, y2, imagem, lingua, ts, descricao, tem_anomalia_redacao) VALUES(:id, :x1, :y1, :x2, :y2, :imagem, :lingua, :ts, :descricao, 'False');";
        echo("<p>$sql</p>");

        $result = $db->prepare($sql);
        $result->execute([':id' => $id, ':x1' => $x1, ':y1' => $y1, ':x2' => $x2, ':y2' => $y2, ':imagem' => $imagem, ':lingua' => $lingua, ':ts' => $ts, ':descricao' => $descricao]);
        
        $sql = "INSERT INTO anomalia_traducao (id, x3, y3, x4, y4, lingua2) VALUES(:id, :x3, :y3, :x4, :y4, :lingua2);";
        echo("<p>$sql</p>");

        $result = $db->prepare($sql);
        $result->execute([':id' => $id, ':x3' => $x3, ':y3' => $y3, ':x4' => $x4, ':y4' => $y4,':lingua2' => $lingua2]);

        $db = null;
        
    }
    catch (PDOException $e)
    {
        echo("<p>ERROR: {$e->getMessage()}</p>");
    }
?>
    </body>
</html>
