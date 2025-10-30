# Comandos de producción – lakeflash.com

> **IMPORTANTE**: Sustituye `TOK_EMPRESAA_AQUI` por el token real que corresponda a cada cliente antes de ejecutar los comandos.

---

## Endpoints que se deberán probar cuando el servicio esté funcional

**Internos (rutas API)**
- Cotización: `api/get-shippingCost`
- Envío de pedido: `api/send-order`
- Obtener cliente: `api/get-client`

## Ejemplos de uso en producción (https://lakeflash.com)

### 1. getShippingCost
```bash
curl -X POST "https://lakeflash.com/api/get-shippingCost" \
     -H "Content-Type: application/json" \
     -d '{
           "token": "TOK_EMPRESAA_AQUI",
           "data_client": {
               "postal_code": "1000",
               "client": "Empresa A",
               "reference": "Av. Corrientes 1234"
           },
           "weight": "10",
           "depth": "1",
           "width": "1",
           "height": "0.5"
         }'
```

### 2. getClient
```bash
curl -X POST "https://lakeflash.com/api/get-client" \
     -H "Content-Type: application/json" \
     -d '{
           "user": "contacto@empresaa.com",
           "token": "TOK_EMPRESAA_AQUI"
         }'
```

### 3. sendOrder
```bash
curl -X POST "https://lakeflash.com/api/send-order" \
     -H "Content-Type: application/json" \
     -d '{
           "token": "TOK_EMPRESAA_AQUI",
           "data_client": {
               "postal_code": "1000",
               "client": "Empresa A",
               "reference": "Av. Corrientes 1234",
               "shipping_data": {
                   "store": { "name": "Test Store" },
                   "email": "contacto@empresaa.com",
                   "province": "Buenos Aires",
                   "city": "Buenos Aires",
                   "address": "Av. Corrientes 1234",
                   "telephone": "+54933333333"
               }
           },
           "weight": "10",
           "depth": "1",
           "width": "1",
           "height": "0.5"
         }'
```

---

## Consejos
1. Mantén siempre la cabecera `Content-Type: application/json`.
2. Verifica que el JSON cumpla exactamente con la estructura esperada por la API.
3. Hasta que el dominio apunte y AutoSSL esté activo, puedes probar con la IP pública y la cabecera `Host: lakeflash.com` o con la URL temporal que proporciona Nuthost.