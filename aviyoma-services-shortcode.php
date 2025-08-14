<?php
/* --- AVİYOMA SERVICES SHORTCODE - GÜNCEL TASARIM ---
   Kodu functions.php dosyanızın sonuna yapıştırın.
   Shortcode kullanımı: [aviyoma_services]
   --- */
if ( ! function_exists('aviyoma_services_shortcode') ) {

function aviyoma_services_shortcode( $atts = [] ) {

    // Kategoriler & hizmet kartları (Aviyoma markalı)
    $categories = [
        'SEO Hizmetleri' => [
            ['id'=>'seo-local','title'=>'Aviyoma Yerel SEO','desc'=>'Google My Business optimizasyonu, yerel dizinler ve bölgesel görünürlük artırımı','duration'=>'14 gün','price'=>9000],
            ['id'=>'seo-national','title'=>'Aviyoma Ulusal SEO','desc'=>'Ulusal ölçekte organik görünürlük ve teknik SEO stratejileri','duration'=>'21 gün','price'=>14000],
            ['id'=>'seo-global','title'=>'Aviyoma Global SEO','desc'=>'Çok dilli ve çok bölgeli SEO stratejileri ile dünya çapında görünürlük','duration'=>'28 gün','price'=>22000],
            ['id'=>'seo-ecommerce','title'=>'Aviyoma E-Ticaret SEO','desc'=>'Kategori, ürün ve filtre yapısı, schema markup, hız optimizasyonu','duration'=>'21 gün','price'=>16000],
        ],
        'Dijital Pazarlama Hizmetleri' => [
            ['id'=>'dp-pr','title'=>'Aviyoma Dijital PR','desc'=>'Online itibar yönetimi, medya ilişkileri ve kriz iletişim planı','duration'=>'21 gün','price'=>18000],
            ['id'=>'dp-googleads','title'=>'Aviyoma Google ADS','desc'=>'Arama, Görüntülü ve Performans Maks kampanyaları ile ROI odaklı reklam yönetimi','duration'=>'14 gün','price'=>12000],
            ['id'=>'dp-metaads','title'=>'Aviyoma META ADS','desc'=>'Facebook/Instagram reklam stratejisi, kreatif optimizasyon ve hedefleme','duration'=>'14 gün','price'=>11000],
            ['id'=>'dp-linkedinads','title'=>'Aviyoma LinkedIn ADS','desc'=>'B2B odaklı hedefleme, kreatif kurgular ve lead generation','duration'=>'14 gün','price'=>13000],
            ['id'=>'dp-social','title'=>'Aviyoma Sosyal Medya','desc'=>'İçerik takvimi, görsel-kopya üretimi ve detaylı raporlama sistemi','duration'=>'30 gün','price'=>15000],
            ['id'=>'dp-content','title'=>'Aviyoma İçerik Pazarlama','desc'=>'Blog, e-kitap ve SEO uyumlu içerik stratejisi ile marka hikayesi','duration'=>'21 gün','price'=>10000],
            ['id'=>'dp-email','title'=>'Aviyoma Email Pazarlama','desc'=>'Segmentasyon, otomasyon ve özel şablon tasarımı ile dönüşüm artırımı','duration'=>'10 gün','price'=>8000],
            ['id'=>'dp-performance','title'=>'Aviyoma Performans Pazarlama','desc'=>'Kanallar arası ROI odaklı optimizasyon ve veri analizi','duration'=>'21 gün','price'=>17000],
            ['id'=>'dp-influencer','title'=>'Aviyoma Influencer Marketing','desc'=>'Influencer seçimi, kontrat yönetimi ve kampanya takibi','duration'=>'14 gün','price'=>14000],
            ['id'=>'dp-production','title'=>'Aviyoma İçerik Üretimi','desc'=>'Video, görsel ve metin prodüksiyon paketi ile marka uyumlu içerik','duration'=>'10 gün','price'=>9000],
        ],
        'Web Hizmetleri' => [
            ['id'=>'web-speed','title'=>'Aviyoma Hız Optimizasyonu','desc'=>'Core Web Vitals, önbellekleme ve sıkıştırma ile performans artırımı','duration'=>'7 gün','price'=>7000],
            ['id'=>'web-i18n','title'=>'Aviyoma Çok Dilli Site','desc'=>'Dil anahtarlama, çeviri ve çok dilli SEO optimizasyonu','duration'=>'14 gün','price'=>11000],
            ['id'=>'web-graphic','title'=>'Aviyoma Grafik Tasarım','desc'=>'Kreatif banner, sosyal medya ve web görselleri tasarımı','duration'=>'7 gün','price'=>6000],
            ['id'=>'web-branding','title'=>'Aviyoma Kurumsal Kimlik','desc'=>'Logo tasarımı, renk paleti ve kurumsal şablonlar oluşturma','duration'=>'14 gün','price'=>12000],
            ['id'=>'web-video','title'=>'Aviyoma Video Prodüksiyon','desc'=>'Kısa/orta ölçekli çekim ve motion grafikleri ile animasyon','duration'=>'14 gün','price'=>15000],
            ['id'=>'web-dev','title'=>'Aviyoma Web Geliştirme','desc'=>'Modern, responsive ve SEO uyumlu web sitesi tasarımı','duration'=>'21 gün','price'=>20000],
            ['id'=>'web-ecom','title'=>'Aviyoma E-Ticaret Kurulumu','desc'=>'Ürün yönetimi, ödeme sistemleri ve güvenlik entegrasyonu','duration'=>'21 gün','price'=>22000],
        ],
        'Yazılım ve Mühendislik Hizmetleri' => [
            ['id'=>'eng-automation','title'=>'Aviyoma Otomasyon','desc'=>'İş akışları ve sistem entegrasyonu otomasyonu ile verimlilik artırımı','duration'=>'21 gün','price'=>20000],
            ['id'=>'eng-autoreport','title'=>'Aviyoma Raporlama Sistemi','desc'=>'Veri çekme, ETL süreçleri ve görselleştirme ile otomatik raporlama','duration'=>'14 gün','price'=>16000],
            ['id'=>'eng-blockchain','title'=>'Aviyoma BlockChain','desc'=>'Akıllı kontratlar ve blockchain entegrasyonları ile güvenli çözümler','duration'=>'30 gün','price'=>35000],
            ['id'=>'eng-cyber','title'=>'Aviyoma Siber Güvenlik','desc'=>'Güvenlik denetimi, zafiyet tarama ve sistem sertleştirme','duration'=>'21 gün','price'=>22000],
            ['id'=>'eng-data','title'=>'Aviyoma Veri Mühendisliği','desc'=>'Veri modeli, pipeline ve depolama çözümleri ile veri yönetimi','duration'=>'21 gün','price'=>26000],
            ['id'=>'eng-erp','title'=>'Aviyoma ERP Çözümleri','desc'=>'ERP kurulumu, özelleştirme ve sistem entegrasyonu','duration'=>'30 gün','price'=>40000],
            ['id'=>'eng-mobile','title'=>'Aviyoma Mobil Uygulama','desc'=>'iOS/Android yerel ya da çapraz platform mobil uygulama geliştirme','duration'=>'30 gün','price'=>35000],
            ['id'=>'eng-saas','title'=>'Aviyoma SaaS Kurulumu','desc'=>'Çok kiracılı mimari ve abonelik akışı ile SaaS platformu','duration'=>'30 gün','price'=>30000],
        ],
        'Yapay Zeka Hizmetleri' => [
            ['id'=>'ai-marketing','title'=>'Aviyoma AI Pazarlama','desc'=>'AI destekli segmentasyon, öngörü ve pazarlama otomasyonu','duration'=>'14 gün','price'=>18000],
            ['id'=>'ai-core','title'=>'Aviyoma Yapay Zeka','desc'=>'Klasik ML ve derin öğrenme çözümleri ile akıllı sistemler','duration'=>'21 gün','price'=>25000],
            ['id'=>'ai-edge','title'=>'Aviyoma Edge AI','desc'=>'Cihaz üzerinde tahmin ve optimizasyon ile edge computing','duration'=>'21 gün','price'=>28000],
            ['id'=>'ai-seo','title'=>'Aviyoma AI SEO','desc'=>'AI destekli içerik kümeleri, öneri sistemi ve teknik analiz','duration'=>'14 gün','price'=>16000],
            ['id'=>'ai-content','title'=>'Aviyoma AI İçerik','desc'=>'Yapay zeka destekli metin, özetleme ve kişiselleştirme','duration'=>'10 gün','price'=>12000],
        ],
    ];

    // Ek hizmetler (Aviyoma markalı)
    $extras_mapping = [
        'SEO Hizmetleri' => [
            ['id'=>'ex-seo-keywords','title'=>'Aviyoma Ek Anahtar Kelime Paketi','price'=>1500],
            ['id'=>'ex-seo-directories','title'=>'Aviyoma Yerel Dizin Kayıtları','price'=>1200],
            ['id'=>'ex-seo-tech-audit','title'=>'Aviyoma Geniş Teknik SEO Denetimi','price'=>3000],
            ['id'=>'ex-seo-fast','title'=>'Aviyoma Hızlı Teslimat','price'=>2000],
        ],
        'Dijital Pazarlama Hizmetleri' => [
            ['id'=>'ex-dp-ab','title'=>'Aviyoma A/B Test Paketi','price'=>2000],
            ['id'=>'ex-dp-creative','title'=>'Aviyoma Reklam Kreatif Üretimi','price'=>2500],
            ['id'=>'ex-dp-report','title'=>'Aviyoma Haftalık Detaylı Rapor','price'=>1500],
            ['id'=>'ex-dp-consult','title'=>'Aviyoma Ek Strateji Oturumu','price'=>1800],
            ['id'=>'ex-dp-fast','title'=>'Aviyoma Hızlı Teslimat','price'=>2000],
        ],
        'Web Hizmetleri' => [
            ['id'=>'ex-web-page','title'=>'Aviyoma Ek Sayfa Tasarımı','price'=>2000],
            ['id'=>'ex-web-assets','title'=>'Aviyoma Premium Görsel Seti','price'=>1200],
            ['id'=>'ex-web-speedplus','title'=>'Aviyoma İleri Hız Optimizasyonu','price'=>2500],
            ['id'=>'ex-web-translate','title'=>'Aviyoma Çeviri/Yerelleştirme','price'=>1800],
            ['id'=>'ex-web-fast','title'=>'Aviyoma Hızlı Teslimat','price'=>2000],
        ],
        'Yazılım ve Mühendislik Hizmetleri' => [
            ['id'=>'ex-eng-qa','title'=>'Aviyoma Test & QA Paketi','price'=>3500],
            ['id'=>'ex-eng-doc','title'=>'Aviyoma Teknik Dokümantasyon','price'=>2500],
            ['id'=>'ex-eng-monitor','title'=>'Aviyoma İzleme & Alarm Kurulumu','price'=>3000],
            ['id'=>'ex-eng-integration','title'=>'Aviyoma Ek Entegrasyon','price'=>5000],
            ['id'=>'ex-eng-security','title'=>'Aviyoma Güvenlik Sertleştirme','price'=>4000],
        ],
        'Yapay Zeka Hizmetleri' => [
            ['id'=>'ex-ai-annotation','title'=>'Aviyoma Veri Anotasyon Saati','price'=>2000],
            ['id'=>'ex-ai-prompt','title'=>'Aviyoma Prompt Kütüphanesi','price'=>1500],
            ['id'=>'ex-ai-opt','title'=>'Aviyoma Model Optimizasyonu','price'=>4000],
            ['id'=>'ex-ai-gpu','title'=>'Aviyoma GPU Eğitim Desteği','price'=>5000],
            ['id'=>'ex-ai-fast','title'=>'Aviyoma Hızlı Teslimat','price'=>2500],
        ],
    ];

    // JSON hazırlanıyor
    $categories_json = wp_json_encode($categories);
    $extras_json = wp_json_encode($extras_mapping);
    $ajax_url = admin_url('admin-ajax.php');
    $nonce = wp_create_nonce('aviyoma_order_nonce');

    ob_start();
    ?>

    <!-- Aviyoma Services Shortcode Output -->
    <div id="aviyoma-root" class="max-w-7xl mx-auto p-6" style="--primary:#005B4F; --primary-light:#007A6B; --heading:#1E3C54; --text:#1F2124; --card-bg:#F8FAFC; --accent:#E6F3F1;">
        <script src="https://cdn.tailwindcss.com"></script>
        <script>
            tailwind.config = {
                theme: {
                    extend: {
                        colors: {
                            aviyoma: {
                                primary: 'var(--primary)',
                                'primary-light': 'var(--primary-light)',
                                heading: 'var(--heading)',
                                text: 'var(--text)',
                                card: 'var(--card-bg)',
                                accent: 'var(--accent)'
                            }
                        }
                    }
                }
            }
        </script>

        <!-- Header Section -->
        <div class="mb-8 text-center">
            <div class="inline-flex items-center gap-2 mb-4 px-4 py-2 bg-[color:var(--accent)] rounded-full">
                <div class="w-2 h-2 bg-[color:var(--primary)] rounded-full animate-pulse"></div>
                <span class="text-sm font-medium text-[color:var(--primary)]">Aviyoma Dijital Ajansı</span>
            </div>
            <h1 class="text-4xl font-bold text-[color:var(--heading)] mb-3">Hizmetlerimizden Size En Uygun Olanları Seçin</h1>
            <p class="text-lg text-gray-600 max-w-2xl mx-auto">Profesyonel dijital çözümlerimizle işinizi büyütün. Her hizmet Aviyoma kalitesi ile sunulur.</p>
        </div>

        <!-- Progress & Search Section -->
        <div class="mb-6 bg-white rounded-xl p-4 shadow-sm border">
            <div class="flex items-center justify-between mb-4">
                <div class="flex items-center gap-4">
                    <div class="text-sm text-gray-500">Seçilen: <strong id="av-count" class="text-[color:var(--primary)]">0</strong> hizmet</div>
                    <div class="text-sm text-gray-500">Kalan Süre: <span id="av-remaining" class="text-[color:var(--primary)] font-semibold">4dk</span></div>
                </div>
                <div class="text-sm text-gray-500 font-medium">Adım <span id="av-step">1</span>/4</div>
            </div>
            <div class="flex gap-3">
                <input id="av-search" type="text" placeholder="🔍 Hizmet veya kategori arayın..." class="flex-1 px-4 py-3 rounded-lg border border-gray-200 focus:ring-2 focus:ring-[color:var(--primary)] focus:border-transparent" />
            </div>
            <div class="mt-4 flex items-center gap-4">
                <div class="flex-1 bg-gray-200 rounded-full h-3 overflow-hidden">
                    <div id="av-progress" class="h-3 rounded-full transition-all duration-300" style="width:25%; background:linear-gradient(90deg,var(--primary),var(--primary-light));"></div>
                </div>
            </div>
        </div>

        <!-- Category Filters -->
        <div id="av-filters" class="mb-6 flex flex-wrap gap-3 justify-center"></div>

        <!-- STEP 1: Service Cards -->
        <div data-step="1" class="av-step">
            <div id="av-cards" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6"></div>

            <div class="mt-8 text-center">
                <div class="text-sm text-gray-500 mb-4">Kartlara tıklayarak bir veya birden fazla hizmet seçebilirsiniz</div>
                <button id="av-continue-1" class="px-8 py-3 rounded-lg bg-[color:var(--primary)] text-white font-semibold text-lg shadow-lg hover:bg-[color:var(--primary-light)] transition-all disabled:opacity-50 disabled:cursor-not-allowed" disabled>
                    Devam Et →
                </button>
            </div>
        </div>

        <!-- STEP 2: Extras -->
        <div data-step="2" class="av-step hidden">
            <div id="av-extras" class="space-y-6"></div>

            <div class="mt-8 flex justify-between">
                <button id="av-back-2" class="px-6 py-3 rounded-lg border-2 border-[color:var(--primary)] text-[color:var(--primary)] bg-white font-semibold hover:bg-[color:var(--primary)] hover:text-white transition-all">
                    ← Geri
                </button>
                <button id="av-continue-2" class="px-8 py-3 rounded-lg bg-[color:var(--primary)] text-white font-semibold text-lg shadow-lg hover:bg-[color:var(--primary-light)] transition-all">
                    Devam Et →
                </button>
            </div>
        </div>

        <!-- STEP 3: Summary -->
        <div data-step="3" class="av-step hidden">
            <div class="bg-white shadow-xl rounded-xl p-6 border">
                <div class="flex items-center gap-3 mb-6">
                    <div class="w-10 h-10 bg-[color:var(--primary)] rounded-full flex items-center justify-center">
                        <span class="text-white font-bold">✓</span>
                    </div>
                    <h3 class="text-2xl font-bold text-[color:var(--heading)]">Seçimlerinizin Özeti</h3>
                </div>
                <div id="av-summary" class="space-y-4"></div>
                <div class="mt-6 pt-6 border-t border-gray-200 flex justify-between items-center">
                    <div class="text-lg font-semibold text-gray-700">Toplam Tutar</div>
                    <div id="av-total" class="text-3xl font-bold text-[color:var(--primary)]">0 ₺</div>
                </div>
            </div>

            <div class="mt-8 flex justify-between">
                <button id="av-back-3" class="px-6 py-3 rounded-lg border-2 border-[color:var(--primary)] text-[color:var(--primary)] bg-white font-semibold hover:bg-[color:var(--primary)] hover:text-white transition-all">
                    ← Geri
                </button>
                <button id="av-continue-3" class="px-8 py-3 rounded-lg bg-[color:var(--primary)] text-white font-semibold text-lg shadow-lg hover:bg-[color:var(--primary-light)] transition-all">
                    Sipariş Formuna Geç →
                </button>
            </div>
        </div>

        <!-- STEP 4: Form -->
        <div data-step="4" class="av-step hidden">
            <div class="bg-white shadow-xl rounded-xl p-6 border max-w-2xl mx-auto">
                <div class="text-center mb-6">
                    <div class="w-16 h-16 bg-[color:var(--primary)] rounded-full flex items-center justify-center mx-auto mb-4">
                        <span class="text-white text-2xl">📧</span>
                    </div>
                    <h3 class="text-2xl font-bold text-[color:var(--heading)]">Siparişinizi Tamamlayın</h3>
                    <p class="text-gray-600 mt-2">Bilgilerinizi bırakın, sizi en kısa sürede arayalım</p>
                </div>
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Ad Soyad</label>
                        <input id="av-name" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[color:var(--primary)] focus:border-transparent" placeholder="Adınız ve soyadınız" />
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">E-posta Adresi</label>
                        <input id="av-email" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[color:var(--primary)] focus:border-transparent" placeholder="ornek@email.com" />
                    </div>
                    <div class="flex items-center gap-3 pt-4">
                        <button id="av-submit" class="flex-1 px-6 py-3 rounded-lg bg-[color:var(--primary)] text-white font-semibold hover:bg-[color:var(--primary-light)] transition-all">
                            Siparişi Gönder
                        </button>
                        <div id="av-status" class="text-sm text-gray-600"></div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Footer -->
        <div class="mt-12 text-center">
            <div class="inline-flex items-center gap-2 text-sm text-gray-500">
                <span>Powered by</span>
                <span class="font-bold text-[color:var(--primary)]">Aviyoma</span>
                <span>— Dijital Pazarlama Ajansı</span>
            </div>
        </div>
    </div>

    <script>
    (function(){
        const categories = <?php echo $categories_json; ?>;
        const extrasMap = <?php echo $extras_json; ?>;
        const ajaxUrl = '<?php echo esc_js($ajax_url); ?>';
        const nonce = '<?php echo esc_js($nonce); ?>';

        // State
        let selected = [];
        let selectedExtras = {};
        let currentStep = 1;

        // Elements
        const cardsWrap = document.getElementById('av-cards');
        const filtersWrap = document.getElementById('av-filters');
        const extrasWrap = document.getElementById('av-extras');
        const summaryWrap = document.getElementById('av-summary');
        const totalEl = document.getElementById('av-total');
        const countEl = document.getElementById('av-count');
        const searchInput = document.getElementById('av-search');
        const progressEl = document.getElementById('av-progress');
        const stepEl = document.getElementById('av-step');

        const btnContinue1 = document.getElementById('av-continue-1');
        const btnBack2 = document.getElementById('av-back-2');
        const btnContinue2 = document.getElementById('av-continue-2');
        const btnBack3 = document.getElementById('av-back-3');
        const btnContinue3 = document.getElementById('av-continue-3');
        const btnSubmit = document.getElementById('av-submit');
        const statusEl = document.getElementById('av-status');

        function showStep(n){
            currentStep = n;
            document.querySelectorAll('.av-step').forEach(el=> el.classList.add('hidden'));
            document.querySelectorAll('[data-step]').forEach(s=>{
                if (s.getAttribute('data-step') == n) s.classList.remove('hidden');
            });
            progressEl.style.width = (n*25) + '%';
            stepEl.textContent = n;
        }

        // Initialize category filters
        (function initFilters(){
            const allChip = document.createElement('button');
            allChip.className = 'px-4 py-2 rounded-full bg-[color:var(--primary)] text-white font-medium shadow-lg hover:bg-[color:var(--primary-light)] transition-all';
            allChip.textContent = 'Tüm Kategoriler';
            allChip.dataset.cat = 'all';
            filtersWrap.appendChild(allChip);

            Object.keys(categories).forEach(cat=>{
                const b = document.createElement('button');
                b.className = 'px-4 py-2 rounded-full bg-white border border-gray-200 text-gray-700 font-medium hover:border-[color:var(--primary)] hover:text-[color:var(--primary)] transition-all';
                b.textContent = cat;
                b.dataset.cat = cat;
                filtersWrap.appendChild(b);
            });

            filtersWrap.addEventListener('click', (e)=>{
                if(!e.target.dataset.cat) return;
                const cat = e.target.dataset.cat;
                Array.from(filtersWrap.children).forEach(c=> {
                    c.classList.remove('bg-[color:var(--primary)]', 'text-white', 'shadow-lg');
                    c.classList.add('bg-white', 'border', 'border-gray-200', 'text-gray-700');
                });
                e.target.classList.remove('bg-white', 'border', 'border-gray-200', 'text-gray-700');
                e.target.classList.add('bg-[color:var(--primary)]', 'text-white', 'shadow-lg');
                filterCards(cat);
            });

            filtersWrap.children[0].classList.add('bg-[color:var(--primary)]', 'text-white', 'shadow-lg');
        })();

        function filterCards(cat){
            Array.from(cardsWrap.children).forEach(card=>{
                if(cat === 'all' || card.dataset.category === cat) {
                    card.classList.remove('hidden');
                } else card.classList.add('hidden');
            });
        }

        // Render service cards with new design
        (function renderCards(){
            cardsWrap.innerHTML = '';
            Object.keys(categories).forEach(cat=>{
                categories[cat].forEach(item=>{
                    const c = document.createElement('div');
                    c.className = 'group bg-white rounded-xl shadow-lg border border-gray-100 cursor-pointer transition-all duration-300 hover:shadow-xl hover:scale-[1.02] overflow-hidden';
                    c.dataset.id = item.id;
                    c.dataset.title = item.title;
                    c.dataset.price = item.price;
                    c.dataset.category = cat;

                    c.innerHTML = `
                        <div class="relative">
                            <!-- Header with gradient -->
                            <div class="bg-gradient-to-r from-[color:var(--primary)] to-[color:var(--primary-light)] p-4 text-white">
                                <div class="flex items-start justify-between">
                                    <div class="flex-1">
                                        <div class="text-xs font-medium opacity-90 mb-1">${cat}</div>
                                        <h3 class="text-lg font-bold leading-tight">${item.title}</h3>
                                    </div>
                                    <div class="text-right">
                                        <div class="text-2xl font-bold">${Number(item.price).toLocaleString()}</div>
                                        <div class="text-xs opacity-90">₺</div>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Content -->
                            <div class="p-4">
                                <p class="text-gray-600 text-sm leading-relaxed mb-4">${item.desc}</p>
                                
                                <!-- Features -->
                                <div class="space-y-2 mb-4">
                                    <div class="flex items-center gap-2 text-xs text-gray-500">
                                        <div class="w-1.5 h-1.5 bg-[color:var(--primary)] rounded-full"></div>
                                        <span>Süre: ${item.duration}</span>
                                    </div>
                                    <div class="flex items-center gap-2 text-xs text-gray-500">
                                        <div class="w-1.5 h-1.5 bg-[color:var(--primary)] rounded-full"></div>
                                        <span>Profesyonel ekip</span>
                                    </div>
                                    <div class="flex items-center gap-2 text-xs text-gray-500">
                                        <div class="w-1.5 h-1.5 bg-[color:var(--primary)] rounded-full"></div>
                                        <span>7/24 destek</span>
                                    </div>
                                </div>
                                
                                <!-- Action button -->
                                <div class="text-center">
                                    <div class="inline-flex items-center gap-2 px-4 py-2 rounded-lg bg-[color:var(--accent)] text-[color:var(--primary)] font-medium text-sm group-hover:bg-[color:var(--primary)] group-hover:text-white transition-all">
                                        <span class="select-none">Seç</span>
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                        </svg>
                                    </div>
                                </div>
                            </div>
                        </div>
                    `;

                    c.addEventListener('click', ()=> togglePrimary(c));
                    cardsWrap.appendChild(c);
                });
            });
        })();

        function togglePrimary(card){
            const id = card.dataset.id;
            const title = card.dataset.title;
            const price = Number(card.dataset.price);
            const category = card.dataset.category;
            const idx = selected.findIndex(s=>s.id===id);
            
            if(idx === -1){
                selected.push({id,title,price,category});
                card.classList.add('ring-4', 'ring-[color:var(--primary)]', 'ring-opacity-50');
                card.style.transform = 'scale(1.02)';
            } else {
                selected.splice(idx,1);
                delete selectedExtras[id];
                card.classList.remove('ring-4', 'ring-[color:var(--primary)]', 'ring-opacity-50');
                card.style.transform = 'scale(1)';
            }
            updateSelectionUI();
        }

        function updateSelectionUI(){
            countEl.textContent = selected.length;
            btnContinue1.disabled = selected.length === 0;
        }

        // Search functionality
        searchInput.addEventListener('input', ()=>{
            const q = searchInput.value.trim().toLowerCase();
            Array.from(cardsWrap.children).forEach(card=>{
                const text = (card.dataset.title + ' ' + card.dataset.category).toLowerCase();
                card.classList.toggle('hidden', !text.includes(q));
            });
        });

        // Step navigation
        btnContinue1.addEventListener('click', ()=>{
            renderExtras();
            showStep(2);
        });

        btnBack2.addEventListener('click', ()=> showStep(1) );
        btnContinue2.addEventListener('click', ()=>{
            renderSummary();
            showStep(3);
        });
        btnBack3.addEventListener('click', ()=> showStep(2) );
        btnContinue3.addEventListener('click', ()=> showStep(4) );

        // Render extras with new design
        function renderExtras(){
            extrasWrap.innerHTML = '';
            selectedExtras = {};
            
            if(selected.length === 0){
                extrasWrap.innerHTML = '<div class="text-center text-gray-500 py-8">Önce hizmet seçin.</div>';
                return;
            }
            
            selected.forEach(s=>{
                const block = document.createElement('div');
                block.className = 'bg-white rounded-xl shadow-lg border border-gray-100 overflow-hidden';
                
                block.innerHTML = `
                    <div class="bg-gradient-to-r from-[color:var(--primary)] to-[color:var(--primary-light)] p-4 text-white">
                        <h4 class="text-xl font-bold">${s.title}</h4>
                        <p class="text-sm opacity-90 mt-1">Ek hizmetler ve özelleştirmeler</p>
                    </div>
                    <div class="p-4">
                        <div id="extras-${s.id}" class="grid grid-cols-1 md:grid-cols-2 gap-3"></div>
                    </div>
                `;
                
                extrasWrap.appendChild(block);
                
                const extrasContainer = document.getElementById(`extras-${s.id}`);
                const map = extrasMap[s.category] || [];
                
                if(map.length === 0){
                    extrasContainer.innerHTML = '<div class="col-span-full text-center text-gray-500 py-4">Bu hizmet için ek hizmet bulunmamaktadır.</div>';
                } else {
                    map.forEach(ex=>{
                        const exCard = document.createElement('div');
                        exCard.className = 'p-4 border border-gray-200 rounded-lg cursor-pointer hover:border-[color:var(--primary)] transition-all group';
                        exCard.innerHTML = `
                            <div class="flex items-center justify-between">
                                <div class="flex-1">
                                    <div class="font-medium text-gray-900">${ex.title}</div>
                                    <div class="text-sm text-gray-500 mt-1">Ek özellik</div>
                                </div>
                                <div class="text-right">
                                    <div class="text-lg font-bold text-[color:var(--primary)]">${Number(ex.price).toLocaleString()} ₺</div>
                                    <div class="text-xs text-gray-500">ek ücret</div>
                                </div>
                            </div>
                        `;
                        
                        exCard.addEventListener('click', ()=>{
                            if(!selectedExtras[s.id]) selectedExtras[s.id]=[];
                            const found = (selectedExtras[s.id] || []).findIndex(e=>e.id===ex.id);
                            if(found === -1){
                                selectedExtras[s.id].push({id:ex.id,title:ex.title,price:ex.price});
                                exCard.classList.add('bg-[color:var(--primary)]', 'text-white', 'border-[color:var(--primary)]');
                                exCard.querySelector('.text-gray-900').classList.add('text-white');
                                exCard.querySelector('.text-gray-500').classList.add('text-white', 'opacity-90');
                                exCard.querySelector('.text-[color:var(--primary)]').classList.add('text-white');
                            } else {
                                selectedExtras[s.id].splice(found,1);
                                exCard.classList.remove('bg-[color:var(--primary)]', 'text-white', 'border-[color:var(--primary)]');
                                exCard.querySelector('.text-white').classList.remove('text-white');
                                exCard.querySelector('.text-white.opacity-90').classList.remove('text-white', 'opacity-90');
                                exCard.querySelector('.text-white').classList.remove('text-white');
                            }
                        });
                        
                        extrasContainer.appendChild(exCard);
                    });
                }
            });
        }

        function renderSummary(){
            summaryWrap.innerHTML = '';
            let total = 0;
            
            selected.forEach(s=>{
                const row = document.createElement('div');
                row.className = 'bg-gray-50 rounded-lg p-4';
                row.innerHTML = `
                    <div class="flex justify-between items-start mb-2">
                        <div class="flex-1">
                            <div class="font-bold text-[color:var(--heading)]">${s.title}</div>
                            <div class="text-sm text-gray-500">${s.category}</div>
                        </div>
                        <div class="text-right">
                            <div class="text-xl font-bold text-[color:var(--primary)]">${Number(s.price).toLocaleString()} ₺</div>
                        </div>
                    </div>
                `;
                summaryWrap.appendChild(row);
                total += Number(s.price);

                const exs = selectedExtras[s.id] || [];
                if(exs.length > 0){
                    exs.forEach(ex=>{
                        const exRow = document.createElement('div');
                        exRow.className = 'ml-6 mt-2 flex justify-between items-center py-2 border-l-2 border-[color:var(--primary)] pl-4';
                        exRow.innerHTML = `
                            <div class="text-sm text-gray-600">+ ${ex.title}</div>
                            <div class="text-sm font-semibold text-[color:var(--primary)]">+${Number(ex.price).toLocaleString()} ₺</div>
                        `;
                        summaryWrap.appendChild(exRow);
                        total += Number(ex.price);
                    });
                }
            });

            totalEl.textContent = total.toLocaleString() + ' ₺';
        }

        // Form submission
        btnSubmit.addEventListener('click', ()=>{
            const name = document.getElementById('av-name').value.trim();
            const email = document.getElementById('av-email').value.trim();
            
            if(!name || !email) { 
                statusEl.textContent = 'Lütfen ad ve e-posta girin.'; 
                return; 
            }
            
            statusEl.textContent = 'Gönderiliyor...';
            btnSubmit.disabled = true;

            const services = selected.map(s=>({id:s.id,title:s.title,price:s.price,category:s.category}));
            const extras = selectedExtras;
            let total = 0;
            services.forEach(s=> total += Number(s.price));
            Object.values(extras).forEach(arr=> arr.forEach(e=> total += Number(e.price)));

            const fd = new FormData();
            fd.append('action','aviyoma_submit_order');
            fd.append('nonce', nonce);
            fd.append('name', name);
            fd.append('email', email);
            fd.append('services', JSON.stringify(services));
            fd.append('extras', JSON.stringify(extras));
            fd.append('total', total);

            fetch(ajaxUrl, { method:'POST', body: fd })
            .then(r=> r.json())
            .then(j=>{
                if(j.success){
                    statusEl.textContent = '✅ Siparişiniz alındı. Teşekkürler!';
                    setTimeout(()=> location.reload(), 2000);
                } else {
                    statusEl.textContent = '❌ Hata: ' + (j.data || 'Gönderilemedi.');
                    btnSubmit.disabled = false;
                }
            }).catch(err=>{
                statusEl.textContent = '❌ Ağ hatası. Lütfen tekrar deneyin.';
                btnSubmit.disabled = false;
            });
        });

        // Initialize
        updateSelectionUI();
        showStep(1);

    })();
    </script>

    <?php
    return ob_get_clean();
}

// Shortcode registration
add_shortcode('aviyoma_services', 'aviyoma_services_shortcode');

// AJAX handler for order submission
function aviyoma_handle_submit() {
    if ( ! isset($_POST['nonce']) || ! wp_verify_nonce(sanitize_text_field(wp_unslash($_POST['nonce'])), 'aviyoma_order_nonce') ) {
        wp_send_json_error('Güvenlik doğrulaması başarısız.');
    }

    $name = isset($_POST['name']) ? sanitize_text_field(wp_unslash($_POST['name'])) : '';
    $email = isset($_POST['email']) ? sanitize_email(wp_unslash($_POST['email'])) : '';
    $services_raw = isset($_POST['services']) ? wp_unslash($_POST['services']) : '[]';
    $extras_raw = isset($_POST['extras']) ? wp_unslash($_POST['extras']) : '{}';
    $total = isset($_POST['total']) ? sanitize_text_field(wp_unslash($_POST['total'])) : '0';

    if ( empty($name) || empty($email) ) {
        wp_send_json_error('Ad ve e-posta gerekli.');
    }

    $services = json_decode($services_raw, true);
    $extras = json_decode($extras_raw, true);

    $to = 'info@lightblue-ostrich-581818.hostingersite.com';
    $from = 'siparis@lightblue-ostrich-581818.hostingersite.com';
    $subject = 'Yeni Sipariş - Aviyoma';
    $headers = array();
    $headers[] = 'From: Aviyoma <' . $from . '>';
    $headers[] = 'Reply-To: ' . $email;
    $headers[] = 'Content-Type: text/html; charset=UTF-8';

    $body = '<h2>Yeni Sipariş - Aviyoma</h2>';
    $body .= '<p><strong>İsim:</strong> ' . esc_html($name) . '<br>';
    $body .= '<strong>E-posta:</strong> ' . esc_html($email) . '</p>';
    $body .= '<h3>Seçilen Hizmetler</h3><ul>';
    if( is_array($services) ){
        foreach($services as $s){
            $body .= '<li>' . esc_html($s['title']) . ' — ' . number_format_i18n($s['price']).' ₺</li>';
        }
    }
    $body .= '</ul>';

    $body .= '<h3>Ek Hizmetler</h3>';
    if( is_array($extras) && count($extras) ){
        foreach($extras as $parentId => $arr){
            if(empty($arr)) continue;
            $body .= '<strong>Üst Hizmet ID: ' . esc_html($parentId) . '</strong><ul>';
            foreach($arr as $ex){
                $body .= '<li>' . esc_html($ex['title']) . ' — ' . number_format_i18n($ex['price']).' ₺</li>';
            }
            $body .= '</ul>';
        }
    } else {
        $body .= '<p>Ek hizmet yok.</p>';
    }

    $body .= '<h3>Toplam: ' . esc_html(number_format_i18n($total)) . ' ₺</h3>';
    $body .= '<p>IP: ' . esc_html( $_SERVER['REMOTE_ADDR'] ?? 'unknown' ) . '</p>';

    // Set sender address
    add_filter( 'wp_mail_from', function($orig){ return 'siparis@lightblue-ostrich-581818.hostingersite.com'; } );
    add_filter( 'wp_mail_from_name', function($orig){ return 'Aviyoma Sipariş'; } );

    $sent = wp_mail( $to, $subject, $body, $headers );

    // Clean filters
    remove_all_filters('wp_mail_from');
    remove_all_filters('wp_mail_from_name');

    if ( $sent ) {
        wp_send_json_success('Gönderildi');
    } else {
        wp_send_json_error('E-posta gönderilemedi. Sunucu posta ayarlarınızı kontrol edin.');
    }
}
add_action('wp_ajax_aviyoma_submit_order', 'aviyoma_handle_submit');
add_action('wp_ajax_nopriv_aviyoma_submit_order', 'aviyoma_handle_submit');

}
?>