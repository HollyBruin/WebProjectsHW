<?php
/**
 * Template Name: Blog Sayfası
 * 
 * Bu şablon NETSEO blog sayfası için özel olarak tasarlanmıştır.
 * WordPress'ten post verilerini çekerek dinamik kartlar oluşturur.
 */

get_header(); ?>

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
</style>

<!-- Hero Section -->
<section class="full-bleed relative py-20 bg-gradient-to-br from-primary via-secondary to-tertiary">
    <div class="w-full max-w-screen-xl mx-auto px-6 md:px-10 relative z-10 text-center">
        <h1 class="font-helvetica text-4xl md:text-6xl font-bold text-white mb-6">
            Blog
        </h1>
        <p class="text-xl text-white/90 max-w-3xl mx-auto">
            Dijital pazarlama dünyasından en güncel bilgiler, trendler ve uzman görüşleri
        </p>
    </div>
</section>

<!-- Search and Filter Section -->
<section class="search-filter-section">
    <div class="w-full max-w-screen-xl mx-auto px-6 md:px-10">
        <div class="search-box">
            <form method="get" action="<?php echo esc_url(home_url('/')); ?>" class="mb-4">
                <input type="hidden" name="post_type" value="post">
                <div class="flex gap-4">
                    <input 
                        type="text" 
                        name="s" 
                        placeholder="Blog yazılarında ara..." 
                        value="<?php echo get_search_query(); ?>"
                        class="search-input flex-1"
                    >
                    <button type="submit" class="bg-white text-primary font-semibold px-8 py-3 rounded-lg hover:bg-gray-100 transition-colors">
                        <i class="fas fa-search mr-2"></i>Ara
                    </button>
                </div>
            </form>
            
            <!-- Category Filter -->
            <div class="category-filter">
                <a href="<?php echo esc_url(home_url('/blog/')); ?>" class="category-btn <?php echo !is_category() ? 'active' : ''; ?>">
                    Tümü
                </a>
                <?php
                $categories = get_categories(array(
                    'orderby' => 'name',
                    'order' => 'ASC',
                    'hide_empty' => true
                ));
                
                foreach($categories as $category) {
                    $is_active = is_category($category->term_id) ? 'active' : '';
                    echo '<a href="' . esc_url(get_category_link($category->term_id)) . '" class="category-btn ' . $is_active . '">' . esc_html($category->name) . '</a>';
                }
                ?>
            </div>
        </div>
    </div>
</section>

