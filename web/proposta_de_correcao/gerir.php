<html>
    <body>
        <h3>Adicionar nova Proposta de Correcao:</h3>
        <form action="update_add.php" method="post">
            <p>Email: <input type="text" name="email"/></p>
            <p>Numero: <input type="number" name="num"/></p>
            <p>TimeStamp: <input type="date" name="ts"/></p>
            <p>Texto: <input type="text" name="texto"/></p>
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
        
            $sql = "SELECT * FROM proposta_de_correcao;";
        
            $result = $db->prepare($sql);
            $result->execute();
            
            echo('<h3>Propostas de Correcao: </h3>');
            echo("<table border=\"0\" cellspacing=\"5\">\n");
            foreach($result as $row)
            {
                
                echo("<tr>\n");
                
                echo("<td>{$row['email']}</td>\n");
                
                echo("<td>{$row['nmr']}</td>\n");
                echo("<td>{$row['data_hora']}</td>\n");
                
                echo("<td>{$row['texto']}</td>\n");
                
                echo("<td><a href=\"edit.php?email={$row['email']}&nmr={$row['nmr']}\">Editar</a></td>\n");
                echo("<td><a href=\"update_remove.php?email={$row['email']}&nmr={$row['nmr']}\">Remover</a></td>\n");
                
                echo("</tr>\n");
            }
            echo("</table>\n");

            $sql = "SELECT * FROM utilizador_qualificado;";
        
            $result = $db->prepare($sql);
            $result->execute();
            
            echo('<h3>Utilizadores Qualificados: </h3>');
            echo("<table border=\"0\" cellspacing=\"5\">\n");
            foreach($result as $row)
            {
                echo("<tr>\n");
                
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
