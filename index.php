<?php
$conexion=mysqli_connect('localhost','root','2801','cochinitoapp');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Consultas</title>
    <link rel="stylesheet" href="./style.css">
</head>
<body>
    <div class="contenedor">
        <div class="consulta-1">
            <h2>Primer consulta</h2>
            <table>
                <tr>
                    <td>Nombre del grupo</td>
                    <td>Monto</td>
                </tr>
                <?php
                $sql="SELECT grupos.group_name, SUM(amount_user_group.amount_deposited) as total
                from amount_user_group
                join grupos on amount_user_group.group_id = grupos.id
                group by grupos.group_name";
                $result=mysqli_query($conexion,$sql);

                while($mostrar=mysqli_fetch_array($result)){
                ?>
                
                <tr>
                    <td><?php echo $mostrar['group_name']?></td>
                    <td><?php echo $mostrar['total']?></td>
                </tr>
                <?php
                }
                ?>                
            </table>
        </div>
        <div class="consulta-2">
            <h2>Segunda Consulta General</h2>        
            <table>
                <tr>
                    <td>Nombre del grupo</td>
                    <td>Cantidad de prestamos</td>
                    <td>Monto</td>
                </tr>
                <?php
                $sql="SELECT grupos.group_name, COUNT(transaction.transaction_name) as prestamos, SUM(operation.value) as monto
                from grupos
                join operation ON grupos.id = operation.group_id
                join transaction ON transaction.id = operation.transaction_id AND transaction.transaction_name = 'loan'
                group by grupos.group_name";
                $result=mysqli_query($conexion,$sql);

                while($mostrar=mysqli_fetch_array($result)){
                ?>
                
                <tr>
                    <td><?php echo $mostrar['group_name']?></td>
                    <td><?php echo $mostrar['prestamos']?></td>
                    <td><?php echo $mostrar['monto']?></td>
                </tr>
                <?php
                }
                ?>
                    
            </table>
        </div>
        <div class="consulta-21">
            <h2>Segunda Consulta individual</h2>        
            <table>
                <tr>
                    <td>Nombre de Usuario</td>
                    <td>Fecha de la Transaccion</td>
                    <td>Valor de la Transaccion</td>
                    <td>Nombre del grupo</td>
                    <td>Frecuencia de Pago</td>
                    <td>Cuotas</td>
                    <td>Tipo de Transaccion</td>
                </tr>
                <?php
                $sql="SELECT u.user_name, o.transaction_date, o.value, g.group_name, o.payment_frequency, o.consecutive, t.transaction_name
                from user u
                join operation o ON u.id = o.user_id
                join grupos g ON o.group_id = g.id
                join transaction t ON o.transaction_id = t.id
                where t.transaction_name = 'loan'";
                $result=mysqli_query($conexion,$sql);

                while($mostrar=mysqli_fetch_array($result)){
                ?>
                
                <tr>
                    <td><?php echo $mostrar['user_name']?></td>
                    <td><?php echo $mostrar['transaction_date']?></td>
                    <td><?php echo $mostrar['value']?></td>
                    <td><?php echo $mostrar['group_name']?></td>
                    <td><?php echo $mostrar['payment_frequency']?></td>
                    <td><?php echo $mostrar['consecutive']?></td>
                    <td><?php echo $mostrar['transaction_name']?></td>
                </tr>
                <?php
                }
                ?>
                    
            </table>
        </div>    
    </div>        
</body>
</html>