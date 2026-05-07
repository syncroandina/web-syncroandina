<?php $this->component('header', ['title' => $title ?? 'Artículo']); ?>
<?php $this->component('navbar'); ?>

<?php
if (!function_exists('formatBlogDateDetail')) {
    function formatBlogDateDetail($dateString) {
        if (empty($dateString)) return '';
        $timestamp = strtotime($dateString);
        $months = ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'];
        $day = date('d', $timestamp);
        $monthIndex = (int)date('m', $timestamp) - 1;
        $year = date('Y', $timestamp);
        return "$day de {$months[$monthIndex]}, $year";
    }
}
?>

<style>
  @keyframes fadeInUp {
    from {
      opacity: 0;
      transform: translateY(30px);
    }
    to {
      opacity: 1;
      transform: translateY(0);
    }
  }

  @keyframes fadeIn {
    from { opacity: 0; }
    to { opacity: 1; }
  }

  @keyframes scaleIn {
    from {
      opacity: 0;
      transform: scale(0.96);
    }
    to {
      opacity: 1;
      transform: scale(1);
    }
  }

  .animate-fade-in-up {
    animation: fadeInUp 0.9s cubic-bezier(0.16, 1, 0.3, 1) both;
  }

  .animate-fade-in {
    animation: fadeIn 1.2s cubic-bezier(0.16, 1, 0.3, 1) both;
  }

  .animate-scale-in {
    animation: scaleIn 1s cubic-bezier(0.16, 1, 0.3, 1) both;
  }

  .delay-100 { animation-delay: 100ms; }
  .delay-200 { animation-delay: 200ms; }
  .delay-300 { animation-delay: 300ms; }

  /* Degradado Mesh sutil de fondo */
  .hero-mesh-bg {
    background-image: 
      radial-gradient(at 0% 0%, rgba(59, 130, 246, 0.03) 0, transparent 50%), 
      radial-gradient(at 100% 0%, rgba(13, 148, 136, 0.02) 0, transparent 50%),
      radial-gradient(at 50% 100%, rgba(243, 244, 246, 0.4) 0, transparent 70%);
  }

  /* Sombra flotante e interactiva premium */
  .interactive-shadow {
    box-shadow: 0 10px 30px -10px rgba(0, 0, 0, 0.04);
    transition: all 0.4s cubic-bezier(0.16, 1, 0.3, 1);
  }
  .interactive-shadow:hover {
    transform: translateY(-4px);
    box-shadow: 0 20px 40px -15px rgba(0, 0, 0, 0.08);
  }
</style>

