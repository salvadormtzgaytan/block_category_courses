# Manual de Usuario - Category Cards Plugin

## 📋 Descripción General

El plugin **Category Cards** transforma la visualización de categorías de cursos en Moodle, mostrando tarjetas elegantes con imágenes personalizadas, colores únicos y información de progreso para cada categoría en la que el usuario está inscrito.

## 🎯 Características Principales

- **Tarjetas visuales** con imágenes personalizadas o iniciales generadas automáticamente
- **Colores personalizables** por categoría
- **Información de progreso** de cursos completados
- **Diseño responsive** que se adapta a cualquier dispositivo
- **Múlt# Manual de Usuario - Category Cards Plugin

## 📋 Descripción General

El plugin **Category Cards** transforma la visualización de categorías de cursos en Moodle, mostrando tarjetas elegantes con imágenes personalizadas, colores únicos y información de progreso para cada categoría en la que el usuario está inscrito.

## 🎯 Características Principales

- **Tarjetas visuales** con imágenes personalizadas o iniciales generadas automáticamente
- **Colores personalizables** por categoría
- **Información de progreso** de cursos completados
- **Diseño responsive** que se adapta a cualquier dispositivo
- **Múltiples opciones de ordenamiento** y filtrado
- **Interfaz de administración** intuitiva y profesional

---

## 🚀 Instalación

### Requisitos del Sistema
- **Moodle 4.1+** o superior
- **PHP 7.4+** o superior
- Permisos de administrador del sitio

### Pasos de Instalación
1. Descargar el plugin desde el repositorio
2. Extraer en `/blocks/category_courses/`
3. Ir a **Administración del sitio > Notificaciones**
4. Seguir el proceso de instalación automática
5. El plugin creará automáticamente las tablas necesarias

---

## ⚙️ Configuración Global

### Acceso a Configuración
**Ruta:** `Administración del sitio > Plugins > Bloques > Category Cards`

### Opciones Disponibles

#### 📊 Opciones de Visualización
- **Mostrar progreso** *(Por defecto: Activado)*
  - Muestra barra de progreso con cursos completados
  - Formato: "X de Y cursos completados"

- **Mostrar descripción** *(Por defecto: Activado)*
  - Muestra descripción de la categoría (truncada)
  - Límite configurable de caracteres

- **Mostrar contador de cursos** *(Por defecto: Activado)*
  - Chip con número total de cursos en la categoría

#### 🔄 Opciones de Ordenamiento
- **Core** *(Por defecto)*: Orden original de Moodle
- **Alfabético**: A-Z por nombre de categoría
- **Por cantidad de cursos**: Mayor a menor número de cursos
- **Por progreso**: Mayor a menor porcentaje completado

#### 🎛️ Opciones Avanzadas
- **Incluir subcategorías** *(Por defecto: Desactivado)*
  - Incluye cursos de subcategorías en el conteo

- **Incluir cursos ocultos** *(Por defecto: Desactivado)*
  - Incluye cursos no visibles para estudiantes

- **Máximo de categorías** *(Por defecto: 12)*
  - Límite de categorías mostradas por bloque

- **Límite de descripción** *(Por defecto: 150)*
  - Caracteres máximos para descripción

- **TTL de caché** *(Por defecto: 300 segundos)*
  - Tiempo de vida del caché para optimizar rendimiento

---

## 🎨 Gestión de Imágenes y Colores

### Acceso a Gestión Visual
**Ruta:** `Administración del sitio > Plugins > Bloques > Category Cards > Manage Category Images`

### Funcionalidades

#### 📸 Subida de Imágenes
- **Formatos soportados:** JPG, PNG, GIF, WebP
- **Tamaño máximo:** 2MB por imagen
- **Resolución recomendada:** 400x240px (ratio 5:3)
- **Optimización automática:** Las imágenes se redimensionan automáticamente

