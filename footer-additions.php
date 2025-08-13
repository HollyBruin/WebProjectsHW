<!-- WordPress footer.php dosyasına eklenecek kodlar -->

<!-- Blog sayfası için özel JavaScript -->
<?php if (is_page_template('blog-page.php') || is_home() || is_category() || is_search()) : ?>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // AJAX ile kategori filtreleme
    const categoryButtons = document.querySelectorAll('.category-btn');
    const searchForm = document.querySelector('.search-filter-section form');
    const blogGrid = document.querySelector('.grid');
    
    // Kategori butonlarına tıklama
    categoryButtons.forEach(button => {
        button.addEventListener('click', function(e) {
            e.preventDefault();
            
            // Aktif sınıfını güncelle
            categoryButtons.forEach(btn => btn.classList.remove('active'));
            this.classList.add('active');
            
            // AJAX isteği gönder
            const category = this.dataset.category || 'all';
            const searchQuery = document.querySelector('input[name="s"]') ? document.querySelector('input[name="s"]').value : '';
            
            filterPosts(category, searchQuery);
        });
    });
    
    // Arama formu
    if (searchForm) {
        searchForm.addEventListener('submit', function(e) {
            e.preventDefault();
            
            const searchQuery = document.querySelector('input[name="s"]').value;
            const activeCategory = document.querySelector('.category-btn.active');
            const category = activeCategory ? activeCategory.dataset.category || 'all' : 'all';
            
            filterPosts(category, searchQuery);
        });
    }
    
    function filterPosts(category, search) {
        // Loading göstergesi
        if (blogGrid) {
            blogGrid.innerHTML = '<div class="col-span-full text-center py-20"><div class="animate-spin rounded-full h-12 w-12 border-b-2 border-primary mx-auto"></div><p class="mt-4 text-gray-600">Yazılar yükleniyor...</p></div>';
        }
        
        const formData = new FormData();
        formData.append('action', 'filter_posts');
        formData.append('category', category);
        formData.append('search', search);
        formData.append('paged', 1);
        
        fetch(ajaxurl, {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.success && blogGrid) {
                blogGrid.innerHTML = data.data.html;
                
                // Yeni yüklenen kartlara hover efektlerini ekle
                initializeBlogCards();
                
                // URL'yi güncelle (sayfa yenilenmeden)
                const url = new URL(window.location);
                if (category !== 'all') {
                    url.searchParams.set('category', category);
                } else {
                    url.searchParams.delete('category');
                }
                if (search) {
                    url.searchParams.set('s', search);
                } else {
                    url.searchParams.delete('s');
                }
                window.history.pushState({}, '', url);
            }
        })
        .catch(error => {
            console.error('Error:', error);
            if (blogGrid) {
                blogGrid.innerHTML = '<div class="col-span-full text-center py-20"><div class="bg-red-50 rounded-lg p-6"><i class="fas fa-exclamation-triangle text-red-500 text-2xl mb-4"></i><p class="text-red-700">Bir hata oluştu. Lütfen tekrar deneyin.</p></div></div>';
            }
        });
    }
    
    // Blog kartlarını başlat
    function initializeBlogCards() {
        // Lazy loading için Intersection Observer
        const images = document.querySelectorAll('.blog-card img[data-src]');
        const imageObserver = new IntersectionObserver((entries, observer) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    const img = entry.target;
                    img.src = img.dataset.src;
                    img.classList.remove('lazy');
                    imageObserver.unobserve(img);
                }
            });
        });
        
        images.forEach(img => imageObserver.observe(img));
        
        // Kartlara hover efektlerini ekle
        const cards = document.querySelectorAll('.blog-card');
        cards.forEach(card => {
            card.addEventListener('mouseenter', function() {
                this.style.transform = 'translateY(-5px)';
                this.style.boxShadow = '0 20px 40px rgba(58, 48, 136, 0.15)';
            });
            
            card.addEventListener('mouseleave', function() {
                this.style.transform = 'translateY(0)';
                this.style.boxShadow = '0 4px 6px rgba(0, 0, 0, 0.1)';
            });
        });
    }
    
    // Sayfa yüklendiğinde blog kartlarını başlat
    initializeBlogCards();
    
    // URL'den kategori ve arama parametrelerini oku
    const urlParams = new URLSearchParams(window.location.search);
    const urlCategory = urlParams.get('category');
    const urlSearch = urlParams.get('s');
    
    if (urlCategory || urlSearch) {
        // URL'deki parametrelere göre filtreleme yap
        const category = urlCategory || 'all';
        const search = urlSearch || '';
        
        // Aktif kategori butonunu güncelle
        if (urlCategory) {
            categoryButtons.forEach(btn => {
                if (btn.dataset.category === urlCategory) {
                    btn.classList.add('active');
                } else {
                    btn.classList.remove('active');
                }
            });
        }
        
        // Arama kutusunu güncelle
        if (urlSearch && document.querySelector('input[name="s"]')) {
            document.querySelector('input[name="s"]').value = urlSearch;
        }
    }
    
    // Sayfalama için AJAX
    document.addEventListener('click', function(e) {
        if (e.target.matches('.pagination a')) {
            e.preventDefault();
            
            const page = e.target.href.match(/paged=(\d+)/);
            if (page) {
                const pageNum = page[1];
                const activeCategory = document.querySelector('.category-btn.active');
                const category = activeCategory ? activeCategory.dataset.category || 'all' : 'all';
                const searchQuery = document.querySelector('input[name="s"]') ? document.querySelector('input[name="s"]').value : '';
                
                loadPage(pageNum, category, searchQuery);
            }
        }
    });
    
    function loadPage(page, category, search) {
        if (blogGrid) {
            blogGrid.innerHTML = '<div class="col-span-full text-center py-20"><div class="animate-spin rounded-full h-12 w-12 border-b-2 border-primary mx-auto"></div><p class="mt-4 text-gray-600">Sayfa yükleniyor...</p></div>';
        }
        
        const formData = new FormData();
        formData.append('action', 'filter_posts');
        formData.append('category', category);
        formData.append('search', search);
        formData.append('paged', page);
        
        fetch(ajaxurl, {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.success && blogGrid) {
                blogGrid.innerHTML = data.data.html;
                initializeBlogCards();
                
                // Sayfayı yukarı kaydır
                window.scrollTo({ top: 0, behavior: 'smooth' });
                
                // URL'yi güncelle
                const url = new URL(window.location);
                url.searchParams.set('paged', page);
                window.history.pushState({}, '', url);
            }
        })
        .catch(error => {
            console.error('Error:', error);
        });
    }
    
    // Newsletter formu
    const newsletterForm = document.querySelector('.newsletter-form');
    if (newsletterForm) {
        newsletterForm.addEventListener('submit', function(e) {
            e.preventDefault();
            
            const email = this.querySelector('input[type="email"]').value;
            const submitBtn = this.querySelector('button[type="submit"]');
            const originalText = submitBtn.innerHTML;
            
            // Loading durumu
            submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Gönderiliyor...';
            submitBtn.disabled = true;
            
            // AJAX ile newsletter kaydı
            const formData = new FormData();
            formData.append('action', 'newsletter_signup');
            formData.append('email', email);
            
            fetch(ajaxurl, {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    submitBtn.innerHTML = '<i class="fas fa-check mr-2"></i>Başarılı!';
                    submitBtn.classList.remove('bg-white', 'hover:bg-gray-100');
                    submitBtn.classList.add('bg-green-500', 'text-white');
                    this.querySelector('input[type="email"]').value = '';
                } else {
                    submitBtn.innerHTML = originalText;
                    submitBtn.disabled = false;
                    alert('Bir hata oluştu. Lütfen tekrar deneyin.');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                submitBtn.innerHTML = originalText;
                submitBtn.disabled = false;
                alert('Bir hata oluştu. Lütfen tekrar deneyin.');
            });
        });
    }
    
    // Sosyal medya paylaşım butonları
    function sharePost(url, title) {
        if (navigator.share) {
            navigator.share({
                title: title,
                url: url
            });
        } else {
            // Fallback: URL'yi panoya kopyala
            navigator.clipboard.writeText(url).then(() => {
                alert('Link panoya kopyalandı!');
            });
        }
    }
    
    // Blog kartlarına sosyal medya paylaşım butonları ekle
    const shareButtons = document.querySelectorAll('.share-post');
    shareButtons.forEach(button => {
        button.addEventListener('click', function(e) {
            e.preventDefault();
            const url = this.dataset.url;
            const title = this.dataset.title;
            sharePost(url, title);
        });
    });
    
    // Arama önerileri (otomatik tamamlama)
    const searchInput = document.querySelector('input[name="s"]');
    if (searchInput) {
        let searchTimeout;
        
        searchInput.addEventListener('input', function() {
            clearTimeout(searchTimeout);
            const query = this.value;
            
            if (query.length > 2) {
                searchTimeout = setTimeout(() => {
                    // AJAX ile arama önerileri getir
                    const formData = new FormData();
                    formData.append('action', 'search_suggestions');
                    formData.append('query', query);
                    
                    fetch(ajaxurl, {
                        method: 'POST',
                        body: formData
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            showSearchSuggestions(data.data.suggestions);
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                    });
                }, 300);
            } else {
                hideSearchSuggestions();
            }
        });
    }
    
    function showSearchSuggestions(suggestions) {
        let suggestionsBox = document.querySelector('.search-suggestions');
        if (!suggestionsBox) {
            suggestionsBox = document.createElement('div');
            suggestionsBox.className = 'search-suggestions absolute top-full left-0 right-0 bg-white border border-gray-200 rounded-lg shadow-lg z-50 mt-1';
            searchInput.parentNode.style.position = 'relative';
            searchInput.parentNode.appendChild(suggestionsBox);
        }
        
        suggestionsBox.innerHTML = suggestions.map(suggestion => 
            `<div class="p-3 hover:bg-gray-50 cursor-pointer border-b border-gray-100 last:border-b-0" onclick="document.querySelector('input[name=\\'s\\']').value='${suggestion.title}'; hideSearchSuggestions();">
                <div class="font-medium text-gray-900">${suggestion.title}</div>
                <div class="text-sm text-gray-500">${suggestion.excerpt}</div>
            </div>`
        ).join('');
        
        suggestionsBox.style.display = 'block';
    }
    
    function hideSearchSuggestions() {
        const suggestionsBox = document.querySelector('.search-suggestions');
        if (suggestionsBox) {
            suggestionsBox.style.display = 'none';
        }
    }
    
    // Sayfa dışına tıklandığında önerileri gizle
    document.addEventListener('click', function(e) {
        if (!e.target.closest('.search-filter-section')) {
            hideSearchSuggestions();
        }
    });
    
    // Klavye navigasyonu
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            hideSearchSuggestions();
        }
    });
    
    // Performans optimizasyonu: Debounce fonksiyonu
    function debounce(func, wait) {
        let timeout;
        return function executedFunction(...args) {
            const later = () => {
                clearTimeout(timeout);
                func(...args);
            };
            clearTimeout(timeout);
            timeout = setTimeout(later, wait);
        };
    }
    
    // Scroll to top butonu
    const scrollToTopBtn = document.createElement('button');
    scrollToTopBtn.innerHTML = '<i class="fas fa-arrow-up"></i>';
    scrollToTopBtn.className = 'fixed bottom-8 right-8 bg-primary text-white p-3 rounded-full shadow-lg hover:bg-secondary transition-all duration-300 opacity-0 pointer-events-none z-50';
    document.body.appendChild(scrollToTopBtn);
    
    const debouncedScrollHandler = debounce(() => {
        if (window.pageYOffset > 300) {
            scrollToTopBtn.style.opacity = '1';
            scrollToTopBtn.style.pointerEvents = 'auto';
        } else {
            scrollToTopBtn.style.opacity = '0';
            scrollToTopBtn.style.pointerEvents = 'none';
        }
    }, 100);
    
    window.addEventListener('scroll', debouncedScrollHandler);
    
    scrollToTopBtn.addEventListener('click', () => {
        window.scrollTo({ top: 0, behavior: 'smooth' });
    });
    
    // Sayfa yüklendiğinde scroll durumunu kontrol et
    debouncedScrollHandler();
});

