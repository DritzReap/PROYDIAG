<?php
  require('./../C/conexion.php');
  
  /*En este bloque 'if' se procede a eliminar un registro de la tabla 'item' a través de ID obtenido por URL desde la página
    index.php, se declara la sentencia $sql, se prepara y se ejecuta pasando como parámetro un arreglo creado que contiene el
    ID del ítem que se eliminará. Se crea el JSON con el mensaje que se enviará en caso de que el proceso sea exitoso. Finalmente,
    se le consulta por el valor de la variable $eliminar para comprobar el resultado de la operación. Si es positivo, enviará
    el JSON que mencionamos.*/
  if(isset($_GET['id_eliminar'])){
	$sql="DELETE FROM item WHERE id_item=?";
	$eliminar=$conexion->prepare($sql);
	$eliminar->execute(array($_GET['id_eliminar']));
	$jsonmsje='{
	  "msjejson":"Se ha eliminado el item con exito.";
	}';
	$jsonmsje=json_encode($jsonmsje);
	if($eliminar){
      header('location:./../V/index.php?mensaje='.$jsonmsje);
	}else{
	  header('location:./../V/index.php?mensaje=No se ha podido eliminar el ítem, vuelva a intentarlo.');
	}
  }
  
  /*En este bloque de condición se actualiza un registro de la tabla item con los datos que se señalan en la guía. Se obtiene el ID
    del registro que se actualizará desde la página index.php y se crea un arreglo con la información entregada. Se obtiene la fecha en
	formato timestamp para agregarla al atributo 'modified_at' y se le da codificación JSON al arreglo para hacer la actualización. Se procede a
	declarar, preparar y ejecutar la sentencia $sql y se pregunta por el valor del resultado final. Se decide qué acción tomará según dicho resultado.*/
  if(isset($_GET['id_actualizar'])){
	$cadena=array(
      "title"=>"Nuevo título",
	  "price"=>12345,
	  "currency"=>1,
	  "country"=>1
	);
	$fecha=date('Y-m-d H:i:s');
	$cadena=json_encode($cadena);
	$decoded=json_decode($cadena);
	$sql3="update item set title_item=?,price=?,currency_id=?,country_id=?,modified_at=? where id_item=?";
	$actualizar=$conexion->prepare($sql3);
	$actualizar->execute(array($decoded->{'title'},$decoded->{'price'},$decoded->{'currency'},$decoded->{'country'},$fecha,$_GET['id_actualizar']));
	if($actualizar){
      header('location:./../V/index.php?mensaje=ÉXITO: Se ha actualizado el ítem.');
    }else{
      header('location:./../V/index.php?mensaje=ERROR: No se ha actualizado el ítem.');
    }
	/*print("<script>alert('Hola ".$decoded->{'title'}.", que tal?')</script>");
	$sql="select currency_id from currency where shortname=?";
	$buscarid=$conexion->prepare($sql);
	$buscarid->execute(array($decoded->{'currency'}));
	if($buscarid->rowCount()>0){
      foreach($buscarid as $currenc){
		$idcu=$currenc['currency_id'];
		print("<script>alert('".$idcu."')</script>");
	  }
	}*/
  }
 
  if(isset($_POST['btnObtenerDatos'])){
	$sql="select i.id_item,i.title_item,ca.ca_name,i.price,i.symbol,cu.shortname,co.coshortname,i.created_at,i.modified_at from item i inner join category ca
    on i.category_id=ca.category_id inner join currency cu on i.currency_id=cu.currency_id inner join country co on i.country_id=co.country_id where id_item=?;";
    $listar=$conexion->prepare($sql);
    $listar->execute(array($_POST['iditem']));
    if($listar->rowCount()>0){
	  foreach($listar as $item){
        echo "<table border='1'>";
        echo "<tr>";
        echo "<td>ID Item</td>";
        echo "<td>Titulo Item</td>";
        echo "<td>Categoria</td>";
        echo "<td>Precio</td>";
        echo "<td>Simbolo</td>";
        echo "<td>Moneda</td>";
        echo "<td>Pais</td>";
        echo "<td>Creado el...</td>";
        echo "<td>Modificado el...</td>";
        echo "</tr>";
        echo "<tr>";
  	    echo "<td>".$item['id_item']."</td>";
   	    echo "<td>".$item['title_item']."</td>";
    	echo "<td>".$item['ca_name']."</td>";
	    echo "<td>".$item['price']."</td>";
    	echo "<td>".$item['symbol']."</td>";
	    echo "<td>".$item['shortname']."</td>";
	    echo "<td>".$item['coshortname']."</td>";
	    echo "<td>".$item['created_at']."</td>";
	    echo "<td>".$item['modified_at']."</td>";
	    echo "</tr>";
	    echo "</table>";
	    $cadjson='{
		  "id_item":'.$item['id_item'].';
  		  "title_item":'.$item['title_item'].';
		  "ca_name":'.$item['ca_name'].';
		  "price":'.$item['price'].';
		  "symbol":'.$item['symbol'].';
		  "currency_shortname":'.$item['shortname'].';
		  "country_shortname":'.$item['coshortname'].';
		  "created_at":'.$item['created_at'].';
		  "modified_at":'.$item['modified_at'].';
	    }';
	    $cadjson=json_encode($cadjson);
	    echo "<br>";
	    echo "JSON del ítem encontrado: ".$cadjson;
      }
	}else{
	  echo "ERROR: No se ha encontrado un ítem con el id: ".$_POST['iditem'];
	}
	echo "<br><br>";
    echo "<a href='./../V/index.php'>Volver a inicio...</a>";
  }
   
   if(isset($_POST['BtnCrear'])){
    $Tit="Otro producto";$Pri=4455;$Cur=1;$Cou=1;$Cat=1234;
	$fecha=date('Y-m-d H:i:s');
	$sql = "insert into item values(?,?,?,?,?,?,?,?,?);";
	$agregar=$conexion->prepare($sql);
	$arreglo=array(null,$Tit,$Cat,$Pri,'%',$Cur,$Cou,$fecha,$fecha);
	$agregar->execute($arreglo);
	if($agregar){
	  $sql="select MAX(id_item) max_id_item from item where title_item=?"; //order by id_item desc";
	  $sentencia=$conexion->prepare($sql);
	  $sentencia->execute([$Tit]);
	  if($sentencia->rowCount()>0){
		foreach($sentencia as $item){
		  $item_id=$item['max_id_item'];
		  $cadjson='{
			"id_item":'.$item_id.';
		  }';
		  $cadjson=json_encode($cadjson);
		  header('location:./../V/index.php?mensaje=ÉXITO: Ítem creado: '.$cadjson);
		}
	  }
	}
  } 
  
  /*if(isset($_GET['id_actualizar'])){
	$sql="update item set title_item='Nuevo título',price=12345,currency_id=(select currency_id from currency where shortname='CLP'),
	country_id=(select country_id from country where coshortname='CL') where id_item=?";
	$actualizar=$conexion->prepare($sql);
	$actualizar->execute(array($_GET['id_actualizar']));
	if($actualizar){
      header('location:./../V/index.php?mensaje=ÉXITO: Se ha actualizado el ítem.');
    }else{
      header('location:./../V/index.php?mensaje=ERROR: No se ha actualizado el ítem.');
    }
  }
  
  if(isset($_GET['id_actualizar'])){
	$sql1="select currency_id from currency where shortname=?";
	$buscaridcat=$conexion->prepare($sql1);
	$buscaridcat->execute(["CLP"]);
	$results=$buscaridcat->fetchAll(PDO::FETCH_OBJ);
	if($buscaridcat->rowCount()>0){
	  foreach($results as $result){
		print("<script>alert('Hola ".$result->category_id.", que tal?')</script>");
	  }
	}
  }
  
  if(isset($_GET['id_actualizar'])){
	$cadena=array(
      "title"=>"Nuevo título",
	  "price"=>12345,
	  "currency"=>"CLP",
	  "country"=>"CL"
	);
	$sql="update item set title_item=".$cadena['title'].",price=".$cadena['price']." where id_item=".$_GET['id_actualizar'].";";
	$actualizar=$conexion->prepare($sql);
	$actualizar->execute($cadena);
	/*if($actualizar){
      header('location:./../V/index.php?mensaje=ÉXITO: Se ha actualizado el ítem.');
    }else{
      header('location:./../V/index.php?mensaje=ERROR: No se ha actualizado el ítem.');
    }
  }*/
  
  /*if(isset($_POST['btnActualizar'])){
	$cadena=array(
	  "id_item"=>htmlentities($_POST['id_item'],ENT_QUOTES),
	  "title_item"=>htmlentities($_POST['title_item'],ENT_QUOTES),
	  "category_id"=>htmlentities($_POST['ca_name'],ENT_QUOTES),
	  "price"=>htmlentities($_POST['price'],ENT_QUOTES),
	  "symbol"=>htmlentities($_POST['symbol'],ENT_QUOTES),
	  "currency_id"=>htmlentities($_POST['currency'],ENT_QUOTES),
	  "country_id"=>htmlentities($_POST['country'],ENT_QUOTES),
	  "created_at"=>htmlentities($_POST['created_at'],ENT_QUOTES),
	  "modified_at"=>htmlentities($_POST['modified_at'],ENT_QUOTES)
	);
	$sql="update item set title_item=".$cadena['title_item'].",category_id=".$cadena['category_id'].",price=".$cadena['price'].",symbol=".$cadena['symbol'].",
	currency_id=".$cadena['currency_id'].",country_id=".$cadena['country_id'].",created_at=".$cadena['created_at'].",modified_at=".$cadena['modified_at']." 
	where id_item=".$_POST['id_item'].";";
	$actualizar=$conexion->prepare($sql);
	$actualizar->execute(array($_POST['id_item']));
	$sql="update item set title_item=?,category_id=?,price=?,symbol=?,currency_id=?,country_id=?,created_at=?,modified_at=?	where id_item=?";
	$actualizar=$conexion->prepare($sql);
	$actualizar->execute($cadena,$_POST['id_item']);
	if($actualizar){
      header('location:./../V/index.php?mensaje=ÉXITO: Se ha actualizado el ítem.');
    }else{
      header('location:./../V/index.php?mensaje=ERROR: No se ha actualizado el ítem.');
    }
 }*/
  
 
?>