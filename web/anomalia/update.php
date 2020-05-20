<html>
    <body>
<?php    
    $id = $_REQUEST['id'];
    $x1 = $_REQUEST['x1'];
    $y1 = $_REQUEST['y1'];
    $x2 = $_REQUEST['x2'];
    $y2 = $_REQUEST['y2'];
    $imagem = $_REQUEST['im'];
    $lingua = $_REQUEST['lingua'];
    $ts = $_REQUEST['ts'];
    $descricao = $_REQUEST['descricao'];
    $redacao = $_REQUEST['redacao'];
    
    if ($redacao) {
        
        try
        {
            
            $host = "db.ist.utl.pt";
            $user ="ist193608";
            $password = "candeeiros";
            $dbname = $user;
            $db = new PDO("pgsql:host=$host;dbname=$dbname", $user, $password);
            $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $sql = "INSERT INTO anomalia (id, x1, y1, x2, y2, imagem, lingua, ts, descricao, tem_anomalia_redacao) VALUES(:id, :x1, :y1, :x2, :y2, :imagem, :lingua, :ts, :descricao, 'True');";
            echo("<p>$sql</p>");

            $result = $db->prepare($sql);
            $result->execute([':id' => $id, ':x1' => $x1, ':y1' => $y1, ':x2' => $x2, ':y2' => $y2, ':imagem' => $imagem, ':lingua' => $lingua, ':ts' => $ts, ':descricao' => $descricao]);
            
            $db = null;
            
        }
        catch (PDOException $e)
        {
            echo("<p>ERROR: {$e->getMessage()}</p>");
        }
        
    } else {
        echo(sprintf("
        <h3>Adicionar nova Anomalia de Traducao:</h3>
        <form action=\"update_trad.php\" method=\"post\">
            <input type=\"hidden\" name=\"id\" value=%s />
                
            <input type=\"hidden\" name=\"x1\" value=%s />
            <input type=\"hidden\" name=\"y1\" value=%s />
            <input type=\"hidden\" name=\"x2\" value=%s />
            <input type=\"hidden\" name=\"y2\" value=%s />

            <input type=\"hidden\" name=\"imagem\" value=%s />
            <input type=\"hidden\" name=\"lingua\" value=%s />
            <input type=\"hidden\" name=\"ts\" value=%s />
            <input type=\"hidden\" name=\"descricao\" value=%s />

            <p>X Inicio da Zona2: <input type=\"number\" name=\"x3\" /></p>
            <p>Y Inicio da Zona2: <input type=\"number\" name=\"y3\" /></p>
            <p>X Fim da Zona2: <input type=\"number\" name=\"x4\" /></p>
            <p>Y Fim da Zona2: <input type=\"number\" name=\"y4\" /></p>
            <p>Lingua2: <input type=\"text\" name=\"lingua2\" /></p>
            <p><input type=\"submit\" value=\"Submit\" /></p>
        </form>
        ", $id, $x1, $y1, $x2, $y2, $imagem, $lingua, $ts, $descricao));
    }
?>
    </body>
</html>