// Newsletter signup AJAX handler
function newsletter_signup() {
    $email = sanitize_email($_POST['email']);
    
    if (!is_email($email)) {
        wp_send_json_error('Geçersiz e-posta adresi');
    }
    
    // E-posta adresini kaydet (örnek: WordPress options tablosuna)
    $existing_emails = get_option('newsletter_subscribers', array());
    
    if (!in_array($email, $existing_emails)) {
        $existing_emails[] = $email;
        update_option('newsletter_subscribers', $existing_emails);
        
        // E-posta gönder (opsiyonel)
        $to = get_option('admin_email');
        $subject = 'Yeni Newsletter Abonesi';
        $message = "Yeni bir newsletter abonesi: $email";
        wp_mail($to, $subject, $message);
        
        wp_send_json_success('Başarıyla abone oldunuz!');
    } else {
        wp_send_json_error('Bu e-posta adresi zaten kayıtlı');
    }
}
add_action('wp_ajax_newsletter_signup', 'newsletter_signup');
add_action('wp_ajax_nopriv_newsletter_signup', 'newsletter_signup');

// Arama önerileri AJAX handler
function search_suggestions() {
    $query = sanitize_text_field($_POST['query']);
    
    if (strlen($query) < 3) {
        wp_send_json_error('Arama terimi çok kısa');
    }
    
    $args = array(
        'post_type' => 'post',
        'post_status' => 'publish',
        'posts_per_page' => 5,
        's' => $query,
        'orderby' => 'relevance'
    );
    
    $search_query = new WP_Query($args);
    $suggestions = array();
    
    if ($search_query->have_posts()) {
        while ($search_query->have_posts()) {
            $search_query->the_post();
            $suggestions[] = array(
                'title' => get_the_title(),
                'excerpt' => wp_trim_words(get_the_excerpt(), 10, '...'),
                'url' => get_permalink()
            );
        }
    }
    
    wp_reset_postdata();
    wp_send_json_success(array('suggestions' => $suggestions));
}
add_action('wp_ajax_search_suggestions', 'search_suggestions');
add_action('wp_ajax_nopriv_search_suggestions', 'search_suggestions');
</script>
<?php endif; ?>