#### 🎨 Personalización de Colores
- **Color picker visual** para selección intuitiva
- **Código hexadecimal** manual (#RRGGBB)
- **Colores por defecto** generados automáticamente basados en el nombre
- **Vista previa en tiempo real** de los cambios

#### 🔄 Sistema de Fallback
1. **Primera prioridad:** Imagen subida por administrador
2. **Segunda prioridad:** Imagen extraída de la descripción de categoría
3. **Tercera prioridad:** Iniciales con color personalizado

---

## 🏗️ Configuración del Bloque

### Agregar el Bloque
1. Activar **modo de edición** en la página deseada
2. Hacer clic en **"Agregar un bloque"**
3. Seleccionar **"Category Cards"**
4. El bloque aparecerá en la región seleccionada

### Configuración Individual del Bloque

#### Acceso
Hacer clic en el **ícono de engranaje** (⚙️) del bloque

#### Opciones Disponibles

##### 📝 Configuración Básica
- **Título personalizado**
  - Sobrescribe el título por defecto
  - Deja vacío para usar "Mis Categorías"

##### 📊 Opciones de Visualización (Override)
- **Mostrar progreso:** Activar/desactivar barra de progreso
- **Mostrar descripción:** Activar/desactivar descripción de categoría
- **Mostrar contador:** Activar/desactivar chip de número de cursos

##### 🔄 Opciones de Ordenamiento (Override)
- **Por defecto:** Usa configuración global
- **Core:** Orden original de Moodle
- **Alfabético:** A-Z por nombre
- **Por cursos:** Mayor a menor cantidad
- **Por progreso:** Mayor a menor completado

##### 🎛️ Opciones Avanzadas (Override)
- **Máximo de categorías:** Límite específico para este bloque
- **Incluir subcategorías:** Incluir cursos de subcategorías

---

## 👥 Permisos y Capacidades

### Capacidades del Plugin

#### `block/category_courses:view`
- **Descripción:** Ver el contenido del bloque
- **Por defecto:** Todos los usuarios autenticados
- **Contexto:** Nivel de bloque

#### `block/category_courses:addinstance`
- **Descripción:** Agregar nueva instancia del bloque
- **Por defecto:** Profesores editores y administradores
- **Contexto:** Nivel de bloque

#### `block/category_courses:myaddinstance`
- **Descripción:** Agregar bloque al Dashboard personal
- **Por defecto:** Todos los usuarios
- **Contexto:** Sistema

#### `block/category_courses:manage`
- **Descripción:** Gestionar imágenes y colores de categorías
- **Por defecto:** Solo administradores
- **Contexto:** Sistema

### Configuración de Permisos
**Ruta:** `Administración del sitio > Usuarios > Permisos > Definir roles`

---

## 🎯 Casos de Uso

### 📚 Para Estudiantes
- **Dashboard personal:** Ver progreso en todas las categorías
- **Navegación rápida:** Acceso directo a categorías de interés
- **Información visual:** Identificar fácilmente categorías por color/imagen

### 👨‍🏫 Para Profesores
- **Página de curso:** Mostrar categorías relacionadas
- **Seguimiento:** Ver progreso general de estudiantes por categoría

### 👨‍💼 Para Administradores
- **Página principal:** Destacar categorías importantes
- **Personalización:** Crear identidad visual por área de conocimiento
- **Organización:** Facilitar navegación en sitios con muchas categorías

---

## 🔧 Solución de Problemas

### Problemas Comunes

#### ❌ "No hay categorías disponibles"
**Causas posibles:**
- Usuario no inscrito en ningún curso
- Todos los cursos están ocultos
- Problemas de permisos de categoría

**Soluciones:**
1. Verificar inscripciones del usuario
2. Revisar visibilidad de cursos y categorías
3. Comprobar permisos de `moodle/category:viewhiddencategories`

#### 🖼️ Imágenes no se muestran
**Causas posibles:**
- Archivo corrupto o formato no soportado
- Problemas de permisos de archivo
- Caché no actualizado

**Soluciones:**
1. Re-subir imagen en formato JPG/PNG
2. Verificar que el archivo sea menor a 2MB
3. Limpiar caché del sitio
4. Verificar permisos del directorio `moodledata`

#### 🎨 Colores no se aplican
**Causas posibles:**
- Código de color inválido
- CSS personalizado que sobrescribe estilos
- Caché del navegador

**Soluciones:**
1. Usar formato hexadecimal válido (#RRGGBB)
2. Revisar CSS personalizado del tema
3. Limpiar caché del navegador (Ctrl+F5)

#### ⚡ Rendimiento lento
**Causas posibles:**
- TTL de caché muy bajo
- Muchas categorías con imágenes grandes
- Servidor con recursos limitados

**Soluciones:**
1. Aumentar TTL de caché a 600-900 segundos
2. Optimizar imágenes antes de subir
3. Reducir máximo de categorías mostradas
4. Activar caché de Moodle

---

## 🔄 Mantenimiento

### Tareas Regulares

#### 🧹 Limpieza de Archivos
- **Frecuencia:** Mensual
- **Acción:** Revisar archivos huérfanos en `moodledata/filedir`
- **Herramienta:** `Administración del sitio > Desarrollo > Purgar cachés`

#### 📊 Monitoreo de Rendimiento
- **Métricas:** Tiempo de carga del bloque
- **Herramientas:** Logs de Moodle, herramientas de profiling
- **Optimización:** Ajustar TTL de caché según uso

#### 🔄 Actualizaciones
- **Verificar:** Nuevas versiones del plugin
- **Backup:** Siempre respaldar antes de actualizar
- **Testing:** Probar en entorno de desarrollo primero

---

## 📞 Soporte Técnico

### Información del Sistema
- **Versión del Plugin:** 2.0.0
- **Compatibilidad:** Moodle 4.1+
- **Última actualización:** Enero 2025

### Logs y Debugging
**Activar logs detallados:**
1. `Administración del sitio > Desarrollo > Debugging`
2. Establecer nivel a "DEVELOPER"
3. Revisar logs en `Administración del sitio > Reportes > Logs`

### Archivos de Configuración
- **Configuración:** `$CFG->dataroot/cache/cachestore_file/default_application/block_category_courses`
- **Archivos:** `$CFG->dataroot/filedir/[hash]/block_category_courses`
- **Base de datos:** Tabla `block_catcourse_images`

---

## 📈 Mejores Prácticas

### 🎨 Diseño Visual
- **Consistencia:** Usar paleta de colores coherente
- **Contraste:** Asegurar legibilidad de texto sobre colores
- **Imágenes:** Mantener estilo visual uniforme
- **Resolución:** Usar imágenes de alta calidad pero optimizadas

### ⚡ Rendimiento
- **Caché:** Configurar TTL apropiado según frecuencia de cambios
- **Límites:** No mostrar más de 20 categorías por bloque
- **Imágenes:** Optimizar tamaño y formato antes de subir
- **Ubicación:** Colocar bloques estratégicamente en la página

### 👥 Experiencia de Usuario
- **Navegación:** Asegurar que enlaces funcionen correctamente
- **Información:** Mostrar datos relevantes sin sobrecargar
- **Responsive:** Verificar visualización en dispositivos móviles
- **Accesibilidad:** Usar alt text descriptivo en imágenes

---

*Este manual cubre todas las funcionalidades del plugin Category Cards. Para soporte adicional, consultar los logs del sistema o contactar al administrador técnico.*