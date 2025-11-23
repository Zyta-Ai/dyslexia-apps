@extends('layouts.app')

@section('content')
    <style>
        body {
            background: linear-gradient(135deg, #84fab0 0%, #8fd3f4 100%);
            min-height: 100vh;
            margin: 0;
            padding: 0;
        }

        /* Story Book Container */
        .story-book {
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 2rem 1rem;
            position: relative;
        }

        /* Book Page */
        .book-page {
            background: linear-gradient(135deg, #fff 0%, #f8f9ff 100%);
            border-radius: 20px;
            max-width: 800px;
            width: 100%;
            margin: 0 auto;
            box-shadow:
                0 20px 60px rgba(0, 0, 0, 0.2),
                inset 0 1px 0 rgba(255, 255, 255, 0.5);
            border: 2px solid rgba(255, 255, 255, 0.3);
            position: relative;
            overflow: hidden;
            animation: bookOpen 1s ease-out;
        }

        .book-page::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 8px;
            background: linear-gradient(90deg, #a8edea, #fed6e3, #d299c2, #ffeaa7);
            border-radius: 20px 20px 0 0;
        }

        /* Book Header */
        .book-header {
            padding: 2rem 3rem 1rem;
            text-align: center;
            background: linear-gradient(135deg, rgba(255, 255, 255, 0.9), rgba(248, 249, 255, 0.8));
            border-bottom: 2px solid rgba(0, 0, 0, 0.1);
        }

        .story-icon-large {
            font-size: 4rem;
            margin-bottom: 1rem;
            display: block;
        }

        .story-title-large {
            font-size: 2.5rem;
            font-weight: bold;
            color: #2d3748;
            margin-bottom: 0.5rem;
            text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.1);
        }

        .story-meta-info {
            display: flex;
            justify-content: center;
            gap: 2rem;
            margin-top: 1rem;
            flex-wrap: wrap;
        }

        .meta-item {
            background: linear-gradient(90deg, #667eea, #764ba2);
            color: white;
            padding: 0.5rem 1rem;
            border-radius: 20px;
            font-size: 0.9rem;
            font-weight: bold;
        }

        /* Book Content */
        .book-content {
            padding: 2rem 3rem 3rem;
            line-height: 2;
            color: #2d3748;
            font-size: 1.1rem;
            text-align: justify;
        }

        .story-text {
            margin-bottom: 0;
            text-indent: 2rem;
            font-size: 1.1rem;
            line-height: 2.2;
            color: #1a202c;
            letter-spacing: 0.3px;
            word-spacing: 0.1em;
        }

        /* Back Button */
        .back-button {
            position: fixed;
            top: 2rem;
            left: 2rem;
            background: linear-gradient(90deg, rgba(167, 222, 212, 1) 0%, rgba(123, 188, 174, 1) 100%);
            color: white;
            border: none;
            border-radius: 50px;
            padding: 0.8rem 1.5rem;
            font-size: 1rem;
            font-weight: bold;
            cursor: pointer;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
            transition: all 0.3s ease;
            z-index: 1000;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .back-button:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.3);
            filter: brightness(1.1);
        }

        /* Scroll to Top Button */
        .scroll-top {
            position: fixed;
            bottom: 2rem;
            right: 2rem;
            background: linear-gradient(90deg, #ff6b6b, #4ecdc4);
            color: white;
            border: none;
            border-radius: 50%;
            width: 50px;
            height: 50px;
            font-size: 1.5rem;
            cursor: pointer;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
            transition: all 0.3s ease;
            opacity: 0;
            visibility: hidden;
        }

        .scroll-top.visible {
            opacity: 1;
            visibility: visible;
        }

        .scroll-top:hover {
            transform: translateY(-3px);
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.3);
        }

        /* Animations */
        @keyframes bookOpen {
            from {
                opacity: 0;
                transform: perspective(1000px) rotateY(-30deg) scale(0.8);
            }

            to {
                opacity: 1;
                transform: perspective(1000px) rotateY(0deg) scale(1);
            }
        }

        /* Mobile Responsive */
        @media (max-width: 768px) {
            .story-book {
                padding: 1rem 0.5rem;
            }

            .book-header {
                padding: 1.5rem 2rem 1rem;
            }

            .story-title-large {
                font-size: 2rem;
            }

            .story-icon-large {
                font-size: 3rem;
            }

            .meta-item {
                font-size: 0.8rem;
                padding: 0.4rem 0.8rem;
            }

            .book-content {
                padding: 1.5rem 2rem 2.5rem;
                font-size: 1rem;
                line-height: 2;
            }

            .story-text {
                font-size: 1rem;
                line-height: 2.1;
                text-indent: 1.5rem;
            }

            .back-button {
                top: 1rem;
                left: 1rem;
                padding: 0.6rem 1.2rem;
                font-size: 0.9rem;
            }

            .story-meta-info {
                gap: 1rem;
            }
        }

        @media (max-width: 480px) {
            .book-header {
                padding: 1rem 1.5rem 0.5rem;
            }

            .story-title-large {
                font-size: 1.8rem;
            }

            .story-icon-large {
                font-size: 2.5rem;
            }

            .book-content {
                padding: 1rem 1.5rem 2rem;
                font-size: 0.95rem;
            }

            .story-text {
                font-size: 0.95rem;
                line-height: 2;
                text-indent: 1rem;
            }

            .story-meta-info {
                flex-direction: column;
                align-items: center;
                gap: 0.5rem;
            }
        }
    </style>

    <!-- Back Button -->
    <button class="back-button" onclick="window.location.href = '{{ route('dongeng.index') }}'">
        <span>📚</span>
        <span>Kembali</span>
    </button>

    <!-- Scroll to Top Button -->
    <button class="scroll-top" id="scrollTop" onclick="scrollToTop()">
        ↑
    </button>

    <div class="story-book">
        <div class="book-page">
            <!-- Book Header -->
            <div class="book-header">
                <span class="story-icon-large">🐜🦗</span>
                <h1 class="story-title-large">Semut dan Belalang</h1>
                <div class="story-meta-info">
                    <span class="meta-item">⏱️ 4 menit</span>
                    <span class="meta-item">📖 Mudah</span>
                    <span class="meta-item">🎯 Moral: Kerja Keras</span>
                </div>
            </div>

            <!-- Book Content -->
            <div class="book-content">
                <p class="story-text">
                    Di sebuah padang rumput yang hijau dan luas, hiduplah dua sahabat yang sangat berbeda. Yang pertama
                    adalah Andi si semut kecil yang sangat rajin dan pekerja keras. Yang kedua adalah Beni si belalang yang
                    suka bermalas-malasan dan hanya ingin bersenang-senang sepanjang hari. Ketika musim panas tiba, matahari
                    bersinar cerah dan cuaca sangat hangat. Andi si semut bangun pagi-pagi sekali dan langsung mulai
                    bekerja. "Aku harus mengumpulkan makanan sebanyak-banyaknya untuk persiapan musim dingin nanti," kata
                    Andi sambil mengangkat sebutir beras yang hampir sebesar tubuhnya. Sementara itu, Beni si belalang baru
                    saja bangun dan langsung bermalas-malasan di bawah dedaunan hijau. "Ah, cuacanya bagus sekali hari ini.
                    Saatnya untuk bersantai dan menikmati hidup," kata Beni sambil meregangkan tubuhnya. Andi berjalan
                    melewati Beni yang sedang rebahan sambil menyanyikan lagu. "Hai Beni, ayo bantu aku mengumpulkan
                    makanan! Nanti kalau musim dingin datang, kita tidak akan kelaparan," ajak Andi dengan ramah. Beni
                    tertawa keras dan berkata, "Hahaha! Untuk apa repot-repot, Andi? Lihat, di mana-mana masih banyak
                    makanan. Musim dingin masih lama kok. Lebih baik kita bersenang-senang dulu!" Andi menggelengkan
                    kepalanya dengan sedih. Dia melanjutkan pekerjaannya mengumpulkan biji-bijian, remah-remah roti, dan
                    makanan lainnya. Dari pagi sampai sore, Andi tidak pernah berhenti bekerja. Sedangkan Beni, dari pagi
                    sampai sore dia hanya bernyanyi, melompat-lompat, dan bermain dengan kupu-kupu. "Kenapa kamu tidak ikut
                    bermain, Andi? Hidupmu akan sia-sia kalau cuma kerja melulu!" teriak Beni dari kejauhan. Andi tidak
                    terganggu dengan ejekan Beni. Dia terus fokus dengan pekerjaannya. "Setiap hari aku harus mengumpulkan
                    makanan. Kalau tidak, nanti aku akan menyesal," gumam Andi sambil terus bekerja. Hari demi hari berlalu.
                    Andi terus bekerja keras mengumpulkan dan menyimpan makanan di dalam lubang kecilnya. Rumahnya sudah
                    penuh dengan berbagai macam makanan yang cukup untuk bertahan selama musim dingin. Sebaliknya, Beni
                    terus saja bermalas-malasan. Dia tidur siang yang panjang, bernyanyi keras-keras, dan menghabiskan
                    waktunya dengan hal-hal yang tidak berguna. Ketika Andi mengingatkannya lagi, Beni selalu menjawab,
                    "Masih banyak waktu, Andi. Santai saja!" Perlahan-lahan, musim mulai berubah. Daun-daun pohon mulai
                    menguning dan berjatuhan. Angin mulai bertiup kencang dan udara mulai terasa dingin. "Sepertinya musim
                    dingin akan segera tiba," kata Andi sambil memeriksa persediaan makanannya. Dia merasa lega karena sudah
                    mempersiapkan semuanya dengan baik. Sementara itu, Beni mulai merasa khawatir ketika melihat perubahan
                    cuaca. "Eh, kok udaranya mulai dingin ya? Tapi tidak apa-apa, pasti masih ada waktu untuk mencari
                    makanan," pikir Beni sambil masih bermalas-malasan. Akhirnya, musim dingin yang dingin dan bersalju pun
                    tiba. Salju turun dengan lebat dan menutup seluruh padang rumput. Angin bertiup kencang dan udara
                    menjadi sangat dingin. Semua makanan di luar tertutup salju dan tidak bisa dimakan. Di dalam lubang
                    kecilnya yang hangat, Andi merasa tenang dan bahagia. Dia punya cukup makanan untuk bertahan selama
                    musim dingin yang panjang. "Syukurlah aku sudah mempersiapkan semuanya sejak musim panas," kata Andi
                    sambil menikmati secangkir teh hangat dan sepiring makanan lezat. Sementara itu, Beni kedinginan dan
                    kelaparan di luar sana. Dia mencari makanan ke sana ke mari, tapi semua sudah tertutup salju. Perutnya
                    keroncongan dan tubuhnya menggigil kedinginan. "Aduh, lapar sekali. Di mana ya bisa cari makanan?" keluh
                    Beni sambil terus mencari. Akhirnya, Beni mengingat sahabatnya Andi. Dengan langkah yang tertatih-tatih
                    karena kedinginan dan kelaparan, Beni mendatangi rumah Andi. Tok tok tok! "Andi, ini aku Beni. Boleh aku
                    masuk? Aku kedinginan dan kelaparan," pinta Beni dengan suara yang lemah. Andi membuka pintu dan melihat
                    kondisi Beni yang memprihatinkan. Meskipun Beni dulu sering mengejeknya, Andi tetap baik hati dan
                    mengajak Beni masuk. "Masuk saja, Beni. Kamu pasti kedinginan," kata Andi sambil memberikan selimut
                    hangat kepada Beni. Andi juga memberikan makanan hangat kepada Beni. Beni makan dengan lahap karena
                    sudah lama tidak makan. Setelah kenyang dan hangat, Beni merasa sangat menyesal dengan sikapnya selama
                    ini. "Maafkan aku, Andi. Aku sudah meremehkanmu dan tidak mau mendengarkan nasihatmu. Sekarang aku tahu
                    betapa pentingnya bekerja keras dan mempersiapkan masa depan," kata Beni dengan mata berkaca-kaca. Andi
                    tersenyum ramah dan berkata, "Tidak apa-apa, Beni. Yang penting sekarang kamu sudah mengerti. Mulai
                    sekarang, mari kita bekerja sama. Kamu bisa tinggal di sini selama musim dingin, tapi nanti kalau musim
                    panas datang lagi, kita harus bekerja keras bersama-sama." Beni mengangguk dengan antusias. "Terima
                    kasih, Andi. Aku berjanji akan menjadi lebih rajin dan tidak akan bermalas-malasan lagi. Kamu sudah
                    mengajarkanku pelajaran yang sangat berharga." Sejak saat itu, Beni berubah menjadi lebih rajin dan
                    pekerja keras. Ketika musim panas datang lagi, Beni dan Andi bekerja sama mengumpulkan makanan untuk
                    persiapan musim dingin berikutnya. Mereka menjadi sahabat sejati yang saling membantu dan mendukung satu
                    sama lain.
                </p>
            </div>
        </div>
    </div>

    <script>
        // Scroll to top functionality
        window.onscroll = function() {
            const scrollTop = document.getElementById('scrollTop');
            if (document.body.scrollTop > 300 || document.documentElement.scrollTop > 300) {
                scrollTop.classList.add('visible');
            } else {
                scrollTop.classList.remove('visible');
            }
        };

        function scrollToTop() {
            document.body.scrollTop = 0;
            document.documentElement.scrollTop = 0;
        }
    </script>
@endsection
