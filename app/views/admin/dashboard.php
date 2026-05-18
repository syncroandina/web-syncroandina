<div class="mb-8 bg-white p-6 rounded-3xl shadow-sm border border-gray-100 flex flex-col lg:flex-row items-center justify-between gap-6">
    <div class="w-full lg:w-auto">
        <h1 class="text-3xl font-extrabold text-gray-900 tracking-tight">Dashboard General</h1>
        <p class="text-gray-500 text-sm mt-1">Resumen de visitas, contactos e interacciones en tiempo real.</p>
    </div>
    
    <form method="GET" action="/admin" class="w-full lg:w-auto flex flex-col sm:flex-row items-center gap-4">
        <!-- Selector de rango predefinido -->
        <div class="w-full sm:w-auto">
            <select name="filter" onchange="handleFilterChange(this.value)" class="w-full px-4 py-2.5 rounded-xl border border-gray-200 focus:outline-none focus:ring-2 focus:ring-secondary focus:border-transparent text-sm font-bold text-gray-700 transition-shadow bg-white">
                <option value="today" <?= $filter === 'today' ? 'selected' : '' ?>>Hoy</option>
                <option value="7_days" <?= $filter === '7_days' ? 'selected' : '' ?>>Últimos 7 días</option>
                <option value="15_days" <?= $filter === '15_days' ? 'selected' : '' ?>>Últimos 15 días</option>
                <option value="30_days" <?= $filter === '30_days' ? 'selected' : '' ?>>Últimos 30 días</option>
                <option value="current_month" <?= $filter === 'current_month' ? 'selected' : '' ?>>Mes actual</option>
                <option value="6_months" <?= $filter === '6_months' ? 'selected' : '' ?>>Últimos 6 meses</option>
                <option value="current_year" <?= $filter === 'current_year' ? 'selected' : '' ?>>Año actual</option>
                <option value="custom" <?= $filter === 'custom' ? 'selected' : '' ?>>Rango personalizado...</option>
            </select>
        </div>
        
        <!-- Selector de fechas personalizado (Flatpickr) -->
        <div id="custom-range-picker" class="<?= $filter === 'custom' ? 'flex' : 'hidden' ?> w-full sm:w-auto flex-col sm:flex-row items-center gap-2">
            <input type="text" id="start_date" name="start_date" value="<?= htmlspecialchars($startDate) ?>" placeholder="Fecha Inicio" class="w-full sm:w-36 px-4 py-2.5 rounded-xl border border-gray-200 text-sm font-medium focus:ring-2 focus:ring-secondary focus:outline-none bg-white">
            <span class="text-gray-400 text-sm font-bold">a</span>
            <input type="text" id="end_date" name="end_date" value="<?= htmlspecialchars($endDate) ?>" placeholder="Fecha Fin" class="w-full sm:w-36 px-4 py-2.5 rounded-xl border border-gray-200 text-sm font-medium focus:ring-2 focus:ring-secondary focus:outline-none bg-white">
            <button type="submit" class="bg-primary hover:bg-secondary text-white px-5 py-2.5 rounded-xl text-sm font-bold transition-all shadow-sm">Filtrar</button>
        </div>
    </form>
</div>

