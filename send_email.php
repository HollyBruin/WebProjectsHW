<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Content-Type');

// Hata raporlamayı aç (geliştirme için)
error_reporting(E_ALL);
ini_set('display_errors', 1);

// POST verilerini kontrol et
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['success' => false, 'message' => 'Sadece POST istekleri kabul edilir']);
    exit;
}

// Form verilerini al ve temizle
$fullName = isset($_POST['fullName']) ? trim($_POST['fullName']) : '';
$email = isset($_POST['email']) ? trim($_POST['email']) : '';
$phone = isset($_POST['phone']) ? trim($_POST['phone']) : '';
$company = isset($_POST['company']) ? trim($_POST['company']) : '';
$website = isset($_POST['website']) ? trim($_POST['website']) : '';
$services = isset($_POST['services']) ? $_POST['services'] : [];
$notes = isset($_POST['notes']) ? trim($_POST['notes']) : '';

// Zorunlu alanları kontrol et
$errors = [];
if (empty($fullName)) {
    $errors[] = 'Ad Soyad gereklidir';
}
if (empty($email)) {
    $errors[] = 'E-posta adresi gereklidir';
} elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $errors[] = 'Geçerli bir e-posta adresi giriniz';
}
if (empty($phone)) {
    $errors[] = 'Telefon numarası gereklidir';
}
if (empty($company)) {
    $errors[] = 'Firma adı gereklidir';
}

if (!empty($errors)) {
    echo json_encode(['success' => false, 'message' => implode(', ', $errors)]);
    exit;
}

// E-posta ayarları
$to = 'info@netseo.com.tr';
$subject = 'Netseo - Yeni Dijital Analiz Talebi';

// Servisleri formatla
$servicesText = '';
if (!empty($services) && is_array($services)) {
    $servicesText = implode(', ', $services);
} else {
    $servicesText = 'Belirtilmemiş';
}

