# Registro de cambios – TaskBoard

## Guía práctica de laboratorio N.º 18
**Semana 16 – Mantenimiento correctivo y evolutivo con apoyo de IA**

### MT-013 – Mantenimiento correctivo

**Problema identificado:**

El endpoint `GET /api/transacciones` aceptaba estados no válidos y respondía `200 OK`, aunque el parámetro recibido no correspondía a los estados permitidos.

**Solución implementada:**

Se agregó validación del parámetro `estado` en el método `index()` del controlador `TransaccionApiController`.

Estados permitidos:
- Iniciada
- Completada
- Fallida

Los estados no válidos ahora generan una respuesta `422 Unprocessable Entity`.

**Pruebas realizadas:**
- C-1. Estado inválido (`Pagada`): 422.
- C-2. Estado válido (`Completada`): 200.
- C-3. Consulta sin filtro de estado: 200.
- C-4. Estado `Iniciada`: 200.
- C-5. Estado `Fallida`: 200.

**Resultado:** 5 de 5 pruebas aprobadas.


### MT-014 – Mantenimiento evolutivo

**Mejora solicitada:**

Agregar filtros opcionales por monto mínimo y máximo al endpoint `GET /api/transacciones/filtrar`.

**Solución implementada:**

Se agregaron los parámetros:
- `monto_min`: valor numérico mayor o igual a cero.
- `monto_max`: valor numérico mayor o igual a cero.

Se incorporó la regla condicional `Rule::when()` para comprobar que `monto_max` sea mayor o igual que `monto_min` únicamente cuando se proporciona el monto mínimo.

También se agregaron condiciones a la consulta para filtrar las transacciones según los montos indicados, conservando los filtros existentes de estado y fechas.

**Pruebas realizadas:**
- M-1. Monto mínimo válido (`monto_min=20`): 200.
- M-2. Monto máximo independiente (`monto_max=100`): 200.
- M-3. Monto máximo menor que el mínimo: 422.
- M-4. Monto mínimo negativo (`-5`): 422.
- M-5. Monto mínimo no numérico (`abc`): 422.
- M-6. Filtro combinado de estado `Completada` y monto mínimo `20`: 200.

### Pruebas de regresión

Se ejecutaron las ocho pruebas existentes de la carpeta `4. Filtro`:

- F-1. Solicitud sin autenticación: 401.
- F-2. Consulta de transacciones de Ana: 200.
- F-3. Consulta de transacciones de Carlos: 200.
- F-4. Estado inválido: 422.
- F-5. Entrada de intento de inyección SQL: 422.
- F-6. Fecha inicial inválida: 422.
- F-7. Fecha final anterior a la inicial: 422.
- F-8. Consulta utilizando únicamente fecha final: 200.

**Resultado de regresión:** 8 de 8 pruebas respondieron según lo esperado.

### Archivos modificados

- `app/Http/Controllers/Api/TransaccionApiController.php`
- `CAMBIOS.md`

### Resultado

Se corrigió la validación de estados en el listado de transacciones y se incorporaron filtros opcionales por rango de montos. Las pruebas realizadas confirmaron el funcionamiento de los nuevos filtros y la conservación del comportamiento de los filtros anteriores.