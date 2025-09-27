<?php
session_start();
require __DIR__.'/db.php';
$pdo = db();

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

$stmt = $pdo->prepare("SELECT id, nombre, precio, genero, imagen FROM productos WHERE id=? AND activo=1");
$stmt->execute([$id]);
$product = $stmt->fetch();

$variants = [];
if ($product) {
  $st = $pdo->prepare("SELECT id, talla, color, stock FROM variantes WHERE producto_id=? ORDER BY talla, color");
  $st->execute([$id]);
  $variants = $st->fetchAll();
}

function money($n){ return '$'.number_format((float)$n, 2); }
?>
<!doctype html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <title>Detalle - sumsum</title>
  <link rel="stylesheet" href="assets/styles.css">
  <meta name="viewport" content="width=device-width,initial-scale=1">
</head>
<body>
  <nav class="nav">
    <div><a href="catalog.php">Catálogo</a></div>
    <a href="index.php" class="brand">sumsum</a>
    <div><a href="#">Mi Perfil</a><a href="cart.php">Carrito</a></div>
  </nav>

  <img src="assets/banner1.jpg" alt="SALE" class="banner">

  <div class="container">
    <?php if(!$product): ?>
      <div style="grid-column:1/-1">
        <h2>Producto no encontrado</h2>
        <p><a class="btn" href="catalog.php">Volver al catálogo</a></p>
      </div>
    <?php else: ?>
      <div class="grid" style="grid-template-columns:1fr 1fr;">
        <div>
          <img src="<?= htmlspecialchars($product['imagen']) ?>"
               alt="<?= htmlspecialchars($product['nombre']) ?>"
               style="width:100%; border-radius:12px;">
        </div>
        <div>
          <h2><?= htmlspecialchars($product['nombre']) ?></h2>
          <p><strong><?= money($product['precio']) ?></strong></p>
          <p>Género: <?= htmlspecialchars($product['genero']) ?></p>

          <form method="post" action="cart.php" style="margin-top:12px;">
            <label for="variant">Variante (talla / color / stock):</label>
            <select id="variant" name="variant_id"
                    style="margin-left:8px; padding:6px 8px; border-radius:8px; border:1px solid #ccc;" required>
              <?php foreach ($variants as $v): ?>
                <option value="<?= (int)$v['id'] ?>" <?= (int)$v['stock']===0 ? 'disabled' : '' ?>>
                  <?= htmlspecialchars($v['talla']) ?><?= $v['color'] ? ' / '.htmlspecialchars($v['color']) : '' ?>
                  (stock: <?= (int)$v['stock'] ?>)
                </option>
              <?php endforeach; ?>
            </select>

            <input type="hidden" name="product_id" value="<?= (int)$product['id'] ?>">
            <input type="hidden" name="action" value="add">
            <button type="submit" class="btn" style="margin-left:8px;">Agregar al carrito</button>
          </form>

          <p style="margin-top:12px;">
            <a href="catalog.php" class="btn" style="background:#fff;color:#222;">Volver</a>
          </p>
        </div>
      </div>
    <?php endif; ?>
  </div>
</body>
</html>
