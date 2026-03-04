# 🚀 Blog Laravel

Aplicación web de Blog desarrollada con **Laravel 12**, **Eloquent ORM**, 
**Bootstrap 5** y **Axios**. Implementa operaciones CRUD completas con 
sistema de layouts Blade y peticiones asíncronas con async/await.

## 🛠️ Tecnologías utilizadas

- **Laravel 12** — Framework PHP
- **Eloquent ORM** — Manejo de base de datos
- **Bootstrap 5** — Estilos y diseño responsive
- **Axios** — Peticiones HTTP asíncronas
- **MySQL** — Base de datos
- **Blade** — Motor de plantillas

## ✨ Funcionalidades

- ✅ Crear, leer, actualizar y eliminar registros (CRUD)
- ✅ Layout reutilizable con Blade
- ✅ Peticiones asíncronas sin recargar la página
- ✅ Validaciones del lado del servidor

## 📦 Instalación

### 1. Clonar el proyecto
git clone https://github.com/magovenegas/Blog-Laravel

### 2. Instalar dependencias
composer install
npm install

### 3. Configurar variables de entorno
cp .env.example .env
php artisan key:generate

### 4. Configurar la base de datos
# Edita el archivo .env con tus credenciales de BD
php artisan migrate

### 5. Iniciar el servidor
npm run dev
php artisan serve

## 🌐 Uso
Abre tu navegador en: http://localhost:8000

## 👤 Autor
**Tu Nombre** — github.com/magovenegas