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

  /* --- Estilización Premium del Motor de Tipografía (Prose) --- */
  .prose h2 {
    font-size: 1.875rem;
    font-weight: 800;
    color: #111827;
    margin-top: 2.5rem;
    margin-bottom: 1.25rem;
    line-height: 1.3;
    letter-spacing: -0.025em;
  }
  .prose h3 {
    font-size: 1.5rem;
    font-weight: 700;
    color: #1f2937;
    margin-top: 2rem;
    margin-bottom: 1rem;
    line-height: 1.4;
  }
  .prose h4 {
    font-size: 1.25rem;
    font-weight: 600;
    color: #374151;
    margin-top: 1.5rem;
    margin-bottom: 0.75rem;
  }
  .prose p {
    margin-bottom: 1.5rem;
    line-height: 1.8;
    color: #4b5563;
  }
  .prose strong, .prose b {
    color: #111827;
    font-weight: 700;
  }
  .prose ul {
    list-style-type: disc;
    padding-left: 1.5rem;
    margin-bottom: 1.75rem;
    color: #4b5563;
  }
  .prose ol {
    list-style-type: decimal;
    padding-left: 1.5rem;
    margin-bottom: 1.75rem;
    color: #4b5563;
  }
  .prose li {
    margin-bottom: 0.5rem;
    padding-left: 0.375rem;
  }
  .prose li::marker {
    color: var(--color-secondary, #DB0000);
    font-weight: bold;
  }
  .prose blockquote {
    border-left: 4px solid #DB0000;
    padding: 1rem 1.5rem;
    background-color: #f9fafb;
    font-style: italic;
    color: #374151;
    border-radius: 0.5rem;
    margin: 2rem 0;
    font-size: 1.1rem;
  }
  .prose img {
    border-radius: 1.5rem;
    box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.05);
    margin: 2.5rem auto;
  }
  .prose a {
    color: #DB0000;
    text-decoration: underline;
    font-weight: 600;
    text-underline-offset: 4px;
    transition: color 0.2s;
  }
  .prose a:hover {
    color: #08173A;
  }
</style>

