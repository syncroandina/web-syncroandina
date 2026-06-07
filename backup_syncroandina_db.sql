-- MySQL dump 10.13  Distrib 8.0.42, for Win64 (x86_64)
--
-- Host: 127.0.0.1    Database: syncroandina_db
-- ------------------------------------------------------
-- Server version	8.0.42

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `blog_categories`
--

DROP TABLE IF EXISTS `blog_categories`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `blog_categories` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `slug` (`slug`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `blog_categories`
--

LOCK TABLES `blog_categories` WRITE;
/*!40000 ALTER TABLE `blog_categories` DISABLE KEYS */;
INSERT INTO `blog_categories` VALUES (3,'Ingeniería y Proyectos Eléctricos','ingenieria-y-proyectos-electricos','2026-06-06 22:17:36'),(4,'Operación y Mantenimiento Industrial','operacion-y-mantenimiento-industrial','2026-06-06 22:17:50'),(5,'Suministro y Gestión de Activos','suministro-y-gestion-de-activos','2026-06-06 22:18:04');
/*!40000 ALTER TABLE `blog_categories` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `blog_posts`
--

DROP TABLE IF EXISTS `blog_posts`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `blog_posts` (
  `id` int NOT NULL AUTO_INCREMENT,
  `author_id` int DEFAULT NULL,
  `category_id` int DEFAULT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `excerpt` text COLLATE utf8mb4_unicode_ci,
  `content` longtext COLLATE utf8mb4_unicode_ci,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `image_alt` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `cta_tagline` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `cta_title` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `cta_description` text COLLATE utf8mb4_unicode_ci,
  `cta_btn_text` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` enum('draft','published') COLLATE utf8mb4_unicode_ci DEFAULT 'draft',
  `published_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `slug` (`slug`),
  KEY `author_id` (`author_id`),
  KEY `fk_blog_post_category` (`category_id`),
  CONSTRAINT `blog_posts_ibfk_1` FOREIGN KEY (`author_id`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  CONSTRAINT `fk_blog_post_category` FOREIGN KEY (`category_id`) REFERENCES `blog_categories` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `blog_posts`
--

LOCK TABLES `blog_posts` WRITE;
/*!40000 ALTER TABLE `blog_posts` DISABLE KEYS */;
INSERT INTO `blog_posts` VALUES (2,1,NULL,'Lorem Ipsum 1','lorem-ipsum-1','Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry&amp;#039;s','<p><strong style=\"color: rgb(0, 0, 0);\">Lorem Ipsum</strong>&nbsp;is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p>','/assets/images/blog/812ee5b3dfc32be5.jpeg','',NULL,NULL,NULL,NULL,'published','2026-05-07 06:07:36','2026-05-07 01:07:36','2026-06-03 02:25:58','2026-06-03 07:25:58'),(3,1,NULL,'Lorem Ipsum 2','lorem-ipsum-2','Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry&amp;#039;s','<p><strong style=\"color: rgb(0, 0, 0);\">Lorem Ipsum</strong>&nbsp;is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p>','/assets/images/blog/dd7a1ceaeb610fc1.jpeg','',NULL,NULL,NULL,NULL,'published','2026-05-07 06:08:30','2026-05-07 01:08:30','2026-06-03 02:25:56','2026-06-03 07:25:56'),(4,1,NULL,'Lorem Ipsum 3','lorem-ipsum-3','Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry&amp;#039;s','<p><strong style=\"color: rgb(0, 0, 0);\">Lorem Ipsum</strong>&nbsp;is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p>','assets/images/blog/1eb45708d2fa3804.jpeg',NULL,NULL,NULL,NULL,NULL,'published','2026-05-07 06:08:41','2026-05-07 01:08:39','2026-06-03 02:25:54','2026-06-03 07:25:54'),(5,1,NULL,'Lorem Ipsum 4','lorem-ipsum-4','Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry&amp;amp;#039;s','<p><strong style=\"color: rgb(0, 0, 0);\">Lorem Ipsum</strong>&nbsp;is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p>','assets/images/blog/e2bf74704d76f2d8.jpeg',NULL,NULL,NULL,NULL,NULL,'published','2026-05-07 06:16:04','2026-05-07 01:15:50','2026-06-03 02:25:51','2026-06-03 07:25:51'),(6,1,NULL,'Lorem Ipsum 5','lorem-ipsum-5','Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry&amp;amp;amp;amp;amp;#039;s','<p><strong style=\"color: rgb(0, 0, 0);\">Lorem Ipsum</strong>&nbsp;is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p>','assets/images/blog/d145b7529b7a848c.jpeg','','','','','','published','2026-05-07 06:16:21','2026-05-07 01:16:06','2026-06-03 02:25:49','2026-06-03 07:25:49'),(8,1,3,'Sincronismo Eléctrico: Maximización de la Eficiencia mediante Operación en Paralelo','sincronismo-electrico-maximizacion-de-la-eficiencia-mediante-operacion-en-paralelo','Descubra cómo el sincronismo y paralelismo de grupos electrógenos optimiza el consumo de combustible, duplica la redundancia crítica y asegura la continuidad de la carga en plantas industriales.','<p>En el panorama industrial y minero actual, la demanda de energía no solo es masiva, sino sumamente variable. Tradicionalmente, ante un incremento en la carga, la respuesta común era adquirir un grupo electrógeno de mayor capacidad nominal. Sin embargo, la ingeniería de potencia moderna demuestra que la implementación de un sistema de sincronización de grupos electrógenos para operar en paralelo ofrece ventajas técnicas, operativas y económicas sustancialmente superiores.</p><p><br></p><h2><strong>¿Qué es el Sincronismo y el Paralelismo Eléctrico?</strong></h2><p><br></p><p>La sincronización es el proceso técnico mediante el cual se igualan los parámetros eléctricos de dos o más fuentes de corriente alterna antes de interconectarlas sobre una misma barra común de distribución. Para que este acoplamiento sea seguro y libre de corrientes de circulación destructivas, los controladores digitales deben ajustar con precisión milimétrica cuatro variables críticas:</p><p><br></p><p>- Secuencia de fases: El orden de rotación de las fases debe ser idéntico.</p><p>- Igualdad de voltajes: La amplitud de la tensión entre los equipos debe ser la misma.</p><p>- Frecuencia exacta: Los motores deben girar a la velocidad angular necesaria para igualar los hercios.</p><p>- Ángulo de fase: Las ondas sinusoidales deben estar perfectamente alineadas en el tiempo, es decir, con un desfase cero.</p><p><br></p><h2><strong>Ventajas Operativas del Sincronismo</strong></h2><p><br></p><p>Una de las mayores bondades de este enfoque es la optimización del consumo de combustible. Cuando un único generador de gran tamaño opera con una carga inferior al treinta por ciento de su capacidad, se produce un fenómeno mecánico adverso donde el diésel no se quema por completo, dañando componentes críticos del motor. Con un sistema en sincronismo, la central inteligente monitoriza la demanda real de la planta: si la carga es baja, opera una sola unidad a su máxima eficiencia; si la demanda escala, el sistema arranca de forma automatizada las unidades secundarias, absorbiendo los picos de potencia sin riesgo de apagones.</p><p><br></p><p>Adicionalmente, el sincronismo aporta una redundancia crítica de tipo N+1. Si un motor del sistema experimenta una alerta o requiere una intervención técnica correctiva inmediata, la lógica de control redistribuye la carga de manera transparente entre las unidades remanentes en la barra, garantizando la continuidad absoluta de los procesos de manufactura o extracción sin interrumpir el suministro eléctrico de la empresa.</p>','/assets/images/blog/8fff836f6c7060ba.webp','Tablero de sincronismo industrial con controladores digitales activos y cableado estructurado para sistemas en paralelo.','¿Hablamos de Ingeniería?','Especialistas en Sistemas de Sincronismo','Optimice la infraestructura energética de su empresa. Cotice hoy la fabricación de tableros de sincronismo industrial a medida.','Contactar con un Ingeniero','published','2026-06-07 03:40:44','2026-06-06 22:40:26','2026-06-06 22:42:41',NULL),(9,1,3,'El Cerebro del Respaldo Energético: Diseño y Seguridad en Tableros de Transferencia Automática','el-cerebro-del-respaldo-energetico-diseno-y-seguridad-en-tableros-de-transferencia-automatica','Conozca el rol de los enclavamientos mecánicos y eléctricos y las temporizaciones digitales en el diseño de tableros de transferencia automática de alta confiabilidad.','<p>Disponer de un grupo electrógeno de última generación en óptimas condiciones mecánicas es solo el primer paso para asegurar la continuidad de una empresa. Ante una interrupción intempestiva del suministro eléctrico de la red comercial, la velocidad y la seguridad con la que la infraestructura conmuta la carga hacia la fuente de emergencia es vital. Es en este escenario crítico donde el Tablero de Transferencia Automática (TTA) se consolida como el componente neurálgico del sistema de potencia.</p><p><br></p><h2><strong>Lógica de Control sin Intervención Humana</strong></h2><p><br></p><p>En el entorno industrial moderno, depender de maniobras manuales para restablecer la energía durante un apagón representa pérdidas económicas sustanciales y altos riesgos de seguridad. Un TTA opera monitorizando de manera constante las líneas de la red pública. Al detectar una anomalía, como una caída de fase o una fluctuación de voltaje severa, inicia automáticamente la siguiente secuencia:</p><p><br></p><p>- Envía la orden de arranque inmediato al grupo electrógeno de respaldo.</p><p>- Espera a que los parámetros de tensión y frecuencia del motor estén completamente estabilizados.</p><p>- Ejecuta la conmutación segura de la carga industrial hacia la fuente de emergencia en cuestión de segundos.</p><p><br></p><h2><strong>La Regla de Oro: Enclavamientos de Seguridad</strong></h2><p><br></p><p>El mayor peligro técnico en un sistema de transferencia es la posibilidad de que la energía de la red comercial y la del generador colisionen en la misma barra distribuidora, lo que provocaría un cortocircuito de proporciones catastróficas. Por esta razón, la fabricación de un tablero de transferencia bajo normas de ingeniería estricta exige un sistema de enclavamiento físico de doble seguridad.&nbsp;</p><p><br></p><p>Este sistema combina una barrera mecánica y un enclavamiento eléctrico que imposibilitan por completo que el interruptor motorizado o contactor de la red pública y el del generador se cierren de forma simultánea. Una fuente debe abrirse obligatoriamente antes de que la otra pueda ingresar al circuito de fuerza.</p><p><br></p><h2><strong>Temporizaciones y Retorno Suave de la Red</strong></h2><p><br></p><p>Cuando el suministro público se restablece, suele regresar de forma inestable. Los controladores digitales integrados en el TTA gestionan un tiempo de espera programado o retardo de retransferencia para certificar que la red comercial esté verdaderamente estabilizada antes de devolver la carga. Posteriormente, el tablero mantiene al grupo electrógeno encendido en vacío durante unos minutos en su retardo de enfriamiento, permitiendo disipar el estrés térmico acumulado en el motor antes de su apagado definitivo.</p>','/assets/images/blog/b40cdd933f068d64.webp','Mecanismo de conmutación de un tablero de transferencia automática industrial con barras de cobre aisladas.','Protección de Energía','Tableros de Transferencia Seguros','Evite accidentes por retorno de energía y garantice un cambio de fuente automatizado y bajo norma técnica internacional.','Solicitar Cotización de TTA','published','2026-06-07 03:51:51','2026-06-06 22:51:51','2026-06-06 22:51:51',NULL),(10,1,4,'Protocolos Críticos en el Mantenimiento Preventivo de Grupos Electrógenos','protocolos-criticos-en-el-mantenimiento-preventivo-de-grupos-electrogenos','Conozca las rutinas esenciales de inspección en sistemas de combustible, baterías y refrigeración para evitar paradas críticas y garantizar el arranque de emergencia.','<p>En el sector industrial, la continuidad de las operaciones depende directamente de la confiabilidad de los sistemas de energía de respaldo. Un grupo electrógeno que no arranca durante una falla de la red comercial puede traducirse en pérdidas económicas críticas. Por ello, implementar un programa de mantenimiento preventivo estructurado bajo normas de ingeniería es una inversión estratégica para proteger sus activos.</p><p><br></p><h2><strong>Puntos Críticos en el Sistema de Combustible</strong></h2><p><br></p><p>Uno de los puntos más vulnerables en los equipos de generación térmica es el almacenamiento prolongado del combustible. El diésel tiende a acumular humedad por condensación dentro de los tanques, lo que fomenta la proliferación de bacterias y la formación de sedimentos que obstruyen los sistemas de inyección.</p><p><br></p><p>Para mitigar esto, el protocolo preventivo debe incluir:</p><p>- Purga constante de agua en los filtros separadores.</p><p>- Reemplazo periódico de los elementos filtrantes según las horas de marcha o el tiempo de caducidad.</p><p>- Inspección de las líneas de retorno para evitar el ingreso de aire al circuito de alta presión.</p><p><br></p><h2><strong>Gestión y Diagnóstico del Sistema Eléctrico de Arranque</strong></h2><p><br></p><p>Las estadísticas demuestran que la mayoría de las fallas de arranque se deben a deficiencias en el sistema de baterías. Durante las visitas de inspección programadas, es obligatorio medir el voltaje en flotación y asegurar que el cargador estático mantenga los parámetros nominales sin sobrecargar las celdas. Asimismo, el reapriete y la limpieza de los bornes eliminan las resistencias parásitas que limitan el torque inicial en el encendido de emergencia.</p><p><br></p><h2><strong>Monitoreo Térmico y Propiedades del Refrigerante</strong></h2><p><br></p><p>Los motores diésel de gran potencia operan bajo regímenes térmicos severos. El refrigerante industrial no solo evita el sobrecalentamiento, sino que contiene aditivos anticavitación que protegen las camisas de los cilindros. Verificar la concentración del refrigerante y el estado de las fajas de la bomba de agua garantiza que el flujo de disipación térmica sea constante, previniendo fallas mayores en la culata por choque térmico.</p>','/assets/images/blog/433b2bb1f60248e2.webp','Técnico revisando niveles y estado del sistema de filtración en un grupo electrógeno industrial.','Evite Apagones','Planes de Mantenimiento Anual','Asegure la operatividad de sus equipos de generación con inspecciones programadas a cargo de ingenieros especialistas.','Cotizar Plan Preventivo','published','2026-06-07 04:00:17','2026-06-06 23:00:17','2026-06-06 23:00:17',NULL),(11,1,4,'Cuándo Programar un Overhaul o Reparación Mayor en Motores Diésel','cuando-programar-un-overhaul-o-reparacion-mayor-en-motores-diesel','Identifique las señales de desgaste técnico y los criterios de horas operativas para planificar la reconstrucción mayor de sus sistemas de generación.','<p>Todo motor de combustión interna utilizado en aplicaciones de generación eléctrica pesada posee un ciclo de vida útil definido por el fabricante. Al alcanzar este límite, o ante la presencia de desgastes severos, se vuelve indispensable realizar una reparación mayor o reconstrucción completa, un proceso conocido técnicamente en el sector industrial como Overhaul.</p><p><br></p><h2><strong>Criterios de Horas Operativas y Ciclo de Vida</strong></h2><p><br></p><p>El indicador primario para planificar una reparación mayor es el contador de horas de marcha del equipo. Por lo general, los motores industriales de alta potencia requieren una evaluación de Overhaul entre las doce mil y veinte mil horas de operación, dependiendo estrictamente del régimen de trabajo (ya sea como respaldo de emergencia o como generación continua) y de la rigurosidad de los mantenimientos preventivos previos.</p><p><br></p><h2><strong>Síntomas Técnicos de Desgaste Crítico</strong></h2><p><br></p><p>Más allá del horómetro, existen señales físicas detectadas en campo que alertan sobre la necesidad inmediata de una reconstrucción mayor para evitar una falla catastrófica:</p><p>- Pérdida notable de compresión y caída en la entrega de potencia nominal.</p><p>- Consumo excesivo de aceite lubricante acompañado de humo azul persistente por el escape.</p><p>- Presencia de partículas metálicas en el análisis químico de laboratorio del aceite usado.</p><p>- Incremento en la presión del cárter debido al soplado de gases de combustión hacia el interior del bloque.</p><p><br></p><h2><strong>El Proceso de Reconstrucción Bajo Norma de Ingeniería</strong></h2><p><br></p><p>Un Overhaul riguroso exige el desmontaje total del motor para realizar metrología de precisión en el cigüeñal y el bloque. El proceso técnico incluye el reemplazo integral de los componentes de desgaste interno mediante la instalación de camisas de cilindro nuevas, pistones, anillos, cojinetes de biela y bancada. Asimismo, se realiza la reconstrucción completa de las culatas, calibración del sistema de inyección y el mantenimiento del turbocompresor para devolver al activo sus parámetros de fábrica y asegurar otra etapa extendida de estabilidad energética.</p>','/assets/images/blog/9c75e09725b9e43e.webp','Bloque de motor diésel industrial desensamblado en taller para proceso de reparación mayor.','Soporte de Ingeniería','Reconstrucción Mayor de Motores','Devuelva la potencia original y la confiabilidad a sus grupos electrógenos con nuestro servicio especializado de Overhaul.','Solicitar Evaluación de Motor','published','2026-06-07 04:06:14','2026-06-06 23:06:10','2026-06-06 23:06:14',NULL),(12,1,5,'Criterios Técnicos para la Selección de Repuestos Críticos en Sistemas de Generación','criterios-tecnicos-para-la-seleccion-de-repuestos-criticos-en-sistemas-de-generacion','Descubra cómo identificar componentes de alta confiabilidad y optimizar el inventario de seguridad para mitigar el riesgo de paradas inesperadas en su planta.','<p>En la gestión de activos energéticos, la disponibilidad de repuestos correctos en el momento preciso es la línea de defensa más sólida contra las paradas de planta no programadas. Un inventario desabastecido o la adquisición de componentes que no cumplen con las tolerancias de ingeniería exactas comprometen la confiabilidad del sistema de respaldo, elevando exponencialmente los costos operativos a mediano plazo.</p><p><br></p><h2><strong>La Importancia de los Consumibles de Alta Eficiencia</strong></h2><p><br></p><p>El rendimiento de un motor de gran potencia está ligado directamente a la calidad de sus fluidos y elementos de filtración. Los filtros de combustible y separadores de agua deben poseer la capacidad micrométrica necesaria para retener partículas imperceptibles que, de lo contrario, desgastarían prematuramente las toberas de los inyectores de alta presión. Asimismo, utilizar elementos de filtración de aire certificados asegura que el flujo de admisión esté libre de impurezas abrasivas, protegiendo las sutiles aspas del turbocompresor y los anillos de los pistones.</p><p><br></p><h2><strong>Componentes Electrónicos de Control y Regulación de Voltaje</strong></h2><p><br></p><p>El desgaste en un grupo electrógeno no solo es mecánico; los componentes eléctricos y electrónicos sufren estrés térmico constante. Disponer de repuestos críticos en el sistema de control, como reguladores automáticos de voltaje (AVR) y sensores de presión o temperatura, es indispensable. Una tarjeta AVR inestable o defectuosa puede causar fluctuaciones de tensión severas que no solo dispararán las protecciones del generador, sino que pueden dañar la maquinaria sensible conectada a la red interna de la empresa.</p><p><br></p><h2><strong>Estructuración de un Inventario de Seguridad Eficiente</strong></h2><p><br></p><p>Para optimizar la gestión de activos, el departamento de mantenimiento debe estructurar un inventario de seguridad basado en la criticidad y el tiempo de reposición de las piezas. Las categorías se deben dividir en:</p><p>- Consumibles de alta rotación: Filtros, fajas de transmisión, mangueras y lubricantes para las rutinas preventivas programadas.</p><p>- Componentes de respuesta rápida: Sensores de bloque, relés de potencia, termostatos y cargadores estáticos de baterías.</p><p>- Repuestos de contingencia mayor: Kits de empaquetaduras de culata, solenoides de parada e inyectores de reemplazo directo.</p>','/assets/images/blog/bca50a4d1cfd7e83.webp','Componentes mecánicos y electrónicos de repuesto organizados para mantenimiento de sistemas de potencia.','Stock Garantizado','Suministro Especializado de Repuestos','Asegure la compatibilidad exacta y la máxima vida útil de sus equipos. Solicite una cotización de repuestos con el número de serie de su motor.','Cotizar Repuestos Ahora','published','2026-06-07 04:23:14','2026-06-06 23:23:14','2026-06-06 23:23:14',NULL),(13,1,5,'Importancia del Dimensionamiento Energético en Proyectos de Ingeniería Llave en Mano','importancia-del-dimensionamiento-energetico-en-proyectos-de-ingenieria-llave-en-mano','Evite los altos costos del sobredimensionamiento o los riesgos técnicos de la falta de potencia mediante una correcta evaluación de cargas y perfiles de demanda.','<p>La planificación e implementación de una planta de generación electromecánica representa una inversión de capital significativa para cualquier organización industrial o minera. El éxito técnico y financiero de estos proyectos radica en la etapa inicial de ingeniería conceptual, específicamente en la correcta evaluación de la demanda de carga y el dimensionamiento preciso del equipamiento térmico y de control.</p><p><br></p><h2><strong>Los Riesgos de un Dimensionamiento Incorrecto</strong></h2><p><br></p><p>Un error común en la gestión de proyectos es optar por el sobredimensionamiento preventivo de los equipos bajo la premisa de \"asegurar el suministro\". Sin embargo, operar motores diésel de gran potencia a cargas ligeras (inferiores al treinta por ciento de su capacidad nominal) reduce drásticamente la temperatura de combustión interna. Esto provoca una combustión incompleta que acumula carbón en las válvulas y genera fugas de combustible por el escape, acortando severamente el intervalo de vida útil del activo.</p><p><br></p><p>Por el contrario, un diseño subdimensionado genera caídas de voltaje y variaciones de frecuencia insostenibles cuando las máquinas de alta demanda o los motores de gran torque de la planta intentan arrancar, provocando apagones automáticos debido a la actuación de los relés de protección por sobrecarga.</p><p><br></p><h2><strong>Análisis del Perfil de Demanda y Tipos de Carga</strong></h2><p><br></p><p>Un correcto dimensionamiento de soluciones energéticas a medida requiere recopilar y analizar datos crudos en campo mediante analizadores de redes. No basta con sumar las potencias nominales de los equipos; es obligatorio mapear:</p><p>- Cargas lineales y no lineales: Identificar la presencia de variadores de frecuencia, sistemas UPS o equipos electrónicos que introducen distorsión armónica al sistema.</p><p>- Picos de arranque (Inrush currents): Cuantificar las corrientes transitorias que exigen los motores eléctricos de gran envergadura al encender.</p><p>- Factor de potencia global: Evaluar la energía reactiva para diseñar bancos de condensadores o filtros que optimicen el rendimiento de la barra común.</p><p><br></p><h2><strong>La Integración de Soluciones Electromecánicas Completa</strong></h2><p><br></p><p>El dimensionamiento final determina no solo los kW del generador, sino las especificaciones del sistema de combustible, los ductos de ventilación forzada para disipación térmica en la sala de máquinas y la estructura de los tableros de transferencia y distribución. Abordar el proyecto desde una perspectiva integral garantiza un sistema balanceado, seguro, alineado a las normativas vigentes y preparado para absorber futuras expansiones de carga de manera escalable.</p>','/assets/images/blog/5d0e458a65b75238.webp','Planos de ingeniería eléctrica y equipo de medición sobre una mesa de trabajo en una oficina técnica.','Ingeniería a Medida','Asesoría en Proyectos Energéticos','Diseñe una infraestructura eléctrica robusta y eficiente. Solicite un estudio de demanda energética con nuestro equipo técnico calificado.','Solicitar Consultoría Técnica','published','2026-06-07 04:28:16','2026-06-06 23:28:16','2026-06-06 23:29:38',NULL);
/*!40000 ALTER TABLE `blog_posts` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `branding`
--

DROP TABLE IF EXISTS `branding`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `branding` (
  `id` int NOT NULL AUTO_INCREMENT,
  `primary_color` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT '#0f172a',
  `secondary_color` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT '#3b82f6',
  `accent_color` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT '#0ea5e9',
  `font_family` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT 'Inter',
  `favicon_path` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `branding`
--

LOCK TABLES `branding` WRITE;
/*!40000 ALTER TABLE `branding` DISABLE KEYS */;
/*!40000 ALTER TABLE `branding` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `call_center_contacts`
--

DROP TABLE IF EXISTS `call_center_contacts`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `call_center_contacts` (
  `id` int NOT NULL AUTO_INCREMENT,
  `title` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `subtitle` varchar(150) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `type` enum('whatsapp','phone') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'whatsapp',
  `phone_number` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `order_index` int DEFAULT '0',
  `is_active` tinyint(1) DEFAULT '1',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `call_center_contacts`
--

LOCK TABLES `call_center_contacts` WRITE;
/*!40000 ALTER TABLE `call_center_contacts` DISABLE KEYS */;
INSERT INTO `call_center_contacts` VALUES (1,'Pablo','Area comercial','whatsapp','51933178568',1,1,'2026-05-11 19:25:48','2026-05-21 17:31:53'),(2,'Pablo','Area comercial','phone','51933178568',2,1,'2026-05-11 19:27:12','2026-05-21 17:31:47');
/*!40000 ALTER TABLE `call_center_contacts` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `clients_logos`
--

DROP TABLE IF EXISTS `clients_logos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `clients_logos` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `logo_path` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `image_alt` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `sort_order` int DEFAULT '0',
  `is_active` tinyint DEFAULT '1',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=33 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `clients_logos`
--

LOCK TABLES `clients_logos` WRITE;
/*!40000 ALTER TABLE `clients_logos` DISABLE KEYS */;
INSERT INTO `clients_logos` VALUES (8,'1','/uploads/clients/client_6a24ca80eaac1.jpg','',1,1,'2026-06-07 01:33:52','2026-06-07 01:33:52'),(9,'2','/uploads/clients/client_6a24ca8b1f285.jpg','',2,1,'2026-06-07 01:34:03','2026-06-07 01:34:03'),(10,'3','/uploads/clients/client_6a24cab75bd3a.jpg','',3,1,'2026-06-07 01:34:47','2026-06-07 01:34:47'),(11,'4','/uploads/clients/client_6a24cac5728c8.jpg','',4,1,'2026-06-07 01:35:01','2026-06-07 01:35:01'),(12,'5','/uploads/clients/client_6a24cb02d8c91.jpg','',5,1,'2026-06-07 01:36:02','2026-06-07 01:36:02'),(13,'6','/uploads/clients/client_6a24cde339bb6.jpg','',6,1,'2026-06-07 01:48:19','2026-06-07 01:48:19'),(14,'7','/uploads/clients/client_6a24cdf533f3f.jpg','',7,1,'2026-06-07 01:48:37','2026-06-07 01:48:37'),(15,'8','/uploads/clients/client_6a24ce1d5776a.jpg','',8,1,'2026-06-07 01:49:17','2026-06-07 01:49:17'),(16,'9','/uploads/clients/client_6a24ce293f105.jpg','',9,1,'2026-06-07 01:49:29','2026-06-07 01:49:29'),(17,'10','/uploads/clients/client_6a24cf80b51ce.jpg','',10,1,'2026-06-07 01:55:12','2026-06-07 01:55:12'),(18,'11','/uploads/clients/client_6a24cf9705c7a.jpg','',11,1,'2026-06-07 01:55:35','2026-06-07 01:55:35'),(19,'12','/uploads/clients/client_6a24cfadd0bb0.jpg','',12,1,'2026-06-07 01:55:57','2026-06-07 01:55:57'),(20,'13','/uploads/clients/client_6a24cfdb7de94.jpg','',13,1,'2026-06-07 01:56:43','2026-06-07 01:56:43'),(21,'14','/uploads/clients/client_6a24cfe5ea7e7.jpg','',14,1,'2026-06-07 01:56:53','2026-06-07 01:56:53'),(22,'15','/uploads/clients/client_6a24cff14b9bb.jpg','',15,1,'2026-06-07 01:57:05','2026-06-07 01:57:05'),(23,'16','/uploads/clients/client_6a24d08babc63.jpg','',16,1,'2026-06-07 01:59:39','2026-06-07 01:59:39'),(24,'17','/uploads/clients/client_6a24d097a6798.jpg','',17,1,'2026-06-07 01:59:51','2026-06-07 01:59:51'),(25,'18','/uploads/clients/client_6a24d0cc3c446.jpg','',18,1,'2026-06-07 02:00:44','2026-06-07 02:00:44'),(26,'19','/uploads/clients/client_6a24d0dac1d65.jpg','',19,1,'2026-06-07 02:00:58','2026-06-07 02:00:58'),(27,'20','/uploads/clients/client_6a24d0e63912d.jpg','',20,1,'2026-06-07 02:01:10','2026-06-07 02:01:10'),(28,'21','/uploads/clients/client_6a24d0f27c67d.jpg','',21,1,'2026-06-07 02:01:22','2026-06-07 02:01:22'),(29,'22','/uploads/clients/client_6a24d101061e2.jpg','',22,1,'2026-06-07 02:01:37','2026-06-07 02:01:37'),(30,'23','/uploads/clients/client_6a24d10e7e216.jpg','',23,1,'2026-06-07 02:01:50','2026-06-07 02:01:50'),(31,'24','/uploads/clients/client_6a24d11a9dc7d.jpg','',24,1,'2026-06-07 02:02:02','2026-06-07 02:02:02'),(32,'25','/uploads/clients/client_6a24d127b5b61.jpg','',25,1,'2026-06-07 02:02:15','2026-06-07 02:02:15');
/*!40000 ALTER TABLE `clients_logos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `contacts`
--

DROP TABLE IF EXISTS `contacts`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `contacts` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `subject` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `message` text COLLATE utf8mb4_unicode_ci,
  `is_read` tinyint(1) DEFAULT '0',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `client_type` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT 'persona',
  `ruc` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `service_id` int DEFAULT NULL,
  `project_id` int DEFAULT NULL,
  `product_id` int DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `service_id` (`service_id`),
  KEY `project_id` (`project_id`),
  KEY `product_id` (`product_id`),
  CONSTRAINT `contacts_ibfk_1` FOREIGN KEY (`service_id`) REFERENCES `services_pages` (`id`) ON DELETE SET NULL,
  CONSTRAINT `contacts_ibfk_2` FOREIGN KEY (`project_id`) REFERENCES `projects` (`id`) ON DELETE SET NULL,
  CONSTRAINT `contacts_ibfk_3` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `contacts`
--

LOCK TABLES `contacts` WRITE;
/*!40000 ALTER TABLE `contacts` DISABLE KEYS */;
/*!40000 ALTER TABLE `contacts` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `footer_config`
--

DROP TABLE IF EXISTS `footer_config`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `footer_config` (
  `id` int NOT NULL AUTO_INCREMENT,
  `about_text` text COLLATE utf8mb4_unicode_ci,
  `address` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `social_links` json DEFAULT NULL,
  `copyright_text` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `footer_config`
--

LOCK TABLES `footer_config` WRITE;
/*!40000 ALTER TABLE `footer_config` DISABLE KEYS */;
/*!40000 ALTER TABLE `footer_config` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `forms`
--

DROP TABLE IF EXISTS `forms`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `forms` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `destination_email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `success_message` text COLLATE utf8mb4_unicode_ci,
  `is_active` tinyint(1) DEFAULT '1',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `forms`
--

LOCK TABLES `forms` WRITE;
/*!40000 ALTER TABLE `forms` DISABLE KEYS */;
/*!40000 ALTER TABLE `forms` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `gallery`
--

DROP TABLE IF EXISTS `gallery`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `gallery` (
  `id` int NOT NULL AUTO_INCREMENT,
  `project_id` int DEFAULT NULL,
  `image_path` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `image_alt` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `caption` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `order_index` int DEFAULT '0',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `project_id` (`project_id`),
  CONSTRAINT `gallery_ibfk_1` FOREIGN KEY (`project_id`) REFERENCES `projects` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=52 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `gallery`
--

LOCK TABLES `gallery` WRITE;
/*!40000 ALTER TABLE `gallery` DISABLE KEYS */;
INSERT INTO `gallery` VALUES (3,9,'/assets/images/projects/gallery/a20dab5c4910b92d.webp','',NULL,99,'2026-06-07 03:42:37','2026-06-07 03:46:49'),(4,9,'/assets/images/projects/gallery/286fe5e9583834c7.webp','',NULL,99,'2026-06-07 03:42:37','2026-06-07 03:46:49'),(5,9,'/assets/images/projects/gallery/47ffc266cd5ae03b.webp','',NULL,99,'2026-06-07 03:42:37','2026-06-07 03:46:49'),(6,9,'/assets/images/projects/gallery/83859853a9db5af9.webp','',NULL,99,'2026-06-07 03:42:37','2026-06-07 03:46:49'),(7,9,'/assets/images/projects/gallery/d7e26036450828ef.webp','',NULL,99,'2026-06-07 03:42:37','2026-06-07 03:46:49'),(8,9,'/assets/images/projects/gallery/251a26ac94e1040b.webp','',NULL,99,'2026-06-07 03:42:37','2026-06-07 03:46:49'),(9,9,'/assets/images/projects/gallery/5faabe8263b48c5a.webp','',NULL,99,'2026-06-07 03:42:37','2026-06-07 03:46:49'),(10,10,'/assets/images/projects/gallery/cbe3ec0f55c8a0d6.jpg','',NULL,99,'2026-06-07 03:53:07','2026-06-07 03:59:27'),(11,10,'/assets/images/projects/gallery/a9dcf8770ae647e3.jpg','',NULL,99,'2026-06-07 03:53:07','2026-06-07 03:59:27'),(12,10,'/assets/images/projects/gallery/60d277880377e086.jpg','',NULL,99,'2026-06-07 03:53:07','2026-06-07 03:59:27'),(13,11,'/assets/images/projects/gallery/0476022bb5bdf9a0.webp',NULL,NULL,99,'2026-06-07 04:06:25','2026-06-07 04:06:25'),(14,11,'/assets/images/projects/gallery/d118b10a31a125fe.webp',NULL,NULL,99,'2026-06-07 04:06:25','2026-06-07 04:06:25'),(15,11,'/assets/images/projects/gallery/87858cb2ad1de823.webp',NULL,NULL,99,'2026-06-07 04:06:25','2026-06-07 04:06:25'),(16,12,'/assets/images/projects/gallery/73a2b8f5e10c48ae.webp','',NULL,99,'2026-06-07 04:14:23','2026-06-07 04:20:18'),(17,12,'/assets/images/projects/gallery/9b7d3676e9b5967e.webp','',NULL,99,'2026-06-07 04:14:23','2026-06-07 04:20:18'),(18,12,'/assets/images/projects/gallery/c855bb4d64474e33.webp','',NULL,99,'2026-06-07 04:14:23','2026-06-07 04:20:18'),(19,12,'/assets/images/projects/gallery/3b0f70d71d9a0677.webp','',NULL,99,'2026-06-07 04:14:23','2026-06-07 04:20:18'),(20,12,'/assets/images/projects/gallery/5ccd0e1f76e4e236.webp','',NULL,99,'2026-06-07 04:14:23','2026-06-07 04:20:18'),(21,12,'/assets/images/projects/gallery/6446aba12a06dc48.webp','',NULL,99,'2026-06-07 04:14:23','2026-06-07 04:20:18'),(22,12,'/assets/images/projects/gallery/90fffa7b634cd353.webp','',NULL,99,'2026-06-07 04:14:23','2026-06-07 04:20:18'),(23,12,'/assets/images/projects/gallery/e91ed36829aa4159.webp','',NULL,99,'2026-06-07 04:14:23','2026-06-07 04:20:18'),(24,12,'/assets/images/projects/gallery/a882cdd78bdd74ae.webp','',NULL,99,'2026-06-07 04:14:23','2026-06-07 04:20:18'),(25,12,'/assets/images/projects/gallery/6d1dc3cd73a797e3.webp','',NULL,99,'2026-06-07 04:14:23','2026-06-07 04:20:18'),(26,12,'/assets/images/projects/gallery/d12d4cd0497b7b43.webp','',NULL,99,'2026-06-07 04:14:23','2026-06-07 04:20:18'),(27,13,'/assets/images/projects/gallery/e8ead9450078f5db.webp',NULL,NULL,99,'2026-06-07 04:28:02','2026-06-07 04:28:02'),(28,13,'/assets/images/projects/gallery/db52dd09f99c206c.webp',NULL,NULL,99,'2026-06-07 04:28:02','2026-06-07 04:28:02'),(29,13,'/assets/images/projects/gallery/923f57bea6510192.webp',NULL,NULL,99,'2026-06-07 04:28:02','2026-06-07 04:28:02'),(30,13,'/assets/images/projects/gallery/105b13e19907429c.webp',NULL,NULL,99,'2026-06-07 04:28:02','2026-06-07 04:28:02'),(31,13,'/assets/images/projects/gallery/4aae5d66984a1782.webp',NULL,NULL,99,'2026-06-07 04:28:02','2026-06-07 04:28:02'),(32,14,'/assets/images/projects/gallery/c7bf687ecca8ccb8.webp',NULL,NULL,99,'2026-06-07 04:36:28','2026-06-07 04:36:28'),(33,14,'/assets/images/projects/gallery/7bd4593291af63ba.webp',NULL,NULL,99,'2026-06-07 04:36:28','2026-06-07 04:36:28'),(34,14,'/assets/images/projects/gallery/3865de7e08738399.webp',NULL,NULL,99,'2026-06-07 04:36:28','2026-06-07 04:36:28'),(35,14,'/assets/images/projects/gallery/53f138b50bded4f1.webp',NULL,NULL,99,'2026-06-07 04:36:28','2026-06-07 04:36:28'),(36,14,'/assets/images/projects/gallery/34673794335912f4.webp',NULL,NULL,99,'2026-06-07 04:36:28','2026-06-07 04:36:28'),(37,14,'/assets/images/projects/gallery/d907868bdf8e1358.webp',NULL,NULL,99,'2026-06-07 04:36:28','2026-06-07 04:36:28'),(38,15,'/assets/images/projects/gallery/2fa43f444dc91c10.webp',NULL,NULL,99,'2026-06-07 04:52:13','2026-06-07 04:52:13'),(39,15,'/assets/images/projects/gallery/6bf3dc9423ab647b.webp',NULL,NULL,99,'2026-06-07 04:52:13','2026-06-07 04:52:13'),(40,15,'/assets/images/projects/gallery/d1c013001159170e.webp',NULL,NULL,99,'2026-06-07 04:52:13','2026-06-07 04:52:13'),(41,15,'/assets/images/projects/gallery/402de995ae62f0fd.webp',NULL,NULL,99,'2026-06-07 04:52:13','2026-06-07 04:52:13'),(42,15,'/assets/images/projects/gallery/f1560f731638f5a1.webp',NULL,NULL,99,'2026-06-07 04:52:13','2026-06-07 04:52:13'),(43,15,'/assets/images/projects/gallery/f00840ce7b59299f.webp',NULL,NULL,99,'2026-06-07 04:52:13','2026-06-07 04:52:13'),(44,15,'/assets/images/projects/gallery/687b7ed4980934d9.webp',NULL,NULL,99,'2026-06-07 04:52:13','2026-06-07 04:52:13'),(45,15,'/assets/images/projects/gallery/bfc4eb1803f6cc80.webp',NULL,NULL,99,'2026-06-07 04:52:13','2026-06-07 04:52:13'),(46,16,'/assets/images/projects/gallery/a580d593bc48639d.webp',NULL,NULL,99,'2026-06-07 05:06:42','2026-06-07 05:06:42'),(47,16,'/assets/images/projects/gallery/e5999fd8a5db56e7.webp',NULL,NULL,99,'2026-06-07 05:06:42','2026-06-07 05:06:42'),(48,16,'/assets/images/projects/gallery/34c289d48ab6e522.webp',NULL,NULL,99,'2026-06-07 05:06:42','2026-06-07 05:06:42'),(49,16,'/assets/images/projects/gallery/fc4a75b17deeed43.webp',NULL,NULL,99,'2026-06-07 05:06:42','2026-06-07 05:06:42'),(50,16,'/assets/images/projects/gallery/1a41583a9174b945.webp',NULL,NULL,99,'2026-06-07 05:06:42','2026-06-07 05:06:42'),(51,16,'/assets/images/projects/gallery/48af8e8d44dbdd3d.webp',NULL,NULL,99,'2026-06-07 05:06:42','2026-06-07 05:06:42');
/*!40000 ALTER TABLE `gallery` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `header_config`
--

DROP TABLE IF EXISTS `header_config`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `header_config` (
  `id` int NOT NULL AUTO_INCREMENT,
  `logo_path` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `menu_json` json DEFAULT NULL,
  `is_sticky` tinyint(1) DEFAULT '1',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `header_config`
--

LOCK TABLES `header_config` WRITE;
/*!40000 ALTER TABLE `header_config` DISABLE KEYS */;
/*!40000 ALTER TABLE `header_config` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `home_gallery`
--

DROP TABLE IF EXISTS `home_gallery`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `home_gallery` (
  `id` int NOT NULL AUTO_INCREMENT,
  `image_path` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `image_alt` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `order_index` int DEFAULT '0',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `home_gallery`
--

LOCK TABLES `home_gallery` WRITE;
/*!40000 ALTER TABLE `home_gallery` DISABLE KEYS */;
/*!40000 ALTER TABLE `home_gallery` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `interactions`
--

DROP TABLE IF EXISTS `interactions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `interactions` (
  `id` int NOT NULL AUTO_INCREMENT,
  `interaction_type` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `url` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `interactions`
--

LOCK TABLES `interactions` WRITE;
/*!40000 ALTER TABLE `interactions` DISABLE KEYS */;
/*!40000 ALTER TABLE `interactions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `menu_links`
--

DROP TABLE IF EXISTS `menu_links`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `menu_links` (
  `id` int NOT NULL AUTO_INCREMENT,
  `title` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `url` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `order_index` int DEFAULT '0',
  `is_active` tinyint(1) DEFAULT '1',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `parent_id` int DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_menu_parent` (`parent_id`),
  CONSTRAINT `fk_menu_parent` FOREIGN KEY (`parent_id`) REFERENCES `menu_links` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `menu_links`
--

LOCK TABLES `menu_links` WRITE;
/*!40000 ALTER TABLE `menu_links` DISABLE KEYS */;
INSERT INTO `menu_links` VALUES (1,'Inicio','/',1,1,'2026-05-05 04:18:37','2026-05-25 15:16:23',NULL),(2,'La Empresa','/nosotros',2,1,'2026-05-05 04:18:37','2026-05-25 15:16:23',NULL),(3,'Servicios','/servicios',3,1,'2026-05-05 04:18:37','2026-05-05 21:52:41',NULL),(4,'Proyectos','/proyectos',5,1,'2026-05-05 04:18:37','2026-05-13 23:07:16',NULL),(5,'Blog','/blog',6,1,'2026-05-05 04:18:37','2026-05-13 23:07:16',NULL),(6,'Contacto','/contacto',7,1,'2026-05-05 04:18:37','2026-05-25 15:16:17',NULL),(7,'Repuestos','/repuestos',4,1,'2026-05-13 23:07:16','2026-05-13 23:07:16',NULL);
/*!40000 ALTER TABLE `menu_links` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `migrations` (
  `id` int NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `executed_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=34 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `migrations`
--

LOCK TABLES `migrations` WRITE;
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
INSERT INTO `migrations` VALUES (1,'01_create_users_table.php','2026-05-05 04:18:37'),(2,'02_create_services_templates_table.php','2026-05-05 04:18:37'),(3,'03_create_services_pages_table.php','2026-05-05 04:18:37'),(4,'04_create_projects_table.php','2026-05-05 04:18:37'),(5,'05_create_gallery_table.php','2026-05-05 04:18:37'),(6,'06_create_blog_posts_table.php','2026-05-05 04:18:37'),(7,'07_create_contacts_table.php','2026-05-05 04:18:37'),(8,'08_create_forms_table.php','2026-05-05 04:18:37'),(9,'09_create_sliders_table.php','2026-05-05 04:18:37'),(10,'10_create_scripts_table.php','2026-05-05 04:18:37'),(11,'11_create_whatsapp_numbers_table.php','2026-05-05 04:18:37'),(12,'12_create_header_config_table.php','2026-05-05 04:18:37'),(13,'13_create_footer_config_table.php','2026-05-05 04:18:37'),(14,'14_create_branding_table.php','2026-05-05 04:18:37'),(15,'15_create_settings_table.php','2026-05-05 04:18:37'),(16,'16_create_menu_links_table.php','2026-05-05 04:18:37'),(17,'17_alter_menu_links_add_parent.php','2026-05-05 04:31:50'),(18,'17_create_service_details_tables.php','2026-05-05 16:42:21'),(19,'18_alter_services_pages_add_sort_order.php','2026-05-05 21:28:44'),(20,'19_alter_services_pages_add_seo_headings.php','2026-05-05 22:50:13'),(21,'20_add_custom_fields_to_projects.php','2026-05-06 03:39:50'),(22,'21_alter_contacts_add_conditional_fields.php','2026-05-07 16:51:59'),(23,'22_create_clients_logos_table.php','2026-05-07 21:43:04'),(24,'23_add_alt_text_to_images.php','2026-05-11 15:09:20'),(25,'24_create_home_gallery_table.php','2026-05-11 16:40:17'),(26,'25_create_blog_categories_table.php','2026-05-11 18:25:27'),(27,'26_alter_blog_posts_add_category.php','2026-05-11 18:25:27'),(28,'27_create_products_tables.php','2026-05-13 22:38:25'),(29,'28_create_analytics_tables.php','2026-05-17 16:30:28'),(30,'29_alter_contacts_add_project_product_fields.php','2026-05-17 19:02:41'),(31,'30_alter_sliders_add_button2_fields.php','2026-05-17 19:25:59'),(32,'31_alter_scripts_add_page_restriction.php','2026-05-21 00:37:25'),(33,'27_alter_blog_posts_add_cta_fields.php','2026-05-21 16:42:31');
/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `page_views`
--

DROP TABLE IF EXISTS `page_views`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `page_views` (
  `id` int NOT NULL AUTO_INCREMENT,
  `page_type` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `entity_id` int DEFAULT NULL,
  `url` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `page_views`
--

LOCK TABLES `page_views` WRITE;
/*!40000 ALTER TABLE `page_views` DISABLE KEYS */;
INSERT INTO `page_views` VALUES (1,'home',NULL,'/','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36','2026-06-07 19:10:10'),(2,'home',NULL,'/','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36','2026-06-07 19:10:14'),(3,'home',NULL,'/','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36','2026-06-07 19:11:13'),(4,'home',NULL,'/','::1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36','2026-06-07 19:11:15'),(5,'home',NULL,'/','::1','Go-http-client/1.1','2026-06-07 20:55:26'),(6,'products',NULL,'/repuestos','::1','Go-http-client/1.1','2026-06-07 21:00:16'),(7,'blog_index',NULL,'/blog','::1','Go-http-client/1.1','2026-06-07 21:00:37'),(8,'projects',NULL,'/proyectos','::1','Go-http-client/1.1','2026-06-07 21:00:51');
/*!40000 ALTER TABLE `page_views` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `product_categories`
--

DROP TABLE IF EXISTS `product_categories`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `product_categories` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `slug` (`slug`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `product_categories`
--

LOCK TABLES `product_categories` WRITE;
/*!40000 ALTER TABLE `product_categories` DISABLE KEYS */;
INSERT INTO `product_categories` VALUES (6,'Filtros','filtros','2026-06-07 19:15:55','2026-06-07 19:15:55'),(7,'Controladores','controladores','2026-06-07 19:24:41','2026-06-07 19:24:41'),(8,'Protecciones','protecciones','2026-06-07 19:24:50','2026-06-07 19:24:50'),(9,'Arranque','arranque','2026-06-07 19:24:57','2026-06-07 19:24:57');
/*!40000 ALTER TABLE `product_categories` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `product_gallery`
--

DROP TABLE IF EXISTS `product_gallery`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `product_gallery` (
  `id` int NOT NULL AUTO_INCREMENT,
  `product_id` int NOT NULL,
  `image_path` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `image_alt` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `order_index` int DEFAULT '0',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `product_id` (`product_id`),
  CONSTRAINT `product_gallery_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `product_gallery`
--

LOCK TABLES `product_gallery` WRITE;
/*!40000 ALTER TABLE `product_gallery` DISABLE KEYS */;
/*!40000 ALTER TABLE `product_gallery` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `products`
--

DROP TABLE IF EXISTS `products`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `products` (
  `id` int NOT NULL AUTO_INCREMENT,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `technical_details` text COLLATE utf8mb4_unicode_ci,
  `main_image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `image_alt` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_active` tinyint(1) DEFAULT '1',
  `category_id` int DEFAULT NULL,
  `sort_order` int DEFAULT '0',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `slug` (`slug`),
  KEY `fk_products_category` (`category_id`),
  CONSTRAINT `fk_products_category` FOREIGN KEY (`category_id`) REFERENCES `product_categories` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `products`
--

LOCK TABLES `products` WRITE;
/*!40000 ALTER TABLE `products` DISABLE KEYS */;
INSERT INTO `products` VALUES (12,'Filtro de Aceite para Motor Cummins KTA38','filtro-de-aceite-para-motor-cummins-kta38','Filtro de aceite de alta eficiencia diseñado específicamente para motores Cummins de la serie KTA38. Este componente garantiza una filtración óptima de partículas y contaminantes, protegiendo los componentes internos del motor contra el desgaste prematuro y asegurando un rendimiento estable en aplicaciones industriales, marinas y de generación de energía exigentes. Fabricado bajo estrictos estándares de calidad para resistir altas presiones y prolongar los intervalos de mantenimiento del equipo.','Compatibilidad: Motores Cummins KTA38 (Marinos e Industriales)\r\nTipo de Filtro: Filtro de Aceite de Flujo Completo / By-pass\r\nAlta capacidad de retención de contaminantes\r\nEstructura reforzada para soportar variaciones de presión\r\nGarantiza la máxima pureza del lubricante en operaciones continuas','/assets/images/products/8a9398c91c0bf1f8.jpg','Filtro de aceite original para motor marino e industrial Cummins KTA38',1,6,0,'2026-06-07 20:27:05','2026-06-07 20:27:05'),(13,'Controlador ComAp InteliLite AMF 25','controlador-comap-intelilite-amf-25','El ComAp InteliLite AMF 25 es un controlador avanzado de fallas de red (AMF) diseñado para un solo grupo electrógeno que opera en modo de respaldo de emergencia. Este módulo ofrece un monitoreo integral, protección exhaustiva del motor y del alternador, y un control de transferencia automática optimizado. Equipado con una interfaz gráfica intuitiva, conectividad flexible y lógica programable, garantiza una gestión energética confiable y segura en aplicaciones residenciales, comerciales e industriales.','Función: Control de falla de red (AMF) y arranque automático\r\nSoporte técnico para motores electrónicos (EFI) y convencionales\r\nMonitoreo trifásico de red (generador y red principal)\r\nPantalla gráfica detallada con idiomas configurables\r\nPuertos de comunicación integrados y opciones de expansión (módulos plug-in)','/assets/images/products/cd7c752c9d9c6de3.jpeg','Módulo de control y transferencia automática ComAp InteliLite AMF 25 para grupos electrógenos',1,7,0,'2026-06-07 20:30:04','2026-06-07 20:31:06'),(14,'Interruptor Termomagnético ABB 3200 A','interruptor-termomagntico-abb-3200-a','Interruptor termomagnético industrial de alta capacidad ABB de 3200 A, diseñado para brindar una protección superior contra sobrecargas y cortocircuitos en sistemas de distribución eléctrica de baja tensión. Ideal para aplicaciones críticas en plantas industriales, centros de datos y grandes infraestructuras comerciales. Este equipo garantiza una alta fiabilidad operativa, máxima seguridad para las instalaciones y una óptima selectividad en la configuración de tableros de distribución general (TG).','Corriente Nominal: 3200 A\r\nMarca: ABB\r\nTipo de Protección: Térmica y Magnética regulable\r\nAplicación: Distribución de energía en baja tensión e instalaciones industriales\r\nAlta capacidad de ruptura y diseño robusto para montaje en tablero','/assets/images/products/d94da9266b802ae3.jpeg','Interruptor termomagnético de caja moldeada ABB de 3200 Amperios para protección industrial',1,8,0,'2026-06-07 20:37:00','2026-06-07 20:37:00'),(15,'Motor de Arranque para Caterpillar 3512B','motor-de-arranque-para-caterpillar-3512b','Motor de arranque de servicio pesado (Heavy Duty) diseñado específicamente para motores de gran cilindrada Caterpillar de la serie 3512B. Este componente de alta resistencia ofrece un torque de arranque superior y un rendimiento constante bajo las condiciones climáticas y de operación más exigentes. Fabricado con materiales de primera calidad y sellado reforzado para proteger los componentes internos contra el polvo y la humedad, asegurando un encendido rápido y reduciendo el tiempo de inactividad de la maquinaria.','Compatibilidad: Motores de la serie Caterpillar 3512B\r\nTipo de Aplicación: Minería, generación de energía e industria marina\r\nDiseño robusto de alta eficiencia para arranques exigentes\r\nExcelente resistencia al choque térmico y vibraciones extremas\r\nComponentes internos de larga vida útil y máxima fiabilidad','/assets/images/products/2f1ff74b9a7dd55c.jpg','Motor de arranque de servicio pesado para motor Caterpillar 3512B',1,9,0,'2026-06-07 20:41:58','2026-06-07 20:41:58');
/*!40000 ALTER TABLE `products` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `projects`
--

DROP TABLE IF EXISTS `projects`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `projects` (
  `id` int NOT NULL AUTO_INCREMENT,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `client` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `completion_date` date DEFAULT NULL,
  `main_image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `image_alt` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_active` tinyint(1) DEFAULT '1',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `challenge_title` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT 'El Reto',
  `challenge_desc` text COLLATE utf8mb4_unicode_ci,
  `solution_title` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT 'La Solución',
  `solution_desc` text COLLATE utf8mb4_unicode_ci,
  `impact_label` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT 'Impacto Logrado',
  `impact_value` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT '100% Optimizado',
  `seo_title` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `seo_description` varchar(1000) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `seo_keywords` varchar(1000) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `slug` (`slug`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `projects`
--

LOCK TABLES `projects` WRITE;
/*!40000 ALTER TABLE `projects` DISABLE KEYS */;
INSERT INTO `projects` VALUES (1,'Migración Cloud','migracin-cloud','Llevamos toda la infraestructura de una corporación andina a la nube con cero downtime.','','2026-04-30','/assets/images/projects/556defac3ee2580c.jpeg','',0,'2026-05-05 03:42:11','2026-06-07 02:37:05','2026-06-02 02:45:49','El Desafio de la Nube','La infraestructura local estaba obsoleta y lenta.','Estrategia de Migracion','Implementamos una arquitectura serverless en AWS.','Reduccion de Costos','45%',NULL,NULL,NULL),(2,'App Móvil Financiera','app-financiera','Desarrollo nativo de app transaccional con biometría integrada.','Banco Andino',NULL,'https://images.unsplash.com/photo-1551288049-bebda4e38f71?ixlib=rb-1.2.1&auto=format&fit=crop&w=800&q=80',NULL,0,'2026-05-05 03:42:11','2026-05-06 03:30:42','2026-05-06 03:30:42','El Reto',NULL,'La Solución',NULL,'Impacto Logrado','100% Optimizado',NULL,NULL,NULL),(3,'Migración Cloud (Copia)','migracin-cloud-copia-4f7b7e','Llevamos toda la infraestructura de una corporación andina a la nube con cero downtime.','Global Corp','2026-04-30','assets/images/projects/0cc827e9b986a925.jpeg',NULL,0,'2026-05-17 23:06:04','2026-05-18 01:12:37','2026-05-18 01:12:37','El Reto',NULL,'La Solución',NULL,'Impacto Logrado','100% Optimizado',NULL,NULL,NULL),(4,'Migración Cloud (Copia)','migracin-cloud-copia-f6f462','Llevamos toda la infraestructura de una corporación andina a la nube con cero downtime.','Global Corp','2026-04-30','assets/images/projects/a86e6abc21eac186.jpeg',NULL,0,'2026-05-17 23:06:10','2026-05-18 01:12:35','2026-05-18 01:12:35','El Reto',NULL,'La Solución',NULL,'Impacto Logrado','100% Optimizado',NULL,NULL,NULL),(5,'Migración Cloud (Copia)','migracin-cloud-copia-282b8a','Llevamos toda la infraestructura de una corporación andina a la nube con cero downtime.','Global Corp','2026-04-30','assets/images/projects/153b06e0a3107e44.jpeg',NULL,0,'2026-05-17 23:06:21','2026-05-18 01:12:32','2026-05-18 01:12:32','El Reto',NULL,'La Solución',NULL,'Impacto Logrado','100% Optimizado',NULL,NULL,NULL),(6,'Migración Cloud (Copia)','migracin-cloud-copia-8c60d4','Llevamos toda la infraestructura de una corporación andina a la nube con cero downtime.','Global Corp','2026-04-30','assets/images/projects/b3898184a3b82411.jpeg',NULL,0,'2026-05-17 23:09:06','2026-05-18 01:12:30','2026-05-18 01:12:30','El Reto',NULL,'La Solución',NULL,'Impacto Logrado','100% Optimizado',NULL,NULL,NULL),(9,'Implementación de Casa de Fuerza de 2 MW con Sistema de Sincronismo Inteligente','implementacin-de-casa-de-fuerza-de-2-mw-con-sistema-de-sincronismo-inteligente','Se desarrolló la implementación integral de una casa de fuerza de 2 MW para una operación ubicada a 4,200 msnm, en una zona sin acceso a la red eléctrica comercial. El proyecto inició con un estudio detallado de cargas para determinar la solución energética más eficiente y confiable para la operación.\r\n\r\nComo resultado del análisis, se instalaron tres grupos electrógenos Cummins equipados con motores KTA38, especialmente acondicionados para operar en condiciones de altura extrema. La solución incluyó un sistema de sincronismo Load Sharing mediante controladores ComAp InteliGen 200, permitiendo una gestión inteligente de la generación eléctrica según la demanda de la planta.\r\n\r\nLa infraestructura fue complementada con llaves térmicas automáticas Siemens y un tablero de transferencia equipado con interruptor ABB de 2000 A, preparado para una futura sincronización con la red comercial. Actualmente, los tres grupos electrógenos operan en sincronismo durante el arranque de la planta y, una vez superada la demanda inicial, dos equipos continúan abasteciendo la carga durante la jornada operativa.\r\n\r\nGracias a una adecuada ingeniería de diseño, supervisión especializada y optimización de la operación energética, el proyecto logró maximizar la eficiencia de la casa de fuerza y reducir significativamente el consumo de combustible.','Cliente','2025-05-10','/assets/images/projects/6e693405596e8744.webp','Casa de fuerza de 2 MW con grupos electrógenos Cummins sincronizados mediante sistema Load Sharing.',1,'2026-06-07 03:42:37','2026-06-07 03:46:49',NULL,'Garantizar suministro eléctrico confiable en una operación aislada de alta demanda','La operación requería una solución energética robusta capaz de abastecer una demanda de arranque de hasta 1700 A y una carga constante de 330 A en una ubicación remota sin acceso a la red eléctrica comercial. Además, los equipos debían operar de forma eficiente a más de 4,200 metros sobre el nivel del mar.','Implementación de sistema de generación sincronizada Load Sharing de 2 MW','Se diseñó e implementó una casa de fuerza de 2 MW compuesta por tres grupos electrógenos Cummins KTA38 preparados para trabajo en altura. La solución incorporó controladores ComAp InteliGen 200 para sincronismo inteligente Load Sharing, protecciones Siemens y un tablero de transferencia ABB de 2000 A preparado para futuras ampliaciones e integración con la red comercial.','Eficiencia Energética','Optimización del consumo de combustible','Implementación de Casa de Fuerza de 2 MW con Grupos Electrógenos Sincronizados','Implementación de una casa de fuerza de 2 MW con grupos electrógenos Cummins sincronizados mediante Load Sharing para garantizar energía confiable y eficiente en operación ubicada a 4,200 msnm.','casa de fuerza 2 MW, grupos electrógenos Cummins, sincronismo Load Sharing, ComAp InteliGen 200, generación eléctrica industrial, sistemas de potencia, grupos electrógenos en altura, casa de fuerza minera, automatización energética, proyectos electromecánicos'),(10,'Migración y Sincronización de Grupo Electrógeno Caterpillar 3516B en Base Load','migracin-y-sincronizacin-de-grupo-electrgeno-caterpillar-3516b-en-base-load','Se ejecutó la migración y actualización del sistema de control de un grupo electrógeno Caterpillar 3516B para una importante empresa del sector de renta de energía. El proyecto tuvo como objetivo permitir la operación en paralelo con la red comercial bajo una configuración Base Load, optimizando la integración y gestión de la generación eléctrica.\r\n\r\nLa solución contempló la extracción e integración de señales de control desde la ECM del motor hacia un controlador Deep Sea Electronics DSE8610, permitiendo la supervisión y control avanzado de la unidad generadora. Asimismo, se implementó el control operativo del motor y la gestión de apertura, cierre y disparo del interruptor Merlin Gerin de 3200 A.\r\n\r\nComo parte de la puesta en marcha, se realizaron pruebas y simulaciones de sincronismo utilizando carga resistiva, verificando el correcto funcionamiento del sistema y obteniendo resultados óptimos en la operación paralela con la red eléctrica.','Caterpillar','2025-06-02','/assets/images/projects/6aa3d7bcdd571edd.webp','Grupo electrógeno Caterpillar 3516B sincronizado con red comercial mediante controlador Deep Sea Electronics DSE8610.',1,'2026-06-07 03:53:07','2026-06-07 03:59:27',NULL,'Integrar un grupo electrógeno existente para operación en paralelo con la red comercial','El cliente requería modernizar el sistema de control de un grupo electrógeno Caterpillar 3516B para permitir su operación en configuración Base Load, garantizando sincronismo seguro, control preciso y compatibilidad con la infraestructura eléctrica existente.','Implementación de control avanzado y sincronismo mediante DSE8610','Se integraron las señales de control de la ECM del motor con un controlador Deep Sea Electronics DSE8610, permitiendo la gestión completa del grupo electrógeno y del interruptor Merlin Gerin de 3200 A. Posteriormente, se realizaron pruebas de sincronismo con carga resistiva para validar la operación estable y segura en paralelo con la red comercial.','Integración Energética','Operación estable en paralelo con la red','Migración de Grupo Electrógeno Caterpillar 3516B para Operación Base Load','Proyecto de migración y modernización de grupo electrógeno Caterpillar 3516B para operación en paralelo con la red comercial mediante controlador DSE8610 y sistema de sincronismo Base Load.','grupo electrógeno Caterpillar 3516B, sincronismo con red eléctrica, DSE8610, operación Base Load, automatización de grupos electrógenos'),(11,'Fabricación e Implementación de Tablero de Transferencia Automático de 1000 A','fabricacin-e-implementacin-de-tablero-de-transferencia-automtico-de-1000-a','Se realizó la fabricación e implementación de un tablero de transferencia automática de 1000 A para una importante empresa del sector de almacenes, diseñado para garantizar la continuidad del suministro eléctrico y una transición segura entre las diferentes fuentes de energía.\r\n\r\nEl proyecto incorporó interruptores térmicos automáticos ABB con sistema de bloqueo mecánico, proporcionando altos estándares de seguridad y confiabilidad operativa. Siguiendo los requerimientos del cliente, se utilizaron componentes ABB tanto en las etapas de fuerza como de control, asegurando uniformidad tecnológica y facilidad de mantenimiento.\r\n\r\nLa automatización del sistema fue desarrollada mediante un controlador Deep Sea Electronics DSE7420, encargado de gestionar la lógica de transferencia automática y supervisar el correcto funcionamiento de la instalación. Como resultado, se obtuvo una solución robusta, segura y preparada para garantizar la continuidad operativa de las instalaciones.','Cliente','2025-12-01','/assets/images/projects/879a5691bc40f094.webp','Tablero de transferencia automática de 1000 A fabricado con componentes ABB y controlador DSE7420.',1,'2026-06-07 04:06:25','2026-06-07 04:06:25',NULL,'Garantizar una transferencia eléctrica segura y confiable para operaciones críticas','El cliente requería un sistema de transferencia automática de alta capacidad que permitiera mantener la continuidad eléctrica de sus operaciones, incorporando componentes de una sola marca para asegurar compatibilidad, confiabilidad y facilidad de gestión técnica.','Desarrollo de tablero automático con tecnología ABB y control DSE7420','Se diseñó y fabricó un tablero de transferencia automática de 1000 A utilizando componentes ABB en los circuitos de fuerza y control, complementados con un controlador DSE7420 para la automatización del sistema. La implementación incluyó interruptores térmicos automáticos con bloqueo mecánico para maximizar la seguridad operativa.','Continuidad Operativa','Transferencia automática segura y confiable','Tablero de Transferencia Automático de 1000 A con Componentes ABB','Fabricación e implementación de tablero de transferencia automática de 1000 A con componentes ABB y controlador DSE7420, diseñado para garantizar continuidad operativa y seguridad eléctrica en instalaciones industriales.','tablero de transferencia automática, tablero ATS 1000A, componentes ABB, DSE7420, automatización eléctrica industrial'),(12,'Modernización de Sistema de Control y Transferencia Automática para Grupo Electrógeno Volvo','modernizacin-de-sistema-de-control-y-transferencia-automtica-para-grupo-electrgeno-volvo','Se ejecutó la modernización integral del sistema de control de un grupo electrógeno equipado con motor Volvo TAD1242 para una importante empresa del sector de telecomunicaciones. El proyecto surgió debido a la avería del controlador original, situación que obligaba a la intervención manual del personal técnico cada vez que se producía una interrupción del suministro eléctrico comercial.\r\n\r\nLa solución contempló la migración completa hacia un controlador ComAp InteliLite AMF 8, realizando además la adecuación y estandarización del sistema para facilitar futuras integraciones con módulos de control disponibles en el mercado. Esta actualización permitió mejorar la confiabilidad operativa y simplificar las tareas de mantenimiento.\r\n\r\nAdicionalmente, se habilitó un nuevo tablero de transferencia automática proporcionado por el cliente, reemplazando el sistema anterior. Para ello, se implementó un controlador Deep Sea Electronics DSE7420, realizando la programación, configuración y calibración de parámetros necesarios para garantizar una operación automática, segura y eficiente ante fallas de la red comercial.','Cliente','2025-08-03','/assets/images/projects/d70348a0b5eb0f59.webp','Grupo electrógeno Volvo TAD1242 modernizado con controlador ComAp y sistema de transferencia automática.',1,'2026-06-07 04:14:23','2026-06-07 04:20:18',NULL,'Eliminar la dependencia de maniobras manuales ante fallas del suministro eléctrico','La avería del controlador original impedía la operación automática del grupo electrógeno, obligando a la intervención constante del personal técnico para ejecutar las transferencias de energía. Además, era necesario modernizar el sistema utilizando tecnología compatible y fácilmente mantenible.','Migración a plataforma ComAp y automatización de transferencia eléctrica','Se reemplazó el controlador original por un módulo ComAp InteliLite AMF 8, realizando la estandarización completa del sistema de control. Asimismo, se implementó un nuevo tablero de transferencia automática mediante un controlador DSE7420, configurado y calibrado para garantizar una respuesta automática ante interrupciones de la red eléctrica.','Automatización Operativa','Transferencia automática sin intervención manual','Modernización de Grupo Electrógeno Volvo con Controlador ComAp y ATS','Modernización de grupo electrógeno Volvo TAD1242 mediante controlador ComAp InteliLite AMF 8 y sistema de transferencia automática DSE7420 para garantizar continuidad operativa en infraestructura de telecomunicaciones.','grupo electrógeno Volvo, ComAp InteliLite AMF 8, DSE7420, transferencia automática, modernización de grupos electrógenos'),(13,'Fabricación de Tableros de Transferencia Automática de 800 A y 1250 A para Infraestructura Aeroportuaria','fabricacin-de-tableros-de-transferencia-automtica-de-800-a-y-1250-a-para-infraestructura-aeroportuaria','Se desarrolló la fabricación de dos tableros de transferencia automática destinados a una importante empresa del sector aeroportuario, diseñados para garantizar la continuidad del suministro eléctrico en instalaciones críticas y de alta exigencia operativa.\r\n\r\nLa solución incluyó la implementación de conmutadores automáticos de la marca LS de procedencia coreana, con capacidades de 800 A y 1250 A, seleccionados por su confiabilidad y desempeño en aplicaciones industriales. Asimismo, se integraron módulos de control Deep Sea Electronics DSE4520 para la automatización de los procesos de transferencia y supervisión del sistema.\r\n\r\nLos tableros fueron diseñados para operar en conjunto con grupos electrógenos de 350 kW, proporcionando una respuesta automática y segura ante interrupciones del suministro eléctrico, asegurando la continuidad de las operaciones y la protección de los sistemas críticos de la infraestructura aeroportuaria.','Cliente','2025-04-02','/assets/images/projects/567f3ac500e6a24d.webp','Tableros de transferencia automática de 800 A y 1250 A fabricados para sistemas de respaldo con grupos electrógenos de 350 kW.',1,'2026-06-07 04:28:02','2026-06-07 04:28:02',NULL,'Garantizar continuidad eléctrica en una infraestructura de alta disponibilidad','Las operaciones aeroportuarias requieren sistemas de respaldo confiables capaces de transferir automáticamente la carga hacia grupos electrógenos ante cualquier interrupción de la red eléctrica, minimizando riesgos y tiempos de inactividad.','Fabricación de tableros ATS de alta capacidad con automatización DSE','Se fabricaron dos tableros de transferencia automática de 800 A y 1250 A utilizando conmutadores automáticos LS y módulos de control DSE4520. La solución fue diseñada para trabajar con grupos electrógenos de 350 kW, garantizando una transferencia rápida, segura y completamente automatizada.','Continuidad Operativa','Respaldo eléctrico automático para sistemas críticos','Tableros de Transferencia Automática para Sistemas de Respaldo Aeroportuario','Fabricación de tableros de transferencia automática de 800 A y 1250 A con conmutadores LS y controladores DSE4520 para sistemas de respaldo eléctrico en infraestructura aeroportuaria.','tablero de transferencia automática, ATS industrial, DSE4520, grupo electrógeno 350 kW, sector aeroportuario'),(14,'Implementación de Sistema de Sincronismo Load Sharing para Operación Minera','implementacin-de-sistema-de-sincronismo-load-sharing-para-operacin-minera','Se desarrolló la ingeniería, fabricación e implementación de un sistema de generación sincronizada en 460 VAC para una operación de exploración minera, diseñado para trabajar con dos grupos electrógenos de 100 kW en configuración Load Sharing.\r\n\r\nLa solución incluyó la fabricación de un tablero de sincronismo equipado con interruptores termomagnéticos Siemens de 250 A y controladores ComAp InteliGen 200, permitiendo una distribución eficiente de la carga entre ambos grupos electrógenos y garantizando una operación estable y confiable.\r\n\r\nComo parte del alcance del proyecto, se realizó el dimensionamiento de los conductores de fuerza para alimentar diversas cargas ubicadas a distancias de hasta 500 metros, considerando criterios técnicos como caída de tensión, capacidad de conducción y eficiencia energética. Asimismo, se fabricó un tablero de distribución de 400 A con derivaciones de 150 A y 100 A, instalado estratégicamente en la entrada de la bocamina para optimizar la distribución eléctrica de la operación.\r\n\r\nAdicionalmente, se efectuaron los cálculos y la selección de un transformador seco de aislamiento para suministrar energía a cargas operando a 220 VAC. El proyecto comprendió todas las etapas de asesoría técnica, diseño de ingeniería, evaluación económica, fabricación e implementación en campo, proporcionando una solución integral para la operación minera.','Cliente','2025-08-06','/assets/images/projects/c3e28e7dbd47eb29.webp','Tablero de sincronismo Load Sharing con controladores ComAp para grupos electrógenos en operación minera.',1,'2026-06-07 04:36:28','2026-06-07 04:36:28',NULL,'Diseñar una solución energética confiable para una operación minera de gran extensión','La operación requería un sistema de generación eléctrica capaz de distribuir energía de manera eficiente a cargas ubicadas a grandes distancias, garantizando estabilidad operativa, adecuada gestión de cargas y niveles óptimos de tensión en toda la instalación.','Sistema integral de sincronismo y distribución eléctrica para exploración minera','Se implementó un sistema Load Sharing con dos grupos electrógenos de 100 kW mediante controladores ComAp InteliGen 200 y protecciones Siemens. Además, se desarrolló la ingeniería de distribución eléctrica, incluyendo tableros de derivación, dimensionamiento de conductores y selección de transformador de aislamiento para optimizar el suministro energético de toda la operación.','Confiabilidad Energética','Distribución eficiente de energía en toda la operación','Sistema de Sincronismo Load Sharing para Grupos Electrógenos en Minería','Implementación de sistema de sincronismo Load Sharing para grupos electrógenos de 100 kW, incluyendo tableros eléctricos, distribución de energía y selección de transformador para operación minera.','Load Sharing, sincronismo de grupos electrógenos, ComAp InteliGen 200, tableros eléctricos mineros, generación eléctrica minera'),(15,'Puesta en Marcha de Sistema de Sincronismo para Casa de Fuerza Minera de 3.35 MW','puesta-en-marcha-de-sistema-de-sincronismo-para-casa-de-fuerza-minera-de-335-mw','Se realizó la puesta en marcha y calibración de un sistema de generación sincronizada compuesto por tres grupos electrógenos Caterpillar modelos 3516B (2000 kW), C27 (750 kW) y C18 (600 kW), integrados en la casa de fuerza de una importante operación minera dedicada a la extracción y procesamiento de oro.\r\n\r\nLa solución fue desarrollada para abastecer de energía tanto las operaciones subterráneas de socavón como la planta de procesamiento de minerales. El sistema de sincronismo Load Sharing se implementó mediante tres tableros de sincronismo equipados con interruptores automáticos ABB de 3200 A y controladores ComAp Base Box NT con interfaz InteliVision 5.\r\n\r\nEl alcance del proyecto incluyó la configuración de arranque remoto, programación y calibración de los módulos de control, integración con las tarjetas electrónicas de los grupos electrógenos y la realización de pruebas operativas bajo condiciones reales de carga minera. Estas pruebas permitieron validar el ingreso y salida de los grupos electrógenos de forma individual y conjunta, asegurando una distribución eficiente de la carga y una operación estable de la planta.\r\n\r\nComo parte del plan de crecimiento de la operación, se contempla la futura incorporación de dos grupos electrógenos Caterpillar C18 adicionales mediante un nuevo tablero de sincronismo, así como la implementación de un sistema SCADA para supervisión y monitoreo remoto en tiempo real de toda la infraestructura energética.','Cliente','2025-01-03','/assets/images/projects/316e8e43a76c6efe.webp','Sistema de sincronismo Load Sharing para grupos electrógenos Caterpillar en operación minera de oro.',1,'2026-06-07 04:52:13','2026-06-07 04:52:13',NULL,'Garantizar una operación sincronizada y confiable para una casa de fuerza de alta capacidad','La operación minera requería coordinar la generación de energía de equipos de diferentes capacidades para abastecer cargas críticas de mina subterránea y planta de procesamiento, manteniendo estabilidad operativa, reparto eficiente de carga y capacidad de expansión futura.','Implementación y puesta en marcha de sistema Load Sharing con tecnología ComAp','Se configuró un sistema de sincronismo Load Sharing para tres grupos electrógenos Caterpillar utilizando tableros de sincronismo con protección ABB y controladores ComAp. La solución incluyó programación avanzada, calibración, arranque remoto y pruebas bajo carga real, garantizando una operación eficiente y escalable para futuras ampliaciones.','Capacidad Energética','3.35 MW de generación sincronizada operativa','Puesta en Marcha de Sistema de Sincronismo Caterpillar para Operación Minera','Implementación y puesta en marcha de sistema de sincronismo Load Sharing para grupos electrógenos Caterpillar en una operación minera de oro, garantizando generación eléctrica confiable y escalable para mina y planta de procesamiento.','sincronismo Load Sharing, grupos electrógenos Caterpillar, ComAp InteliVision 5, casa de fuerza minera, generación eléctrica minera'),(16,'Puesta en Marcha de Grupo Electrógeno Caterpillar 3512B para Operación Minera en Altura','puesta-en-marcha-de-grupo-electrgeno-caterpillar-3512b-para-operacin-minera-en-altura','Se llevó a cabo la puesta en marcha de un grupo electrógeno Caterpillar 3512B destinado a abastecer las cargas críticas de una importante operación minera ubicada a 4600 m.s.n.m. en el sur del Perú. Debido a las exigentes condiciones de operación en altura, fue necesario realizar una configuración especializada para garantizar el desempeño y la confiabilidad del sistema de generación.\r\n\r\nEl proyecto incluyó la preparación integral del grupo electrógeno, la migración del sistema de control y la implementación de un controlador ComAp InteliLite 4 AMF 8, realizando además la programación y calibración de parámetros para optimizar el arranque y funcionamiento del equipo en condiciones de baja densidad atmosférica.\r\n\r\nGracias a la correcta configuración y puesta en servicio, se logró asegurar un suministro eléctrico confiable para la operación minera. Como parte de la estrategia de crecimiento de la unidad productiva, se encuentra en evaluación la implementación de un sistema de sincronismo que permita operar el grupo electrógeno en paralelo con la red comercial, contribuyendo a cubrir los incrementos de demanda energética derivados de la expansión de la mina.','Cliente','2024-02-07','/assets/images/projects/116240ba7be49558.webp','Grupo electrógeno Caterpillar 3512B configurado para operación minera a 4600 metros sobre el nivel del mar.',1,'2026-06-07 04:58:36','2026-06-07 05:06:42',NULL,'Garantizar generación confiable en condiciones extremas de altura','La operación minera requería una solución de generación eléctrica capaz de funcionar eficientemente a 4600 m.s.n.m., donde las condiciones ambientales afectan el desempeño de los equipos y exigen configuraciones especializadas para mantener la confiabilidad operativa.','Migración y calibración avanzada de sistema de control ComAp','Se implementó un controlador ComAp InteliLite 4 AMF 8, realizando la migración, programación y calibración completa del sistema de control del grupo electrógeno Caterpillar 3512B. La solución permitió optimizar el funcionamiento del equipo en altura y garantizar la continuidad del suministro eléctrico para la operación minera.','Confiabilidad Operativa','Generación estable a 4600 m.s.n.m.','Puesta en Marcha de Grupo Electrógeno Caterpillar 3512B en Minería','Puesta en marcha y configuración de grupo electrógeno Caterpillar 3512B para operación minera a 4600 m.s.n.m., incluyendo migración de control ComAp y calibración especializada para trabajo en altura.','Caterpillar 3512B, grupo electrógeno minero, ComAp InteliLite AMF 8, generación eléctrica en altura, puesta en marcha de grupos electrógenos');
/*!40000 ALTER TABLE `projects` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `scripts`
--

DROP TABLE IF EXISTS `scripts`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `scripts` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `code` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `placement` enum('head','body_start','body_end') COLLATE utf8mb4_unicode_ci DEFAULT 'head',
  `page_restriction` enum('all','thanks_only') COLLATE utf8mb4_unicode_ci DEFAULT 'all',
  `is_active` tinyint(1) DEFAULT '1',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `scripts`
--

LOCK TABLES `scripts` WRITE;
/*!40000 ALTER TABLE `scripts` DISABLE KEYS */;
/*!40000 ALTER TABLE `scripts` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `service_gallery`
--

DROP TABLE IF EXISTS `service_gallery`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `service_gallery` (
  `id` int NOT NULL AUTO_INCREMENT,
  `service_id` int NOT NULL,
  `image_path` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `image_alt` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `sort_order` int DEFAULT '0',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `service_id` (`service_id`),
  CONSTRAINT `service_gallery_ibfk_1` FOREIGN KEY (`service_id`) REFERENCES `services_pages` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=65 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `service_gallery`
--

LOCK TABLES `service_gallery` WRITE;
/*!40000 ALTER TABLE `service_gallery` DISABLE KEYS */;
INSERT INTO `service_gallery` VALUES (17,14,'/assets/images/services/gallery/8a2fecd2b55575a3.webp','',99,'2026-06-05 00:47:13'),(18,14,'/assets/images/services/gallery/012362433cca104e.webp','',99,'2026-06-05 00:48:06'),(21,15,'/assets/images/services/gallery/373a7bda973d30e5.webp','',99,'2026-06-05 02:51:17'),(22,15,'/assets/images/services/gallery/f8df27f2fdfe700d.webp','',99,'2026-06-05 02:51:17'),(23,16,'/assets/images/services/gallery/704fa6ecb8aea258.webp',NULL,99,'2026-06-05 17:21:30'),(24,16,'/assets/images/services/gallery/452c1865b97f0135.webp',NULL,99,'2026-06-05 17:21:30'),(25,17,'/assets/images/services/gallery/f0f105f57b4a9f36.webp',NULL,99,'2026-06-05 21:07:13'),(26,17,'/assets/images/services/gallery/b86478514022e539.webp',NULL,99,'2026-06-05 21:07:13'),(27,17,'/assets/images/services/gallery/ab58b73d7e095217.webp',NULL,99,'2026-06-05 21:07:13'),(28,18,'/assets/images/services/gallery/000147a95ed70d9b.webp',NULL,99,'2026-06-05 21:42:51'),(29,18,'/assets/images/services/gallery/0bf609e11d10a832.webp',NULL,99,'2026-06-05 21:42:51'),(30,18,'/assets/images/services/gallery/502b2affa79f1748.webp',NULL,99,'2026-06-05 21:42:51'),(31,19,'/assets/images/services/gallery/9e419c64234bf13a.webp','',99,'2026-06-05 22:06:27'),(32,19,'/assets/images/services/gallery/600ee7c3271b1fdb.webp','',99,'2026-06-05 22:06:27'),(33,19,'/assets/images/services/gallery/971c58b898a71b0d.webp','',99,'2026-06-05 22:06:27'),(34,19,'/assets/images/services/gallery/3593ecb18777a122.webp','',99,'2026-06-05 22:06:27'),(35,20,'/assets/images/services/gallery/8d783a01b2890233.webp',NULL,99,'2026-06-05 22:36:38'),(36,20,'/assets/images/services/gallery/ca9393b17c940e00.webp',NULL,99,'2026-06-05 22:36:38'),(37,20,'/assets/images/services/gallery/e5397f30d6c4808c.webp',NULL,99,'2026-06-05 22:36:38'),(38,20,'/assets/images/services/gallery/84b33f202f833ed5.webp',NULL,99,'2026-06-05 22:36:38'),(39,21,'/assets/images/services/gallery/9da176f7a8bb10ed.webp',NULL,99,'2026-06-05 23:25:20'),(40,21,'/assets/images/services/gallery/de248a172c25876e.webp',NULL,99,'2026-06-05 23:25:20'),(41,21,'/assets/images/services/gallery/401aee198e557933.webp',NULL,99,'2026-06-05 23:25:20'),(42,21,'/assets/images/services/gallery/8c3921831b0b359e.webp',NULL,99,'2026-06-05 23:25:20'),(43,21,'/assets/images/services/gallery/852edb52e22addb3.webp',NULL,99,'2026-06-05 23:25:20'),(44,22,'/assets/images/services/gallery/5314bba62eb86c20.webp',NULL,99,'2026-06-06 03:18:00'),(45,22,'/assets/images/services/gallery/03da52138aef2d95.webp',NULL,99,'2026-06-06 03:18:00'),(46,22,'/assets/images/services/gallery/31af844da711e0c7.webp',NULL,99,'2026-06-06 03:18:00'),(47,22,'/assets/images/services/gallery/1de3ee4044e3173f.webp',NULL,99,'2026-06-06 03:18:00'),(48,23,'/assets/images/services/gallery/391b2299d9bdbfc9.webp',NULL,99,'2026-06-06 20:17:59'),(49,23,'/assets/images/services/gallery/7f118098ae4944bd.webp',NULL,99,'2026-06-06 20:17:59'),(50,23,'/assets/images/services/gallery/2ca3388f126dfd35.webp',NULL,99,'2026-06-06 20:17:59'),(51,23,'/assets/images/services/gallery/9366f936e979ed6c.webp',NULL,99,'2026-06-06 20:17:59'),(52,23,'/assets/images/services/gallery/3462f64014c4decf.webp',NULL,99,'2026-06-06 20:17:59'),(53,23,'/assets/images/services/gallery/e756483a8219fd29.webp',NULL,99,'2026-06-06 20:17:59'),(54,24,'/assets/images/services/gallery/ab101589427528eb.webp',NULL,99,'2026-06-06 20:34:46'),(55,24,'/assets/images/services/gallery/4ecbe425f1fe464a.webp',NULL,99,'2026-06-06 20:34:46'),(56,24,'/assets/images/services/gallery/2d3f276e5d5be3f6.webp',NULL,99,'2026-06-06 20:34:46'),(57,24,'/assets/images/services/gallery/238d792c60f204aa.webp',NULL,99,'2026-06-06 20:34:46'),(58,25,'/assets/images/services/gallery/7ebe531ef4332b0c.webp',NULL,99,'2026-06-06 20:53:18'),(59,25,'/assets/images/services/gallery/b219c9181b8d24a5.webp',NULL,99,'2026-06-06 20:53:18'),(60,25,'/assets/images/services/gallery/d6ab61e423bc96ff.webp',NULL,99,'2026-06-06 20:53:18'),(61,25,'/assets/images/services/gallery/8842636007cabe6e.webp',NULL,99,'2026-06-06 20:53:18'),(62,25,'/assets/images/services/gallery/989466e6a545a323.webp',NULL,99,'2026-06-06 20:53:18'),(63,25,'/assets/images/services/gallery/63449d7b5a79aa89.webp',NULL,99,'2026-06-06 20:53:18'),(64,25,'/assets/images/services/gallery/0876928e8a182e49.webp',NULL,99,'2026-06-06 20:53:18');
/*!40000 ALTER TABLE `service_gallery` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `service_items`
--

DROP TABLE IF EXISTS `service_items`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `service_items` (
  `id` int NOT NULL AUTO_INCREMENT,
  `service_id` int NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `sort_order` int DEFAULT '0',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `service_id` (`service_id`),
  CONSTRAINT `service_items_ibfk_1` FOREIGN KEY (`service_id`) REFERENCES `services_pages` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=221 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `service_items`
--

LOCK TABLES `service_items` WRITE;
/*!40000 ALTER TABLE `service_items` DISABLE KEYS */;
INSERT INTO `service_items` VALUES (129,15,'Sincronismo en Paralelo:','Configuración para que múltiples grupos electrógenos operen juntos según la demanda de carga.',0,'2026-06-05 02:51:22'),(130,15,'Paralelismo con la Red:','Sistemas de transferencia y sincronización suave con la red eléctrica comercial.',1,'2026-06-05 02:51:22'),(131,15,'Programación de Módulos:','Calibración avanzada de controladores especializados (Deep Sea, ComAp, Woodward).',2,'2026-06-05 02:51:22'),(132,15,'Sistemas de Protección:','Implementación de relés de protección contra sobrecorriente, retorno de potencia y variaciones de frecuencia.',3,'2026-06-05 02:51:22'),(137,16,'Dimensionamiento Técnico:','Cálculo exacto de la capacidad requerida para optimizar la compra de equipos de generación.',0,'2026-06-05 17:21:30'),(138,16,'Estudios de Viabilidad:','Evaluación técnica y económica para la implementación de sistemas de sincronismo y respaldo.',1,'2026-06-05 17:21:30'),(139,16,'Auditoría de Sistemas:','Diagnóstico integral de la infraestructura eléctrica actual para identificar puntos de falla.',2,'2026-06-05 17:21:30'),(140,16,'Cumplimiento Normativo:','Asesoría en la adaptación de proyectos bajo el Código Nacional de Electricidad y normas internacionales.',3,'2026-06-05 17:21:30'),(145,17,'Registro de Carga (Logging):','Monitoreo continuo con analizadores de redes para capturar el perfil de consumo real.',0,'2026-06-05 21:07:13'),(146,17,'Análisis de Parámetros:','Evaluación de caídas de tensión, transitorios, picos de arranque y factor de potencia.',1,'2026-06-05 21:07:13'),(147,17,'Ingeniería de Detalle:','Desarrollo de planos eléctricos, diagramas unifilares y memorias de cálculo a medida.',2,'2026-06-05 21:07:13'),(148,17,'Optimización de Costos:','Dimensionamiento preciso de componentes para reducir el gasto innecesario en equipos.',3,'2026-06-05 21:07:13'),(153,18,'Ingeniería de Envolventes:','Estructuras metálicas auto-soportadas con grado de protección adecuado para entornos industriales y mineros.',0,'2026-06-05 21:42:51'),(154,18,'Lógica de Control:','Integración avanzada de controladores digitales multimarca para un paralelismo completamente automatizado.',1,'2026-06-05 21:42:51'),(155,18,'Sistemas de Barras:','Diseño y dimensionamiento de barras de cobre electrolítico de alta conductividad con aislamiento de seguridad.',2,'2026-06-05 21:42:51'),(156,18,'Protecciones Integradas:','Equipamiento con relés de protección contra retorno de potencia, sobrecorriente y fallas a tierra.',3,'2026-06-05 21:42:51'),(165,19,'Enclavamiento Seguro:','Sistemas de enclavamiento mecánico y eléctrico integrado para evitar el cruce de fuentes de energía.',0,'2026-06-05 22:08:49'),(166,19,'Controladores Digitales:','Módulos de transferencia configurables con pantallas de diagnóstico para monitorear fases y voltajes.',1,'2026-06-05 22:08:49'),(167,19,'Componentes de Potencia:','Equipamiento con contactores avanzados, llaves térmicas e interruptores motorizados de alta capacidad.',2,'2026-06-05 22:08:49'),(168,19,'Diseño Ergonómico:','Gabinete metálico con pintura electrostática, luces piloto de estado y selectores manual-automático externos.',3,'2026-06-05 22:08:49'),(173,20,'Balance de Cargas:','Diseño y distribución simétrica de las fases para optimizar el rendimiento del suministro eléctrico.',0,'2026-06-05 22:36:38'),(174,20,'Protección Avanzada:','Equipamiento con interruptores de caja moldeada, llaves magnéticas y diferenciales de alta sensibilidad.',1,'2026-06-05 22:36:38'),(175,20,'Estructura Modular:','Gabinetes auto-soportados o empotrados con pintura al horno anticorrosiva y compartimentos seguros.',2,'2026-06-05 22:36:38'),(176,20,'Identificación Técnica:','Rotulado y señalización completa de cada circuito y bornera para un mantenimiento rápido y seguro.',3,'2026-06-05 22:36:38'),(181,21,'Montaje de Casas de Fuerza:','Diseño, cimentación e instalación completa de salas de motores y plantas de generación diésel.',0,'2026-06-05 23:25:20'),(182,21,'Sistemas de Combustible:','Implementación de tanques de almacenamiento diario, tuberías y sistemas automatizados de bombeo.',1,'2026-06-05 23:25:20'),(183,21,'Atenuación Acústica:','Diseño e instalación de ductos de ventilación, silenciadores críticos y cabinas insonorizadas.',2,'2026-06-05 23:25:20'),(184,21,'Sistemas de Escape:','Montaje mecánico de ductos de evacuación de gases de escape aislados térmicamente.',3,'2026-06-05 23:25:20'),(189,22,'Diagnóstico de Fallas Eléctricas:','Identificación y reparación de cortocircuitos, fallas en alternadores, tarjetas AVR y cableado de control.',0,'2026-06-06 03:18:00'),(190,22,'Reparación Mecánica de Emergencia:','Solución a problemas críticos en el sistema de inyección, turbocompresores, bombas de agua y culatas.',1,'2026-06-06 03:18:00'),(191,22,'Solución en Sistemas de Control:','Reemplazo, reprogramación y calibración de módulos digitales y relés de protección averiados.',2,'2026-06-06 03:18:00'),(192,22,'Pruebas de Rendimiento Post-Falla:','Evaluación del comportamiento del equipo con banco de carga para certificar la estabilidad de la potencia.',3,'2026-06-06 03:18:00'),(197,23,'Cambio de Consumibles:','Reemplazo periódico de aceite de motor, refrigerantes y filtros de aire, combustible y aceite.',0,'2026-06-06 20:17:59'),(198,23,'Inspección de Baterías:','Verificación de densidad, voltajes, limpieza de bornes y estado del cargador estático de baterías.',1,'2026-06-06 20:17:59'),(199,23,'Ajuste y Control Eléctrico:','Revisión, reapriete de conexiones en el alternador de potencia y limpieza de componentes de control.',2,'2026-06-06 20:17:59'),(200,23,'Pruebas de Simulación:','Pruebas operativas programadas con y sin carga para evaluar la respuesta de arranque automático.',3,'2026-06-06 20:17:59'),(205,24,'Overhaul y Reconstrucción:','Desmontaje, evaluación dimensional y cambio integral de componentes internos de desgaste (kits de motor).',0,'2026-06-06 20:34:46'),(206,24,'Metrología de Precisión:','Medición técnica con micrómetros y alesómetros para garantizar tolerancias de fábrica en bloques y cigüeñales.',1,'2026-06-06 20:34:46'),(207,24,'Servicio de Culatas:','Rectificación, asientos de válvulas, cambio de guías, sellos y pruebas de estanqueidad hidráulica.',2,'2026-06-06 20:34:46'),(208,24,'Inyección y Turbos:','Mantenimiento preventivo y correctivo de turbocompresores, calibración de bombas de inyección e inyectores.',3,'2026-06-06 20:34:46'),(213,25,'Consumibles de Mantenimiento:','Filtros de aire, aceite, combustible y refrigerantes industriales de larga duración.',0,'2026-06-06 20:53:18'),(214,25,'Componentes de Control:','Módulos digitales de operación, tarjetas de regulación de voltaje (AVR) y sensores de seguridad.',1,'2026-06-06 20:53:18'),(215,25,'Repuestos de Fuerza:','Interruptores de potencia, contactores, relés de protección y cargadores estáticos de batería.',2,'2026-06-06 20:53:18'),(216,25,'Kits de Motor Mecánicos:','Empaquetaduras completas, inyectores, bombas de agua, fajas de transmisión y turbocompresores.',3,'2026-06-06 20:53:18'),(217,14,'Diseño y Consultoría:','Planificación técnica de ingeniería eléctrica bajo normativas internacionales.',0,'2026-06-07 00:47:58'),(218,14,'Montaje Electromecánico:','Instalación de celdas de media tensión, transformadores de potencia y cableado estructurado.',1,'2026-06-07 00:47:58'),(219,14,'Puesta en Marcha:','Configuración avanzada de sistemas de sincronismo e interconexión segura.',2,'2026-06-07 00:47:58'),(220,14,'Pruebas de Seguridad:','Ensayos exhaustivos de aislamiento, continuidad y sistemas de puesta a tierra.',3,'2026-06-07 00:47:58');
/*!40000 ALTER TABLE `service_items` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `services_pages`
--

DROP TABLE IF EXISTS `services_pages`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `services_pages` (
  `id` int NOT NULL AUTO_INCREMENT,
  `template_id` int DEFAULT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `content` text COLLATE utf8mb4_unicode_ci,
  `icon` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `image_alt` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_active` tinyint(1) DEFAULT '1',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `sort_order` int DEFAULT '0',
  `heading_description` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT 'Descripción',
  `heading_details` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT 'Detalles del servicio',
  `heading_gallery` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT 'Trabajos Realizados',
  `heading_cta` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT '¿Interesado en este Servicio?',
  `cta_description` varchar(1000) COLLATE utf8mb4_unicode_ci DEFAULT 'Nuestro equipo de especialistas está listo para diseñar una cotización personalizada adaptada a los requerimientos de tu proyecto.',
  `seo_title` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `seo_description` varchar(1000) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `seo_keywords` varchar(1000) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `slug` (`slug`),
  KEY `template_id` (`template_id`),
  CONSTRAINT `services_pages_ibfk_1` FOREIGN KEY (`template_id`) REFERENCES `services_templates` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=26 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `services_pages`
--

LOCK TABLES `services_pages` WRITE;
/*!40000 ALTER TABLE `services_pages` DISABLE KEYS */;
INSERT INTO `services_pages` VALUES (14,NULL,'Proyectos de Generación en Baja y Media Tensión','proyectos-de-generacion-en-baja-y-media-tension','<p>En <strong>Syncro Andina</strong> diseñamos, planificamos y ejecutamos proyectos de generación eléctrica en baja y media tensión, adaptados rigurosamente a las exigencias operativas y normativas de los sectores minero e industrial en el Perú.</p><p>Desarrollamos soluciones integrales de ingeniería que abarcan desde el tendido de redes y la habilitación de celdas de llegada hasta la interconexión de sistemas críticos de respaldo energético. Nuestro enfoque técnico garantiza una infraestructura robusta, optimizando la distribución de la carga y eliminando los riesgos de caídas de tensión que puedan comprometer la continuidad de sus operaciones o causar costosas paradas de planta.</p><p>Contamos con un equipo de ingenieros electromecánicos altamente calificados y equipamiento tecnológico de vanguardia para asegurar instalaciones eléctricas seguras, eficientes y de alta disponibilidad, preparadas para trabajar en las condiciones geográficas y climáticas más exigentes del país.</p>',NULL,'/assets/images/services/350b30b61a3ad798.webp','Instalación de plantas de generación térmica y subestaciones eléctricas en baja y media tensión por ingenieros de Syncro Andina.',1,'2026-06-03 02:59:35','2026-06-07 00:47:58',NULL,1,'Ingeniería Avanzada en Infraestructura de Baja y Media Tensión','Alcance Técnico de Nuestros Proyectos Eléctricos','Casos de Éxito y Obras Ejecutadas en Campo','¿Planea un Proyecto de Generación en Baja o Media Tensión?','Optimice su infraestructura eléctrica con el respaldo de ingenieros especialistas. Solicite una consultoría técnica para evaluar la demanda energética de su empresa y diseñar una solución a su medida.','Proyectos de Generación en Baja y Media Tensión','En Syncro Andina diseñamos, planificamos y ejecutamos proyectos de generación eléctrica en baja y media tensión, adaptados rigurosamente a las exigencias operativas y normativas de los sectores minero e industrial en el Perú.',''),(15,NULL,'Servicio de Sincronización de Grupos Electrógenos','servicio-de-sincronizacion-de-grupos-electrogenos','<p>En <strong>Syncro Andina</strong> nos especializamos en el servicio de sincronización de grupos electrógenos, permitiendo que múltiples unidades de generación térmica operen en paralelo de manera segura, eficiente y completamente automatizada. Esta solución es fundamental para empresas que buscan optimizar su consumo de combustible, absorber picos de demanda energética y garantizar un respaldo eléctrico redundante ante fallas críticas en la red principal.</p><p><br></p><p>Desarrollamos la ingeniería de sincronismo integrando módulos de control avanzados (como Deep Sea, ComAp o Woodward) y configurando el reparto equitativo de carga activa (kW) y reactiva (kVAR) entre los motores. Nuestro proceso elimina el riesgo de desfases eléctricos y retornos de energía, asegurando una transición suave y sin interrupciones en la transferencia de potencia hacia su planta industrial o campamento minero.</p><p><br></p><p>Ya sea para configurar un sistema de sincronismo entre grupos electrógenos diésel de gran potencia o para poner en marcha el paralelismo con la red comercial, nuestro equipo técnico le garantiza una calibración de alta precisión bajo los estándares internacionales de seguridad eléctrica.</p>',NULL,'/assets/images/services/4c11358b12a2222a.webp','Ingenieros electromecánicos realizando pruebas de sincronismo y paralelismo en grupos electrógenos industriales.',1,'2026-06-05 01:04:35','2026-06-05 22:52:50',NULL,2,'Sincronismo y Paralelismo de Motores Diésel de Alta Potencia','Especificaciones del Servicio de Sincronización Eléctrica','Sistemas de Sincronismo Implementados en Campo','¿Busca Automatizar el Sincronismo de sus Grupos Electrógenos?','Evite fallas críticas por desfases en sus motores. Póngase en contacto con nuestros ingenieros especialistas para diseñar una solución de paralelismo robusta y eficiente para su planta.',NULL,NULL,NULL),(16,NULL,'Servicio de Asesoría Personalizada en Generación y Soluciones Energéticas','servicio-de-asesoria-personalizada-en-generacion-y-soluciones-energeticas','<p>En <strong>Syncro Andina</strong> brindamos un servicio de asesoría personalizada en generación y soluciones energéticas, diseñado para acompañar a las empresas en la toma de decisiones estratégicas sobre su infraestructura eléctrica. Entendemos que cada proyecto industrial, comercial o minero posee demandas únicas; por ello, nuestros ingenieros especialistas evalúan a detalle sus requerimientos para proponer sistemas de respaldo y continuidad térmica altamente eficientes y técnica y económicamente viables.</p><p><br></p><p>Nuestra consultoría abarca el análisis crítico de sistemas de fuerza existentes, la recomendación de tecnologías de sincronismo adecuadas y la estructuración de proyectos de baja y media tensión. Nos enfocamos en resolver vulnerabilidades operativas, mitigar riesgos de sobrecarga y garantizar que su inversión tecnológica esté alineada con las normativas eléctricas vigentes en el Perú, asegurando el máximo retorno de inversión.</p><p><br></p><p>Al elegir nuestra asesoría especializada, usted contará con un socio estratégico en ingeniería electromecánica que le proporcionará informes técnicos claros, dimensionamientos precisos y un mapa de ruta óptimo para garantizar un suministro eléctrico ininterrumpido en sus operaciones más exigentes.</p>',NULL,'/assets/images/services/c3a8d65b1eec9ec1.webp','Consultoría técnica de ingeniería eléctrica y asesoría especializada en sistemas de generación de energía por ingenieros de Syncro Andina.',1,'2026-06-05 16:57:40','2026-06-05 22:52:50',NULL,3,'Consultoría Especializada en Ingeniería de Potencia y Eficiencia Energética','Componentes de Nuestro Servicio de Asesoría Técnica','Estudios y Asesorías Desarrolladas para la Industria','¿Necesita el Respaldo de Expertos para Planificar su Infraestructura Energética?','No arriesgue su inversión con dimensionamientos incorrectos. Solicite una asesoría personalizada con nuestro equipo de ingenieros y diseñe un sistema de generación seguro, eficiente y escalable.',NULL,NULL,NULL),(17,NULL,'Servicio de Evaluación de la Demanda Energética y Diseño de Soluciones a Medida','servicio-de-evaluacion-de-la-demanda-energetica-y-diseno-de-soluciones-a-medida','<p>En <strong>Syncro Andina </strong>ofrecemos un servicio especializado de evaluación de la <strong>demanda energética y diseño de soluciones a medida</strong>, enfocado en diagnosticar con precisión matemática el consumo real y las fluctuaciones de carga de su infraestructura. Mediante el uso de analizadores de redes y herramientas de registro de última generación, cuantificamos parámetros críticos como la potencia activa, reactiva, picos de arranque y distorsión armónica, evitando sobredimensionamientos costosos o subdimensionamientos de alto riesgo.</p><p><br></p><p>Con los datos crudos obtenidos en campo, nuestro departamento de ingeniería desarrolla diseños electromecánicos personalizados. Estructuramos la arquitectura técnica ideal para sus plantas térmicas, dimensionamos los transformadores de potencia adecuados y definimos la lógica de control para sus sistemas de transferencia y sincronismo, garantizando un proyecto eficiente, seguro y con la flexibilidad necesaria para futuras expansiones.</p><p><br></p><p>Este servicio le permite optimizar su factura eléctrica, mitigar penalizaciones por mal factor de potencia y, sobre todo, contar con un plano técnico y conceptual perfectamente adaptado al perfil operativo real de su empresa, asegurando una estabilidad energética absoluta.</p>',NULL,'/assets/images/services/ec76758c8caeba42.webp','Ingeniero utilizando un analizador de redes eléctricas para evaluar la demanda de carga en una planta industrial.',1,'2026-06-05 20:54:29','2026-06-05 22:52:50',NULL,4,'Diagnóstico de Carga Eléctrica y Diseño de Proyectos a la Medida','Etapas de la Evaluación y Diseño Energético','Estudios de Demanda y Diseños Implementados','¿Desea Conocer el Perfil Energético Real de su Infraestructura?','Proteja sus equipos y optimice sus costos operativos. Solicite un servicio de evaluación de demanda con nuestro equipo técnico y obtenga un diseño de ingeniería adaptado al 100% a sus necesidades reales.',NULL,NULL,NULL),(18,NULL,'Fabricación de Tableros de Sincronismo','fabricacion-de-tableros-de-sincronismo','<p>En Syncro Andina somos especialistas en la fabricación de tableros de sincronismo diseñados bajo los más estrictos estándares de ingeniería eléctrica. Estos sistemas centralizados permiten la integración, el paralelismo y la automatización de múltiples grupos electrógenos, logrando un reparto de carga equitativo y eficiente para responder con precisión ante las demandas de energía más críticas de la industria y la minería.</p><p><br></p><p>Cada tablero es ensamblado en nuestro taller utilizando componentes modulares de alta calidad y estructuras robustas que garantizan una larga vida útil en entornos operativos exigentes. Configuramos e integramos la lógica de control mediante controladores avanzados que supervisan de forma constante la frecuencia, el voltaje y el ángulo de fase de los motores, eliminando riesgos de desfases eléctricos antes del cierre de los interruptores de potencia.</p><p><br></p><p>Nuestra fabricación a medida asegura que el sistema se adapte por completo a la arquitectura energética de su empresa, ofreciendo interfaces intuitivas para el operador, compatibilidad con sistemas de monitoreo remoto (SCADA) y una protección termo-magnética y electrónica perimetral de máxima confiabilidad.</p>',NULL,'/assets/images/services/b72c921ad7451458.webp','Proceso de ensamblaje y cableado de un tablero de sincronismo industrial para control de energía en paralelo.',1,'2026-06-05 21:30:20','2026-06-06 20:47:00',NULL,5,'Diseño y Ensamblaje de Tableros de Sincronismo Industrial','Características Técnicas de Nuestra Fabricación','Sistemas de Control y Sincronismo Fabricados','¿Necesita un Tablero de Sincronismo a la Medida de su Operación?','Garantice el paralelismo seguro de sus equipos de generación. Póngase en contacto con nuestro equipo de ingeniería para cotizar la fabricación de un tablero eléctrico configurado exactamente para sus requerimientos técnicos.',NULL,NULL,NULL),(19,NULL,'Fabricación de Tableros de Transferencia Automática y/o Manual','fabricacion-de-tableros-de-transferencia-automatica-yo-manual','<p>En <strong>Syncro Andina</strong> diseñamos y fabricamos tableros de transferencia automática (TTA) y manual (TTM) que garantizan una conmutación de energía segura, rápida y confiable ante fallas o cortes en el suministro eléctrico principal. Nuestros tableros están preparados para coordinar la desconexión de la red comercial y ordenar el arranque inmediato del grupo electrógeno, asegurando que su planta, almacén o infraestructura crítica retome operaciones en cuestión de segundos.</p><p><br></p><p>La fabricación se realiza bajo normativas técnicas internacionales, empleando contactores robustos, interruptores motorizados de alta velocidad y enclavamientos tanto mecánicos como eléctricos. Este doble sistema de seguridad física evita de forma absoluta cualquier posibilidad de cortocircuito por retorno o cruce involuntario entre ambas fuentes de energía, protegiendo tanto sus cargas como la integridad de su personal técnico.</p><p><br></p><p>Integramos controladores de transferencia digitales configurables que monitorean constantemente las variaciones de voltaje, caídas de fase y frecuencia. Esto permite parametrizar retardos de temporización exactos para el enfriamiento de los motores y el reingreso suave de la red, entregando una solución de respaldo automatizada, duradera y libre de mantenimiento constante.</p>',NULL,'/assets/images/services/8f551fb1fa6edfd0.webp','Tablero de transferencia automática industrial con contactores e interruptores motorizados para conmutación de energía de respaldo.',1,'2026-06-05 21:58:21','2026-06-06 20:47:00',NULL,6,'Soluciones de Conmutación Eléctrica y Tableros de Transferencia','Especificaciones Técnicas de Nuestros Tableros de Transferencia','Tableros de Conmutación y Respaldo Fabricados en Campo','¿Busca Asegurar el Cambio de Energía Automática en su Empresa?','Proteja sus operaciones contra pérdidas de energía prolongadas. Solicite hoy mismo la cotización de un tablero de transferencia automática o manual dimensionado exactamente para la carga de su infraestructura.',NULL,NULL,NULL),(20,NULL,'Fabricación de Tableros de Distribución','fabricacion-de-tableros-de-distribucion','<p>En <strong>Syncro Andina</strong> diseñamos y fabricamos tableros de distribución eléctrica en baja tensión, configurados a la medida para centralizar, seccionar y proteger de manera eficiente los diferentes circuitos de fuerza e iluminación de sus instalaciones. Es un equipamiento indispensable para plantas industriales, centros comerciales y proyectos mineros que requieren una subdivisión de carga segura y balanceada con la máxima fiabilidad operativa.</p><p><br></p><p>Nuestra fabricación emplea gabinetes metálicos robustos con altos grados de protección IP y resistencia al impacto mecánico. Equipamos los sistemas utilizando interruptores termomagnéticos de caja moldeada (MCCB), llaves generales de alta capacidad y bloques de distribución modulares. Toda la arquitectura interna está diseñada para mitigar el estrés térmico, asegurando un óptimo flujo de disipación de calor y reduciendo a cero el riesgo de sobrecalentamientos imprevistos.</p><p><br></p><p>Implementamos peinados de cables con precisión milimétrica y barras conductoras de cobre electrolítico debidamente aisladas y etiquetadas según el Código Nacional de Electricidad. Esto no solo garantiza una protección perimetral infalible ante sobrecargas y cortocircuitos, sino que facilita drásticamente las labores posteriores de mantenimiento preventivo y futuras ampliaciones de carga en su infraestructura.</p>',NULL,'/assets/images/services/10bfcd2999a97232.webp','Tablero de distribución eléctrica industrial con interruptores termomagnéticos y de caja moldeada para protección de circuitos.',1,'2026-06-05 22:36:38','2026-06-06 20:47:00',NULL,7,'Sistemas de Distribución Eléctrica y Centralización de Fuerza','Características de Diseño de Nuestros Tableros de Distribución','Tableros de Distribución e Infraestructura Eléctrica Fabricada','¿Necesita un Tablero de Distribución Seguro y Configurado a Medida?','Evite fallas por sobrecarga y asegure la protección de su maquinaria pesada. Solicite una cotización con nuestro equipo de ingeniería para fabricar un sistema de distribución eléctrica balanceado y bajo norma técnica.',NULL,NULL,NULL),(21,NULL,'Soluciones de Generación Electromecánica','soluciones-de-generacion-electromecanica','<p>En <strong>Syncro Andina</strong> desarrollamos soluciones de <strong>generación electromecánica</strong> integrales, abordando proyectos de gran envergadura desde la ingeniería conceptual hasta el montaje final en campo. Nos especializamos en la integración de sistemas mecánicos de combustión y potencia con infraestructuras eléctricas de distribución, asegurando que cada planta de generación térmica opere en un entorno técnico balanceado, seguro y optimizado para el rendimiento continuo.</p><p><br></p><p>Nuestro alcance abarca el diseño e instalación de sistemas críticos de soporte para motores diésel de gran potencia, incluyendo líneas de alimentación de combustible con tanques de almacenamiento normados, sistemas de escape industrial con atenuadores de ruido (silenciadores) y ductos de ventilación forzada para garantizar el correcto flujo térmico en salas de máquinas o casas de fuerza.</p><p><br></p><p>Coordinamos cada fase del montaje electromecánico bajo estrictas medidas de seguridad y alineamiento dimensional, garantizando el acoplamiento perfecto entre motor y alternador, la amortiguación de vibraciones estructurales y la correcta canalización de los conductores de fuerza en baja y media tensión. Ofrecemos una ejecución llave en mano que respalda de forma definitiva la infraestructura energética de sectores mineros, industriales y comerciales.</p>',NULL,'/assets/images/services/4925541a0a69907d.webp','Montaje e instalación de plantas de generación térmica y sistemas electromecánicos industriales.',1,'2026-06-05 22:58:29','2026-06-06 20:47:00',NULL,8,'Ingeniería y Montaje de Plantas de Generación Electromecánica','Alcance de Nuestras Soluciones Electromecánicas','Obras e Infraestructuras Electromecánicas Ejecutadas','¿Planea Implementar o Migrar una Planta Electromecánica?','Asegure la robustez de su infraestructura energética con un montaje de nivel ingeniería. Solicite una consultoría técnica con nuestros especialistas electromecánicos para desarrollar un proyecto llave en mano y a la medida de su empresa.',NULL,NULL,NULL),(22,NULL,'Mantenimiento Correctivo de Grupos Electrógenos','mantenimiento-correctivo-de-grupos-electrogenos','<p>En <strong>Syncro Andina</strong> ofrecemos un servicio especializado de mantenimiento correctivo de <strong>grupos electrógenos</strong>, diseñado para atender fallas inesperadas y restablecer el suministro eléctrico de respaldo de su empresa en el menor tiempo posible. Entendemos que una parada imprevista en sus sistemas de generación puede traducirse en cuantiosas pérdidas económicas y riesgos operativos; por ello, contamos con un equipo de soporte técnico de respuesta rápida preparado para diagnosticar y solucionar averías de alta complejidad en campo.</p><p><br></p><p>Nuestro servicio abarca la reparación integral de fallas mecánicas en el motor de combustión y fallas eléctricas en el alternador de potencia o en el sistema de control. Desarmamos, evaluamos y reparamos componentes críticos bajo estrictas tolerancias de fábrica, solucionando desde problemas en el sistema de inyección de combustible y sobrecalentamientos térmicos, hasta cortocircuitos en los devanados, averías en los interruptores de potencia y desprogramación de módulos de transferencia.</p><p><br></p><p>Utilizamos herramientas de diagnóstico por computadora de nivel industrial para identificar códigos de error con precisión matemática. Al confiar en nuestro mantenimiento correctivo, usted se asegura de que el equipo no solo vuelva a encender, sino que recupere sus parámetros nominales de operación, garantizando una entrega de carga estable, segura y completamente confiable ante cualquier emergencia de red.</p>',NULL,'/assets/images/services/8cc6498b16d47eb1.webp','Técnicos electromecánicos reparando una falla crítica en un motor diésel de un grupo electrógeno industrial.',1,'2026-06-06 01:49:32','2026-06-06 20:47:00',NULL,9,'Reparación y Soporte Técnico de Emergencia para Sistemas de Generación','Alcance de Nuestro Servicio de Mantenimiento Correctivo','Intervenciones Correctivas y Reparaciones de Éxito en Campo','¿Su Grupo Electrógeno Presenta Fallas o No Enciende?','Restablezca la seguridad energética de su planta con técnicos expertos. Póngase en contacto inmediato con nuestro equipo de ingeniería para coordinar una visita técnica correctiva de urgencia.',NULL,NULL,NULL),(23,NULL,'Mantenimiento Preventivo de Grupos Electrógenos','mantenimiento-preventivo-de-grupos-electrogenos','<p>En <strong>Syncro Andina</strong> diseñamos y ejecutamos programas integrales de <strong>mantenimiento preventivo para grupos electrógenos</strong>, asegurando que sus sistemas de energía de respaldo se mantengan en óptimas condiciones operativas y listos para responder con un 100% de fiabilidad ante cualquier falla de la red eléctrica comercial. Un plan de inspección técnica periódica es la estrategia más eficiente para prolongar la vida útil de sus motores diésel, reducir costos por reparaciones de emergencia y mitigar el riesgo de paradas imprevistas en su planta industrial o campamento minero.</p><p><br></p><p>Nuestros protocolos de servicio se estructuran bajo estrictos estándares técnicos e incluyen rutinas exhaustivas de revisión por niveles (filtros, fluidos y sistemas críticos). Realizamos el cambio programado de consumibles esenciales como aceite multigrado, refrigerantes de larga duración, filtros de combustible, agua y aire. Asimismo, evaluamos el estado de desgaste de las fajas de transmisión, mangueras, y el correcto funcionamiento del sistema de precalentamiento del bloque del motor.</p><p><br></p><p>El mantenimiento preventivo no se limita a la mecánica; nuestro equipo de ingenieros y técnicos especializados inspecciona detalladamente el sistema eléctrico y electrónico de control. Verificamos el estado y nivel de carga de las baterías de arranque, calibramos los parámetros de operación en los módulos digitales, revisamos el correcto apriete de bornes de potencia en los alternadores y simulamos transferencias de carga en vacío y con carga real, entregando un informe técnico detallado que certifica la solidez energética de sus instalaciones.</p>',NULL,'/assets/images/services/481d1a2c15e886e8.webp','Inspección técnica programada y mantenimiento preventivo de un grupo electrógeno industrial en una sala de máquinas.',1,'2026-06-06 03:26:31','2026-06-06 20:47:00',NULL,10,'Planes de Mantenimiento Programado y Gestión de Activos Energéticos','Protocolos de Inspección Preventiva y Monitoreo Técnico','Programas de Mantenimiento Preventivo Ejecutados a Nivel Nacional','¿Desea Garantizar que su Grupo Electrógeno Responda ante una Emergencia?','Evite fallas costosas y proteja la continuidad de su empresa. Póngase en contacto con nuestro equipo de ingeniería para diseñar un plan de mantenimiento preventivo anual adaptado al régimen operativo de sus equipos.',NULL,NULL,NULL),(24,NULL,'Servicio de Reparación de Motores de Grupos Electrógenos','servicio-de-reparacion-de-motores-de-grupos-electrogenos','<p>En <strong>Syncro Andina</strong> ofrecemos un <strong>servicio especializado de reparación mayor y reconstrucción integral (Overhaul) de motores de grupos electrógenos diésel de gran potencia.</strong> Cuando un motor alcanza su límite de horas de operación establecido por el fabricante o presenta una pérdida drástica de eficiencia térmica y mecánica, nuestro equipo de ingenieros y técnicos interviene el equipo bajo rigurosos protocolos de metrología y precisión mecánica, devolviendo al motor a sus parámetros nominales con una confiabilidad cercana al 100% de su estado original.</p><p><br></p><p>El proceso de reparación se ejecuta en talleres especializados o directamente en las instalaciones del cliente bajo estrictas condiciones de limpieza y control ambiental. Desarmamos el motor por completo para realizar el lavado químico de bloques, pruebas de tintes penetrantes para detectar fisuras y la evaluación dimensional de componentes críticos. Reemplazamos todos los elementos de desgaste interno empleando kits de reparación de alta calidad, incluyendo camisas de cilindro, pistones, anillos, cojinetes de biela y bancada, además de la reconstrucción de la culata y el mantenimiento del sistema de sobrealimentación (turbocompresores).</p><p><br></p><p>Asimismo, calibramos e inspeccionamos el sistema de inyección de combustible de alta presión y el sistema de sincronización mecánica. Cada motor reparado pasa por un riguroso proceso de asentamiento y pruebas dinámicas de rendimiento antes de ser reincorporado a la estructura de potencia de la empresa, asegurando una compresión perfecta, una combustión limpia y la estabilidad energética ininterrumpida que sus operaciones mineras o industriales demandan.</p>',NULL,'/assets/images/services/d26d9b83105e8460.webp','Proceso de reconstrucción y reparación mayor u overhaul de un motor diésel de gran potencia para grupo electrógeno industrial.',1,'2026-06-06 20:24:37','2026-06-06 20:47:00',NULL,11,'Reparación Mayor (Overhaul) y Reacondicionamiento de Motores Diésel','Procesos de Ingeniería en Reparación de Motores de Potencia','Motores Reconstruidos y Puestos en Operación Comercial','¿Su Motor ha Cumplido su Ciclo de Horas o Requiere una Reparación Mayor?','Recupere la potencia original y la confiabilidad de su sistema de generación térmica. Solicite una evaluación técnica con nuestros especialistas en motores pesados para programar un servicio de overhaul bajo norma de ingeniería.',NULL,NULL,NULL),(25,NULL,'Venta de Repuestos para Grupos Electrógenos','venta-de-repuestos-para-grupos-electrogenos','<p>En <strong>Syncro Andina</strong> proveemos un servicio especializado de <strong>suministro y venta de repuestos para grupos electrógenos</strong>, garantizando el acceso inmediato a componentes originales y consumibles críticos de la más alta calidad industrial. Comprendemos que la disponibilidad oportuna de una pieza puede marcar la diferencia entre la continuidad de su planta o una costosa parada no programada; por ello, mantenemos un stock estratégico diseñado para atender las demandas y emergencias operativas de los sectores minero, comercial e industrial en todo el Perú.</p><p><br></p><p>Nuestro catálogo abarca una amplia gama de soluciones que cubren tanto las necesidades mecánicas como eléctricas de los sistemas de generación térmica. Suministramos desde filtros de alta eficiencia (aire, aceite, combustible y separadores de agua) y aceites multigrado normados, hasta componentes mayores de motor como empaquetaduras, turbocompresores, bombas de agua y kits de reparación. Asimismo, proveemos elementos de control y potencia esenciales, incluyendo tarjetas reguladoras de voltaje (AVR), cargadores estáticos de baterías, sensores de protección y módulos de control digital.</p><p><br></p><p>Al adquirir sus componentes con nosotros, usted recibe el respaldo de un equipo de ingenieros que le brindará asesoría técnica especializada para asegurar la compatibilidad exacta de cada pieza con el modelo y número de serie de su motor. Nos encargamos de la gestión logística integral para despachar los repuestos con la máxima velocidad y seguridad hacia su proyecto, garantizando un rendimiento óptimo y prolongando la vida útil de su infraestructura energética.</p>',NULL,'/assets/images/services/d3f2579cb47b3a46.webp','Almacén industrial con stock disponible de repuestos, consumibles y componentes críticos para grupos electrógenos.',1,'2026-06-06 20:46:52','2026-06-06 20:53:18',NULL,12,'Suministro Especializado de Componentes y Consumibles Industriales','Categorías de Nuestro Inventario de Repuestos de Potencia','Garantía de Suministro y Despacho Logístico en Campo','¿Requiere una Cotización de Repuestos o Componentes Críticos?','Mantenga sus sistemas de respaldo operativos con repuestos de alta confiabilidad. Envíenos el modelo o número de serie de sus equipos de generación y nuestro equipo técnico le cotizará las piezas exactas con despacho a nivel nacional.',NULL,NULL,NULL);
/*!40000 ALTER TABLE `services_pages` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `services_templates`
--

DROP TABLE IF EXISTS `services_templates`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `services_templates` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `layout_structure` json DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `services_templates`
--

LOCK TABLES `services_templates` WRITE;
/*!40000 ALTER TABLE `services_templates` DISABLE KEYS */;
/*!40000 ALTER TABLE `services_templates` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `settings`
--

DROP TABLE IF EXISTS `settings`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `settings` (
  `id` int NOT NULL AUTO_INCREMENT,
  `setting_key` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `setting_value` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `setting_key` (`setting_key`)
) ENGINE=InnoDB AUTO_INCREMENT=796 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `settings`
--

LOCK TABLES `settings` WRITE;
/*!40000 ALTER TABLE `settings` DISABLE KEYS */;
INSERT INTO `settings` VALUES (1,'logo_url','/assets/images/branding/834d39d785976308.png?1778105256','2026-05-05 04:18:37','2026-05-06 22:07:36'),(2,'contact_phone','+51933178568','2026-05-05 04:18:37','2026-05-05 13:53:25'),(3,'font_h1','Inter','2026-05-05 11:34:44','2026-05-05 11:35:52'),(4,'font_h2','Inter','2026-05-05 11:34:44','2026-05-05 11:35:52'),(5,'font_h3','Inter','2026-05-05 11:34:44','2026-05-05 11:35:52'),(6,'font_h4','Inter','2026-05-05 11:34:44','2026-05-05 11:35:52'),(7,'font_h5','Inter','2026-05-05 11:34:44','2026-05-05 11:35:52'),(8,'font_h6','Inter','2026-05-05 11:34:44','2026-05-05 11:35:52'),(9,'font_body','Inter','2026-05-05 11:34:44','2026-05-05 11:35:52'),(17,'color_primary','#08173A','2026-05-05 11:36:18','2026-05-06 21:38:50'),(18,'color_secondary','#DB0000','2026-05-05 11:36:18','2026-05-06 21:38:03'),(19,'color_accent','#FF0000','2026-05-05 11:36:18','2026-05-06 21:38:03'),(20,'color_light_gray','#f8fafc','2026-05-05 11:36:18','2026-05-05 11:36:18'),(21,'color_gray','#64748b','2026-05-05 11:36:18','2026-05-05 11:36:18'),(22,'color_dark_gray','#1e293b','2026-05-05 11:36:18','2026-05-05 11:36:18'),(54,'favicon_url','/assets/images/branding/f41714081232705f.png?1778105256','2026-05-05 11:42:10','2026-05-06 22:07:36'),(88,'services_label','INGENIERÍA ENERGÉTICA','2026-05-05 21:36:32','2026-05-21 14:41:04'),(89,'services_title','Soluciones de Generación Eléctrica, Fabricación de Tableros y Servicios Electromecánicos','2026-05-05 21:36:32','2026-05-21 14:47:24'),(90,'services_description','Somos especialistas en el diseño y ejecución de sistemas de energía de respaldo a diésel. Desde la evaluación de carga hasta la fabricación de tableros de distribución, optimizamos sus operaciones con mantenimiento correctivo especializado y venta de repuestos originales para grupos electrógenos.','2026-05-05 21:36:32','2026-05-21 14:47:24'),(94,'services_limit','3','2026-05-05 22:05:35','2026-05-05 22:05:35'),(95,'page_services_title','Sistemas de Generación Térmica, Sincronismo de Motores y Tableros de Transferencia','2026-05-05 22:05:35','2026-05-21 14:47:24'),(96,'page_services_description','Garantizamos la continuidad de su infraestructura con asesoría personalizada en ingeniería energética. Desarrollamos proyectos en baja y media tensión, soluciones electromecánicas a medida y un servicio técnico de reparación y mantenimiento para grupos electrógenos industriales.','2026-05-05 22:05:35','2026-05-21 14:47:24'),(97,'contact_seo_title','Contacto - Syncro Andina','2026-05-06 00:18:36','2026-05-06 00:18:36'),(98,'contact_seo_description','Ponte en contacto con Syncro Andina. Solicita información comercial o de soporte técnico para escalar la tecnología de tu empresa.','2026-05-06 00:18:36','2026-05-06 00:18:36'),(99,'contact_seo_keywords','contacto, cotización, soporte corporativo, syncro andina','2026-05-06 00:18:36','2026-05-06 00:18:36'),(100,'contact_heading','Inicie su proyecto con nosotros','2026-05-06 00:18:36','2026-05-21 17:29:34'),(101,'contact_description','Póngase en contacto con nuestro equipo de ingeniería para coordinar una consultoría técnica de evaluación y diseñar la solución energética exacta que su infraestructura requiere.','2026-05-06 00:18:36','2026-05-21 17:29:13'),(102,'contact_address_label','Estamos en:','2026-05-06 00:18:36','2026-05-06 01:18:05'),(103,'contact_address_value','Lima - Perú','2026-05-06 00:18:36','2026-05-06 01:18:05'),(104,'contact_email_label','Correo Corporativo:','2026-05-06 00:18:36','2026-05-06 01:18:05'),(105,'contact_email_value','ventas@syncroandina.pe','2026-05-06 00:18:36','2026-05-21 17:29:13'),(106,'contact_phone_label','Línea de Atención:','2026-05-06 00:18:36','2026-05-06 01:18:06'),(107,'contact_phone_value','+51 933 178 568','2026-05-06 00:18:36','2026-05-21 17:29:13'),(108,'contact_form_heading','Solicitar Asesoría Especializada','2026-05-06 00:18:36','2026-05-21 17:29:13'),(109,'about_seo_title','Syncro Andina | Ingeniería de Potencia y Sincronismo en Perú','2026-05-06 00:25:31','2026-05-21 17:53:44'),(110,'about_seo_description','En Syncro Andina estamos convencidos de que la ingeniería de potencia avanzada no es solo un soporte, sino el pilar fundamental que garantiza la continuidad operativa y el crecimiento sostenible del sector industrial y minero.','2026-05-06 00:25:31','2026-05-21 17:50:09'),(111,'about_seo_keywords','syncro andina sac,ingenieria de potencia peru,sincronismo de grupos electrogenos,soluciones energeticas industriales,mantenimiento de grupos electrogenos,tableros de transferencia automatica,casas de fuerza mineria,motores diesel de gran potencia,proyectos electromecanicos,servicios energeticos en baja y media tension','2026-05-06 00:25:31','2026-05-21 17:52:43'),(112,'about_title','SYNCRO ANDINA S.A.C','2026-05-06 00:25:31','2026-05-21 17:50:09'),(113,'about_description','En Syncro Andina estamos convencidos de que la ingeniería de potencia avanzada no es solo un soporte, sino el pilar fundamental que garantiza la continuidad operativa y el crecimiento sostenible del sector industrial y minero.','2026-05-06 00:25:31','2026-05-21 17:50:09'),(114,'about_image_title','Nuestro Equipo','2026-05-06 00:25:31','2026-05-06 00:25:31'),(115,'about_image_subtitle','Especialistas en ingeniería electromecánica','2026-05-06 00:25:31','2026-05-21 17:50:09'),(116,'about_mission_title','Nuestra Misión','2026-05-06 00:25:31','2026-05-21 17:51:00'),(117,'about_mission_desc','Elevar los estándares de eficiencia y seguridad en sistemas de generación de energía a nivel nacional, entregando soluciones de sincronismo y respaldo técnico de máxima precisión.','2026-05-06 00:25:31','2026-05-21 17:51:00'),(118,'about_impact_title','Respaldo y Solidez','2026-05-06 00:25:31','2026-05-21 17:51:00'),(119,'about_impact_desc','Garantizamos la continuidad operativa de infraestructuras críticas en minería, comercio e industria, optimizando sistemas térmicos y tableros eléctricos bajo estrictas normas de ingeniería.','2026-05-06 00:25:31','2026-05-21 17:51:00'),(120,'about_image','//assets/images/about/3bde5279fd12fd83.jpeg','2026-05-06 00:25:31','2026-05-06 01:52:54'),(133,'footer_description','Transformando negocios con soluciones tecnológicas innovadoras. Llevamos tu corporación al siguiente nivel de eficiencia y seguridad.','2026-05-06 01:05:50','2026-05-06 01:05:50'),(134,'footer_facebook','#','2026-05-06 01:05:50','2026-05-06 01:09:38'),(135,'footer_instagram','#','2026-05-06 01:05:50','2026-05-06 01:09:38'),(136,'footer_linkedin','','2026-05-06 01:05:50','2026-05-06 01:09:38'),(137,'footer_twitter','','2026-05-06 01:05:50','2026-05-06 01:09:38'),(138,'footer_youtube','#','2026-05-06 01:05:50','2026-05-06 01:09:38'),(139,'footer_menu_heading','Enlaces Rápidos','2026-05-06 01:05:50','2026-05-06 01:05:50'),(140,'footer_link_title_1','Inicio','2026-05-06 01:05:50','2026-05-06 01:14:15'),(141,'footer_link_url_1','http://localhost:8000/','2026-05-06 01:05:50','2026-05-06 01:14:15'),(142,'footer_link_title_2','La empresa','2026-05-06 01:05:50','2026-05-06 01:14:15'),(143,'footer_link_url_2','/nosotros','2026-05-06 01:05:50','2026-05-06 01:14:15'),(144,'footer_link_title_3','Servicios','2026-05-06 01:05:50','2026-05-06 01:14:15'),(145,'footer_link_url_3','/servicios','2026-05-06 01:05:50','2026-05-06 01:14:15'),(146,'footer_link_title_4','Proyectos','2026-05-06 01:05:50','2026-05-06 01:14:15'),(147,'footer_link_url_4','/proyectos','2026-05-06 01:05:50','2026-05-06 01:14:15'),(148,'footer_link_title_5','Contacto','2026-05-06 01:05:50','2026-05-06 01:14:15'),(149,'footer_link_url_5','/contacto','2026-05-06 01:05:50','2026-05-06 01:14:15'),(319,'projects_home_title','Proyectos Realizados en Generación y Sincronismo de Energía','2026-05-06 03:10:25','2026-05-21 15:18:08'),(320,'projects_home_subtitle','Evidencia de nuestra capacidad operativa y precisión técnica en campo. Documentamos nuestros trabajos en migración de plantas térmicas, paralelismo de motores de gran potencia y automatización de sistemas eléctricos de respaldo para los sectores más exigentes del país.','2026-05-06 03:10:25','2026-05-21 15:18:08'),(321,'projects_page_title','Casos de Éxito en Proyectos de Generación Eléctrica Industrial','2026-05-06 03:10:25','2026-05-21 15:18:08'),(322,'projects_page_subtitle','Garantía de rendimiento y continuidad a través de obras ejecutadas con los más altos estándares. Diseñamos e instalamos infraestructuras de baja y media tensión, consolidándonos como socios estratégicos en el desarrollo energético del sector minero e industrial.','2026-05-06 03:10:25','2026-05-21 15:18:08'),(335,'home_cta_tagline','¿LISTO PARA ASEGURAR SU OPERACIÓN?','2026-05-06 21:39:45','2026-05-21 14:53:37'),(336,'home_cta_headline','Garantice la potencia y continuidad de su infraestructura industrial','2026-05-06 21:39:45','2026-05-21 14:53:37'),(337,'home_cta_description','Nuestro equipo de ingenieros está listo para diseñar la solución energética exacta que su empresa requiere. Evite paradas imprevistas con sistemas de respaldo de alta confiabilidad.','2026-05-06 21:39:45','2026-05-21 14:53:37'),(338,'home_cta_btn1_title','Solicitar asesoría','2026-05-06 21:39:45','2026-05-06 22:41:20'),(339,'home_cta_btn1_url','/contacto','2026-05-06 21:39:45','2026-05-06 21:39:45'),(340,'home_cta_btn2_title','Ver servicios','2026-05-06 21:39:45','2026-05-06 22:41:20'),(341,'home_cta_btn2_url','/servicios','2026-05-06 21:39:45','2026-05-06 21:39:45'),(374,'footer_brand_name','Syncro Andina','2026-05-07 02:15:19','2026-05-07 02:15:19'),(375,'footer_copyright','© 2026 Syncro Andina. Todos los derechos reservados.','2026-05-07 02:15:19','2026-05-07 02:15:19'),(386,'clients_slider_speed','40s','2026-05-07 22:24:22','2026-05-18 01:07:09'),(387,'clients_slider_gap','gap-12','2026-05-07 22:24:22','2026-05-07 23:13:10'),(390,'gallery_home_title','Galería de Operaciones e Infraestructura Energética','2026-05-11 17:25:13','2026-05-21 15:29:47'),(391,'gallery_home_subtitle','Inspeccione nuestra capacidad en campo a través de registros reales de nuestros proyectos. Evidencia fotográfica de la instalación de casas de fuerza, sincronismo de motores diésel y fabricación de tableros eléctricos.','2026-05-11 17:25:13','2026-05-21 15:29:47'),(396,'gallery_home_tagline','VISUALICE NUESTRO TRABAJO','2026-05-11 17:40:30','2026-05-21 15:29:47'),(408,'container_desktop','85%','2026-05-13 22:17:52','2026-05-13 22:19:05'),(409,'container_tablet','90%','2026-05-13 22:17:52','2026-05-13 22:17:52'),(410,'container_mobile','95%','2026-05-13 22:17:52','2026-05-13 22:21:40'),(417,'products_label','','2026-05-14 02:05:24','2026-05-14 02:05:24'),(418,'products_title','','2026-05-14 02:05:24','2026-05-14 02:05:24'),(419,'products_description','','2026-05-14 02:05:24','2026-05-14 02:05:24'),(420,'page_products_title','','2026-05-14 02:05:24','2026-05-14 02:05:24'),(421,'page_products_description','','2026-05-14 02:05:24','2026-05-14 02:05:24'),(422,'notification_emails','pablobautista.dev@gmail.com','2026-05-17 17:00:54','2026-05-17 17:03:24'),(423,'notification_enable_admin','1','2026-05-17 17:00:54','2026-05-17 17:11:37'),(424,'notification_enable_client','1','2026-05-17 17:00:54','2026-05-17 17:11:37'),(425,'notification_sender_name','Syncro Andina','2026-05-17 17:00:54','2026-05-17 17:03:24'),(442,'notification_use_smtp','1','2026-05-17 17:33:34','2026-05-17 17:33:34'),(443,'notification_smtp_host','smtp.gmail.com','2026-05-17 17:33:34','2026-05-17 17:33:34'),(444,'notification_smtp_port','465','2026-05-17 17:33:34','2026-05-17 17:33:34'),(445,'notification_smtp_encryption','ssl','2026-05-17 17:33:34','2026-05-17 17:33:34'),(446,'notification_smtp_user','pablobautista.dev@gmail.com','2026-05-17 17:33:34','2026-05-17 17:33:34'),(447,'notification_smtp_pass','byad urnc hipe avzg','2026-05-17 17:33:34','2026-05-17 17:33:34'),(473,'carousel_services_speed','4000','2026-05-18 00:51:49','2026-05-18 01:05:59'),(485,'carousel_projects_speed','4000','2026-05-18 01:02:34','2026-05-18 01:06:08'),(486,'home_blog_tagline','ARTÍCULOS ESPECIALIZADOS','2026-05-18 01:03:57','2026-05-21 17:17:15'),(487,'home_blog_title','Artículos Técnicos de Energía y Sistemas de Respaldo','2026-05-18 01:03:57','2026-05-21 17:17:15'),(488,'blog_page_tagline','CONOCIMIENTO COMPARTIDO','2026-05-18 01:03:57','2026-05-21 18:19:46'),(489,'blog_page_title','Artículos Técnicos de Energía y Sistemas de Respaldo','2026-05-18 01:03:57','2026-05-21 18:19:46'),(490,'blog_page_description','Compartimos nuestra experiencia en campo: guías de mantenimiento preventivo para grupos electrógenos, normativas de tableros eléctricos y las últimas innovaciones en sincronismo e ingeniería de potencia industrial.','2026-05-18 01:03:57','2026-05-21 18:19:46'),(491,'blog_sidebar_cta_title','¿Necesita Soporte Técnico?','2026-05-18 01:03:57','2026-05-21 18:19:46'),(492,'blog_sidebar_cta_description','Consulte con nuestros ingenieros especialistas la solución exacta para sus sistemas de potencia y grupos electrógenos.','2026-05-18 01:03:57','2026-05-21 18:19:46'),(493,'blog_sidebar_cta_btn_text','Solicitar Cotización','2026-05-18 01:03:57','2026-05-21 18:19:46'),(494,'carousel_blog_speed','4000','2026-05-18 01:03:57','2026-05-18 01:06:42'),(512,'carousel_products_speed','4000','2026-05-18 01:06:18','2026-05-18 01:06:18'),(516,'carousel_gallery_speed','4000','2026-05-18 01:06:29','2026-05-18 01:06:29'),(585,'products_home_title','Suministro de Repuestos Especializados','2026-05-21 15:11:29','2026-05-21 15:11:29'),(586,'products_home_subtitle','Optimice sus sistemas de generación electromecánica con soluciones de repuestos a medida. Ofrecemos componentes certificados para motores de baja y media tensión, asegurando el respaldo energético continuo que su infraestructura demanda.','2026-05-21 15:11:29','2026-05-21 15:11:29'),(587,'products_page_title','Venta de Repuestos para Grupos Electrógenos Cummins, Caterpillar y Perkins','2026-05-21 15:11:29','2026-05-21 15:12:24'),(588,'products_page_subtitle','Mantenga la máxima eficiencia de sus equipos con nuestro catálogo especializado de repuestos originales y componentes críticos para plantas de generación térmica. Suministramos filtros, fajas, módulos de control y repuestos de alta calidad para motores diésel de gran potencia.','2026-05-21 15:11:29','2026-05-21 15:12:24'),(602,'clients_slider_tagline','PRESENCIA EN EL SECTOR','2026-05-21 15:25:48','2026-05-21 15:25:48'),(603,'clients_slider_title','Marcas y Empresas que Respaldan Nuestra Ingeniería','2026-05-21 15:25:48','2026-05-21 15:25:48'),(610,'home_blog_description','Compartimos nuestra experiencia en campo: recomendaciones de mantenimiento preventivo para grupos electrógenos, normativas de tableros eléctricos y tecnologías de transferencia automática.','2026-05-21 17:17:15','2026-05-21 17:17:15'),(642,'call_center_main_title','Central de Atención','2026-05-21 17:32:00','2026-05-21 17:32:00'),(643,'call_center_main_subtitle','ESTAMOS LISTOS PARA AYUDARTE','2026-05-21 17:32:00','2026-05-21 17:32:00'),(644,'call_center_footer_text','© Syncro Andina - Soluciones Industriales','2026-05-21 17:32:00','2026-05-21 17:32:00'),(645,'call_center_is_visible','1','2026-05-21 17:32:00','2026-05-21 17:32:00'),(653,'about_image_alt','Nuestro Equipo','2026-05-21 17:50:09','2026-05-21 17:50:09'),(694,'home_seo_title','Generación Eléctrica y Servicios Electromecánicos - Syncro Andina','2026-05-21 18:05:07','2026-05-21 18:05:36'),(695,'home_seo_keywords','transformación digital, desarrollo web, software a medida, aplicaciones corporativas','2026-05-21 18:05:07','2026-05-21 18:05:07'),(696,'home_seo_description','Syncro Andina: Desarrollo de software premium, transformación digital y modernización cloud para corporaciones.','2026-05-21 18:05:07','2026-05-21 18:05:07'),(697,'home_welcome_title','Impulsa tu negocio con tecnología de vanguardia','2026-05-21 18:05:07','2026-05-21 18:05:07'),(698,'home_welcome_description','Ofrecemos soluciones integrales diseñadas para impulsar el crecimiento y la seguridad de tu infraestructura corporativa a través de consultoría tecnológica de alto nivel.','2026-05-21 18:05:07','2026-05-21 18:05:07'),(711,'services_seo_title','Servicios de Ingeniería de Potencia y Grupos Electrógenos','2026-05-21 18:11:59','2026-05-21 18:11:59'),(712,'services_seo_keywords','servicios electromecanicos,sincronismo de grupos electrógenos,tableros de transferencia automatica,mantenimiento preventivo grupos electrogenos,reparacion de motores diesel,proyectos baja media tension,tableros de distribucion,venta de repuestos grupos electrogenos,soluciones energeticas a medida,evaluacion demanda energetica','2026-05-21 18:11:59','2026-05-21 18:11:59'),(713,'services_seo_description','Expertos en sincronismo de grupos electrógenos, fabricación de tableros avanzados y mantenimiento correctivo y preventivo. Soluciones de potencia en Perú.','2026-05-21 18:11:59','2026-05-21 18:11:59'),(719,'products_seo_title','Venta de Repuestos para Grupos Electrógenos | Cummins, CAT y Perkins','2026-05-21 18:13:30','2026-05-21 18:13:30'),(720,'products_seo_keywords','repuestos para grupos electrogenos,repuestos cummins peru,repuestos caterpillar grupos electrogenos,componentes plantas de generacion,filtros para motores diesel,modulos de control grupos electrogenos,repuestos originales perkins,suministro de componentes industriales,mantenimiento correctivo motores diésel,accesorios grupos electrógenos','2026-05-21 18:13:30','2026-05-21 18:13:30'),(721,'products_seo_description','Suministro especializado de repuestos originales y componentes críticos para grupos electrógenos Cummins, Caterpillar y Perkins. Stock industrial en Perú.','2026-05-21 18:13:30','2026-05-21 18:13:30'),(727,'projects_seo_title','Proyectos Ejecutados y Casos de Éxito | Syncro Andina','2026-05-21 18:15:26','2026-05-21 18:15:26'),(728,'projects_seo_keywords','proyectos de generacion electrica,casas de fuerza mineria,implementacion de plantas termicas,casos de exito ingenieria,obras electromecanicas peru,instalacion baja media tension,proyectos de sincronismo en campo,automatizacion sistemas de energia,ingenieria de potencia cusco,sistemas de respaldo industrial','2026-05-21 18:15:26','2026-05-21 18:15:26'),(729,'projects_seo_description','Conozca nuestros proyectos y casos de éxito en ingeniería de potencia, casas de fuerza y sistemas de generación en baja y media tensión en todo el Perú.','2026-05-21 18:15:26','2026-05-21 18:15:26'),(740,'blog_seo_title','Blog Técnico de Ingeniería Energética y Grupos Electrógenos | Syncro Andina','2026-05-21 18:19:46','2026-05-21 18:21:10'),(741,'blog_seo_keywords','blog tecnico ingenieria,guias de mantenimiento grupos electrogenos,normas de tableros electricos,sincronismo de motores industriales,articulos de ingenieria de potencia,sistemas de respaldo a diesel,soluciones electromecanicas peru,capacitacion en energia termica,informacion tecnica cummins caterpillar','2026-05-21 18:19:46','2026-05-21 18:21:10'),(742,'blog_seo_description','Artículos técnicos, recomendaciones de mantenimiento de grupos electrógenos y soluciones de sincronismo industrial para ingenieros y empresas en el Perú.','2026-05-21 18:19:46','2026-05-21 18:21:10'),(771,'services_subtitle','Estos son nuestros servicios','2026-06-06 23:54:43','2026-06-06 23:54:43');
/*!40000 ALTER TABLE `settings` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sliders`
--

DROP TABLE IF EXISTS `sliders`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `sliders` (
  `id` int NOT NULL AUTO_INCREMENT,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `top_label` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT 'SYNCRO ANDINA INGENIERÍA',
  `subtitle` text COLLATE utf8mb4_unicode_ci,
  `image_path` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `image_alt` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `button_text` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `button_link` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `button2_text` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `button2_link` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `order_index` int DEFAULT '0',
  `is_active` tinyint(1) DEFAULT '1',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sliders`
--

LOCK TABLES `sliders` WRITE;
/*!40000 ALTER TABLE `sliders` DISABLE KEYS */;
INSERT INTO `sliders` VALUES (1,'Soluciones Integrales en Energía y Sincronización','SYNCRO ANDINA INGENIERÍA','Diseñamos e implementamos proyectos de generación en baja y media tensión con la máxima precisión técnica. Garantizamos la continuidad y potencia que su industria y operaciones mineras exigen.','/assets/images/sliders/365f5bd7bccdd48a.webp','Soluciones Integrales en Energía y Sincronización','Explorar Soluciones','/servicios','','',0,1,'2026-05-05 03:42:11','2026-06-07 02:19:07'),(4,'Especialistas en Sincronismo y Grupos Electrógenos','SYNCRO ANDINA INGENIERÍA','Optimice su sistema energético con nuestra fabricación de tableros de sincronismo y transferencia automática. Ofrecemos mantenimiento preventivo, correctivo y reparación de motores de gran potencia.','/assets/images/sliders/232512f9cf3cbb60.webp','Especialistas en Sincronismo y Grupos Electrógenos','Explorar Soluciones','/servicios','','',0,1,'2026-05-06 00:04:26','2026-06-07 02:19:18'),(5,'Ingeniería Eléctrica de Alta Confiabilidad a su Medida','SYNCRO ANDINA INGENIERÍA','Evaluamos su demanda energética para diseñar e instalar soluciones electromecánicas y casas de fuerza eficientes. Un equipo de amplia experiencia listo para respaldar sus proyectos más exigentes.','/assets/images/sliders/c8379266982b08f2.webp','Ingeniería Eléctrica de Alta Confiabilidad a su Medida','Explorar Soluciones','/servicios','','',0,1,'2026-05-06 00:04:28','2026-06-07 02:19:38');
/*!40000 ALTER TABLE `sliders` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `users` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `role` enum('admin','editor') COLLATE utf8mb4_unicode_ci DEFAULT 'admin',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'Administrador Syncro','admin@syncroandina.com','$2y$12$/M6hjvVwcWGDGa7.V6BpYecdXcl6oK4Znc2cr3MEpLn84qpHGviRK','admin','2026-05-07 01:07:36','2026-05-07 01:07:36',NULL);
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `whatsapp_numbers`
--

DROP TABLE IF EXISTS `whatsapp_numbers`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `whatsapp_numbers` (
  `id` int NOT NULL AUTO_INCREMENT,
  `number` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `agent_name` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `default_message` text COLLATE utf8mb4_unicode_ci,
  `is_active` tinyint(1) DEFAULT '1',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `whatsapp_numbers`
--

LOCK TABLES `whatsapp_numbers` WRITE;
/*!40000 ALTER TABLE `whatsapp_numbers` DISABLE KEYS */;
/*!40000 ALTER TABLE `whatsapp_numbers` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2026-06-07 16:16:24