<article class="min-h-screen bg-white pt-24 pb-32">
    <!-- Hero / Cabecera del Artículo Premium con Mesh Gradient -->
    <header class="hero-mesh-bg py-16 md:py-24 border-b border-gray-100 relative overflow-hidden">
        <div class="absolute inset-0 bg-grid-slate-100 [mask-image:linear-gradient(0deg,white,transparent)] opacity-30"></div>
        <div class="container mx-auto px-4 max-w-4xl relative z-10">
            <!-- Botón Volver estilizado con efecto hover tridimensional -->
            <div class="animate-fade-in-up">
                <a href="<?= url('blog') ?>" class="inline-flex items-center gap-2.5 text-xs font-bold text-gray-500 hover:text-secondary transition-all bg-white border border-gray-100 hover:border-gray-200 px-4 py-2.5 rounded-full mb-8 shadow-sm hover:shadow-md group">
                    <svg class="w-4 h-4 group-hover:-translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                    <span>Volver al Blog</span>
                </a>
            </div>

            <!-- Etiqueta superior flotante -->
            <div class="flex items-center gap-3 mb-6 animate-fade-in-up delay-100">
                <span class="px-3.5 py-1.5 bg-secondary/10 text-secondary rounded-full font-bold text-[10px] tracking-widest uppercase shadow-sm">Estrategia & Tecnología</span>
                <span class="text-gray-300 font-bold">&bull;</span>
                <span class="text-xs text-gray-400 font-extrabold tracking-wider uppercase font-mono"><?= formatBlogDateDetail($post['published_at']) ?></span>
            </div>

            <!-- Título Monumental con revelado de animación suave -->
            <h1 class="text-3xl md:text-5xl font-black text-gray-900 leading-[1.15] mb-8 animate-fade-in-up delay-200 tracking-tight">
                <?= htmlspecialchars($post['title']) ?>
            </h1>

            <!-- Autor con efecto de tarjeta flotante -->
            <div class="flex items-center gap-4 bg-white/80 backdrop-blur-md border border-gray-100 rounded-2xl p-3 shadow-sm inline-flex animate-fade-in-up delay-300">
                <div class="w-11 h-11 bg-gradient-to-tr from-secondary to-primary text-white rounded-xl flex items-center justify-center font-extrabold text-base shadow-md shadow-secondary/15">
                    <?= strtoupper(substr($post['author_name'] ?? 'A', 0, 1)) ?>
                </div>
                <div class="pr-3">
                    <span class="block font-extrabold text-gray-900 text-sm"><?= htmlspecialchars($post['author_name'] ?? 'Administrador') ?></span>
                    <span class="block text-[10px] font-bold text-gray-400 uppercase tracking-wider">Especialista en Soluciones Digitales</span>
                </div>
            </div>
        </div>
    </header>

    <!-- Contenido Principal -->
    <div class="container mx-auto px-4 max-w-4xl mt-16">
        <!-- Imagen Principal de Alta Calidad con Zoom Interactivo y Sombra Premium -->
        <?php if(!empty($post['image'])): ?>
            <div class="rounded-[2.5rem] overflow-hidden shadow-[0_25px_60px_-15px_rgba(0,0,0,0.07)] mb-16 border border-gray-100/60 relative aspect-[21/10] max-h-[480px] group animate-scale-in">
                <div class="absolute inset-0 bg-gradient-to-t from-black/20 via-transparent to-transparent z-10 pointer-events-none"></div>
                <img src="<?= asset($post['image']) ?>" alt="<?= htmlspecialchars($post['title']) ?>" class="w-full h-full object-cover group-hover:scale-[1.03] transition-transform duration-[2s] ease-out">
            </div>
        <?php endif; ?>

        <!-- Contenedor del Cuerpo con Tipografía Ultra Premium -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-16 animate-fade-in">
            <!-- Cuerpo del Post (Ocupa 2 de 3 columnas) -->
            <div class="lg:col-span-2 space-y-8 text-gray-700 leading-relaxed text-[16px] md:text-[17px]">
                <!-- Extracto Destacado en Itálica con elegante bloque de cita lateral -->
                <?php if(!empty($post['excerpt'])): ?>
                    <p class="text-lg md:text-xl font-bold text-gray-900/80 leading-relaxed border-l-[6px] border-secondary pl-6 italic mb-10 bg-gray-50/50 py-5 pr-4 rounded-r-3xl">
                        "<?= htmlspecialchars($post['excerpt']) ?>"
                    </p>
                <?php endif; ?>

                <!-- Contenido principal con estilos de tipografía mejorados -->
                <div class="prose max-w-none text-gray-700 space-y-6 leading-[1.8] font-normal">
                    <?= $post['content'] ?>
                </div>
            </div>

            <!-- Sidebar Lateral -->
            <aside class="space-y-10">
                <!-- Tarjeta de Recomendaciones Interactivas -->
                <?php if(!empty($recommended)): ?>
                    <div class="bg-gray-50/30 rounded-[2rem] p-8 border border-gray-100/80">
                        <h4 class="text-xs font-black uppercase tracking-widest text-gray-900 mb-6 flex items-center gap-2">
                            <span class="w-1.5 h-3 bg-secondary rounded-full"></span>
                            Artículos Recomendados
                        </h4>
                        <div class="space-y-5">
                            <?php foreach($recommended as $rec): ?>
                                <div class="p-4 rounded-2xl bg-white/40 hover:bg-white border border-transparent hover:border-gray-100 interactive-shadow flex flex-col gap-1.5">
                                    <span class="text-[9px] font-bold text-gray-400 uppercase tracking-wider font-mono"><?= formatBlogDateDetail($rec['published_at']) ?></span>
                                    <h5 class="font-extrabold text-xs md:text-sm text-gray-900 leading-snug group-hover:text-secondary transition-colors">
                                        <a href="<?= url('blog/' . $rec['slug']) ?>" class="hover:text-secondary transition-colors line-clamp-2"><?= htmlspecialchars($rec['title']) ?></a>
                                    </h5>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                <?php endif; ?>

                <!-- CTA Corporativo con Vidrio Esmerilado e Iluminación Radial -->
                <div class="bg-slate-900 rounded-[2.25rem] p-8 text-white relative overflow-hidden shadow-2xl shadow-slate-900/20 group">
                    <!-- Efecto de gradiente y blur de fondo corporativo -->
                    <div class="absolute -top-24 -left-24 w-48 h-48 bg-primary/20 rounded-full blur-3xl group-hover:scale-110 transition-transform duration-1000"></div>
                    <div class="absolute -bottom-24 -right-24 w-48 h-48 bg-secondary/20 rounded-full blur-3xl group-hover:scale-110 transition-transform duration-1000"></div>
                    
                    <div class="relative z-10">
                        <span class="text-[9px] font-black uppercase tracking-widest text-secondary bg-secondary/10 px-3 py-1 rounded-full inline-block mb-4">¿Listo para innovar?</span>
                        <h4 class="text-xl font-extrabold mb-4 leading-tight tracking-tight">Impulsa el mañana de tu empresa hoy mismo</h4>
                        <p class="text-xs text-slate-400 mb-6 leading-relaxed">Conéctate con nuestro equipo de consultores corporativos de Syncro Andina para diseñar una solución a tu medida.</p>
                        
                        <button onclick="openContactModal('Consulta originada en artículo: <?= htmlspecialchars($post['title']) ?>')" class="w-full py-3.5 px-4 bg-white hover:bg-secondary text-slate-900 hover:text-white font-bold text-xs rounded-xl transition-all flex items-center justify-center gap-2 shadow-lg shadow-white/5 hover:shadow-secondary/30 group">
                            <span>Iniciar Conversación</span>
                            <svg class="w-4 h-4 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                        </button>
                    </div>
                </div>
            </aside>
        </div>
    </div>
</article>

<?php $this->component('contact_modal'); ?>
<?php $this->component('footer'); ?>
