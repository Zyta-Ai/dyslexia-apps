@extends('layouts.app')

@section('content')
    <style>
        body {
            background: linear-gradient(135deg, #f093fb 0%, #f5576c 50%, #4facfe 100%);
            min-height: 100vh;
            margin: 0;
            padding: 0;
        }        /* Story Book Container */
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
            background: linear-gradient(90deg, #ff6b6b, #4ecdc4, #45b7d1, #96ceb4);
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
                <span class="story-icon-large">🐰🐢</span>
                <h1 class="story-title-large">Kelinci dan Kura-kura</h1>
                <div class="story-meta-info">
                    <span class="meta-item">⏱️ 5 menit</span>
                    <span class="meta-item">📖 Mudah</span>
                    <span class="meta-item">🎯 Moral: Ketekunan</span>
                </div>
            </div>

            <!-- Book Content -->
            <div class="book-content">
                <p class="story-text">
                    Pada suatu hari yang cerah di hutan, hiduplah seekor kelinci yang sangat sombong bernama Rico. Rico
                    selalu membanggakan dirinya sebagai hewan tercepat di hutan. Setiap hari, dia berlari ke sana ke mari
                    sambil mengejek hewan-hewan lain yang bergerak lambat. "Lihat aku! Aku sangat cepat! Kalian semua lambat
                    sekali!" kata Rico dengan angkuh. Semua hewan di hutan sudah muak dengan sikap sombong Rico. Mereka
                    mencari cara untuk memberi pelajaran kepada kelinci yang sombong itu. Pada suatu pagi, ketika Rico
                    sedang berlari dan mengejek seperti biasa, tiba-tiba muncul suara kecil dari balik batu. "Rico, apakah
                    kamu berani bertanding lari denganku?" tanya suara itu. Rico tertawa terbahak-bahak ketika melihat siapa
                    yang mengajaknya bertanding. Ternyata itu adalah Kiko, seekor kura-kura kecil yang bergerak sangat
                    lambat. "Hahahaha! Kamu, si lambat, mau bertanding lari denganku? Ini pasti lelucon terbaik tahun ini!"
                    kata Rico sambil terus tertawa. Kiko tidak tersinggung dengan ejekan Rico. Dengan sabar dia berkata,
                    "Aku serius, Rico. Mari kita bertanding lari dari pohon besar ini sampai ke sungai di ujung hutan. Siapa
                    yang sampai duluan dialah pemenangnya." Rico masih terus tertawa, "Baiklah, Kiko. Aku terima
                    tantanganmu. Ini akan menjadi kemenangan termudah dalam hidupku!" Keesokan harinya, semua hewan di hutan
                    berkumpul untuk menyaksikan perlombaan antara Rico si kelinci cepat dan Kiko si kura-kura lambat. Pak
                    Burung Hantu bertindak sebagai wasit. "Siap... mulai!" teriak Pak Burung Hantu. Rico langsung melesat
                    seperti kilat, meninggalkan Kiko yang baru saja mulai melangkah perlahan. Dalam sekejap, Rico sudah
                    berlari sangat jauh hingga Kiko tidak terlihat lagi. "Ini terlalu mudah," gumam Rico sambil terus
                    berlari kencang. Ketika sudah berlari setengah perjalanan, Rico menoleh ke belakang dan tidak melihat
                    Kiko sama sekali. "Kura-kura lambat itu pasti masih di belakang sana. Aku punya waktu banyak untuk
                    istirahat," pikir Rico. Rico kemudian memutuskan untuk tidur siang di bawah pohon rindang. "Aku akan
                    tidur sebentar saja. Toh, Kiko masih jauh di belakang. Aku bisa bangun nanti dan tetap menang," kata
                    Rico sambil memejamkan mata. Sementara itu, Kiko terus berjalan perlahan tapi pasti. Langkah demi
                    langkah, dia tidak pernah berhenti sekalipun. Ketika melihat Rico sedang tertidur di bawah pohon, Kiko
                    tidak mengejek atau membangunkannya. Dia terus fokus berjalan menuju garis finish. "Pelan-pelan saja,
                    yang penting sampai," gumam Kiko sambil terus melangkah. Rico terbangun ketika matahari sudah mulai
                    condong ke barat. "Wah, aku tidur terlalu lama! Tapi tidak apa-apa, aku masih paling cepat," kata Rico
                    sambil mengusap mata. Rico mulai berlari lagi, tapi kali ini dia tidak terlalu tergesa-gesa karena yakin
                    dia masih akan menang. Ketika Rico hampir sampai di garis finish, dia terkejut melihat Kiko sudah berada
                    sangat dekat dengan sungai. "Tidak mungkin!" teriak Rico sambil berlari sekuat tenaga. Tapi sudah
                    terlambat. Tepat ketika Rico hampir menyusul, Kiko menyentuh tepi sungai terlebih dahulu. "Aku menang!"
                    seru Kiko dengan gembira. Semua hewan di hutan bersorak gembira. Rico terduduk lemas di tanah, tidak
                    percaya dengan apa yang baru saja terjadi. Pak Burung Hantu mendekat dan berkata, "Rico, ini adalah
                    pelajaran berharga untukmu. Kecepatan tidak ada artinya jika disertai dengan kesombongan dan kemalasan.
                    Kiko menang bukan karena dia cepat, tapi karena dia tekun dan tidak pernah menyerah." Rico merasa sangat
                    malu dengan sikapnya selama ini. Dia mendekati Kiko dan berkata, "Maafkan aku, Kiko. Aku sudah sombong
                    dan meremehkanmu. Kamu mengajarkanku bahwa ketekunan dan kesabaran lebih berharga daripada kecepatan
                    semata." Kiko tersenyum ramah, "Tidak apa-apa, Rico. Yang penting kita sudah berteman sekarang." Sejak
                    hari itu, Rico tidak lagi sombong. Dia menjadi lebih rendah hati dan sering membantu hewan-hewan lain di
                    hutan. Rico dan Kiko pun menjadi sahabat baik yang saling membantu.
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

        // Add reading progress (optional enhancement)
        let lastScrollTop = 0;
        window.addEventListener('scroll', function() {
            let scrollTop = window.pageYOffset || document.documentElement.scrollTop;
            // Reading progress logic could be added here
            lastScrollTop = scrollTop;
        });
    </script>
@endsection
