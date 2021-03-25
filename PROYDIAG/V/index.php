<?php
  require('./../C/conexion.php');
?>
<!DOCTYPE html>
<html>
  <head>
	<title>Página Diagnóstico</title>
	<meta charset="utf-8" />
  </head>
  <body>
    <h2>Datos de la tabla ÍTEM:</h2>
	<table border='1'>
      <tr>
    	<td>ID Ítem</td>
    	<td>Título Ítem</td>
    	<td>Categoría</td>
    	<td>Precio</td>
    	<td>Símbolo</td>
    	<td>Moneda</td>
    	<td>País</td>
    	<td>Creado el...</td>
		<td>Modificado el...</td>
		<td>Acciones</td>
      </tr>
	  <?php
	    $sql="select i.id_item,i.title_item,ca.ca_name,i.price,i.symbol,cu.shortname,co.coshortname,i.created_at,i.modified_at from item i inner join category ca
		on i.category_id=ca.category_id inner join currency cu on i.currency_id=cu.currency_id inner join country co on i.country_id=co.country_id;";
        $listar=$conexion->query($sql);
        foreach($listar as $item){
	  ?>
	  <tr>
	    <td><?php echo $item['id_item'] ?></td>
		<td><?php echo $item['title_item'] ?></td>
		<td><?php echo $item['ca_name'] ?></td>
		<td><?php echo $item['price'] ?></td>
		<td><?php echo $item['symbol'] ?></td>
		<td><?php echo $item['shortname'] ?></td>
		<td><?php echo $item['coshortname'] ?></td>
		<td><?php echo $item['created_at'] ?></td>
		<td><?php echo $item['modified_at'] ?></td>
		<td>
		  <!--<a href="./../V/actualizarUsuario.php?id_actualizar=<?php echo $item['id_item']; ?>">Actualizar</a><br>-->
		  <a href="./../M/mantenedor.php?id_actualizar=<?php echo $item['id_item']; ?>">Actualizar</a><br>
		  <a href="./../M/mantenedor.php?id_eliminar=<?php echo $item['id_item']; ?>">Eliminar</a><br>
		</td>
	  </tr>
	  <?php } ?>
	</table>
	<br>
	<form action="./../M/mantenedor.php" method="post" name="form1" id="form1">
	  <div>
		<label class="label" for="buscarporid"> Buscar por Id: </label>
		<input type="text" name="iditem" id="iditem" placeholder="Ingrese ID para buscar...."/>
        <input type="submit" name="btnObtenerDatos" id="btnObtenerDatos" value="Buscar" /><br>
		<label class="label" for="crearitem"> Crear un nuevo ítem: </label>
		<input type="submit" name="BtnCrear" id="BtnCrear" value="Crear" />
      </div>
	</form>
	<h3><?php if(isset($_GET['mensaje'])){echo $_GET['mensaje'];} ?></h3>
  </body>
</html>