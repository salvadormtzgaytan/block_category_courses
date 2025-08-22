<?php
defined('MOODLE_INTERNAL') || die();

$string['pluginname'] = 'Tarjetas de Categorías';
$string['notauth'] = 'Debes iniciar sesión para ver tus categorías de cursos.';
$string['privacy:metadata'] = 'El bloque Tarjetas de Categorías no almacena datos personales.';

// Settings
$string['cardstyle'] = 'Estilo de tarjeta';
$string['cardstyle_desc'] = 'Elige el estilo visual para las tarjetas de categoría';
$string['cardstyle_rounded'] = 'Esquinas redondeadas';
$string['cardstyle_flat'] = 'Diseño plano';

$string['showprogress'] = 'Mostrar porcentaje de avance';
$string['showprogress_desc'] = 'Mostrar porcentaje de finalización por categoría';
$string['showdescription'] = 'Mostrar descripción';
$string['showdescription_desc'] = 'Mostrar extracto de descripción de categoría';
$string['showcoursecount'] = 'Mostrar contador de cursos';
$string['showcoursecount_desc'] = 'Mostrar número de cursos inscritos';

$string['sortorder'] = 'Orden de clasificación';
$string['sortorder_desc'] = 'Cómo ordenar las categorías';
$string['sortorder_core'] = 'Orden del núcleo de Moodle';
$string['sortorder_alphabetical'] = 'Alfabético';
$string['sortorder_coursecount'] = 'Número de cursos';
$string['sortorder_progress'] = 'Porcentaje de avance';

$string['includesubcategories'] = 'Incluir subcategorías';
$string['includesubcategories_desc'] = 'Contar cursos de subcategorías';
$string['includehidden'] = 'Incluir cursos ocultos';
$string['includehidden_desc'] = 'Incluir cursos ocultos en los conteos';

$string['maxcategories'] = 'Máximo de categorías';
$string['maxcategories_desc'] = 'Número máximo de categorías a mostrar';
$string['descriptionlimit'] = 'Límite de descripción';
$string['descriptionlimit_desc'] = 'Máximo de caracteres para extracto de descripción';

$string['cachettl'] = 'TTL de caché (segundos)';
$string['cachettl_desc'] = 'Tiempo de vida para caché de usuario/categoría';

$string['nocategories'] = 'No hay categorías disponibles';
$string['coursesenrolled'] = '{$a} cursos inscritos';
$string['completed'] = 'Completado';
$string['viewcategory'] = 'Ver categoría';

// Block configuration
$string['customtitle'] = 'Título personalizado';

// Management page
$string['manageimages'] = 'Gestionar Imágenes de Categorías';
$string['editcategoryimage'] = 'Editar Imagen de Categoría';
$string['categoryimage'] = 'Imagen de Categoría';
$string['categoryimage_help'] = 'Sube una imagen para esta categoría. Formatos soportados: JPG, PNG, GIF, WebP. Tamaño máximo: 2MB.';
$string['categorycolor'] = 'Color de Fondo';

// Status labels
$string['configured'] = 'Configurado';
$string['defaultstatus'] = 'Por defecto';
$string['edit'] = 'Editar';
$string['currentpreview'] = 'Vista previa actual';
$string['categoryupdated'] = 'Categoría actualizada exitosamente';
$string['coursescompleted'] = '{$a->completed} de {$a->total} cursos completados';

// Click behavior
$string['clickbehavior'] = 'Comportamiento del clic';
$string['clickbehavior_category'] = 'Abrir página de categoría';
$string['clickbehavior_courses'] = 'Mostrar lista de cursos';