<!-- Stats Grid -->
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-6 mb-10">
    <!-- Stat 1: Total Visitas -->
    <div class="bg-white rounded-3xl p-6 shadow-sm border border-gray-100 hover:shadow-md transition-shadow relative overflow-hidden group">
        <div class="absolute -right-6 -top-6 w-20 h-20 bg-blue-50 rounded-full group-hover:scale-150 transition-transform duration-500 ease-out z-0"></div>
        <div class="relative z-10 flex items-center justify-between">
            <div>
                <p class="text-sm font-bold text-gray-400 mb-1">Visitas Totales</p>
                <h3 class="text-3xl font-black text-gray-900"><?= number_format($metrics['views']) ?></h3>
                <p class="text-xs text-gray-500 mt-2">Páginas navegadas</p>
            </div>
            <div class="w-12 h-12 bg-blue-50/50 text-secondary border border-blue-100 rounded-2xl flex items-center justify-center flex-shrink-0">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
            </div>
        </div>
    </div>
    
    <!-- Stat 2: Contacto Formulario -->
    <div class="bg-white rounded-3xl p-6 shadow-sm border border-gray-100 hover:shadow-md transition-shadow relative overflow-hidden group">
        <div class="absolute -right-6 -top-6 w-20 h-20 bg-green-50 rounded-full group-hover:scale-150 transition-transform duration-500 ease-out z-0"></div>
        <div class="relative z-10 flex items-center justify-between">
            <div>
                <p class="text-sm font-bold text-gray-400 mb-1">Formularios (Leads)</p>
                <h3 class="text-3xl font-black text-gray-900"><?= number_format($metrics['leads']) ?></h3>
                <p class="text-xs text-gray-500 mt-2">Mensajes de contacto</p>
            </div>
            <div class="w-12 h-12 bg-green-50/50 text-green-600 border border-green-100 rounded-2xl flex items-center justify-center flex-shrink-0">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
            </div>
        </div>
    </div>

    <!-- Stat 3: WhatsApp Clicks -->
    <div class="bg-white rounded-3xl p-6 shadow-sm border border-gray-100 hover:shadow-md transition-shadow relative overflow-hidden group">
        <div class="absolute -right-6 -top-6 w-20 h-20 bg-teal-50 rounded-full group-hover:scale-150 transition-transform duration-500 ease-out z-0"></div>
        <div class="relative z-10 flex items-center justify-between">
            <div>
                <p class="text-sm font-bold text-gray-400 mb-1">Clicks WhatsApp</p>
                <h3 class="text-3xl font-black text-gray-900"><?= number_format($metrics['whatsapp']) ?></h3>
                <p class="text-xs text-gray-500 mt-2">Chats iniciados</p>
            </div>
            <div class="w-12 h-12 bg-teal-50/50 text-teal-600 border border-teal-100 rounded-2xl flex items-center justify-center flex-shrink-0">
                <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413Z"></path></svg>
            </div>
        </div>
    </div>

    <!-- Stat 4: Llamadas Clicks -->
    <div class="bg-white rounded-3xl p-6 shadow-sm border border-gray-100 hover:shadow-md transition-shadow relative overflow-hidden group">
        <div class="absolute -right-6 -top-6 w-20 h-20 bg-orange-50 rounded-full group-hover:scale-150 transition-transform duration-500 ease-out z-0"></div>
        <div class="relative z-10 flex items-center justify-between">
            <div>
                <p class="text-sm font-bold text-gray-400 mb-1">Clicks Llamadas</p>
                <h3 class="text-3xl font-black text-gray-900"><?= number_format($metrics['phone']) ?></h3>
                <p class="text-xs text-gray-500 mt-2">Llamadas telefónicas</p>
            </div>
            <div class="w-12 h-12 bg-orange-50/50 text-orange-600 border border-orange-100 rounded-2xl flex items-center justify-center flex-shrink-0">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path></svg>
            </div>
        </div>
    </div>

    <!-- Stat 5: Blog Visits -->
    <div class="bg-white rounded-3xl p-6 shadow-sm border border-gray-100 hover:shadow-md transition-shadow relative overflow-hidden group">
        <div class="absolute -right-6 -top-6 w-20 h-20 bg-purple-50 rounded-full group-hover:scale-150 transition-transform duration-500 ease-out z-0"></div>
        <div class="relative z-10 flex items-center justify-between">
            <div>
                <p class="text-sm font-bold text-gray-400 mb-1">Visitas al Blog</p>
                <h3 class="text-3xl font-black text-gray-900"><?= number_format($metrics['blog_views']) ?></h3>
                <p class="text-xs text-gray-500 mt-2">Artículos del blog leídos</p>
            </div>
            <div class="w-12 h-12 bg-purple-50/50 text-purple-600 border border-purple-100 rounded-2xl flex items-center justify-center flex-shrink-0">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9.5a2.5 2.5 0 00-2.5-2.5H15"></path></svg>
            </div>
        </div>
    </div>
</div>

<!-- Chart Section -->
<div class="bg-white rounded-3xl p-6 lg:p-8 shadow-sm border border-gray-100 mb-10">
    <h3 class="text-lg font-bold text-gray-900 mb-6">Tendencia de Actividad e Interacciones</h3>
    <div class="relative w-full h-[320px] md:h-[400px]">
        <canvas id="dailyMetricsChart"></canvas>
    </div>
</div>

