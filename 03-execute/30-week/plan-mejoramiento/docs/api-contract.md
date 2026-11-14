# Contrato API

Base: /api/v1. JSON. Error: {code, message, details}.

| Método | Ruta | Resultado |
|---|---|---|
| GET | /health | Estado |
| POST | /auth/login | Token |
| GET | /categories | Categorías |
| GET/POST | /users | Lista o crea usuarios |
| GET/PUT | /users/{id} | Consulta o edita usuario |
| GET/POST | /bicycles | Lista o crea bicicletas |
| GET/PUT/DELETE | /bicycles/{id} | Consulta, edita o baja |
| GET/POST | /rentals | Lista o crea alquiler |
| GET | /rentals/{id} | Detalle |
| GET | /rentals/overdue | Vencidos |
| POST | /rentals/{id}/lines/{line}/return | Devolución |
| GET | /reports/most-requested?from&to | Reporte |

Códigos: 201 creación, 204 baja, 401 credenciales, 404 inexistente, 409 conflicto y 422 validación.
