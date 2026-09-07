/**
 * Script de Compilación Node.js para Syncro Andina Web Application
 * Comando: npm run build
 * Genera el paquete compilado en la carpeta dist/
 */

const { execSync } = require('child_process');
const fs = require('fs');
const path = require('path');

const rootDir = __dirname;
const distDir = path.join(rootDir, 'dist');
const zipPath = path.join(distDir, 'syncroandina_installer.zip');

console.log('=========================================================');
console.log(' 🚀 Compilando aplicación web con Node.js (npm run build)');
console.log('=========================================================\n');

// 1. Crear / Asegurar que exista la carpeta dist/
if (!fs.existsSync(distDir)) {
    fs.mkdirSync(distDir, { recursive: true });
}

// 2. Ejecutar el proceso de empaquetado
try {
    const output = execSync('php build_installer.php', { encoding: 'utf-8', cwd: rootDir });
    console.log(output);
} catch (error) {
    console.error('❌ Error durante la compilación en dist/:', error.stdout || error.message);
    process.exit(1);
}

// 3. Corroboración física real en el sistema de archivos del sistema operativo
let attempts = 0;
let isPhysicalFileReady = false;

while (attempts < 30) {
    if (fs.existsSync(zipPath)) {
        try {
            const stats = fs.statSync(zipPath);
            if (stats.size > 0) {
                isPhysicalFileReady = true;
                break;
            }
        } catch (e) {}
    }
    // Sincronización breve de 100ms
    const delayEnd = Date.now() + 100;
    while (Date.now() < delayEnd) {}
    attempts++;
}

if (!isPhysicalFileReady) {
    console.error('❌ Error: El archivo ZIP no pudo ser verificado físicamente en el disco.');
    process.exit(1);
}
