# 🚀 Guía de Despliegue Gratuito — Project JEC

## Stack recomendado (todo gratis)

| Capa | Servicio | Notas |
|------|----------|-------|
| App PHP/Laravel | **Railway.app** | 500 hrs/mes gratis, soporte nativo PHP |
| Base de datos | **SQLite** (incluida) | Sin costo, archivo en el propio servidor |
| Alternativa BD | **PlanetScale** (MySQL) | 5 GB gratis, escala automáticamente |
| Dominio | **railway.app** | subdominio gratis incluido |

---

## Opción A — Railway (recomendada, más fácil)

1. Crea cuenta en [railway.app](https://railway.app)
2. Nuevo proyecto → "Deploy from GitHub repo"
3. Conecta tu repositorio `Project_JEC`
4. Railway detecta Laravel automáticamente
5. En **Variables** agrega:
   ```
   APP_KEY=         ← genera con: php artisan key:generate --show
   APP_ENV=production
   APP_DEBUG=false
   DB_CONNECTION=sqlite
   ```
6. En **Settings → Start Command** pon:
   ```
   php artisan migrate --force && php artisan serve --host=0.0.0.0 --port=$PORT
   ```
7. ¡Listo! Railway te da una URL pública.

---

## Opción B — Render.com

1. Crea cuenta en [render.com](https://render.com)
2. New → Web Service → conecta tu repo
3. Build Command: `composer install --no-dev && php artisan config:cache`
4. Start Command: `php artisan serve --host=0.0.0.0 --port=$PORT`
5. Agrega las variables de entorno igual que Railway

---

## Comandos post-despliegue

```bash
php artisan key:generate
php artisan migrate --force
php artisan db:seed          # solo si quieres el usuario admin inicial
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

---

## Optimización SQLite para producción

SQLite es perfecta para este sistema porque:
- ✅ Sin configuración de servidor de BD
- ✅ Archivo único, fácil de hacer backup
- ✅ Soporta bien hasta ~10,000 registros y ~20 usuarios simultáneos
- ✅ Laravel la soporta 100% nativamente

Si en el futuro necesitas escalar, migrar a MySQL toma 5 minutos cambiando `.env`.
