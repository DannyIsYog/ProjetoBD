<html>
    <body>
        <form action="show.php" method="post">
            <p>Nome1: <input type="text" name="nome1"/></p>
            <p>Nome2: <input type="text" name="nome2"/></p>
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
            
            echo("<h3>Locais Publicos:</h3>");
            echo("<table border=\"0\" cellspacing=\"5\">\n");
            foreach($result as $row)
            {
                echo("<tr>\n");
                
                echo("<td>{$row['nome']}</td>\n");
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
