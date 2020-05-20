<html>
    <body>
        <?php
        try
        {
            $host = "db.ist.utl.pt";
            $user ="ist193608";
            $password = "candeeiros";
            $dbname = $user;
        
            $db = new PDO("pgsql:host=$host;dbname=$dbname", $user, $password);
            $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
            $sql = "SELECT * FROM utilizador;";
        
            $result = $db->prepare($sql);
            $result->execute();
            
            echo("<table border=\"0\" cellspacing=\"5\">\n");
            foreach($result as $row)
            {
                
                echo("<tr>\n");
                
                echo("<td>{$row['email']}</td>\n");
                $count = $db->prepare("SELECT count(*) AS num FROM utilizador_qualificado WHERE email = :email;");
                $count->execute([":email" => $row['email']]);
                $r = $count->fetch(PDO::FETCH_ASSOC);
                if ($r['num'] > 0) {
                    echo("<td>Utilizador Qualificado</td>");
                } else {
                    echo("<td>Utilizador Regular</td>");
                }
                
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