<!-- Blog Posts Section -->
<section class="py-20 bg-gray-50">
    <div class="w-full max-w-screen-xl mx-auto px-6 md:px-10">
        <?php
        // Blog posts query
        $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
        $posts_per_page = 9; // 3x3 grid
        
        $args = array(
            'post_type' => 'post',
            'post_status' => 'publish',
            'posts_per_page' => $posts_per_page,
            'paged' => $paged,
            'orderby' => 'date',
            'order' => 'DESC'
        );
        
        // If searching
        if (get_search_query()) {
            $args['s'] = get_search_query();
        }
        
        // If category archive
        if (is_category()) {
            $args['cat'] = get_queried_object_id();
        }
        
        $blog_query = new WP_Query($args);
        
        if ($blog_query->have_posts()) : ?>
            <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
                <?php while ($blog_query->have_posts()) : $blog_query->the_post(); ?>
                    <article class="blog-card bg-white rounded-2xl overflow-hidden shadow-lg">
                        <!-- Featured Image -->
                        <div class="h-48 bg-gradient-to-br from-primary to-secondary relative overflow-hidden">
                            <?php if (has_post_thumbnail()) : ?>
                                <?php the_post_thumbnail('medium', array('class' => 'w-full h-full object-cover')); ?>
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
                                echo '<div class="absolute top-4 left-4">';
                                echo '<a href="' . esc_url(get_category_link($category->term_id)) . '" class="blog-tag">' . esc_html($category->name) . '</a>';
                                echo '</div>';
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
                                    <time datetime="<?php echo get_the_date('c'); ?>">
                                        <?php echo get_the_date('d.m.Y'); ?>
                                    </time>
                                </div>
                                <div class="flex items-center mr-4">
                                    <i class="fas fa-user mr-2"></i>
                                    <span><?php the_author(); ?></span>
                                </div>
                                <div class="flex items-center">
                                    <i class="fas fa-clock mr-2"></i>
                                    <span><?php echo get_reading_time(); ?> dk okuma</span>
                                </div>
                            </div>
                            
                            <!-- Excerpt -->
                            <div class="text-gray-600 mb-4 line-clamp-3">
                                <?php echo wp_trim_words(get_the_excerpt(), 20, '...'); ?>
                            </div>
                            
                            <!-- Read More Button -->
                            <a href="<?php the_permalink(); ?>" class="inline-flex items-center text-secondary font-semibold hover:text-primary transition-colors">
                                Devamını Oku
                                <i class="fas fa-arrow-right ml-2"></i>
                            </a>
                        </div>
                    </article>
                <?php endwhile; ?>
            </div>
            
            <!-- Pagination -->
            <?php if ($blog_query->max_num_pages > 1) : ?>
                <div class="pagination">
                    <?php
                    echo paginate_links(array(
                        'base' => str_replace(999999999, '%#%', esc_url(get_pagenum_link(999999999))),
                        'format' => '?paged=%#%',
                        'current' => max(1, get_query_var('paged')),
                        'total' => $blog_query->max_num_pages,
                        'prev_text' => '<i class="fas fa-chevron-left"></i> Önceki',
                        'next_text' => 'Sonraki <i class="fas fa-chevron-right"></i>',
                        'type' => 'list',
                        'end_size' => 3,
                        'mid_size' => 3
                    ));
                    ?>
                </div>
            <?php endif; ?>
            
        <?php else : ?>
            <!-- No Posts Found -->
            <div class="text-center py-20">
                <div class="bg-white rounded-2xl p-12 shadow-lg max-w-2xl mx-auto">
                    <i class="fas fa-search text-6xl text-gray-300 mb-6"></i>
                    <h2 class="font-helvetica text-2xl font-bold text-primary mb-4">
                        <?php echo get_search_query() ? 'Arama sonucu bulunamadı' : 'Henüz blog yazısı yok'; ?>
                    </h2>
                    <p class="text-gray-600 mb-6">
                        <?php echo get_search_query() ? 'Aradığınız kriterlere uygun blog yazısı bulunamadı. Farklı anahtar kelimeler deneyebilirsiniz.' : 'Yakında burada harika içerikler olacak!'; ?>
                    </p>
                    <a href="<?php echo esc_url(home_url('/blog/')); ?>" class="bg-primary hover:bg-secondary text-white font-semibold px-8 py-3 rounded-lg transition-colors">
                        Tüm Yazıları Görüntüle
                    </a>
                </div>
            </div>
        <?php endif; ?>
        
        <?php wp_reset_postdata(); ?>
    </div>
</section>

<!-- Newsletter Section -->
<section class="py-20 bg-white">
    <div class="w-full max-w-screen-xl mx-auto px-6 md:px-10">
        <div class="bg-gradient-to-br from-primary to-secondary rounded-2xl p-12 text-center text-white">
            <h2 class="font-helvetica text-3xl md:text-4xl font-bold mb-4">
                Güncel Kalın
            </h2>
            <p class="text-xl mb-8 opacity-90">
                En son dijital pazarlama trendlerini ve ipuçlarını e-posta ile alın
            </p>
            <form class="flex flex-col sm:flex-row gap-4 max-w-md mx-auto">
                <input 
                    type="email" 
                    placeholder="E-posta adresiniz" 
                    class="flex-1 px-6 py-3 rounded-lg text-gray-900 focus:outline-none focus:ring-2 focus:ring-white"
                    required
                >
                <button type="submit" class="bg-white text-primary font-semibold px-8 py-3 rounded-lg hover:bg-gray-100 transition-colors">
                    Abone Ol
                </button>
            </form>
        </div>
    </div>
</section>

<script>
// Reading time calculation function
function getReadingTime() {
    const content = document.querySelector('.entry-content');
    if (content) {
        const text = content.textContent || content.innerText;
        const wordCount = text.trim().split(/\s+/).length;
        const readingTime = Math.ceil(wordCount / 200); // Average reading speed: 200 words per minute
        return readingTime;
    }
    return 3; // Default reading time
}

// Initialize reading time for all posts
document.addEventListener('DOMContentLoaded', function() {
    const readingTimeElements = document.querySelectorAll('[data-reading-time]');
    readingTimeElements.forEach(element => {
        const postId = element.dataset.postId;
        const content = document.querySelector(`#post-${postId} .entry-content`);
        if (content) {
            const readingTime = getReadingTime();
            element.textContent = `${readingTime} dk okuma`;
        }
    });
});
</script>

<?php
// Helper function to get reading time
function get_reading_time() {
    $content = get_the_content();
    $word_count = str_word_count(strip_tags($content));
    $reading_time = ceil($word_count / 200); // 200 words per minute
    return $reading_time;
}

get_footer(); ?>