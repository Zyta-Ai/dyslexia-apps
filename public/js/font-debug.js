/**
 * Font Debug Utility
 * Membantu debug masalah font loading
 */

window.FontDebug = {
    // Test apakah font tersedia
    isFontAvailable: function (fontName) {
        const canvas = document.createElement('canvas');
        const context = canvas.getContext('2d');

        // Test dengan teks sample
        const testText = 'OpenDyslexic Font Test';

        // Ukur dengan font default
        context.font = '16px serif';
        const serifWidth = context.measureText(testText).width;

        context.font = '16px sans-serif';
        const sansWidth = context.measureText(testText).width;

        // Ukur dengan font yang ditest
        context.font = `16px "${fontName}", serif`;
        const testWidthSerif = context.measureText(testText).width;

        context.font = `16px "${fontName}", sans-serif`;
        const testWidthSans = context.measureText(testText).width;

        // Font tersedia jika ukuran berbeda dari default
        return (testWidthSerif !== serifWidth) || (testWidthSans !== sansWidth);
    },

    // Cek semua font yang di load
    checkAllFonts: function () {
        const fontsToCheck = [
            'Open Dyslexic',
            'OpenDyslexic',
            'Comic Sans MS',
            'Trebuchet MS',
            'Verdana'
        ];

        console.group('🔍 Font Availability Check');
        fontsToCheck.forEach(font => {
            const isAvailable = this.isFontAvailable(font);
            console.log(`${isAvailable ? '✅' : '❌'} ${font}: ${isAvailable ? 'Available' : 'Not Available'}`);
        });
        console.groupEnd();

        return fontsToCheck.map(font => ({
            name: font,
            available: this.isFontAvailable(font)
        }));
    },

    // Cek font yang sedang digunakan
    getCurrentFont: function (element = document.body) {
        const style = window.getComputedStyle(element);
        return style.fontFamily;
    },

    // Force reload font
    reloadFont: function (fontUrl) {
        // Remove existing link
        const existingLink = document.querySelector(`link[href*="${fontUrl}"]`);
        if (existingLink) {
            existingLink.remove();
        }

        // Add new link
        const link = document.createElement('link');
        link.rel = 'stylesheet';
        link.href = fontUrl + '&t=' + Date.now(); // Cache bust
        document.head.appendChild(link);

        console.log('🔄 Font reloaded:', fontUrl);
    },

    // Test loading dari berbagai source
    testFontSources: function () {
        const sources = [
            'https://fonts.googleapis.com/css2?family=Open+Dyslexic:wght@400;700&display=swap',
            'https://cdn.jsdelivr.net/npm/@opendyslexic/opendyslexic@1.0.3/open-dyslexic-regular.css'
        ];

        console.group('🌐 Testing Font Sources');
        sources.forEach((source, index) => {
            fetch(source)
                .then(response => {
                    if (response.ok) {
                        console.log(`✅ Source ${index + 1} OK:`, source);
                    } else {
                        console.warn(`⚠️ Source ${index + 1} Error ${response.status}:`, source);
                    }
                })
                .catch(error => {
                    console.error(`❌ Source ${index + 1} Failed:`, source, error);
                });
        });
        console.groupEnd();
    },

    // Info lengkap tentang font
    getFullInfo: function () {
        console.group('📊 Complete Font Information');

        console.log('Current body font:', this.getCurrentFont());
        console.log('Font loading status:', document.body.getAttribute('data-font-loaded'));

        if ('fonts' in document) {
            console.log('Font Loading API available: ✅');
            console.log('Loaded fonts:', Array.from(document.fonts).map(f => f.family));
        } else {
            console.log('Font Loading API available: ❌');
        }

        this.checkAllFonts();
        this.testFontSources();

        console.groupEnd();
    }
};

// Tambahkan ke console untuk debugging
console.log('🎨 Font Debug Utility loaded. Use FontDebug.getFullInfo() for complete analysis.');