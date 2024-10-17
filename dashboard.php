<?php
session_start();
if (!isset($_SESSION['login']))
    header("location: index.php");	
?>

<html>
<head>
	<title>Sistema de Pruebas UNACH</title>
    <!-- Bootstrap core CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootswatch@4.5.2/dist/cerulean/bootstrap.min.css">
	<link href="css/cmce-styles.css" rel="stylesheet">
	<!-- Bootstrap core JavaScript -->
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>    
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body>
<nav class="navbar navbar-dark bg-dark">
	<div class="container-fluid">
    	<a class="navbar-brand"><b>Nombre de usuario:</b> <?php echo $_SESSION['nomusuario']; ?></a> 
		<a href="cerrar.php"><button class="btn btn-warning">Cerrar Sesión</button></a>
  </div>
</nav>
<center>
	<br><br><br><br>
		
	<form action="dashboard.php" method="GET">
	<div class="formpanel" id="f1">
		<b>Buscar producto por precio mayor a:</b> <input type="text" name="pre" size="4">
		<button class="btn btn-primary" type="submit">Buscar</button>
	</div>
	</form>
	
	<br><br>
		<hr>
	<br><br>

	<button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#exampleModal">
  		Nuevo Producto
	</button>

	<br><br>
<?php

	include('conexion.php');
	$con = conectaDB();
  if(isset($_GET['pre'])==true) {		
    $sql ="SELECT idPro, Nombre, Precio, Ext FROM tb_productos WHERE Precio > " . $_GET['pre'];
  } else {
    $sql ="SELECT idPro, Nombre, Precio, Ext FROM tb_productos";
  }
  
 // Inicio de la tabla
echo "<table class='table' style='width:570;'>";
echo "<thead class='table-dark'>";
echo "<th>ID</th>"; // Nueva columna para el ID
echo "<th>Nombre</th>";
echo "<th>Precio</th>";
echo "<th>Existencia</th>"; // Nueva columna para existencia
echo "<th>Acciones</th>"; // Acciones
echo "</thead>";
echo "<tbody>";

// Recuperar y mostrar los datos de los productos
$resultado = mysqli_query($con, $sql);  
while($fila = mysqli_fetch_row($resultado)) {
    echo "<tr>";
    echo "<td>".$fila[0]."</td>"; // Mostrar ID del producto
    echo "<td>".$fila[1]."</td>";
    echo "<td>".$fila[2]."</td>";
    echo "<td>".$fila[3]."</td>"; // Mostrar existencia
    echo "<td>
    <a href='controller/eliminar.php?idp=".$fila[0]."' onclick='return confirm(\"¿Estás seguro de que deseas eliminar este producto?\");'>
        <img src='iconoeliminar.png' width='20' height='20' alt='Eliminar'>
    </a>
    <a href='#' class='edit-product' data-id='".$fila[0]."' data-nombre='".$fila[1]."' data-precio='".$fila[2]."' data-existencia='".$fila[3]."'>
        <img src='iconoeditar.jpg' width='20' height='20' alt='Editar'>
    </a>
</td>";
    echo "</tr>";
}

echo "</tbody></table>";
?>
<br><br>

<!-- Modal para agregar nuevo producto -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Registrar nuevo producto</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form id="productForm">
          <div class="mb-3">
            <label for="productName" class="form-label">Nombre del Producto:</label>
            <input type="text" class="form-control" id="productName" name="nombre" required>
          </div>
          <div class="mb-3">
            <label for="productPrice" class="form-label">Precio:</label>
            <input type="number" class="form-control" id="productPrice" name="precio" required>
          </div>
          <div class="mb-3">
            <label for="productStock" class="form-label">Existencia:</label>
            <input type="number" class="form-control" id="productStock" name="existencia" required>
          </div>
          <!-- Asegúrate de que el botón esté dentro del formulario -->
          <div class="modal-footer">
            <button type="submit" class="btn btn-success">Guardar</button>
            <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cerrar</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>


<!-- Modal para editar producto -->
<div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="editModalLabel">Editar Producto</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form id="editForm">
          <div class="mb-3">
            <label for="editProductId" class="form-label">ID del Producto:</label>
            <input type="text" class="form-control" id="editProductId" name="id" readonly> <!-- Campo de solo lectura -->
          </div>
          <div class="mb-3">
            <label for="editProductName" class="form-label">Nombre del Producto:</label>
            <input type="text" class="form-control" id="editProductName" name="nombre" required>
          </div>
          <div class="mb-3">
            <label for="editProductPrice" class="form-label">Precio:</label>
            <input type="number" class="form-control" id="editProductPrice" name="precio" required>
          </div>
          <div class="mb-3">
            <label for="editProductStock" class="form-label">Existencia:</label>
            <input type="number" class="form-control" id="editProductStock" name="existencia" required>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="submit" class="btn btn-success" id="updateProductButton">Actualizar</button>
        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>
</div>



<!-----Funcion al usar el boton guardar de nuevo producto ------>
<script>
$(document).ready(function() {
  // Guardar nuevo producto
  $('#productForm').on('submit', function(event) {
    event.preventDefault(); // Prevenir el envío del formulario por defecto

    var formData = $(this).serialize(); // Serializar los datos del formulario

    $.ajax({
      url: 'controller/insertar.php',
      method: 'POST',
      data: formData,
      dataType: 'json',
      success: function(response) {
        if (response.success) {
          alert('Producto registrado exitosamente.');
          location.reload(); // Recargar la página para ver el nuevo producto
        } else {
          alert('Error al registrar el producto.');
        }
      },
      error: function() {
        alert('Error en la conexión :C.');
      }
    });
  });
});
</script>


<script>
$(document).ready(function() {
  // Editar producto
  $('.edit-product').on('click', function() {
    // Rellenar el modal con los datos del producto
    $('#editProductId').val($(this).data('id')); // Rellenar el campo oculto con el ID
    $('#editProductName').val($(this).data('nombre'));
    $('#editProductPrice').val($(this).data('precio'));
    $('#editProductStock').val($(this).data('existencia'));
    $('#editModal').modal('show'); // Mostrar el modal
  });

  // Actualizar producto
  $('#updateProductButton').on('click', function() {
    var formData = $('#editForm').serialize(); // Serializar los datos del formulario de edición

    $.ajax({
      url: 'controller/actualizar.php', // Cambia esto a la ruta donde está tu lógica de actualización
      method: 'POST',
      data: formData,
      dataType: 'json',
      success: function(response) {
        if (response.success) {
          alert('Producto actualizado exitosamente.');
          location.reload(); // Recargar la página para ver los cambios
        } else {
          alert('Error al actualizar el producto.');
        }
      },
      error: function() {
        alert('Error en la conexión act :C.');
      }
    });
  });
});
</script>
</body>
</html>
