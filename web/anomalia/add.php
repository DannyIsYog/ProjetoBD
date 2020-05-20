<html>
    <body>
        <h3>Adicionar nova Anomalia:</h3>
        <form action="update.php" method="post">
            <p>Id: <input type="number" name="id"/></p>
            
            <p>X Inicio da Zona: <input type="number" name="x1"/></p>
            <p>Y Inicio da Zona: <input type="number" name="y1"/></p>
            <p>X Fim da Zona: <input type="number" name="x2"/></p>
            <p>Y Fim da Zona: <input type="number" name="y2"/></p>

            <p>Imagem: <input type="text" name="im"/></p>
            <p>Lingua: <input type="text" name="lingua"/></p>
            <p>TimeStamp: <input type="date" name="ts"/></p>
            <p>Descricao: <input type="text" name="descricao"/></p>

            <p>E uma anomalia de redacao? <input type="checkbox" name="redacao"/></p>

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
        
            $db = null;
        }
        catch (PDOException $e)
        {
            echo("<p>ERROR: {$e->getMessage()}</p>");
        }
        ?>
    </body>
</html>
