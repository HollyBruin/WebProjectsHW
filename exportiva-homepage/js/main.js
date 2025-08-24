// Exportiva Homepage - Main JavaScript File
document.addEventListener('DOMContentLoaded', function() {
    
    // Initialize all components
    initNavigation();
    initScrollAnimations();
    initChartAnimations();
    initShipAnimation();
    initParallaxEffects();
    initSmoothScrolling();
    initLoadingScreen();
    initInteractiveElements();
    
    // Navigation functionality
    function initNavigation() {
        const navToggle = document.querySelector('.nav-toggle');
        const navMenu = document.querySelector('.nav-menu');
        const navbar = document.querySelector('.navbar');
        
        // Mobile menu toggle
        if (navToggle) {
            navToggle.addEventListener('click', function() {
                navMenu.classList.toggle('active');
                navToggle.classList.toggle('active');
            });
        }
        
        // Navbar background on scroll
        window.addEventListener('scroll', function() {
            if (window.scrollY > 100) {
                navbar.style.background = 'rgba(30, 58, 138, 0.98)';
            } else {
                navbar.style.background = 'rgba(30, 58, 138, 0.95)';
            }
        });
        
        // Close mobile menu when clicking on links
        const navLinks = document.querySelectorAll('.nav-link');
        navLinks.forEach(link => {
            link.addEventListener('click', function() {
                navMenu.classList.remove('active');
                navToggle.classList.remove('active');
            });
        });
    }
    
    // Scroll animations
    function initScrollAnimations() {
        const observerOptions = {
            threshold: 0.1,
            rootMargin: '0px 0px -50px 0px'
        };
        
        const observer = new IntersectionObserver(function(entries) {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('aos-animate');
                }
            });
        }, observerOptions);
        
        // Observe all elements with data-aos attribute
        const animatedElements = document.querySelectorAll('[data-aos]');
        animatedElements.forEach(el => observer.observe(el));
        
        // Parallax scroll effect for hero section
        const hero = document.querySelector('.hero');
        const worldMap = document.querySelector('.world-map');
        
        if (hero && worldMap) {
            window.addEventListener('scroll', function() {
                const scrolled = window.pageYOffset;
                const rate = scrolled * -0.5;
                worldMap.style.transform = `translateY(${rate}px)`;
            });
        }
    }
    
    // Chart animations
    function initChartAnimations() {
        const chartBars = document.querySelectorAll('.chart-bar');
        
        const chartObserver = new IntersectionObserver(function(entries) {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    const bar = entry.target;
                    const value = bar.getAttribute('data-value');
                    const barFill = bar.querySelector('.bar-fill');
                    
                    // Animate bar height
                    setTimeout(() => {
                        barFill.style.height = `${value * 3}px`;
                    }, 200);
                    
                    // Show value on hover
                    bar.addEventListener('mouseenter', function() {
                        const barValue = bar.querySelector('.bar-value');
                        if (barValue) {
                            barValue.style.opacity = '1';
                        }
                    });
                    
                    bar.addEventListener('mouseleave', function() {
                        const barValue = bar.querySelector('.bar-value');
                        if (barValue) {
                            barValue.style.opacity = '0';
                        }
                    });
                }
            });
        }, { threshold: 0.5 });
        
        chartBars.forEach(bar => chartObserver.observe(bar));
    }
    
    // Interactive ship animation
    function initShipAnimation() {
        const ship = document.getElementById('interactive-ship');
        const shipContainer = document.querySelector('.ship-container');
        
        if (ship && shipContainer) {
            let shipPosition = { x: 0, y: 0 };
            let isAnimating = false;
            
            // Ship movement on scroll
            window.addEventListener('scroll', function() {
                if (!isAnimating) {
                    const scrolled = window.pageYOffset;
                    const servicesSection = document.getElementById('services');
                    const servicesTop = servicesSection.offsetTop;
                    const servicesHeight = servicesSection.offsetHeight;
                    
                    if (scrolled >= servicesTop && scrolled <= servicesTop + servicesHeight) {
                        const progress = (scrolled - servicesTop) / servicesHeight;
                        shipPosition.x = progress * 80; // 80% of container width
                        shipPosition.y = Math.sin(progress * Math.PI * 4) * 20; // Wave effect
                        
                        ship.style.transform = `translate(${shipPosition.x}%, ${shipPosition.y}px) rotate(${progress * 10}deg)`;
                    }
                }
            });
            
            // Ship click interaction
            ship.addEventListener('click', function() {
                if (!isAnimating) {
                    isAnimating = true;
                    ship.style.animation = 'ship-bounce 0.6s ease';
                    
                    setTimeout(() => {
                        ship.style.animation = '';
                        isAnimating = false;
                    }, 600);
                }
            });
        }
    }
    
    // Parallax effects
    function initParallaxEffects() {
        const parallaxElements = document.querySelectorAll('.service-card, .story-card, .team-member');
        
        window.addEventListener('scroll', function() {
            const scrolled = window.pageYOffset;
            
            parallaxElements.forEach((element, index) => {
                const rate = scrolled * (0.1 + index * 0.02);
                element.style.transform = `translateY(${rate}px)`;
            });
        });
    }
    
    // Smooth scrolling for navigation links
    function initSmoothScrolling() {
        const links = document.querySelectorAll('a[href^="#"]');
        
        links.forEach(link => {
            link.addEventListener('click', function(e) {
                e.preventDefault();
                const targetId = this.getAttribute('href');
                const targetSection = document.querySelector(targetId);
                
                if (targetSection) {
                    const offsetTop = targetSection.offsetTop - 80; // Account for fixed navbar
                    
                    window.scrollTo({
                        top: offsetTop,
                        behavior: 'smooth'
                    });
                }
            });
        });
    }
    
    // Loading screen
    function initLoadingScreen() {
        // Create loading screen
        const loadingScreen = document.createElement('div');
        loadingScreen.className = 'loading';
        loadingScreen.innerHTML = '<div class="loading-spinner"></div>';
        document.body.appendChild(loadingScreen);
        
        // Hide loading screen after page loads
        window.addEventListener('load', function() {
            setTimeout(() => {
                loadingScreen.classList.add('hidden');
                setTimeout(() => {
                    loadingScreen.remove();
                }, 500);
            }, 1000);
        });
    }
    
    // Interactive elements
    function initInteractiveElements() {
        // CTA button interactions
        const ctaButtons = document.querySelectorAll('.cta-primary, .cta-secondary');
        ctaButtons.forEach(button => {
            button.addEventListener('click', function(e) {
                e.preventDefault();
                
                // Add click animation
                this.style.transform = 'scale(0.95)';
                setTimeout(() => {
                    this.style.transform = '';
                }, 150);
                
                // Handle different CTA actions
                if (this.textContent.includes('Analizi')) {
                    showModal('analiz-modal', 'Ücretsiz İhracat Analizi');
                } else if (this.textContent.includes('Demo')) {
                    showModal('demo-modal', 'Demo Toplantısı Planla');
                }
            });
        });
        
        // CTA form submission
        const ctaForm = document.querySelector('.cta-form');
        if (ctaForm) {
            ctaForm.addEventListener('submit', function(e) {
                e.preventDefault();
                const email = this.querySelector('.cta-input').value;
                
                if (validateEmail(email)) {
                    showSuccessMessage('Rehber başarıyla gönderildi! E-posta adresinizi kontrol edin.');
                    this.querySelector('.cta-input').value = '';
                } else {
                    showErrorMessage('Lütfen geçerli bir e-posta adresi girin.');
                }
            });
        }
        
        // AI Chatbot interaction
        const chatbot = document.getElementById('ai-chatbot');
        if (chatbot) {
            chatbot.addEventListener('click', function() {
                showModal('chatbot-modal', 'Exportiva AI Asistan');
            });
        }
        
        // Service card interactions
        const serviceCards = document.querySelectorAll('.service-card');
        serviceCards.forEach(card => {
            card.addEventListener('mouseenter', function() {
                this.style.transform = 'translateY(-15px) scale(1.02)';
            });
            
            card.addEventListener('mouseleave', function() {
                this.style.transform = 'translateY(0) scale(1)';
            });
        });
        
        // Success story cards
        const storyCards = document.querySelectorAll('.story-card');
        storyCards.forEach(card => {
            card.addEventListener('click', function() {
                const title = this.querySelector('h3').textContent;
                const highlight = this.querySelector('.story-highlight').textContent;
                showModal('story-modal', title, highlight);
            });
        });
    }
    
    // Utility functions
    function validateEmail(email) {
        const re = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        return re.test(email);
    }
    
    function showModal(modalId, title, content = '') {
        // Create modal if it doesn't exist
        let modal = document.getElementById(modalId);
        if (!modal) {
            modal = createModal(modalId, title, content);
        }
        
        modal.style.display = 'flex';
        document.body.style.overflow = 'hidden';
    }
    
    function createModal(id, title, content) {
        const modal = document.createElement('div');
        modal.id = id;
        modal.className = 'modal';
        modal.innerHTML = `
            <div class="modal-content">
                <div class="modal-header">
                    <h3>${title}</h3>
                    <span class="modal-close">&times;</span>
                </div>
                <div class="modal-body">
                    ${content || 'Bu özellik yakında aktif olacak!'}
                </div>
            </div>
        `;
        
        document.body.appendChild(modal);
        
        // Close modal functionality
        const closeBtn = modal.querySelector('.modal-close');
        closeBtn.addEventListener('click', () => closeModal(modal));
        
        modal.addEventListener('click', (e) => {
            if (e.target === modal) {
                closeModal(modal);
            }
        });
        
        return modal;
    }
    
    function closeModal(modal) {
        modal.style.display = 'none';
        document.body.style.overflow = 'auto';
    }
    
    function showSuccessMessage(message) {
        showNotification(message, 'success');
    }
    
    function showErrorMessage(message) {
        showNotification(message, 'error');
    }
    
    function showNotification(message, type) {
        const notification = document.createElement('div');
        notification.className = `notification notification-${type}`;
        notification.textContent = message;
        
        document.body.appendChild(notification);
        
        // Show notification
        setTimeout(() => {
            notification.classList.add('show');
        }, 100);
        
        // Hide and remove notification
        setTimeout(() => {
            notification.classList.remove('show');
            setTimeout(() => {
                notification.remove();
            }, 300);
        }, 3000);
    }
    
    // Add CSS for modals and notifications
    addModalStyles();
    
    function addModalStyles() {
        const style = document.createElement('style');
        style.textContent = `
            .modal {
                display: none;
                position: fixed;
                z-index: 2000;
                left: 0;
                top: 0;
                width: 100%;
                height: 100%;
                background-color: rgba(0, 0, 0, 0.5);
                align-items: center;
                justify-content: center;
            }
            
            .modal-content {
                background-color: white;
                margin: auto;
                padding: 0;
                border-radius: 20px;
                width: 90%;
                max-width: 500px;
                box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
                animation: modalSlideIn 0.3s ease;
            }
            
            @keyframes modalSlideIn {
                from { transform: translateY(-50px); opacity: 0; }
                to { transform: translateY(0); opacity: 1; }
            }
            
            .modal-header {
                padding: 1.5rem;
                border-bottom: 1px solid #e5e7eb;
                display: flex;
                justify-content: space-between;
                align-items: center;
            }
            
            .modal-header h3 {
                margin: 0;
                color: var(--primary-blue);
            }
            
            .modal-close {
                font-size: 1.5rem;
                cursor: pointer;
                color: #6b7280;
                transition: color 0.3s ease;
            }
            
            .modal-close:hover {
                color: var(--primary-blue);
            }
            
            .modal-body {
                padding: 1.5rem;
                color: var(--text-primary);
            }
            
            .notification {
                position: fixed;
                top: 20px;
                right: 20px;
                padding: 1rem 1.5rem;
                border-radius: 10px;
                color: white;
                font-weight: 500;
                z-index: 3000;
                transform: translateX(400px);
                transition: transform 0.3s ease;
            }
            
            .notification.show {
                transform: translateX(0);
            }
            
            .notification-success {
                background: #10b981;
            }
            
            .notification-error {
                background: #ef4444;
            }
            
            @keyframes ship-bounce {
                0%, 100% { transform: translateY(0) scale(1); }
                50% { transform: translateY(-20px) scale(1.1); }
            }
        `;
        
        document.head.appendChild(style);
    }
    
    // Performance optimization: Throttle scroll events
    function throttle(func, limit) {
        let inThrottle;
        return function() {
            const args = arguments;
            const context = this;
            if (!inThrottle) {
                func.apply(context, args);
                inThrottle = true;
                setTimeout(() => inThrottle = false, limit);
            }
        }
    }
    
    // Apply throttling to scroll events
    const throttledScrollHandler = throttle(function() {
        // Scroll-based animations are already handled by Intersection Observer
        // This is just for performance optimization
    }, 16); // ~60fps
    
    window.addEventListener('scroll', throttledScrollHandler);
    
    // Initialize world map animations
    initWorldMapAnimations();
    
    function initWorldMapAnimations() {
        const mapPoints = document.querySelectorAll('.map-point');
        const tradeLines = document.querySelectorAll('.trade-line');
        
        // Stagger animation for map points
        mapPoints.forEach((point, index) => {
            point.style.animationDelay = `${index * 0.5}s`;
        });
        
        // Stagger animation for trade lines
        tradeLines.forEach((line, index) => {
            line.style.animationDelay = `${index * 0.3}s`;
        });
    }
    
    // Add keyboard navigation support
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            const modals = document.querySelectorAll('.modal');
            modals.forEach(modal => {
                if (modal.style.display === 'flex') {
                    closeModal(modal);
                }
            });
        }
    });
    
    // Add touch support for mobile devices
    let touchStartY = 0;
    let touchEndY = 0;
    
    document.addEventListener('touchstart', function(e) {
        touchStartY = e.changedTouches[0].screenY;
    });
    
    document.addEventListener('touchend', function(e) {
        touchEndY = e.changedTouches[0].screenY;
        handleSwipe();
    });
    
    function handleSwipe() {
        const swipeThreshold = 50;
        const diff = touchStartY - touchEndY;
        
        if (Math.abs(diff) > swipeThreshold) {
            if (diff > 0) {
                // Swipe up - could trigger next section
                console.log('Swipe up detected');
            } else {
                // Swipe down - could trigger previous section
                console.log('Swipe down detected');
            }
        }
    }
    
    // Console welcome message
    console.log(`
    🚢 Exportiva Homepage Loaded Successfully!
    
    Features:
    ✅ Interactive Navigation
    ✅ Smooth Scroll Animations
    ✅ Parallax Effects
    ✅ Interactive Charts
    ✅ Ship Animation
    ✅ Responsive Design
    ✅ Touch Support
    
    Made with ❤️ for Exportiva
    `);
});