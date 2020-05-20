<html>
    <body>
<?php
    $nome1 = $_REQUEST['nome1'];
    $nome2 = $_REQUEST['nome2'];

    try
    {
        $host = "db.ist.utl.pt";
        $user ="ist193608";
        $password = "candeeiros";
        $dbname = $user;
        $db = new PDO("pgsql:host=$host;dbname=$dbname", $user, $password);
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $sql = "SELECT * FROM local_publico WHERE nome = :nome1 OR nome = :nome2";

        $result = $db->prepare($sql);
        $result->execute([':nome1' => $nome1, ':nome2' => $nome2]);
        $f = $result->fetch(PDO::FETCH_ASSOC);
        
        $min_lat = $f['latitude'];
        $max_lat = $f['latitude'];
        $min_lon = $f['longitude'];
        $max_lon = $f['longitude'];


        $f = $result->fetch(PDO::FETCH_ASSOC);

        if ($min_lat > $f['latitude']) {
            $min_lat = $f['latitude'];
        } else {
            $max_lat = $f['latitude'];
        }

        if ($min_lon > $f['longitude']) {
            $min_lon = $f['longitude'];
        } else {
            $max_lon = $f['longitude'];
        }

        $sql = "SELECT anomalia.* FROM (item join incidencia on item.id = incidencia.item_id) join anomalia on anomalia.id = incidencia.anomalia_id where longitude between :min_lon and :max_lon and latitude between :min_lat and :max_lat";
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