<!-- Genel site JavaScript -->
<script>
// Sayfa yüklendiğinde çalışacak genel fonksiyonlar
document.addEventListener('DOMContentLoaded', function() {
    // Smooth scroll için
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function (e) {
            e.preventDefault();
            const target = document.querySelector(this.getAttribute('href'));
            if (target) {
                target.scrollIntoView({
                    behavior: 'smooth',
                    block: 'start'
                });
            }
        });
    });
    
    // Form validasyonu
    const forms = document.querySelectorAll('form');
    forms.forEach(form => {
        form.addEventListener('submit', function(e) {
            const requiredFields = form.querySelectorAll('[required]');
            let isValid = true;
            
            requiredFields.forEach(field => {
                if (!field.value.trim()) {
                    isValid = false;
                    field.classList.add('border-red-500');
                } else {
                    field.classList.remove('border-red-500');
                }
            });
            
            if (!isValid) {
                e.preventDefault();
                alert('Lütfen tüm gerekli alanları doldurun.');
            }
        });
    });
    
    // E-posta validasyonu
    const emailFields = document.querySelectorAll('input[type="email"]');
    emailFields.forEach(field => {
        field.addEventListener('blur', function() {
            const email = this.value;
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            
            if (email && !emailRegex.test(email)) {
                this.classList.add('border-red-500');
                this.setCustomValidity('Geçerli bir e-posta adresi girin');
            } else {
                this.classList.remove('border-red-500');
                this.setCustomValidity('');
            }
        });
    });
});

// Sayfa performansı için lazy loading
if ('IntersectionObserver' in window) {
    const imageObserver = new IntersectionObserver((entries, observer) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                const img = entry.target;
                img.src = img.dataset.src;
                img.classList.remove('lazy');
                imageObserver.unobserve(img);
            }
        });
    });
    
    document.querySelectorAll('img[data-src]').forEach(img => {
        imageObserver.observe(img);
    });
}
</script>