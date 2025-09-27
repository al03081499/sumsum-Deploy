<?php
require __DIR__.'/db.php';
$pdo = db();
$products = $pdo->query("SELECT id, nombre, precio, imagen FROM productos WHERE activo=1")->fetchAll();
?>
<!doctype html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <title>Catálogo - sumsum</title>
  <link rel="stylesheet" href="assets/styles.css">
</head>
<body>
  <nav class="nav">
    <div>
      <a href="catalog.php" class="active">Catálogo</a>
      <a href="index.php" class="brand">sumsum</a>
    </div>
    <div>
      <a href="#">Mi Perfil</a>
      <a href="cart.php">Carrito (0)</a>
    </div>
  </nav>

  <img src="assets/banner.jpg" alt="SALE" class="banner">

  <div class="container">
    <h2>Catálogo de Productos</h2>
    <div class="grid">
      <?php foreach($products as $p): ?>
        <div class="card">
          <img src="<?= htmlspecialchars($p['imagen']) ?>" alt="<?= htmlspecialchars($p['nombre']) ?>">
          <div class="p">
            <h3><?= htmlspecialchars($p['nombre']) ?></h3>
            <p>$<?= number_format((float)$p['precio'],2) ?></p>
            <a href="product.php?id=<?= (int)$p['id'] ?>" class="btn">Detalle</a>
          </div>
        </div>
      <?php endforeach; ?>
    </div>
  </div>
</body>
</html>



