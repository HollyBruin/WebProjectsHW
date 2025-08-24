# Exportiva İhracat Danışmanlığı - Modern Anasayfa

Bu proje, Exportiva İhracat Danışmanlığı şirketi için tasarlanmış modern, etkileşimli ve dinamik bir anasayfadır.

## 🚀 Özellikler

### ✨ Ana Özellikler
- **Modern Tasarım**: Exportiva'nın kurumsal renklerine (#1E3A8A, #3B82F6, #f0f0f0) sadık kalınarak tasarlandı
- **Responsive Tasarım**: Tüm cihazlarda mükemmel görünüm
- **Poppins Font**: Modern ve okunabilir tipografi
- **Smooth Animasyonlar**: CSS ve JavaScript ile gelişmiş animasyonlar
- **Parallax Efektleri**: Scroll ile etkileşimli görsel efektler

### 🎯 Bölümler

#### 1. Hero Alanı
- Tam ekran giriş bölümü
- Dünya haritası arka planı
- Türkiye'den çıkan ticaret okları
- Animasyonlu logo
- CTA butonları (Ücretsiz Analiz, Demo Toplantısı)

#### 2. Hizmetlerimiz
- 6 ana hizmet kartı
- On-scroll animasyonlar
- Hover efektleri
- İnteraktif gemi animasyonu

#### 3. Başarı Hikâyeleri
- Yatay kaydırmalı kartlar
- Gerçekçi başarı örnekleri
- Hover animasyonları

#### 4. İhracat Verisi
- İnteraktif grafik barları
- Scroll ile yükselen animasyonlar
- Hover'da rakam gösterimi

#### 5. CTA Funnel
- Lead magnet alanı
- E-posta formu
- Ücretsiz rehber indirme

#### 6. Takım & AI Asistan
- Takım üyeleri kartları
- Sosyal medya overlay'leri
- AI chatbot butonu

#### 7. Footer
- Dalga animasyonlu tasarım
- Sosyal medya linkleri
- Responsive grid yapısı

### 🎨 Tasarım Özellikleri
- **Renk Paleti**: Exportiva mavileri (#1E3A8A, #3B82F6) ve gri tonları (#f0f0f0)
- **Tipografi**: Poppins font ailesi (300-800 weight)
- **Gölgeler**: Modern ve yumuşak gölge efektleri
- **Border Radius**: 20px yuvarlatılmış köşeler
- **Gradients**: Mavi tonlarında gradient geçişler

### 📱 Responsive Özellikler
- Mobile-first yaklaşım
- Breakpoint'ler: 480px, 768px, 1200px
- Touch-friendly etkileşimler
- Swipe gesture desteği
- Mobile navigation menu

### 🎭 Animasyonlar
- **CSS Animations**: Keyframe tabanlı animasyonlar
- **JavaScript Animations**: Scroll-triggered animasyonlar
- **Parallax Effects**: Derinlik hissi veren efektler
- **Hover Effects**: İnteraktif hover animasyonları
- **Loading Screen**: Sayfa yükleme animasyonu

### 🔧 Teknik Özellikler
- **Vanilla JavaScript**: Framework bağımsız
- **CSS Grid & Flexbox**: Modern layout sistemleri
- **Intersection Observer**: Performanslı scroll animasyonları
- **Throttling**: Optimize edilmiş scroll event'leri
- **Touch Events**: Mobile gesture desteği

## 🛠️ Kurulum

### Gereksinimler
- Modern web tarayıcısı
- Local web server (önerilen)

### Kurulum Adımları
1. Projeyi klonlayın veya indirin
2. `exportiva-homepage` klasörüne gidin
3. `index.html` dosyasını bir web server ile açın

### Local Server Kurulumu
```bash
# Python 3 ile
python -m http.server 8000

# Node.js ile
npx serve .

# PHP ile
php -S localhost:8000
```

## 📁 Proje Yapısı

```
exportiva-homepage/
├── index.html          # Ana HTML dosyası
├── css/
│   └── style.css      # Ana CSS dosyası
├── js/
│   └── main.js        # Ana JavaScript dosyası
├── img/               # Görsel dosyaları
│   ├── exportiva-logo.png
│   ├── exportiva-logo-white.png
│   ├── team-1.jpg
│   ├── team-2.jpg
│   └── team-3.jpg
└── README.md          # Bu dosya
```

## 🎯 Kullanım

### Navigasyon
- **Ana Sayfa**: Hero bölümüne dönüş
- **Hizmetler**: Hizmet kartları bölümü
- **Başarılar**: Başarı hikâyeleri
- **Ekibimiz**: Takım üyeleri
- **İletişim**: Footer bölümü

### Etkileşimler
- **Scroll**: Sayfa boyunca smooth scroll
- **Hover**: Kartlarda hover efektleri
- **Click**: CTA butonları ve kartlar
- **Touch**: Mobile swipe gesture'ları

### CTA Butonları
- **Ücretsiz İhracat Analizi**: Modal açılır
- **Demo Toplantısı**: Demo modal'ı
- **Rehberi İndir**: E-posta formu

## 🔧 Özelleştirme

### Renk Değişiklikleri
CSS dosyasında `:root` değişkenlerini düzenleyin:
```css
:root {
    --primary-blue: #1E3A8A;    /* Ana mavi */
    --secondary-blue: #3B82F6;  /* Açık mavi */
    --light-gray: #f0f0f0;      /* Açık gri */
}
```

### İçerik Güncellemeleri
- HTML dosyasında metinleri değiştirin
- Görselleri `img/` klasöründe güncelleyin
- Takım bilgilerini güncelleyin

### Animasyon Hızları
CSS'de animation-duration değerlerini ayarlayın:
```css
.animation {
    animation-duration: 1s; /* Hızı değiştirin */
}
```

## 📱 Browser Desteği

- ✅ Chrome 80+
- ✅ Firefox 75+
- ✅ Safari 13+
- ✅ Edge 80+
- ✅ Mobile browsers

## 🚀 Performans

- **Lazy Loading**: Görseller için lazy loading
- **Throttling**: Scroll event'leri optimize edildi
- **CSS Animations**: GPU-accelerated animasyonlar
- **Minified Assets**: Production için optimize edildi

## 🔒 Güvenlik

- XSS koruması
- Input validation
- Secure event handling
- No external dependencies

## 📞 Destek

Herhangi bir sorun veya özelleştirme talebi için:
- GitHub Issues kullanın
- Proje dokümantasyonunu inceleyin
- README dosyasını kontrol edin

## 📄 Lisans

Bu proje Exportiva İhracat Danışmanlığı için özel olarak tasarlanmıştır.

## 🙏 Teşekkürler

- Poppins font ailesi için Google Fonts
- Font Awesome ikonları
- Modern web standartları
- CSS Grid ve Flexbox

---

**Exportiva - İhracatta Dijital Gücünüz** 🚢