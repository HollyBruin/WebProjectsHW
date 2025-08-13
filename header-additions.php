<!-- WordPress header.php dosyasına eklenecek kodlar -->

<!-- Tailwind CSS Konfigürasyonu -->
<script>
tailwind.config = {
    theme: {
        extend: {
            fontFamily: {
                'helvetica': ['Helvetica', 'Arial', 'sans-serif'],
                'roboto': ['Roboto', 'sans-serif'],
            },
            colors: {
                'primary': '#3A3088',
                'secondary': '#646FD1',
                'tertiary': '#764BA2',
                'quaternary': '#FFFFFF',
            }
        }
    }
}
</script>

<!-- AJAX URL için WordPress localize script -->
<script>
var ajaxurl = "<?php echo admin_url('admin-ajax.php'); ?>";
</script>

<!-- Blog sayfası için özel meta etiketleri -->
<?php if (is_page_template('blog-page.php') || is_home() || is_category() || is_search()) : ?>
    <meta name="description" content="NETSEO blog - Dijital pazarlama, SEO, sosyal medya ve web tasarım konularında güncel bilgiler ve uzman görüşleri">
    <meta name="keywords" content="dijital pazarlama, SEO, sosyal medya, web tasarım, reklam yönetimi">
    <meta property="og:title" content="NETSEO Blog - Dijital Pazarlama Rehberi">
    <meta property="og:description" content="Dijital pazarlama dünyasından en güncel bilgiler ve uzman görüşleri">
    <meta property="og:type" content="website">
    <meta property="og:url" content="<?php echo esc_url(get_permalink()); ?>">
    <meta property="og:image" content="<?php echo get_template_directory_uri(); ?>/assets/images/blog-og-image.jpg">
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="NETSEO Blog - Dijital Pazarlama Rehberi">
    <meta name="twitter:description" content="Dijital pazarlama dünyasından en güncel bilgiler ve uzman görüşleri">
    <meta name="twitter:image" content="<?php echo get_template_directory_uri(); ?>/assets/images/blog-og-image.jpg">
<?php endif; ?>

<!-- Canonical URL -->
<?php if (is_home() || is_category() || is_search()) : ?>
    <link rel="canonical" href="<?php echo esc_url(get_permalink()); ?>">
<?php endif; ?>

<!-- RSS Feed -->
<link rel="alternate" type="application/rss+xml" title="<?php bloginfo('name'); ?> RSS Feed" href="<?php bloginfo('rss2_url'); ?>">

<!-- Preload critical fonts -->
<link rel="preload" href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&display=swap" as="style" onload="this.onload=null;this.rel='stylesheet'">
<noscript><link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&display=swap"></noscript>

<!-- Preload Font Awesome -->
<link rel="preload" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" as="style" onload="this.onload=null;this.rel='stylesheet'">
<noscript><link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css"></noscript>

<!-- Structured Data for Blog -->
<?php if (is_home() || is_category()) : ?>
<script type="application/ld+json">
{
    "@context": "https://schema.org",
    "@type": "Blog",
    "name": "<?php bloginfo('name'); ?> Blog",
    "description": "Dijital pazarlama dünyasından en güncel bilgiler ve uzman görüşleri",
    "url": "<?php echo esc_url(home_url('/blog/')); ?>",
    "publisher": {
        "@type": "Organization",
        "name": "NETSEO",
        "logo": {
            "@type": "ImageObject",
            "url": "<?php echo get_template_directory_uri(); ?>/assets/images/logo.png"
        }
    },
    "mainEntityOfPage": {
        "@type": "WebPage",
        "@id": "<?php echo esc_url(home_url('/blog/')); ?>"
    }
}
</script>
<?php endif; ?>

<!-- Blog sayfası için özel CSS -->
<?php if (is_page_template('blog-page.php') || is_home() || is_category() || is_search()) : ?>
<style>
    /* Critical CSS for blog page */
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
<?php endif; ?>