<!-- Bottom Grid: Top Services & Blog Posts -->
<div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-10">
    <!-- Top Services -->
    <div class="bg-white rounded-3xl p-6 lg:p-8 shadow-sm border border-gray-100 overflow-hidden flex flex-col">
        <div class="flex items-center justify-between pb-4 border-b border-gray-100 mb-6">
            <h3 class="text-lg font-bold text-gray-900">Top 5 Servicios Más Visitados</h3>
            <span class="text-xs font-bold px-2.5 py-1 bg-blue-50 text-secondary border border-blue-100 rounded-lg">Popularidad</span>
        </div>
        <div class="flex-1 space-y-4">
            <?php if (!empty($topServices)): ?>
                <?php foreach($topServices as $srv): ?>
                    <div class="flex items-center gap-4 group">
                        <div class="w-12 h-12 rounded-xl bg-gray-100 border border-gray-200/60 overflow-hidden flex-shrink-0 flex items-center justify-center">
                            <?php if (!empty($srv['image'])): ?>
                                <img src="<?= '/' . ltrim($srv['image'], '/') ?>" class="w-full h-full object-cover">
                            <?php else: ?>
                                <svg class="w-6 h-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                            <?php endif; ?>
                        </div>
                        <div class="flex-1 min-w-0">
                            <div class="flex justify-between items-center mb-1">
                                <h4 class="text-sm font-bold text-gray-900 truncate group-hover:text-secondary transition-colors"><?= htmlspecialchars($srv['title']) ?></h4>
                                <span class="text-xs font-black text-gray-800 bg-gray-100 px-2 py-0.5 rounded-md"><?= number_format($srv['visits']) ?> visitas</span>
                            </div>
                            <?php 
                                $maxVisits = $topServices[0]['visits'] ?: 1;
                                $percent = ($srv['visits'] / $maxVisits) * 100;
                            ?>
                            <div class="w-full bg-gray-100 h-2 rounded-full overflow-hidden">
                                <div class="bg-secondary h-full rounded-full transition-all duration-500" style="width: <?= $percent ?>%"></div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="h-48 flex flex-col items-center justify-center text-gray-400 italic text-sm">
                    <svg class="w-10 h-10 mb-2 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    No hay visitas registradas para servicios en este período.
                </div>
            <?php endif; ?>
        </div>
    </div>

    <!-- Top Articles -->
    <div class="bg-white rounded-3xl p-6 lg:p-8 shadow-sm border border-gray-100 overflow-hidden flex flex-col">
        <div class="flex items-center justify-between pb-4 border-b border-gray-100 mb-6">
            <h3 class="text-lg font-bold text-gray-900">Top 5 Artículos de Blog Más Visitados</h3>
            <span class="text-xs font-bold px-2.5 py-1 bg-orange-50 text-orange-600 border border-orange-100 rounded-lg">Popularidad</span>
        </div>
        <div class="flex-1 space-y-4">
            <?php if (!empty($topArticles)): ?>
                <?php foreach($topArticles as $art): ?>
                    <div class="flex items-center gap-4 group">
                        <div class="w-12 h-12 rounded-xl bg-gray-100 border border-gray-200/60 overflow-hidden flex-shrink-0 flex items-center justify-center">
                            <?php if (!empty($art['image'])): ?>
                                <img src="<?= '/' . ltrim($art['image'], '/') ?>" class="w-full h-full object-cover">
                            <?php else: ?>
                                <svg class="w-6 h-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                            <?php endif; ?>
                        </div>
                        <div class="flex-1 min-w-0">
                            <div class="flex justify-between items-center mb-1">
                                <h4 class="text-sm font-bold text-gray-900 truncate group-hover:text-orange-500 transition-colors"><?= htmlspecialchars($art['title']) ?></h4>
                                <span class="text-xs font-black text-gray-800 bg-gray-100 px-2 py-0.5 rounded-md"><?= number_format($art['visits']) ?> visitas</span>
                            </div>
                            <?php 
                                $maxArtVisits = $topArticles[0]['visits'] ?: 1;
                                $percentArt = ($art['visits'] / $maxArtVisits) * 100;
                            ?>
                            <div class="w-full bg-gray-100 h-2 rounded-full overflow-hidden">
                                <div class="bg-orange-500 h-full rounded-full transition-all duration-500" style="width: <?= $percentArt ?>%"></div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="h-48 flex flex-col items-center justify-center text-gray-400 italic text-sm">
                    <svg class="w-10 h-10 mb-2 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    No hay visitas registradas para el blog en este período.
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<!-- Load Chart.js and Flatpickr dependencies -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script src="https://cdn.jsdelivr.net/npm/flatpickr/dist/l10n/es.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Inicializar Flatpickr
    flatpickr("#start_date", {
        locale: "es",
        dateFormat: "Y-m-d",
        onClose: function() {
            checkCustomDates();
        }
    });
    flatpickr("#end_date", {
        locale: "es",
        dateFormat: "Y-m-d",
        onClose: function() {
            checkCustomDates();
        }
    });

    function checkCustomDates() {
        const start = document.getElementById('start_date').value;
        const end = document.getElementById('end_date').value;
        if (start && end) {
            document.getElementById('start_date').closest('form').submit();
        }
    }

    window.handleFilterChange = function(val) {
        const customPicker = document.getElementById('custom-range-picker');
        if (val === 'custom') {
            customPicker.classList.remove('hidden');
            customPicker.classList.add('flex');
        } else {
            customPicker.classList.add('hidden');
            customPicker.classList.remove('flex');
            customPicker.closest('form').submit();
        }
    };

    // Gráfico Sincronizado
    const dailyMetrics = <?= json_encode($dailyMetrics) ?>;
    
    const labels = dailyMetrics.map(item => {
        const parts = item.date.split('-');
        const months = ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ago', 'Sep', 'Oct', 'Nov', 'Dic'];
        return `${parts[2]} ${months[parseInt(parts[1]) - 1]}`;
    });
    
    const viewsData = dailyMetrics.map(item => item.views);
    const leadsData = dailyMetrics.map(item => item.leads);
    const whatsappData = dailyMetrics.map(item => item.whatsapp);
    const phoneData = dailyMetrics.map(item => item.phone);
    const blogViewsData = dailyMetrics.map(item => item.blog_views);

    const ctx = document.getElementById('dailyMetricsChart').getContext('2d');
    
    const colorSecondary = getComputedStyle(document.documentElement).getPropertyValue('--secondary').trim() || '#3b82f6';
    
    const secondaryGradient = ctx.createLinearGradient(0, 0, 0, 400);
    secondaryGradient.addColorStop(0, 'rgba(59, 130, 246, 0.15)');
    secondaryGradient.addColorStop(1, 'rgba(59, 130, 246, 0.0)');

    new Chart(ctx, {
        type: 'line',
        data: {
            labels: labels,
            datasets: [
                {
                    label: 'Visitas Totales',
                    data: viewsData,
                    borderColor: colorSecondary,
                    backgroundColor: secondaryGradient,
                    fill: true,
                    tension: 0.35,
                    borderWidth: 3,
                    pointBackgroundColor: colorSecondary,
                    pointHoverRadius: 7
                },
                {
                    label: 'Formularios (Leads)',
                    data: leadsData,
                    borderColor: '#10b981',
                    backgroundColor: 'transparent',
                    fill: false,
                    tension: 0.35,
                    borderWidth: 2,
                    pointBackgroundColor: '#10b981',
                    pointHoverRadius: 5
                },
                {
                    label: 'Clicks WhatsApp',
                    data: whatsappData,
                    borderColor: '#0d9488',
                    backgroundColor: 'transparent',
                    fill: false,
                    tension: 0.35,
                    borderWidth: 2,
                    pointBackgroundColor: '#0d9488',
                    pointHoverRadius: 5
                },
                {
                    label: 'Llamadas Clicks',
                    data: phoneData,
                    borderColor: '#f97316',
                    backgroundColor: 'transparent',
                    fill: false,
                    tension: 0.35,
                    borderWidth: 2,
                    pointBackgroundColor: '#f97316',
                    pointHoverRadius: 5
                },
                {
                    label: 'Visitas al Blog',
                    data: blogViewsData,
                    borderColor: '#8b5cf6',
                    backgroundColor: 'transparent',
                    fill: false,
                    tension: 0.35,
                    borderWidth: 2,
                    pointBackgroundColor: '#8b5cf6',
                    pointHoverRadius: 5
                }
            ]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'top',
                    labels: {
                        usePointStyle: true,
                        font: {
                            family: 'Inter',
                            size: 12,
                            weight: '600'
                        },
                        padding: 20
                    }
                },
                tooltip: {
                    backgroundColor: '#0f172a',
                    titleFont: { family: 'Inter', weight: 'bold' },
                    bodyFont: { family: 'Inter' },
                    padding: 12,
                    cornerRadius: 12,
                    boxPadding: 6,
                    usePointStyle: true
                }
            },
            scales: {
                y: {
                    grid: {
                        color: '#f3f4f6'
                    },
                    ticks: {
                        font: { family: 'Inter', size: 11, weight: '500' },
                        color: '#9ca3af',
                        precision: 0
                    }
                },
                x: {
                    grid: {
                        display: false
                    },
                    ticks: {
                        font: { family: 'Inter', size: 11, weight: '500' },
                        color: '#9ca3af'
                    }
                }
            }
        }
    });
});
</script>
