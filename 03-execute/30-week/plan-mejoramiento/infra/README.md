# Infraestructura

Ejecute desde la raíz del plan:

docker compose -f infra/docker-compose.yml up --build

Servicios: React 5173, API 8000, página 8080 y PostgreSQL interno. Para reiniciar datos use docker compose -f infra/docker-compose.yml down -v.
