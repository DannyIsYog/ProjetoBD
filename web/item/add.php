<html>
    <body>
        <h3>Adicionar novo Item:</h3>
        <form action="update.php" method="post">
            <p>Id: <input type="number" name="id"/></p>
            <p>Descricao: <input type="text" name="desc"/></p>
            <p>Localizacao: <input type="text" name="loc"/></p>
            <p>Latitude: <input type="number" step="0.000001" name="latitude"/></p>
            <p>Longitude: <input type="number" step="0.000001" name="longitude"/></p>
            <p><input type="submit" value="Submit"/></p>
        </form>

        <?php
            $host = "db.ist.utl.pt";
            $user ="ist193608";
            $password = "candeeiros";
            $dbname = $user;
        
            $db = new PDO("pgsql:host=$host;dbname=$dbname", $user, $password);
            $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
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
        ?>
    </body>
</html>
