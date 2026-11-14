# ADR-002: bloqueo pesimista

Estado: aceptado. La entrega bloquea bicicletas con lockForUpdate. La transacción revalida disponibilidad y devuelve 409 al perdedor.
