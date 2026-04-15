# Sistema de Modelado de Base de Datos

## Descripción
Este proyecto corresponde a la construcción de un modelo de base de datos a partir del análisis de un dominio de negocio. Se desarrollaron tres niveles: Modelo Entidad Relación (MER), Modelo Relacional (MR) y modelo físico en MySQL.

El sistema integra tres dominios: ubicación, comercial y seguridad.

## Dominio de Ubicación
Permite organizar la información geográfica en una estructura jerárquica compuesta por continente, país, departamento, ciudad y barrio.

## Dominio Comercial
Permite gestionar productos y ventas mediante las entidades categoría, producto, factura y detalle de factura, garantizando la trazabilidad de las operaciones.

## Dominio de Seguridad
Permite controlar el acceso al sistema mediante las entidades persona, usuario y roles, separando identidad, autenticación y autorización.

## Estructura Técnica
El modelo fue implementado en MySQL utilizando llaves primarias autoincrementales, llaves foráneas para relaciones y restricciones como NOT NULL y UNIQUE para garantizar la integridad de los datos.

## Relaciones
Un continente tiene muchos países, un país tiene muchos departamentos, un departamento tiene muchas ciudades y una ciudad tiene muchos barrios. Un producto pertenece a una categoría. Una factura puede tener múltiples detalles. Un usuario está asociado a una persona y a un rol.

## Validación
El modelo cumple con normalización básica, integridad referencial y coherencia entre los niveles conceptual, lógico y físico.

## Ejecución
Ejecutar el script SQL en MySQL para crear la base de datos y sus tablas.