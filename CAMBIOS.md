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
- Estado inválido: 422.
- Estado válido: 200.
- Consulta sin estado: 200.
- Consulta con estado Iniciada: 200.
- Consulta con estado Fallida: 200.

### MT-014 – Mantenimiento evolutivo

**Mejora solicitada:**

Agregar filtros opcionales por monto mínimo y máximo al endpoint `GET /api/transacciones/filtrar`.

**Solución implementada:**

Se agregaron los parámetros:
- `monto_min`: valor numérico mayor o igual a cero.
- `monto_max`: valor numérico mayor o igual a cero.

Se incorporó una validación personalizada para comprobar que `monto_max` sea mayor o igual que `monto_min` únicamente cuando ambos parámetros estén presentes.

También se agregaron condiciones a la consulta para filtrar las transacciones según los montos indicados.

**Pruebas realizadas:**
- Filtro por monto mínimo: 200.
- Filtro combinado de monto mínimo y máximo: 200.
- Filtro por monto máximo de forma independiente: 200.
- Monto mínimo negativo: 422.
- Monto máximo menor que el mínimo: 422.

### Archivos modificados

- `app/Http/Controllers/Api/TransaccionApiController.php`
- `CAMBIOS.md`

### Resultado

Se corrigió la validación de estados en el listado de transacciones y se incorporaron filtros por rango de montos, manteniendo el funcionamiento de los filtros existentes.