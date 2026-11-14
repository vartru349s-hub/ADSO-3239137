# Especificación funcional

## Propósito
Bike Share permite administrar bicicletas urbanas, usuarios, alquileres, devoluciones y reportes.

## Historias de usuario
1. Iniciar sesión como operador.
2. Registrar usuarios.
3. Consultar y buscar usuarios.
4. Registrar bicicletas por código de modelo.
5. Editar unidades y tarifa.
6. Dar de baja lógicamente una bicicleta.
7. Alquilar una o dos bicicletas disponibles.
8. Devolver cada bicicleta por separado.
9. Consultar alquileres abiertos y vencidos.
10. Ver bicicletas más solicitadas por periodo.

## Seis reglas de negocio
- RN-01: máximo dos bicicletas sin devolver por usuario.
- RN-02: cada línea vence 24 horas después de la entrega.
- RN-03: un usuario con vencidos no recibe otra bicicleta.
- RN-04: 0 <= available_units <= total_units siempre.
- RN-05: modelo, nombre, categoría y tarifa se congelan en la línea.
- RN-06: alquileres/devoluciones no se eliminan; catálogo con baja lógica.

## Cinco requisitos no funcionales
- RNF-01: fechas ISO-8601 en UTC.
- RNF-02: mensajes de interfaz y errores en español.
- RNF-03: carrera por la última unidad: un éxito y un HTTP 409.
- RNF-04: API JSON versionada en /api/v1 y paginada hasta 50.
- RNF-05: un comando Docker y pruebas automatizadas.
