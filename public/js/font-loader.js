/**
 * Font Loader untuk OpenDyslexic
 * Mendeteksi dan memastikan font disleksia berhasil dimuat
 */

class FontLoader {
    constructor() {
        this.fontsToLoad = [
            'Open Dyslexic',
            'OpenDyslexic'
        ];
        this.fallbackFonts = [
            'Comic Sans MS',
            'Trebuchet MS', 
            'Verdana',
            'Arial'
        ];
        this.init();
    }

    init() {
        // Cek apakah Font Loading API tersedia
        if ('fonts' in document) {
            this.loadWithFontAPI();
        } else {
            // Fallback untuk browser lama
            this.loadWithFallback();
        }
    }

    loadWithFontAPI() {
        // Muat font menggunakan Font Loading API
        const fontPromises = this.fontsToLoad.map(fontFamily => {
            return document.fonts.load(`400 16px "${fontFamily}"`).catch(error => {
                console.warn(`Failed to load font: ${fontFamily}`, error);
                return null;
            });
        });

        Promise.allSettled(fontPromises).then(results => {
            const loadedFonts = results.filter(result => result.status === 'fulfilled' && result.value);
            
            if (loadedFonts.length > 0) {
                console.log('✅ OpenDyslexic font loaded successfully');
                this.applyFont();
            } else {
                console.warn('⚠️ OpenDyslexic font failed to load, using fallback');
                this.applyFallback();
            }
        });
    }

    loadWithFallback() {
        // Deteksi font dengan membandingkan ukuran teks
        const testText = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
        const fallbackFont = 'Arial';
        
        // Buat elemen test
        const testDiv = document.createElement('div');
        testDiv.style.cssText = `
            position: absolute;
            left: -9999px;
            top: -9999px;
            font-size: 72px;
            visibility: hidden;
            white-space: nowrap;
        `;
        document.body.appendChild(testDiv);

        // Ukur dengan font fallback
        testDiv.style.fontFamily = fallbackFont;
        testDiv.textContent = testText;
        const fallbackWidth = testDiv.offsetWidth;

        // Test setiap font OpenDyslexic
        let fontLoaded = false;
        for (const fontFamily of this.fontsToLoad) {
            testDiv.style.fontFamily = `"${fontFamily}", ${fallbackFont}`;
            const testWidth = testDiv.offsetWidth;
            
            if (testWidth !== fallbackWidth) {
                fontLoaded = true;
                console.log(`✅ ${fontFamily} loaded successfully`);
                break;
            }
        }

        document.body.removeChild(testDiv);

        if (fontLoaded) {
            this.applyFont();
        } else {
            console.warn('⚠️ OpenDyslexic font not detected, using fallback');
            this.applyFallback();
        }
    }

    applyFont() {
        // Terapkan font OpenDyslexic
        document.body.setAttribute('data-font-loaded', 'true');
        
        // Tambahkan style untuk memastikan font diterapkan
        const style = document.createElement('style');
        style.textContent = `
            [data-font-loaded="true"] * {
                font-family: 'Open Dyslexic', 'OpenDyslexic', 'Comic Sans MS', 'Trebuchet MS', 'Verdana', cursive, sans-serif !important;
            }
        `;
        document.head.appendChild(style);
    }

    applyFallback() {
        // Terapkan font fallback yang ramah disleksia
        document.body.setAttribute('data-font-loaded', 'fallback');
        
        const style = document.createElement('style');
        style.textContent = `
            [data-font-loaded="fallback"] * {
                font-family: 'Comic Sans MS', 'Trebuchet MS', 'Verdana', cursive, sans-serif !important;
            }
        `;
        document.head.appendChild(style);

        // Tampilkan notifikasi kepada pengguna
        this.showFallbackNotification();
    }

    showFallbackNotification() {
        // Buat notifikasi sederhana
        const notification = document.createElement('div');
        notification.style.cssText = `
            position: fixed;
            top: 10px;
            right: 10px;
            background: #fbbf24;
            color: #92400e;
            padding: 12px 16px;
            border-radius: 8px;
            font-size: 14px;
            font-weight: bold;
            z-index: 9999;
            max-width: 300px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.15);
        `;
        notification.textContent = '⚠️ Font disleksia tidak dapat dimuat. Menggunakan font alternatif.';
        
        document.body.appendChild(notification);
        
        // Hapus notifikasi setelah 5 detik
        setTimeout(() => {
            if (notification.parentNode) {
                notification.parentNode.removeChild(notification);
            }
        }, 5000);
    }
}

// Inisialisasi font loader setelah DOM siap
if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', () => new FontLoader());
} else {
    new FontLoader();
}