(function(){
  'use strict';

  const prefersReducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;

  // World canvas background with glowing links from Türkiye
  const worldCanvas = document.getElementById('worldCanvas');
  if (worldCanvas) {
    const ctx = worldCanvas.getContext('2d');
    const dpi = window.devicePixelRatio || 1;

    function resizeCanvas() {
      const { width, height } = worldCanvas.getBoundingClientRect();
      worldCanvas.width = Math.floor(width * dpi);
      worldCanvas.height = Math.floor(height * dpi);
      ctx.setTransform(dpi, 0, 0, dpi, 0, 0);
    }
    window.addEventListener('resize', resizeCanvas);
    resizeCanvas();

    const centers = [
      { name: 'Türkiye', x: 0.58, y: 0.42 },
      { name: 'Almanya', x: 0.52, y: 0.37 },
      { name: 'ABD', x: 0.24, y: 0.38 },
      { name: 'Brezilya', x: 0.32, y: 0.62 },
      { name: 'B.A.E', x: 0.67, y: 0.50 },
      { name: 'Japonya', x: 0.84, y: 0.42 },
      { name: 'G.Kore', x: 0.80, y: 0.40 },
      { name: 'Birleşik Krallık', x: 0.47, y: 0.36 },
    ];

    function draw(timestamp) {
      const { width, height } = worldCanvas;
      ctx.clearRect(0, 0, width, height);

      // faint world grid
      ctx.save();
      ctx.globalAlpha = 0.06;
      ctx.strokeStyle = '#6aa2ff';
      const stepX = Math.max(80, Math.floor(width/12));
      const stepY = Math.max(60, Math.floor(height/10));
      for (let x = 0; x < width; x += stepX) { ctx.beginPath(); ctx.moveTo(x, 0); ctx.lineTo(x, height); ctx.stroke(); }
      for (let y = 0; y < height; y += stepY) { ctx.beginPath(); ctx.moveTo(0, y); ctx.lineTo(width, y); ctx.stroke(); }
      ctx.restore();

      // nodes and linking arcs from Turkey to others
      const tr = centers[0];
      const tx = tr.x * width; const ty = tr.y * height;
      ctx.save();
      ctx.fillStyle = '#6aa2ff';
      ctx.shadowBlur = 16; ctx.shadowColor = '#3B82F6';
      ctx.beginPath(); ctx.arc(tx, ty, 3, 0, Math.PI*2); ctx.fill();
      ctx.restore();

      centers.slice(1).forEach((c, i) => {
        const cx = c.x * width; const cy = c.y * height;
        const p = (Math.sin((timestamp/1000) + i) + 1) / 2; // 0..1
        const midX = tx + (cx - tx) * p;
        const midY = ty + (cy - ty) * p - 20; // small arc offset

        // gradient stroke
        const grad = ctx.createLinearGradient(tx, ty, cx, cy);
        grad.addColorStop(0, 'rgba(106,162,255,0.6)');
        grad.addColorStop(1, 'rgba(59,130,246,0.1)');
        ctx.strokeStyle = grad;
        ctx.lineWidth = 2;
        ctx.beginPath();
        ctx.moveTo(tx, ty);
        ctx.quadraticCurveTo(midX, midY, cx, cy);
        ctx.stroke();

        // traveling particle
        const t = (timestamp/2000 + i*0.2) % 1;
        const qx = (1 - t)**2 * tx + 2*(1 - t)*t*midX + t**2 * cx;
        const qy = (1 - t)**2 * ty + 2*(1 - t)*t*midY + t**2 * cy;
        ctx.save();
        ctx.fillStyle = '#a2c5ff';
        ctx.shadowBlur = 10; ctx.shadowColor = '#a2c5ff';
        ctx.beginPath(); ctx.arc(qx, qy, 2, 0, Math.PI*2); ctx.fill();
        ctx.restore();

        // end node
        ctx.save();
        ctx.globalAlpha = 0.6; ctx.fillStyle = '#3B82F6';
        ctx.beginPath(); ctx.arc(cx, cy, 2, 0, Math.PI*2); ctx.fill();
        ctx.restore();
      });

      if (!prefersReducedMotion) requestAnimationFrame(draw);
    }
    if (!prefersReducedMotion) requestAnimationFrame(draw);
  }

  // Intersection-based reveal animations
  const revealEls = document.querySelectorAll('.reveal, .timeline-item, .icon-card, .service-card, .model-step, .blog-list li');
  const io = new IntersectionObserver((entries) => {
    entries.forEach(entry => {
      if (entry.isIntersecting) {
        entry.target.classList.add('show');
        io.unobserve(entry.target);
      }
    });
  }, { threshold: 0.15 });
  revealEls.forEach(el => io.observe(el));

  // Services sticky flow (activate sequentially)
  const stickySteps = document.querySelectorAll('.sticky-step');
  const so = new IntersectionObserver((entries) => {
    entries.forEach(entry => {
      if (entry.isIntersecting) entry.target.classList.add('show');
    });
  }, { threshold: 0.6 });
  stickySteps.forEach(s => so.observe(s));

  // Stats counter-up
  const statNumbers = document.querySelectorAll('.stat-number');
  const co = new IntersectionObserver((entries) => {
    entries.forEach(entry => {
      if (!entry.isIntersecting) return;
      const el = entry.target; const target = parseInt(el.getAttribute('data-target') || '0', 10);
      const durationMs = 1200;
      const start = performance.now();
      function tick(now) {
        const p = Math.min(1, (now - start) / durationMs);
        const eased = 1 - Math.pow(1 - p, 3);
        const value = Math.floor(eased * target);
        el.textContent = value + (target >= 100 ? '' : '+');
        if (p < 1) requestAnimationFrame(tick);
      }
      requestAnimationFrame(tick);
      co.unobserve(el);
    });
  }, { threshold: 0.5 });
  statNumbers.forEach(n => co.observe(n));

  // Testimonials slider
  const slider = document.querySelector('.testimonial-slider');
  if (slider) {
    const slides = Array.from(slider.querySelectorAll('.slide'));
    const prevBtn = slider.querySelector('.prev');
    const nextBtn = slider.querySelector('.next');
    let index = 0;

    function show(i) {
      slides.forEach((s, k) => s.classList.toggle('active', k === i));
    }
    function next() { index = (index + 1) % slides.length; show(index); }
    function prev() { index = (index - 1 + slides.length) % slides.length; show(index); }

    nextBtn.addEventListener('click', next);
    prevBtn.addEventListener('click', prev);
    if (!prefersReducedMotion) setInterval(next, 5000);

    // star sparkle on hover
    slides.forEach(s => {
      s.addEventListener('mouseenter', () => s.querySelector('.stars').classList.add('spark'));
      s.addEventListener('mouseleave', () => s.querySelector('.stars').classList.remove('spark'));
    });
  }

  // Exit intent popup
  const popup = document.getElementById('exitPopup');
  const popupClose = document.getElementById('popupClose');
  let popupShown = false;
  function openPopup(){ if (!popupShown) { popup.classList.add('show'); popup.setAttribute('aria-hidden','false'); popupShown = true; } }
  function closePopup(){ popup.classList.remove('show'); popup.setAttribute('aria-hidden','true'); }
  if (popup && !prefersReducedMotion) {
    document.addEventListener('mouseout', (e) => {
      if (e.clientY <= 0) openPopup();
    });
  }
  if (popupClose) popupClose.addEventListener('click', closePopup);

})();