// E-posta içeriği
$message = "
<html>
<head>
    <meta charset='UTF-8'>
    <title>Netseo - Yeni Dijital Analiz Talebi</title>
    <style>
        body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; }
        .container { max-width: 600px; margin: 0 auto; padding: 20px; }
        .header { background: linear-gradient(135deg, #8b5cf6, #3b82f6); color: white; padding: 20px; border-radius: 10px 10px 0 0; text-align: center; }
        .content { background: #f8fafc; padding: 30px; border-radius: 0 0 10px 10px; }
        .field { margin-bottom: 15px; }
        .label { font-weight: bold; color: #374151; }
        .value { color: #6b7280; margin-top: 5px; }
        .services { background: #e0e7ff; padding: 15px; border-radius: 8px; margin: 10px 0; }
        .footer { text-align: center; margin-top: 30px; color: #6b7280; font-size: 14px; }
    </style>
</head>
<body>
    <div class='container'>
        <div class='header'>
            <h2>🚀 Yeni Dijital Analiz Talebi</h2>
            <p>Netseo Dijital Pazarlama Ajansı</p>
        </div>
        <div class='content'>
            <div class='field'>
                <div class='label'>👤 Ad Soyad:</div>
                <div class='value'>" . htmlspecialchars($fullName) . "</div>
            </div>
            
            <div class='field'>
                <div class='label'>📧 E-posta:</div>
                <div class='value'>" . htmlspecialchars($email) . "</div>
            </div>
            
            <div class='field'>
                <div class='label'>📞 Telefon:</div>
                <div class='value'>" . htmlspecialchars($phone) . "</div>
            </div>
            
            <div class='field'>
                <div class='label'>🏢 Firma:</div>
                <div class='value'>" . htmlspecialchars($company) . "</div>
            </div>
            
            <div class='field'>
                <div class='label'>🌐 Website:</div>
                <div class='value'>" . (empty($website) ? 'Belirtilmemiş' : htmlspecialchars($website)) . "</div>
            </div>
            
            <div class='field'>
                <div class='label'>🎯 İlgilendiği Servisler:</div>
                <div class='services'>" . htmlspecialchars($servicesText) . "</div>
            </div>
            
            <div class='field'>
                <div class='label'>📝 Ekstra Notlar:</div>
                <div class='value'>" . (empty($notes) ? 'Belirtilmemiş' : nl2br(htmlspecialchars($notes))) . "</div>
            </div>
            
            <div class='field'>
                <div class='label'>📅 Talep Tarihi:</div>
                <div class='value'>" . date('d.m.Y H:i:s') . "</div>
            </div>
        </div>
        
        <div class='footer'>
            <p>Bu e-posta Netseo web sitesi üzerinden gönderilmiştir.</p>
            <p>Lütfen müşteri ile en kısa sürede iletişime geçin.</p>
        </div>
    </div>
</body>
</html>
";

// E-posta başlıkları
$headers = [
    'MIME-Version: 1.0',
    'Content-type: text/html; charset=UTF-8',
    'From: Netseo Web Sitesi <noreply@netseo.com.tr>',
    'Reply-To: ' . $email,
    'X-Mailer: PHP/' . phpversion()
];

// E-posta gönder
$mailSent = mail($to, $subject, $message, implode("\r\n", $headers));

if ($mailSent) {
    // Başarılı gönderim için müşteriye de otomatik yanıt gönder
    $customerSubject = 'Netseo - Talebiniz Alındı!';
    $customerMessage = "
    <html>
    <head>
        <meta charset='UTF-8'>
        <title>Netseo - Talebiniz Alındı</title>
        <style>
            body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; }
            .container { max-width: 600px; margin: 0 auto; padding: 20px; }
            .header { background: linear-gradient(135deg, #8b5cf6, #3b82f6); color: white; padding: 30px; border-radius: 10px 10px 0 0; text-align: center; }
            .content { background: #f8fafc; padding: 30px; border-radius: 0 0 10px 10px; }
            .highlight { background: #e0e7ff; padding: 20px; border-radius: 8px; margin: 20px 0; text-align: center; }
            .footer { text-align: center; margin-top: 30px; color: #6b7280; font-size: 14px; }
        </style>
    </head>
    <body>
        <div class='container'>
            <div class='header'>
                <h2>🎉 Teşekkürler " . htmlspecialchars($fullName) . "!</h2>
                <p>Dijital analiz talebiniz başarıyla alındı</p>
            </div>
            <div class='content'>
                <p>Merhaba <strong>" . htmlspecialchars($fullName) . "</strong>,</p>
                
                <p>Netseo Dijital Pazarlama Ajansı'na gösterdiğiniz ilgi için teşekkür ederiz!</p>
                
                <div class='highlight'>
                    <h3>🚀 Ücretsiz Dijital Analiziniz Hazırlanıyor</h3>
                    <p>Uzman ekibimiz 24 saat içinde sizinle iletişime geçerek:</p>
                    <ul style='text-align: left; display: inline-block;'>
                        <li>✅ SEO Teknik Audit (2.500₺ değerinde)</li>
                        <li>✅ Rakip Analizi (1.500₺ değerinde)</li>
                        <li>✅ Anahtar Kelime Analizi (1.000₺ değerinde)</li>
                        <li>✅ Strateji Önerileri (2.000₺ değerinde)</li>
                    </ul>
                    <p><strong>Toplam 7.000₺ değerinde analiz tamamen ücretsiz!</strong></p>
                </div>
                
                <p>Bu süreçte herhangi bir sorunuz olursa bizimle iletişime geçebilirsiniz:</p>
                <ul>
                    <li>📧 E-posta: info@netseo.com.tr</li>
                    <li>📞 Telefon: +90 (212) XXX XX XX</li>
                    <li>🌐 Website: www.netseo.com.tr</li>
                </ul>
                
                <p>Dijital başarınız için yanınızdayız!</p>
                
                <p>Saygılarımızla,<br><strong>Netseo Dijital Pazarlama Ekibi</strong></p>
            </div>
            
            <div class='footer'>
                <p>Bu e-posta otomatik olarak gönderilmiştir.</p>
                <p>Netseo Dijital Pazarlama Ajansı © 2024</p>
            </div>
        </div>
    </body>
    </html>
    ";
    
    $customerHeaders = [
        'MIME-Version: 1.0',
        'Content-type: text/html; charset=UTF-8',
        'From: Netseo Dijital Pazarlama <info@netseo.com.tr>',
        'Reply-To: info@netseo.com.tr',
        'X-Mailer: PHP/' . phpversion()
    ];
    
    // Müşteriye otomatik yanıt gönder
    mail($email, $customerSubject, $customerMessage, implode("\r\n", $customerHeaders));
    
    echo json_encode(['success' => true, 'message' => 'Form başarıyla gönderildi']);
} else {
    echo json_encode(['success' => false, 'message' => 'E-posta gönderilemedi. Lütfen tekrar deneyin.']);
}
?>