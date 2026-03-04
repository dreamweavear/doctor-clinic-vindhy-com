<?php $this->extend('layouts/legal'); ?>
<?php $this->section('content'); ?>

<div class="legal-hero rounded-3 mb-4 px-4 py-4" style="background:linear-gradient(135deg,#713f12,#92400e)">
    <h1 class="text-white fw-bold mb-1"><i class="fas fa-cookie-bite me-2"></i>कुकी नीति</h1>
    <div class="fw-semibold mb-1" style="color:#fde68a">Cookie Policy</div>
    <div class="text-white-50" style="font-size:.82rem">clinic.vindhy.com</div>
</div>

<div class="last-updated">📅 अंतिम अपडेट: मार्च 2026</div>

<div class="legal-card">
    <h2 class="section-title"><i class="fas fa-question-circle"></i>1. कुकी क्या होती है? <small class="text-muted fw-normal ms-1" style="font-size:.75rem">What is a Cookie?</small></h2>
    <p style="font-size:.88rem">कुकी एक छोटी टेक्स्ट फ़ाइल होती है जो आपका ब्राउज़र आपके डिवाइस पर सेव करता है। यह वेबसाइट को आपकी प्राथमिकताएँ याद रखने में मदद करती है।</p>
    <div class="bilingual-label">A cookie is a small text file stored on your device by your browser. It helps websites remember your preferences and session information.</div>

    <h2 class="section-title"><i class="fas fa-list-ul"></i>2. हम कौन-सी कुकी इस्तेमाल करते हैं? <small class="text-muted fw-normal ms-1" style="font-size:.75rem">Cookies We Use</small></h2>
    
    <div class="table-responsive">
        <table class="table table-sm table-bordered" style="font-size:.83rem">
            <thead class="table-primary">
                <tr><th>कुकी का नाम</th><th>उद्देश्य</th><th>अवधि</th><th>जरूरी?</th></tr>
            </thead>
            <tbody>
                <tr>
                    <td><code>ci_session</code></td>
                    <td>लॉगिन सेशन बनाए रखने के लिए<br><small class="text-muted">Maintains login session</small></td>
                    <td>Session / बंद होने पर x</td>
                    <td><span class="badge bg-success">✅ हाँ</span></td>
                </tr>
                <tr>
                    <td><code>cookieConsent</code></td>
                    <td>आपकी कुकी सहमति याद रखने के लिए (localStorage)<br><small class="text-muted">Remembers your cookie consent choice</small></td>
                    <td>1 साल / 1 year</td>
                    <td><span class="badge bg-warning text-dark">⚠️ कार्यात्मक</span></td>
                </tr>
            </tbody>
        </table>
    </div>
    
    <div class="alert alert-success py-2 mt-2" style="font-size:.82rem">
        <i class="fas fa-check-circle me-1"></i>हम <strong>कोई ट्रैकिंग, विज्ञापन, या तृतीय-पक्ष कुकी</strong> उपयोग नहीं करते।<br>
        <span class="bilingual-label">We do NOT use any tracking, advertising, or third-party cookies.</span>
    </div>

    <h2 class="section-title"><i class="fas fa-ban"></i>3. कुकी कैसे डिसेबल करें? <small class="text-muted fw-normal ms-1" style="font-size:.75rem">How to Disable Cookies</small></h2>
    <p style="font-size:.88rem">आप अपने ब्राउज़र की सेटिंग में जाकर कुकी बंद कर सकते हैं:</p>
    <ul style="font-size:.88rem">
        <li><strong>Chrome:</strong> Settings → Privacy and Security → Cookies and other site data</li>
        <li><strong>Firefox:</strong> Options → Privacy &amp; Security → Cookies and Site Data</li>
        <li><strong>Edge:</strong> Settings → Cookies and site permissions</li>
        <li><strong>Safari:</strong> Preferences → Privacy → Cookies</li>
    </ul>
    <div class="alert alert-warning py-2 mt-2" style="font-size:.82rem">
        <i class="fas fa-exclamation-triangle me-1"></i>नोट: कुकी बंद करने पर आप सिस्टम में लॉगिन नहीं कर पाएंगे।<br>
        <span class="bilingual-label">Note: Disabling cookies may prevent you from logging into the system.</span>
    </div>
</div>

<?php $this->endSection(); ?>
