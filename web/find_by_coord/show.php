<html>
    <body>
<?php
    $x = $_REQUEST['x'];
    $y = $_REQUEST['y'];
    $dx = $_REQUEST['dx'];
    $dy = $_REQUEST['dy'];
    $max_lat = $x+$dx;
    $min_lat = $x-$dx;
    $max_lon = $y+$dy;
    $min_lon = $y-$dy;

    try
    {
        $host = "db.ist.utl.pt";
        $user ="ist193608";
        $password = "candeeiros";
        $dbname = $user;
        $db = new PDO("pgsql:host=$host;dbname=$dbname", $user, $password);
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $sql = "SELECT anomalia.* FROM (item join incidencia on item.id = incidencia.item_id) join anomalia on anomalia.id = incidencia.anomalia_id where longitude between :min_lon and :max_lon and latitude between :min_lat and :max_lat and anomalia.ts > CURRENT_DATE - INTERVAL '3 months'";
        $result = $db->prepare($sql);
        $result->execute([':min_lat' => $min_lat, ':max_lat' => $max_lat, ':min_lon' => $min_lon, ':max_lon' => $max_lon]);
        
        echo("<table border=\"0\" cellspacing=\"5\">\n");
        foreach($result as $row)
        {
            echo("<tr>\n");
            
            echo("<td>{$row['id']}</td>\n");
            echo("<td>({$row['x1']}, {$row['y1']}), ({$row['x2']}, {$row['y2']})</td>\n");
            echo("<td>{$row['imagem']}</td>\n");
            echo("<td>{$row['lingua']}</td>\n");
            echo("<td>{$row['ts']}</td>\n");
            echo("<td>{$row['descricao']}</td>\n");
            echo("<td>{$row['tem_anomalia_redacao']}</td>\n");
            
            echo("</tr>\n");
        }
        echo("</table>\n");

        
        $db = null;
    }
    catch (PDOException $e)
    {
        echo("<p>ERROR: {$e->getMessage()}</p>");
    }
?>
    </body>
</html>
