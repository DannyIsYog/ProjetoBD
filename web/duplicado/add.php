<html>
    <body>
        <h3>Adicionar novo Item:</h3>
        <form action="update.php" method="post">
            <p>Id1: <input type="number" name="id1"/></p>
            <p>Id2: <input type="number" name="id2"/></p>
            <p><input type="submit" value="Submit"/></p>
        </form>

        <h3>Items: </h3>
        <?php
        try
        {
            $host = "db.ist.utl.pt";
            $user ="ist193608";
            $password = "candeeiros";
            $dbname = $user;
        
            $db = new PDO("pgsql:host=$host;dbname=$dbname", $user, $password);
            $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
            $sql = "SELECT * FROM item;";
        
            $result = $db->prepare($sql);
            $result->execute();
            
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