<article class="bg-[#F8FAFC] pb-20">
    <!-- Hero / Cabecera del Artículo Premium con Mesh Gradient -->
    <header class="bg-white hero-mesh-bg pt-32 pb-12 border-b border-gray-100 relative overflow-hidden">
        <div class="absolute inset-0 bg-grid-slate-100 [mask-image:linear-gradient(0deg,white,transparent)] opacity-30"></div>
        <div class="container mx-auto px-4 max-w-3xl relative z-10 text-center">
            <!-- Botón Volver -->
            <div class="animate-fade-in-up mb-8">
                <a href="<?= url('blog') ?>" class="inline-flex items-center gap-2 text-xs font-bold text-gray-400 hover:text-secondary transition-colors">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                    <span>VOLVER AL BLOG</span>
                </a>
            </div>

            <!-- Categoría en parte superior -->
            <div class="flex justify-center mb-5 animate-fade-in-up delay-100">
                <span class="px-4 py-1.5 bg-secondary/10 text-secondary rounded-full font-black text-[10px] tracking-widest uppercase border border-secondary/5">
                    <?= htmlspecialchars($post['category_name'] ?? 'Estrategia & Tecnología') ?>
                </span>
            </div>

            <!-- Título Monumental Centrado -->
            <h1 class="text-3xl md:text-5xl lg:text-6xl font-black text-gray-900 leading-[1.1] mb-8 animate-fade-in-up delay-200 tracking-tight">
                <?= htmlspecialchars($post['title']) ?>
            </h1>

            <!-- Autor y Fecha simplificados y centrados -->
            <div class="flex items-center justify-center gap-6 animate-fade-in-up delay-300 text-left border-t border-slate-100 pt-6 inline-flex">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 bg-gradient-to-tr from-slate-800 to-slate-900 text-white rounded-full flex items-center justify-center font-extrabold text-sm">
                        <?= strtoupper(substr($post['author_name'] ?? 'A', 0, 1)) ?>
                    </div>
                    <div>
                        <span class="block font-bold text-gray-900 text-xs"><?= htmlspecialchars($post['author_name'] ?? 'Administrador') ?></span>
                        <span class="block text-[9px] font-bold text-gray-400 uppercase tracking-wider">Syncro Andina Team</span>
                    </div>
                </div>
                <div class="w-px h-8 bg-gray-200"></div>
                <div class="flex flex-col">
                    <span class="text-[9px] font-bold text-gray-400 uppercase tracking-wider">Publicado el</span>
                    <span class="text-xs font-extrabold text-gray-700"><?= formatBlogDateDetail($post['published_at']) ?></span>
                </div>
            </div>
        </div>
    </header>

    <!-- Contenido Principal Ampliado para Mejor Lectura -->
    <div class="container mx-auto px-4 max-w-5xl mt-16">
        <!-- Imagen Principal de Alta Calidad -->
        <?php if(!empty($post['image'])): ?>
            <div class="rounded-[2.5rem] overflow-hidden shadow-[0_25px_60px_-15px_rgba(0,0,0,0.07)] mb-16 border border-gray-100/60 relative aspect-[21/9] max-h-[520px] group animate-scale-in">
                <div class="absolute inset-0 bg-gradient-to-t from-black/20 via-transparent to-transparent z-10 pointer-events-none"></div>
                <img src="<?= asset($post['image']) ?>" alt="<?= htmlspecialchars($post['image_alt'] ?: $post['title']) ?>" class="w-full h-full object-cover group-hover:scale-[1.03] transition-transform duration-[2s] ease-out">
            </div>
        <?php endif; ?>

        <!-- Contenedor del Cuerpo con Rejilla Asimétrica Premium -->
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 lg:gap-16 animate-fade-in">
            <!-- Cuerpo del Post (Ocupa 8 de 12 columnas) -->
            <div class="lg:col-span-8">
                <div class="bg-white p-8 md:p-12 rounded-[2.5rem] shadow-sm border border-slate-200/60">
                    <!-- Extracto Destacado -->
                    <?php if(!empty($post['excerpt'])): ?>
                        <div class="relative mb-12">
                            <div class="absolute top-0 left-0 w-1.5 h-full bg-secondary rounded-full"></div>
                            <p class="text-xl md:text-2xl font-extrabold text-gray-900/90 leading-relaxed pl-8 italic">
                                "<?= htmlspecialchars($post['excerpt']) ?>"
                            </p>
                        </div>
                    <?php endif; ?>

                    <!-- Contenido principal - Ya estilizado vía clase .prose de arriba -->
                    <div class="prose max-w-none text-gray-700 font-normal">
                        <?= $post['content'] ?>
                    </div>
                </div>
            </div>

            <!-- Sidebar Lateral (Ocupa 4 de 12 columnas) y ahora es STICKY -->
            <aside class="lg:col-span-4 relative">
                <div class="sticky top-32 space-y-8">
                    <!-- CTA Corporativo (AHORA ARRIBA) -->
                    <div class="bg-slate-900 rounded-[2.25rem] p-8 text-white relative overflow-hidden shadow-2xl shadow-slate-900/20 group">
                        <div class="absolute -top-24 -left-24 w-48 h-48 bg-primary/20 rounded-full blur-3xl group-hover:scale-110 transition-transform duration-1000"></div>
                        <div class="absolute -bottom-24 -right-24 w-48 h-48 bg-secondary/20 rounded-full blur-3xl group-hover:scale-110 transition-transform duration-1000"></div>
                        
                        <div class="relative z-10">
                            <span class="text-[9px] font-black uppercase tracking-widest text-secondary bg-secondary/10 px-3 py-1 rounded-full inline-block mb-4">¿Hablamos?</span>
                            <h2 class="text-xl font-extrabold mb-3 leading-tight tracking-tight">Impulsa tu infraestructura hoy</h2>
                            <p class="text-xs text-slate-400 mb-6 leading-relaxed">Conéctate con nuestros ingenieros comerciales para una solución a medida.</p>
                            
                            <button onclick="openContactModal('Consulta originada en artículo: <?= addslashes(htmlspecialchars($post['title'])) ?>')" class="w-full py-3.5 px-4 bg-white hover:bg-secondary text-slate-900 hover:text-white font-bold text-xs rounded-xl transition-all flex items-center justify-center gap-2 shadow-lg shadow-white/5 hover:shadow-secondary/30 group">
                                <span>Iniciar Conversación</span>
                                <svg class="w-4 h-4 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                            </button>
                        </div>
                    </div>

                    <!-- Tarjeta de Recomendaciones (AHORA ABAJO) -->
                    <?php if(!empty($recommended)): ?>
                        <div class="bg-white rounded-[2rem] p-7 border border-slate-200/60 shadow-sm">
                            <h2 class="text-xs font-black uppercase tracking-widest text-gray-900 mb-6 flex items-center gap-2">
                                <span class="w-1.5 h-3 bg-secondary rounded-full"></span>
                                Artículos Relacionados
                            </h2>
                            <div class="space-y-4">
                                <?php foreach($recommended as $rec): ?>
                                    <a href="<?= url('blog/' . $rec['slug']) ?>" class="block p-4 rounded-2xl bg-slate-50 hover:bg-white border border-slate-100 hover:border-slate-200 shadow-sm hover:shadow-md interactive-shadow transition-all group">
                                        <span class="text-[9px] font-bold text-gray-400 uppercase tracking-wider block mb-1"><?= formatBlogDateDetail($rec['published_at']) ?></span>
                                        <h3 class="font-bold text-sm text-gray-900 leading-snug group-hover:text-secondary transition-colors line-clamp-2">
                                            <?= htmlspecialchars($rec['title']) ?>
                                        </h3>
                                    </a>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>
            </aside>
        </div>
    </div>
</article>

<?php $this->component('contact_modal'); ?>
<?php $this->component('footer'); ?>
