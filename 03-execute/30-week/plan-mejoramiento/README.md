Este proyecto es la solución del plan de mejoramiento del aprendiz A08, ficha 3239137, dominio bike-share

# Bike Share

Sistema para administrar usuarios, bicicletas, alquileres, devoluciones y reportes. Incluye Laravel, React, PostgreSQL, Docker, sitio público y herramientas de sembrado.

## Inicio rápido

1. Copie api/.env.example como api/.env.
2. Ejecute docker compose -f infra/docker-compose.yml up --build.
3. Abra http://localhost:5173 y http://localhost:8000/api/v1/health.
4. Ejecute php tool/seed.php para sembrar por la API.

Credenciales: operator / Operator123!. No se versionan secretos ni dependencias generadas.
