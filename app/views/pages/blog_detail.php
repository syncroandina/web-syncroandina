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
    color: #0F172A;
    margin-top: 3rem;
    margin-bottom: 1.25rem;
    line-height: 1.35;
    letter-spacing: -0.025em;
  }
  .prose h3 {
    font-size: 1.5rem;
    font-weight: 700;
    color: #1E293B;
    margin-top: 2.25rem;
    margin-bottom: 1rem;
    line-height: 1.4;
  }
  .prose h4 {
    font-size: 1.25rem;
    font-weight: 600;
    color: #334155;
    margin-top: 1.75rem;
    margin-bottom: 0.75rem;
  }
  .prose p {
    margin-bottom: 1.75rem;
    line-height: 1.85;
    color: #334155;
    font-size: 1.05rem;
  }
  .prose strong, .prose b {
    color: #0F172A;
    font-weight: 800;
  }
  .prose ul {
    list-style-type: none;
    padding-left: 0;
    margin-bottom: 1.75rem;
  }
  .prose ul li {
    position: relative;
    padding-left: 1.5rem;
    margin-bottom: 0.75rem;
    line-height: 1.75;
    color: #334155;
  }
  .prose ul li::before {
    content: "";
    position: absolute;
    left: 0.25rem;
    top: 0.65rem;
    width: 6px;
    height: 6px;
    border-radius: 50%;
    background-color: var(--secondary, #DB0000);
  }
  .prose ol {
    list-style-type: decimal;
    padding-left: 1.5rem;
    margin-bottom: 1.75rem;
    color: #334155;
  }
  .prose li {
    margin-bottom: 0.6rem;
  }
  .prose blockquote {
    border-left: 4px solid var(--secondary, #DB0000);
    padding: 1.5rem 2rem;
    background-color: #F8FAFC;
    font-style: italic;
    color: #1E293B;
    border-radius: 1.25rem;
    margin: 2.5rem 0;
    font-size: 1.15rem;
    line-height: 1.75;
    font-weight: 500;
    border: 1px solid #F1F5F9;
    border-left-width: 4px;
  }
  .prose img {
    border-radius: 2rem;
    box-shadow: 0 20px 40px -15px rgba(15, 23, 42, 0.08);
    margin: 3rem auto;
    border: 1px solid #F1F5F9;
  }
  .prose a {
    color: var(--secondary, #DB0000);
    text-decoration: none;
    font-weight: 750;
    position: relative;
    transition: color 0.3s ease;
  }
  .prose a::after {
    content: '';
    position: absolute;
    width: 100%;
    transform: scaleX(0);
    height: 2px;
    bottom: -2px;
    left: 0;
    background-color: var(--secondary, #DB0000);
    transform-origin: bottom right;
    transition: transform 0.25s ease-out;
  }
  .prose a:hover {
    color: var(--secondary, #DB0000);
  }
  .prose a:hover::after {
    transform: scaleX(1);
    transform-origin: bottom left;
  }
</style>

<article class="bg-[#F8FAFC] pt-32 pb-24">
    <!-- Contenido Principal Centrado -->
    <div class="container mx-auto px-4 max-w-6xl">
        <!-- Contenedor con Rejilla de 12 Columnas -->
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 lg:gap-16 animate-fade-in">
            <!-- Cuerpo del Post (Ocupa 8 de 12 columnas) -->
            <div class="lg:col-span-8">
                <div class="text-left bg-white p-8 md:p-12 rounded-[2.5rem] border border-slate-100 shadow-sm">
                    <!-- Título del Artículo -->
                    <h1 class="text-3xl md:text-5xl font-extrabold text-gray-900 leading-tight mb-4 tracking-tight">
                        <?= htmlspecialchars(html_entity_decode(htmlspecialchars_decode($post['title'] ?? ''), ENT_QUOTES, 'UTF-8'), ENT_QUOTES, 'UTF-8') ?>
                    </h1>
                    

                    
                    <!-- Migas de Pan (Breadcrumbs) para SEO y Navegabilidad -->
                    <nav class="mb-6 flex overflow-x-auto pb-1" aria-label="Breadcrumb">
                        <ol class="inline-flex items-center space-x-1.5 md:space-x-2 text-[10px] font-black uppercase tracking-widest text-gray-400 select-none whitespace-nowrap">
                            <li class="inline-flex items-center">
                                <a href="<?= url('') ?>" class="inline-flex items-center hover:text-secondary transition-colors">
                                    Inicio
                                </a>
                            </li>
                            <li>
                                <div class="flex items-center gap-1.5">
                                    <svg class="w-3 h-3 text-gray-300" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path></svg>
                                    <a href="<?= url('blog') ?>" class="hover:text-secondary transition-colors">Blog</a>
                                </div>
                            </li>
                            <?php if (!empty($post['category_name'])): ?>
                                <li>
                                    <div class="flex items-center gap-1.5">
                                        <svg class="w-3 h-3 text-gray-300" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path></svg>
                                        <a href="<?= url('blog') . '?categoria=' . htmlspecialchars($post['category_slug'] ?? '') ?>" class="hover:text-secondary transition-colors">
                                            <?= htmlspecialchars(html_entity_decode(htmlspecialchars_decode($post['category_name']), ENT_QUOTES, 'UTF-8'), ENT_QUOTES, 'UTF-8') ?>
                                        </a>
                                    </div>
                                </li>
                            <?php endif; ?>
                            <li aria-current="page">
                                <div class="flex items-center gap-1.5">
                                    <svg class="w-3 h-3 text-gray-300" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path></svg>
                                    <span class="text-gray-600 font-bold truncate max-w-[140px] sm:max-w-[200px] md:max-w-[300px]">
                                        <?= htmlspecialchars(html_entity_decode(htmlspecialchars_decode($post['title'] ?? ''), ENT_QUOTES, 'UTF-8'), ENT_QUOTES, 'UTF-8') ?>
                                    </span>
                                </div>
                            </li>
                        </ol>
                    </nav>
                    
                    <!-- Línea Divisoria -->
                    <hr class="border-gray-250 mb-8 select-none">
                    
                    <!-- Imagen Principal de Alta Calidad -->
                    <?php if(!empty($post['image'])): ?>
                        <div class="rounded-3xl overflow-hidden shadow-md mb-8 border border-gray-150 relative max-h-[480px]">
                            <img src="<?= asset($post['image']) ?>" alt="<?= htmlspecialchars($post['image_alt'] ?: $post['title']) ?>" class="w-full h-full object-cover">
                        </div>
                    <?php endif; ?>

                    <!-- Extracto Destacado Premium (Blockquote) -->
                    <?php if(!empty($post['excerpt'])): ?>
                        <div class="relative mb-12 bg-slate-50/80 border border-slate-100/70 rounded-[2rem] p-8 md:p-10 overflow-hidden shadow-sm flex items-start gap-4">
                            <div class="w-1.5 h-full absolute left-0 top-0 bg-secondary rounded-l-full"></div>
                            
                            <div class="relative z-10 pl-2">
                                <p class="text-lg md:text-xl font-extrabold text-slate-800/90 leading-relaxed italic">
                                    "<?= htmlspecialchars(html_entity_decode(htmlspecialchars_decode($post['excerpt'] ?? ''), ENT_QUOTES, 'UTF-8'), ENT_QUOTES, 'UTF-8') ?>"
                                </p>
                            </div>
                        </div>
                    <?php endif; ?>

                    <!-- Contenido principal - Ya estilizado vía clase .prose de arriba -->
                    <div class="prose max-w-none text-gray-850 font-normal">
                        <?= html_entity_decode($post['content'] ?? '', ENT_QUOTES, 'UTF-8') ?>
                    </div>
                </div>
            </div>

            <!-- Sidebar Lateral (Ocupa 4 de 12 columnas) y es STICKY -->
            <aside class="lg:col-span-4 relative">
                <div class="sticky top-32 space-y-8">
                    
                    <!-- Sidebar Widget: Publicaciones Recientes (Fiel a la Referencia) -->
                    <div class="bg-white border border-slate-100 p-6 md:p-8 rounded-2xl shadow-sm">
                        <h2 class="text-xs font-black uppercase tracking-widest text-gray-900 mb-4 flex items-center gap-2">
                            <span class="w-1.5 h-3 bg-primary rounded-full"></span>
                            Publicaciones recientes
                        </h2>
                        <hr class="border-gray-200 mb-5 select-none">
                        
                        <?php if(!empty($recommended)): ?>
                            <div class="space-y-5">
                                <?php foreach($recommended as $rec): ?>
                                    <div class="group">
                                        <a href="<?= url('blog/' . $rec['slug']) ?>" class="block font-bold text-xs md:text-sm text-gray-950 hover:text-secondary transition-colors leading-snug mb-1">
                                            <?= htmlspecialchars(html_entity_decode(htmlspecialchars_decode($rec['title'] ?? ''), ENT_QUOTES, 'UTF-8'), ENT_QUOTES, 'UTF-8') ?>
                                        </a>
                                        <span class="block text-[10px] font-bold text-gray-400 uppercase tracking-wider leading-none"><?= formatBlogDateDetail($rec['published_at']) ?></span>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        <?php endif; ?>
                    </div>

                    <!-- CTA Corporativo Fino (Unificado y Administrable) -->
                    <?php
                    $ctaTagline = !empty($post['cta_tagline']) ? $post['cta_tagline'] : '¿Hablamos?';
                    $ctaTitle = !empty($post['cta_title']) ? $post['cta_title'] : ($settings['blog_sidebar_cta_title'] ?? 'Impulsa tu infraestructura hoy');
                    $ctaDescription = !empty($post['cta_description']) ? $post['cta_description'] : ($settings['blog_sidebar_cta_description'] ?? 'Conéctate con nuestros ingenieros comerciales para una solución a medida.');
                    $ctaBtnText = !empty($post['cta_btn_text']) ? $post['cta_btn_text'] : ($settings['blog_sidebar_cta_btn_text'] ?? 'Iniciar Conversación');
                    ?>
                    <div class="bg-slate-900 rounded-2xl p-7 text-white relative overflow-hidden shadow-lg group border border-white/5">
                        <div class="absolute -top-24 -left-24 w-48 h-48 bg-primary/20 rounded-full blur-3xl group-hover:scale-125 transition-transform duration-1000"></div>
                        <div class="absolute -bottom-24 -right-24 w-48 h-48 bg-secondary/20 rounded-full blur-3xl group-hover:scale-125 transition-transform duration-1000"></div>
                        
                        <div class="relative z-10">
                            <span class="text-[9px] font-black uppercase tracking-widest text-secondary bg-secondary/10 px-3 py-1.5 rounded-full inline-block mb-3 border border-secondary/10 select-none"><?= htmlspecialchars($ctaTagline) ?></span>
                            <h2 class="text-base font-extrabold mb-2 leading-tight tracking-tight"><?= htmlspecialchars($ctaTitle) ?></h2>
                            <p class="text-[11px] text-slate-400 mb-5 leading-relaxed"><?= htmlspecialchars($ctaDescription) ?></p>
                            
                            <button onclick="openContactModal('Consulta originada en artículo: <?= addslashes(htmlspecialchars($post['title'])) ?>')" class="w-full py-3.5 px-4 bg-white hover:bg-secondary text-slate-900 hover:text-white font-bold text-xs rounded-xl transition-all duration-300 flex items-center justify-center gap-2 shadow-sm hover:shadow-secondary/30 group">
                                <span><?= htmlspecialchars($ctaBtnText) ?></span>
                                <svg class="w-3.5 h-3.5 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                            </button>
                        </div>
                    </div>
                </div>
            </aside>
        </div>
    </div>
</article>

<?php $this->component('contact_modal'); ?>
<?php $this->component('footer'); ?>
