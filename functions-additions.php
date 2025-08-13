<?php
/**
 * NETSEO Blog Page Functions
 * Bu dosyayı temanızın functions.php dosyasına ekleyin
 */

// Blog sayfası için gerekli CSS ve JS dosyalarını yükle
function netseo_blog_enqueue_scripts() {
    if (is_page_template('blog-page.php') || is_home() || is_category() || is_search()) {
        // Tailwind CSS
        wp_enqueue_style('tailwindcss', 'https://cdn.tailwindcss.com');
        
        // Google Fonts
        wp_enqueue_style('google-fonts', 'https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&display=swap');
        
        // Font Awesome
        wp_enqueue_style('font-awesome', 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css');
        
        // Custom CSS
        wp_enqueue_style('netseo-blog-style', get_template_directory_uri() . '/assets/css/blog-style.css');
    }
}
add_action('wp_enqueue_scripts', 'netseo_blog_enqueue_scripts');

// Okuma süresi hesaplama fonksiyonu
function netseo_get_reading_time($post_id = null) {
    if (!$post_id) {
        $post_id = get_the_ID();
    }
    
    $content = get_post_field('post_content', $post_id);
    $word_count = str_word_count(strip_tags($content));
    $reading_time = ceil($word_count / 200); // Dakikada 200 kelime
    
    return max(1, $reading_time); // En az 1 dakika
}

// Blog kartları için özel excerpt uzunluğu
function netseo_blog_excerpt_length($length) {
    return 20; // 20 kelime
}
add_filter('excerpt_length', 'netseo_blog_excerpt_length');

// Excerpt daha fazla linkini kaldır
function netseo_remove_excerpt_more($more) {
    return '';
}
add_filter('excerpt_more', 'netseo_remove_excerpt_more');

// Blog sayfası için özel sayfalama
function netseo_blog_pagination($query = null) {
    if (!$query) {
        global $wp_query;
        $query = $wp_query;
    }
    
    $big = 999999999;
    $pagination = paginate_links(array(
        'base' => str_replace($big, '%#%', esc_url(get_pagenum_link($big))),
        'format' => '?paged=%#%',
        'current' => max(1, get_query_var('paged')),
        'total' => $query->max_num_pages,
        'prev_text' => '<i class="fas fa-chevron-left"></i> Önceki',
        'next_text' => 'Sonraki <i class="fas fa-chevron-right"></i>',
        'type' => 'array',
        'end_size' => 3,
        'mid_size' => 3
    ));
    
    if ($pagination) {
        echo '<div class="pagination">';
        foreach ($pagination as $link) {
            echo $link;
        }
        echo '</div>';
    }
}

// Blog arama fonksiyonu
function netseo_blog_search_form($form) {
    if (is_page_template('blog-page.php') || is_home() || is_category()) {
        $form = '<form method="get" action="' . esc_url(home_url('/')) . '" class="mb-4">
            <input type="hidden" name="post_type" value="post">
            <div class="flex gap-4">
                <input type="text" name="s" placeholder="Blog yazılarında ara..." value="' . get_search_query() . '" class="search-input flex-1">
                <button type="submit" class="bg-white text-primary font-semibold px-8 py-3 rounded-lg hover:bg-gray-100 transition-colors">
                    <i class="fas fa-search mr-2"></i>Ara
                </button>
            </div>
        </form>';
    }
    return $form;
}
add_filter('get_search_form', 'netseo_blog_search_form');

// Kategori filtreleme için AJAX endpoint
function netseo_ajax_filter_posts() {
    $category = $_POST['category'];
    $search = $_POST['search'];
    $paged = $_POST['paged'] ? $_POST['paged'] : 1;
    
    $args = array(
        'post_type' => 'post',
        'post_status' => 'publish',
        'posts_per_page' => 9,
        'paged' => $paged,
        'orderby' => 'date',
        'order' => 'DESC'
    );
    
    if ($category && $category !== 'all') {
        $args['cat'] = $category;
    }
    
    if ($search) {
        $args['s'] = $search;
    }
    
    $query = new WP_Query($args);
    
    ob_start();
    
    if ($query->have_posts()) {
        echo '<div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">';
        while ($query->have_posts()) {
            $query->the_post();
            get_template_part('template-parts/content', 'blog-card');
        }
        echo '</div>';
        
        // Pagination
        if ($query->max_num_pages > 1) {
            netseo_blog_pagination($query);
        }
    } else {
        echo '<div class="text-center py-20">
            <div class="bg-white rounded-2xl p-12 shadow-lg max-w-2xl mx-auto">
                <i class="fas fa-search text-6xl text-gray-300 mb-6"></i>
                <h2 class="font-helvetica text-2xl font-bold text-primary mb-4">Sonuç bulunamadı</h2>
                <p class="text-gray-600 mb-6">Aradığınız kriterlere uygun blog yazısı bulunamadı.</p>
            </div>
        </div>';
    }
    
    $html = ob_get_clean();
    wp_reset_postdata();
    
    wp_send_json_success(array('html' => $html));
}
add_action('wp_ajax_filter_posts', 'netseo_ajax_filter_posts');
add_action('wp_ajax_nopriv_filter_posts', 'netseo_ajax_filter_posts');

// Blog kartı template part'ı oluştur
function netseo_create_blog_card_template() {
    $template_content = '<?php
/**
 * Template part for displaying blog cards
 */
?>
<article class="blog-card bg-white rounded-2xl overflow-hidden shadow-lg">
    <!-- Featured Image -->
    <div class="h-48 bg-gradient-to-br from-primary to-secondary relative overflow-hidden">
        <?php if (has_post_thumbnail()) : ?>
            <?php the_post_thumbnail(\'medium\', array(\'class\' => \'w-full h-full object-cover\')); ?>
        <?php else : ?>
            <div class="w-full h-full flex items-center justify-center">
                <i class="fas fa-newspaper text-white text-4xl opacity-60"></i>
            </div>
        <?php endif; ?>
        
        <!-- Category Badge -->
        <?php
        $categories = get_the_category();
        if (!empty($categories)) {
            $category = $categories[0];
            echo \'<div class="absolute top-4 left-4">\';
            echo \'<a href="\' . esc_url(get_category_link($category->term_id)) . \'" class="blog-tag">\' . esc_html($category->name) . \'</a>\';
            echo \'</div>\';
        }
        ?>
    </div>
    
    <!-- Content -->
    <div class="p-6">
        <!-- Title -->
        <h2 class="font-helvetica text-xl font-bold text-primary mb-3 line-clamp-2">
            <a href="<?php the_permalink(); ?>" class="hover:text-secondary transition-colors">
                <?php the_title(); ?>
            </a>
        </h2>
        
        <!-- Tags -->
        <?php
        $tags = get_the_tags();
        if ($tags) : ?>
            <div class="flex flex-wrap gap-2 mb-4">
                <?php foreach ($tags as $tag) : ?>
                    <a href="<?php echo esc_url(get_tag_link($tag->term_id)); ?>" class="blog-tag">
                        #<?php echo esc_html($tag->name); ?>
                    </a>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
        
        <!-- Meta Information -->
        <div class="flex items-center text-sm text-gray-500 mb-4">
            <div class="flex items-center mr-4">
                <i class="fas fa-calendar mr-2"></i>
                <time datetime="<?php echo get_the_date(\'c\'); ?>">
                    <?php echo get_the_date(\'d.m.Y\'); ?>
                </time>
            </div>
            <div class="flex items-center mr-4">
                <i class="fas fa-user mr-2"></i>
                <span><?php the_author(); ?></span>
            </div>
            <div class="flex items-center">
                <i class="fas fa-clock mr-2"></i>
                <span><?php echo netseo_get_reading_time(); ?> dk okuma</span>
            </div>
        </div>
        
        <!-- Excerpt -->
        <div class="text-gray-600 mb-4 line-clamp-3">
            <?php echo wp_trim_words(get_the_excerpt(), 20, \'...\'); ?>
        </div>
        
        <!-- Read More Button -->
        <a href="<?php the_permalink(); ?>" class="inline-flex items-center text-secondary font-semibold hover:text-primary transition-colors">
            Devamını Oku
            <i class="fas fa-arrow-right ml-2"></i>
        </a>
    </div>
</article>';
    
    $template_dir = get_template_directory() . '/template-parts';
    if (!file_exists($template_dir)) {
        wp_mkdir_p($template_dir);
    }
    
    file_put_contents($template_dir . '/content-blog-card.php', $template_content);
}

// Tema aktifleştirildiğinde blog kartı template'ini oluştur
add_action('after_switch_theme', 'netseo_create_blog_card_template');

// Blog sayfası için özel CSS
function netseo_blog_custom_css() {
    if (is_page_template('blog-page.php') || is_home() || is_category() || is_search()) {
        ?>
        <style>
            .font-helvetica { font-family: 'Helvetica', Arial, sans-serif; }
            .font-roboto { font-family: 'Roboto', sans-serif; }
            
            /* Full-bleed helper */
            .full-bleed {
                position: relative;
                width: 100vw;
                left: 50%;
                right: 50%;
                margin-left: -50vw;
                margin-right: -50vw;
            }
            
            html, body { overflow-x: hidden; }
            
            /* Blog card hover effects */
            .blog-card {
                transition: all 0.3s ease;
            }
            
            .blog-card:hover {
                transform: translateY(-5px);
                box-shadow: 0 20px 40px rgba(58, 48, 136, 0.15);
            }
            
            /* Tag styling */
            .blog-tag {
                background: linear-gradient(135deg, #3A3088, #646FD1);
                color: white;
                padding: 4px 12px;
                border-radius: 20px;
                font-size: 12px;
                font-weight: 500;
                transition: all 0.3s ease;
            }
            
            .blog-tag:hover {
                transform: scale(1.05);
            }
            
            /* Line clamp utilities */
            .line-clamp-2 {
                display: -webkit-box;
                -webkit-line-clamp: 2;
                -webkit-box-orient: vertical;
                overflow: hidden;
            }
            
            .line-clamp-3 {
                display: -webkit-box;
                -webkit-line-clamp: 3;
                -webkit-box-orient: vertical;
                overflow: hidden;
            }
            
            /* Pagination styling */
            .pagination {
                display: flex;
                justify-content: center;
                gap: 10px;
                margin-top: 40px;
            }
            
            .pagination a,
            .pagination span {
                padding: 12px 20px;
                border-radius: 8px;
                text-decoration: none;
                font-weight: 500;
                transition: all 0.3s ease;
            }
            
            .pagination a {
                background: #f8f9fa;
                color: #3A3088;
                border: 2px solid transparent;
            }
            
            .pagination a:hover {
                background: #3A3088;
                color: white;
                border-color: #3A3088;
            }
            
            .pagination .current {
                background: #3A3088;
                color: white;
            }
            
            /* Search and filter section */
            .search-filter-section {
                background: linear-gradient(135deg, #3A3088, #646FD1, #764BA2);
                padding: 40px 0;
                margin-bottom: 40px;
            }
            
            .search-box {
                background: rgba(255, 255, 255, 0.1);
                backdrop-filter: blur(10px);
                border: 1px solid rgba(255, 255, 255, 0.2);
                border-radius: 12px;
                padding: 20px;
            }
            
            .search-input {
                background: white;
                border: none;
                border-radius: 8px;
                padding: 12px 20px;
                width: 100%;
                font-size: 16px;
            }
            
            .search-input:focus {
                outline: none;
                box-shadow: 0 0 0 3px rgba(255, 255, 255, 0.3);
            }
            
            /* Category filter */
            .category-filter {
                display: flex;
                flex-wrap: wrap;
                gap: 10px;
                margin-top: 20px;
            }
            
            .category-btn {
                background: rgba(255, 255, 255, 0.2);
                color: white;
                border: 1px solid rgba(255, 255, 255, 0.3);
                padding: 8px 16px;
                border-radius: 20px;
                text-decoration: none;
                font-size: 14px;
                transition: all 0.3s ease;
            }
            
            .category-btn:hover,
            .category-btn.active {
                background: white;
                color: #3A3088;
            }
            
            /* Responsive design */
            @media (max-width: 768px) {
                .search-filter-section .flex {
                    flex-direction: column;
                }
                
                .category-filter {
                    justify-content: center;
                }
                
                .pagination {
                    flex-wrap: wrap;
                }
            }
        </style>
        <?php
    }
}
add_action('wp_head', 'netseo_blog_custom_css');

// Blog sayfası için özel JavaScript
function netseo_blog_custom_js() {
    if (is_page_template('blog-page.php') || is_home() || is_category() || is_search()) {
        ?>
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
                    const searchQuery = document.querySelector('input[name="s"]').value;
                    
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
                    if (data.success) {
                        blogGrid.innerHTML = data.data.html;
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                });
            }
            
            // Lazy loading için Intersection Observer
            const images = document.querySelectorAll('.blog-card img');
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
        });
        </script>
        <?php
    }
}
add_action('wp_footer', 'netseo_blog_custom_js');

// Blog sayfası için özel meta bilgileri
function netseo_blog_meta_tags() {
    if (is_page_template('blog-page.php') || is_home() || is_category() || is_search()) {
        ?>
        <meta name="description" content="NETSEO blog - Dijital pazarlama, SEO, sosyal medya ve web tasarım konularında güncel bilgiler ve uzman görüşleri">
        <meta name="keywords" content="dijital pazarlama, SEO, sosyal medya, web tasarım, reklam yönetimi">
        <meta property="og:title" content="NETSEO Blog - Dijital Pazarlama Rehberi">
        <meta property="og:description" content="Dijital pazarlama dünyasından en güncel bilgiler ve uzman görüşleri">
        <meta property="og:type" content="website">
        <meta property="og:url" content="<?php echo esc_url(get_permalink()); ?>">
        <?php
    }
}
add_action('wp_head', 'netseo_blog_meta_tags');
?>