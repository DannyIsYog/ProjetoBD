<html>
    <body>
        <h3>Adicionar novo Local:</h3>
        <form action="update.php" method="post">
            <p>Latitude: <input type="number" step="0.000001" name="latitude"/></p>
            <p>Longitude: <input type="number" step="0.000001" name="longitude"/></p>
            <p>Nome: <input type="text" name="nome"/></p>
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
        
            $sql = "SELECT * FROM local_publico;";
        
            $result = $db->prepare($sql);
            $result->execute();
            
            echo("<h3>Locais Publicos: </h3>");
            echo("<table border=\"0\" cellspacing=\"5\">\n");
            foreach($result as $row)
            {
                
                echo("<tr>\n");
                
                echo("<td>{$row['latitude']}</td>\n");
                echo("<td>{$row['longitude']}</td>\n");
                echo("<td>{$row['nome']}</td>\n");
                
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
