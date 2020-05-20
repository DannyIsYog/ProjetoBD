<html>
    <body>
        <h3>Adicionar novo Item:</h3>
        <form action="update.php" method="post">
            <p>Id da Anomalia: <input type="number" name="iid"/></p>
            <p>Id do Item: <input type="number" name="aid"/></p>
            <p>Email: <input type="text" name="email"/></p>
            <p><input type="submit" value="Submit"/></p>
        </form>
        <?php
        try
        {
            $host = "db.ist.utl.pt";
            $user ="ist193608";
            $password = "candeeiros";
            $dbname = $user;
        
            $db = new PDO("pgsql:host=$host;dbname=$dbname", $user, $password);
            $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
            $sql = "SELECT * FROM anomalia;";
        
            $result = $db->prepare($sql);
            $result->execute();
            
            echo("<h3>Anomalias: </h3>");
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

            $sql = "SELECT * FROM item;";
        
            $result = $db->prepare($sql);
            $result->execute();

            echo("<h3>Items: </h3>");
            echo("<table border=\"0\" cellspacing=\"5\">\n");
            foreach($result as $row)
            {
                echo("<tr>\n");
                
                echo("<td>{$row['id']}</td>\n");
                echo("<td>{$row['descricao']}</td>\n");
                echo("<td>{$row['localizacao']}</td>\n");
                echo("<td>{$row['latitude']}</td>\n");
                echo("<td>{$row['longitude']}</td>\n");
                
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
