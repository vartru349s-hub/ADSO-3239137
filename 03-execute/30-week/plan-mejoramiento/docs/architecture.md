# Arquitectura

React consume una API REST Laravel; Laravel controla PostgreSQL y ejecuta reglas en transacciones. Nginx sirve el sitio público.

- app: SPA React.
- api: Laravel y persistencia.
- database: PostgreSQL 16.
- page: presentación estática.
- tool: sembrador PHP por HTTP.
- infra: Compose, redes y volúmenes.

## Flujo crítico
Al alquilar, Laravel bloquea filas con SELECT FOR UPDATE, valida disponibilidad y usuario, crea alquiler y líneas congeladas, y descuenta unidades en una transacción. El competidor por la última unidad recibe 409.
