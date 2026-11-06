# VIGILA - Prototipo de Panel de Videovigilancia

Prototipo simple en PHP que representa la solución propuesta al caso práctico VIGILA
(optimización de infraestructura en AWS para servicios de videovigilancia).

- Registro de cámaras con zona, estado y tipo de almacenamiento (S3 / Glacier / EBS)
- Panel con resumen de cámaras activas, prioritarias y en archivo
- Sin base de datos: almacenamiento en archivo JSON

## Despliegue
PHP 8.x + Nginx. Dar permisos de escritura a `data/` y `uploads/`.
