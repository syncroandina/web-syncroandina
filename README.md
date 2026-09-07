# Syncro Andina Web Application & CMS

Aplicación Web Corporativa Modular con Asistente de Instalación Autónomo (Estilo WordPress) y Sistema de Respaldos de Base de Datos.

## 🚀 Comandos Disponibles

### 1. Iniciar Servidor de Desarrollo Local
```bash
npm run dev
```
Inicia el servidor local en `http://localhost:8000`.

---

### 2. Generar Backup de la Base de Datos MySQL
```bash
npm run backup_db
```
Genera un volcado SQL completo de la estructura y datos de la base de datos MySQL dentro de la carpeta **`backup_bd/`**:
* **`backup_bd/backup_nombre_fecha_hora.sql`** (Respaldo fechado).
* **`backup_bd/latest_backup.sql`** (Último respaldo acumulado).

---

### 3. Compilar Aplicación (Generar ZIP de Producción)
```bash
npm run build
```
Genera el paquete de instalación comprimido limpio en **`dist/syncroandina_installer.zip`**.

---

## 📦 Despliegue en Producción

1. Ejecuta `npm run build`.
2. Sube y descomprime el archivo **`dist/syncroandina_installer.zip`** en tu hosting o servidor.
3. Abre el dominio/URL en tu navegador para iniciar el asistente de instalación interactivo (`/install`).