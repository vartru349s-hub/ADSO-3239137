# Modelo de datos

- users: operador o usuario, documento y credenciales.
- categories: UUID y nombre único. Semillas: Urbanas, Montaña, Plegables, Eléctricas e Infantiles.
- bicycles: UUID, código único, nombre, categoría, tarifa, total, disponibles y deleted_at.
- rentals: UUID, usuario, operador y rented_at UTC.
- rental_lines: bicicleta y copia congelada de código, nombre, categoría, tarifa, vencimiento y devolución.

Las FK conservan integridad. La disponibilidad cambia solo en transacciones. La línea preserva la historia aunque cambie el catálogo.
