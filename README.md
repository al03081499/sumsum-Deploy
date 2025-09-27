# sumsum-Deploy
Este proyecto implementa una **tienda en línea simple de ropa** que permite visualizar productos, consultar sus variantes (tallas y colores) y gestionarlos en un carrito de compras.
El objetivo es mostrar la integración entre **frontend (HTML/CSS)**, **backend (PHP)** y **base de datos (MySQL)**, aplicando conceptos de desarrollo web y bases de datos relacionales.

## Tecnologías
- PHP 8 (XAMPP / Apache)
- MySQL (phpMyAdmin / Workbench)
- HTML5 + CSS3

## Funcionalidades
- Catálogo dinámico de productos (solo activos).
- Página de detalle con variantes (talla, color, stock).
- Carrito de compras en sesión (añadir, quitar, vaciar).
- Simulación de checkout (sin afectar stock en este avance).

## Limitaciones
- No incluye autenticación de usuarios.
- No procesa pagos reales.
- Checkout aún no descuenta stock en BD.

##  Cómo ejecutar
1. Clonar este repositorio.
2. Copiar la carpeta `sumsum-Deploy` dentro de `C:\xampp\htdocs\`.
3. Importar `sql/schema.sql` en MySQL (phpMyAdmin o Workbench).
4. Iniciar Apache y MySQL desde XAMPP.
5. Abrir [http://localhost/sumsum/index.php](http://localhost/sumsum-Deploy/index.php).

