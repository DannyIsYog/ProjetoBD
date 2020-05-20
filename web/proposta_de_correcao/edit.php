<html>
    <body>
        <h3>Editar Proposta de Correcao:</h3>
        <form action="update_edit.php" method="post">
            <?php
                $email = $_REQUEST['email'];
                $nmr = $_REQUEST['nmr'];
                
                echo(sprintf("
                <input type=\"hidden\" name=\"email\" value=%s />
                <input type=\"hidden\" name=\"num\" value=%s />
                ", $email, $nmr));
                
            ?>
            <p>TimeStamp: <input type="date" name="ts"/></p>
            <p>Texto: <input type="text" name="texto"/></p>
            <p><input type="submit" value="Submit"/></p>
        </form>
    </body>
</html>
