@extends('layouts.app')

@section('content')
    <style>
        /* Import OpenDyslexic font with multiple sources for better compatibility */
        @import url('https://fonts.googleapis.com/css2?family=Open+Dyslexic:wght@400;700&display=swap');
        @import url('https://cdn.jsdelivr.net/npm/@opendyslexic/opendyslexic@1.0.3/open-dyslexic-regular.css');
        
        /* Define font-face for local fallback */
        @font-face {
            font-family: 'OpenDyslexic-Fallback';
            src: local('Comic Sans MS'), local('Trebuchet MS'), local('Verdana');
            font-display: swap;
        }

        body {
            font-family: 'Open Dyslexic', 'OpenDyslexic', 'OpenDyslexic-Fallback', 'Comic Sans MS', 'Trebuchet MS', 'Verdana', cursive, sans-serif;
            font-display: swap;
            background: linear-gradient(135deg, #ffecd2 0%, #fcb69f 50%, #a8edea 100%);
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
            background: linear-gradient(90deg, #ffecd2, #fcb69f, #a8edea, #84fab0);
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
                <span class="story-icon-large">🦌🐊</span>
                <h1 class="story-title-large">Si Kancil dan Buaya</h1>
                <div class="story-meta-info">
                    <span class="meta-item">⏱️ 6 menit</span>
                    <span class="meta-item">📖 Sedang</span>
                    <span class="meta-item">🎯 Moral: Kecerdikan</span>
                </div>
            </div>

            <!-- Book Content -->
            <div class="book-content">
                <p class="story-text">
                    Di sebuah hutan tropis yang lebat dan hijau, hiduplah seekor kancil kecil yang sangat cerdik bernama
                    Kiki. Kiki terkenal di seluruh hutan karena kepandaiannya memecahkan masalah dengan cara yang kreatif
                    dan cerdas. Suatu hari, Kiki merasa sangat haus dan ingin minum air segar dari sungai yang mengalir
                    jernih di pinggir hutan. Namun, ada masalah besar yang menghadang. Sungai itu dihuni oleh puluhan buaya
                    ganas yang selalu siap memangsa siapa saja yang berani mendekati air. "Aduh, aku sangat haus, tapi
                    bagaimana caranya sampai ke sungai tanpa dimakan buaya?" gumam Kiki sambil menggaruk kepalanya. Kiki
                    duduk di bawah pohon besar sambil berpikir keras. Dia melihat buaya-buaya itu mengambang di permukaan
                    air sambil menunggu mangsa. Mata mereka yang besar dan tajam selalu mengawasi sekeliling. "Hmm, pasti
                    ada cara untuk mengakali buaya-buaya itu," pikir Kiki. Tiba-tiba, lampu kecerdikannya menyala terang.
                    Kiki mendapat ide cemerlang yang bisa menyelamatkan nyawanya sekaligus membantunya sampai ke sungai
                    dengan selamat. Kiki berjalan dengan percaya diri ke tepi sungai. Buaya-buaya yang melihatnya langsung
                    tertarik dan mulai berenang mendekat. "Wah, ada makanan enak nih!" kata Bubu, buaya terbesar yang
                    menjadi pemimpin kawanan. Namun, Kiki tidak takut sama sekali. Dengan suara yang keras dan percaya diri,
                    Kiki berteriak, "Hai, para buaya! Aku punya kabar penting dari Raja Hutan!" Semua buaya berhenti
                    berenang dan mendengarkan dengan penasaran. "Apa katamu, Kancil kecil?" tanya Bubu dengan nada
                    mencurigakan. Kiki tersenyum licik dan berkata, "Raja Hutan ingin menghitung berapa jumlah kalian semua.
                    Dia akan memberikan hadiah besar kepada kawanan buaya terbanyak di sungai ini!" Mata buaya-buaya
                    berbinar mendengar kata 'hadiah besar'. Mereka mulai tertarik dengan tawaran Kiki. "Benarkah itu? Hadiah
                    apa yang akan kami dapat?" tanya Cici, buaya betina yang ada di samping Bubu. "Itu rahasia! Tapi
                    hadiahnya sangat besar dan berharga. Kalian pasti akan senang sekali," jawab Kiki dengan meyakinkan.
                    "Tapi ada satu masalah, aku tidak bisa menghitung kalian kalau kalian berserakan seperti ini. Bisakah
                    kalian berbaris rapi dari tepi sungai ini sampai ke seberang?" Para buaya mulai berdiskusi dengan heboh.
                    Mereka sangat tertarik dengan hadiah yang dijanjikan Raja Hutan. "Ayo kita berbaris! Mungkin kita bisa
                    dapat makanan berlimpah!" seru Dodo, buaya muda yang paling bersemangat. "Baiklah," kata Bubu akhirnya.
                    "Kami akan berbaris untuk Raja Hutan. Tapi kamu harus menghitung kami satu per satu dengan benar!"
                    Buaya-buaya mulai berbaris rapi dari satu tepi sungai ke tepi yang lain. Mereka membentuk jembatan buaya
                    yang kokoh dan stabil. Punggung mereka yang lebar berjejer seperti batu-batu loncatan yang sempurna.
                    Kiki hampir tidak bisa menahan tawa melihat rencananya berhasil dengan sempurna. "Baiklah, sekarang aku
                    akan mulai menghitung. Kalian tidak boleh bergerak sama sekali supaya hitungannya tidak salah," kata
                    Kiki sambil mulai melompat ke punggung buaya pertama. "SATU!" teriak Kiki sambil melompat ke punggung
                    Bubu. "DUA!" lompat lagi ke buaya kedua. "TIGA!" terus ke buaya ketiga. Para buaya merasa bangga
                    dihitung satu per satu. Mereka diam tidak bergerak sama sekali karena takut mengganggu proses
                    penghitungan. Kiki terus melompat dari satu punggung buaya ke punggung buaya lainnya sambil berteriak
                    angka. "EMPAT! LIMA! ENAM! TUJUH!" Kiki melompat dengan lincah dan cepat. Dia sudah hampir sampai di
                    tengah sungai. Buaya-buaya masih tetap diam dan menunggu dengan sabar karena mengira mereka sedang
                    dihitung untuk mendapat hadiah. "DELAPAN! SEMBILAN! SEPULUH! SEBELAS!" Kiki terus melompat dengan
                    gembira. Air sungai yang jernih sudah semakin dekat. Dia bisa merasakan semilir angin segar dari
                    seberang sungai. "DUA BELAS! TIGA BELAS! EMPAT BELAS! LIMA BELAS!" Kiki akhirnya sampai di punggung
                    buaya terakhir yang berada tepat di tepi seberang. Dengan lompatan terakhir yang tinggi, Kiki berhasil
                    mendarat dengan selamat di tepi sungai yang satunya. "ENAM BELAS! Terima kasih semuanya!" teriak Kiki
                    sambil tertawa lepas. Kiki langsung berlari ke sungai dan minum air segar sepuasnya. Air itu terasa
                    sangat dingin dan menyegarkan setelah perjalanan yang menegangkan. Buaya-buaya baru menyadari bahwa
                    mereka telah ditipu ketika melihat Kiki sudah berada di seberang sungai dengan selamat. "HEI! KAMU
                    MENIPU KAMI!" teriak Bubu dengan marah sambil menggertakkan giginya yang besar dan tajam. "MANA
                    HADIAHNYA? MANA RAJA HUTAN?" seru para buaya lainnya dengan kesal. Kiki tersenyum lebar sambil menjawab
                    dari seberang sungai, "Terima kasih sudah membantu aku menyeberangi sungai! Kalian memang buaya-buaya
                    yang baik hati!" Para buaya menyadari bahwa mereka telah dijadikan jembatan oleh kancil yang cerdik itu.
                    Meski kesal, mereka tidak bisa tidak kagum dengan kecerdikan Kiki. "Dasar kancil licik! Tapi harus aku
                    akui, dia memang sangat pintar," gumam Bubu sambil menggelengkan kepala. "Lain kali kita harus lebih
                    hati-hati," tambah Cici sambil kembali mengambang di air. Sejak hari itu, Kiki menjadi semakin terkenal
                    di hutan karena berhasil mengakali buaya-buaya ganas dengan kecerdikannya. Cerita tentang bagaimana
                    seekor kancil kecil bisa menyeberangi sungai dengan bantuan buaya-buaya itu menyebar ke seluruh hutan
                    dan menghibur semua hewan. Para hewan lain belajar dari Kiki bahwa kecerdikan dan kreativitas bisa
                    mengatasi masalah yang tampak tidak mungkin dipecahkan. Kiki juga belajar bahwa meskipun tipuannya
                    berhasil, dia harus selalu berhati-hati dan tidak meremehkan lawan. Buaya-buaya akhirnya juga belajar
                    untuk tidak mudah percaya pada janji-janji yang terlalu muluk dan selalu berpikir dua kali sebelum
                    membantu orang asing.
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
