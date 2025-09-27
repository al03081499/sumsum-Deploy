<?php
session_start();
require __DIR__.'/db.php';
$pdo = db();

// estructura del carrito:

if (!isset($_SESSION['cart'])) {
  $_SESSION['cart'] = [];
}

$action = $_POST['action'] ?? $_GET['action'] ?? null;

// agregar producto
if ($action === 'add' && isset($_POST['product_id'], $_POST['variant_id'])) {
  $product_id = (int)$_POST['product_id'];
  $variant_id = (int)$_POST['variant_id'];

  // aumenta qty
  $found = false;
  foreach ($_SESSION['cart'] as &$item) {
    if ($item['product_id'] === $product_id && $item['variant_id'] === $variant_id) {
      $item['qty'] += 1;
      $found = true;
      break;
    }
  }
  unset($item);
  if (!$found) {
    $_SESSION['cart'][] = ['product_id'=>$product_id, 'variant_id'=>$variant_id, 'qty'=>1];
  }

  header('Location: cart.php'); 
  exit;
}

if ($action === 'remove' && isset($_GET['i'])) {
  $i = (int)$_GET['i'];
  if (isset($_SESSION['cart'][$i])) {
    array_splice($_SESSION['cart'], $i, 1);
  }
  header('Location: cart.php');
  exit;
}

// vaciar carrito
if ($action === 'clear') {
  $_SESSION['cart'] = [];
  header('Location: cart.php');
  exit;
}

// Traer datos de productos/variantes para mostrar
$items = [];
$total = 0.0;

if (!empty($_SESSION['cart'])) {
  // Prepara consultas
  $prodStmt = $pdo->prepare("SELECT id, nombre, precio, imagen FROM productos WHERE id=?");
  $varStmt  = $pdo->prepare("SELECT id, talla, color, stock FROM variantes WHERE id=?");

  foreach ($_SESSION['cart'] as $idx => $it) {
    $prodStmt->execute([$it['product_id']]);
    $p = $prodStmt->fetch();

    $varStmt->execute([$it['variant_id']]);
    $v = $varStmt->fetch();

    if ($p && $v) {
      $line = [
        'idx'     => $idx,
        'nombre'  => $p['nombre'],
        'imagen'  => $p['imagen'],
        'precio'  => (float)$p['precio'],
        'talla'   => $v['talla'],
        'color'   => $v['color'],
        'qty'     => (int)$it['qty'],
        'subtotal'=> (float)$p['precio'] * (int)$it['qty']
      ];
      $items[] = $line;
      $total  += $line['subtotal'];
    }
  }
}

function money($n){ return '$'.number_format((float)$n, 2); }
?>
<!doctype html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <title>Carrito - sumsum</title>
  <link rel="stylesheet" href="assets/styles.css">
  <meta name="viewport" content="width=device-width,initial-scale=1">
</head>
<body>
  <nav class="nav">
    <div>
      <a href="catalog.php">Catálogo</a>
      <a href="index.php" class="brand">sumsum</a>
    </div>
    <div>
      <a href="#">Mi Perfil</a>
      <a href="cart.php" class="active">Carrito</a>
    </div>
  </nav>

  <img src="assets/banner1.jpg" alt="SALE" class="banner">

  <div class="container">
    <h2>Tu carrito</h2>

    <?php if (empty($items)): ?>
      <p>Tu carrito está vacío.</p>
      <p><a href="catalog.php" class="btn">Ir al catálogo</a></p>
    <?php else: ?>
      <table class="table">
        <thead>
          <tr>
            <th>Producto</th>
            <th>Variante</th>
            <th>Cantidad</th>
            <th>Precio</th>
            <th>Subtotal</th>
            <th></th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($items as $line): ?>
            <tr>
              <td>
                <div style="display:flex; gap:10px; align-items:center;">
                  <img src="<?= htmlspecialchars($line['imagen']) ?>" alt="" style="width:56px; height:56px; object-fit:cover; border-radius:8px;">
                  <span><?= htmlspecialchars($line['nombre']) ?></span>
                </div>
              </td>
              <td>
                <?= htmlspecialchars($line['talla']) ?>
                <?php if ($line['color']): ?>
                  / <?= htmlspecialchars($line['color']) ?>
                <?php endif; ?>
              </td>
              <td><?= (int)$line['qty'] ?></td>
              <td><?= money($line['precio']) ?></td>
              <td><?= money($line['subtotal']) ?></td>
              <td>
                <a class="btn" style="background:#fff;color:#222;"
                   href="cart.php?action=remove&i=<?= (int)$line['idx'] ?>">Quitar</a>
              </td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>

      <p><strong>Total: <?= money($total) ?></strong></p>

      <div style="display:flex; gap:8px; margin-top:12px;">
        <a href="catalog.php" class="btn" style="background:#fff;color:#222;">Seguir comprando</a>
        <a href="cart.php?action=clear" class="btn" style="background:#fff;color:#222;">Vaciar carrito</a>
        <a href="#" class="btn">Checkout (demo)</a>
      </div>
    <?php endif; ?>
  </div>
</body>
</html>

