<html>
    <body>
        <h3>Adicionar nova Correcao:</h3>
        <form action="update_add.php" method="post">
            <p>Email: <input type="text" name="email"/></p>
            <p>Numero: <input type="number" name="num"/></p>
            <p>Id da Anomalia: <input type="number" name="anomalia_id"/></p>
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
        
            $sql = "SELECT * FROM correcao;";
        
            $result = $db->prepare($sql);
            $result->execute();
            
            echo("<h3>Correcoes: </h3>");
            echo("<table border=\"0\" cellspacing=\"5\">\n");
            foreach($result as $row)
            {
                
                echo("<tr>\n");
                
                echo("<td>{$row['email']}</td>\n");
                echo("<td>{$row['nmr']}</td>\n");
                echo("<td>{$row['anomalia_id']}</td>\n");
                
                echo("<td><a href=\"update_remove.php?email={$row['email']}&nmr={$row['nmr']}&aid={$row['anomalia_id']}\">Remover</a></td>\n");
                
                echo("</tr>\n");
            }
            echo("</table>\n");

            echo("<h3>Propostas de Correcao: </h3>");
            $sql = "SELECT * FROM proposta_de_correcao;";
        
            $result = $db->prepare($sql);
            $result->execute();
            
            echo("<table border=\"0\" cellspacing=\"5\">\n");
            foreach($result as $row)
            {
                
                echo("<tr>\n");
                
                echo("<td>{$row['email']}</td>\n");
                echo("<td>{$row['nmr']}</td>\n");
                echo("<td>{$row['data_hora']}</td>\n");
                echo("<td>{$row['texto']}</td>\n");
                
                echo("</tr>\n");
            }
            echo("</table>\n");


            echo("<h3>Incidencias: </h3>");
            $sql = "SELECT * FROM incidencia;";
        
            $result = $db->prepare($sql);
            $result->execute();

            echo("<table border=\"0\" cellspacing=\"5\">\n");
            foreach($result as $row)
            {
                
                echo("<tr>\n");
                
                echo("<td>{$row['anomalia_id']}</td>\n");
                echo("<td>{$row['item_id']}</td>\n");
                echo("<td>{$row['email']}</td>\n");
                                
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
