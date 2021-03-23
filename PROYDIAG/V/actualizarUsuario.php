<?php
  require('./../C/conexion.php');
?>
<html>
  <head>
  	<title>Actualizar Ítem</title>
    <meta charset="UTF-8"/>
  </head>
  <body>
    <h2>Actualización de datos de Ítem</h2>
	<form method="POST" name="formulario" id="formulario" action="./../M/mantenedor.php">
	<?php
	  if(isset($_GET['id_actualizar'])){
		$sql="select i.id_item,i.title_item,ca.ca_name,i.price,i.symbol,cu.shortname,co.coshortname,i.created_at,i.modified_at from item i inner join category ca
		on i.category_id=ca.category_id inner join currency cu on i.currency_id=cu.currency_id inner join country co on i.country_id=co.country_id";
		$listar=$conexion->query($sql);
		foreach($listar as $item){
	      if($item['id_item']==$_GET['id_actualizar']){
	?>
	  <div>
	    <label class="label" for="id_item">ID Ítem:</label>
	    <input type="text" name="id_item" id="id_item" value="<?php echo $item['id_item']; ?>" readonly/>
	  </div>
	  <div>
	    <label class="label" for="title_item">Título Ítem:</label>
	    <input type="text" name="title_item" id="title_item" value="<?php echo $item['title_item']; ?>"/>
	  </div>
	  <div>
	    <label class="label" for="ca_name">Categoría Ítem:</label>
	    <select name="ca_name" id="ca_name">
		  <option selected readonly value="0">Seleccione categoría...</option>
		  <?php
		  $sql="select * from category";
			$listar=$conexion->query($sql);
			foreach($listar as $category){
		  ?>
		  <option value="<?php echo $category['category_id']; ?>"><?php echo $category['ca_name']; ?></option>
		  <?php } ?>
		</select>
	  </div>
	  <div>
	    <label class="label" for="price">Precio Ítem:</label>
	    <input type="text" name="price" id="price" value="<?php echo $item['price']; ?>"/>
	  </div>
	  <div>
	    <label class="label" for="symbol">Símbolo Ítem:</label>
	    <input type="text" name="symbol" id="symbol" value="<?php echo $item['symbol']; ?>"/>
	  </div>
	  <div>
	    <label class="label" for="currency">Divisa Ítem:</label>
	    <select name="currency" id="currency">
		  <option selected readonly value="0">Seleccione divisa...</option>
		  <?php
		  $sql="select * from currency";
			$listar=$conexion->query($sql);
			foreach($listar as $currency){
		  ?>
		  <option value="<?php echo $currency['currency_id']; ?>"><?php echo $currency['shortname']; ?></option>
		  <?php } ?>
		</select>
	  </div>
	  <div>
	    <label class="label" for="country">País Ítem:</label>
	    <select name="country" id="country">
		  <option selected readonly value="0">Seleccione país...</option>
		  <?php
		  $sql="select * from country";
			$listar=$conexion->query($sql);
			foreach($listar as $country){
		  ?>
		  <option value="<?php echo $country['country_id']; ?>"><?php echo $country['coshortname']; ?></option>
		  <?php } ?>
		</select>
	  </div>
	  <div>
	    <label class="label" for="created_at">Fecha creación:</label>
	    <input type="text" name="created_at" id="created_at" value="<?php echo $item['created_at']; ?>"/>
	  </div>
	  <div>
	    <label class="label" for="modified_at">Fecha modificación:</label>
	    <input type="text" name="modified_at" id="modified_at" value="<?php echo $item['modified_at']; ?>"/>
	  </div>
	<?php }}} ?>
	<div>
	  <input type="submit" name="btnActualizar" id="btnActualizar" value="Actualizar"/>
	  <input type="reset" name="btnCancelar" id="btnCancelar" value="Cancelar"/>
	</div>
	</form>
  </body>
</html>