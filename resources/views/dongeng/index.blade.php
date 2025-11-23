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
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            margin: 0;
            padding: 0;
        }

        /* Container Styles */
        .story-container {
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            align-items: center;
            padding: 2rem 1rem;
            position: relative;
        }

        /* Header Styles */
        .story-header {
            text-align: center;
            margin-bottom: 3rem;
            color: white;
            animation: fadeInDown 1s ease-out;
        }

        .story-title {
            font-size: 3rem;
            font-weight: bold;
            margin-bottom: 1rem;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.3);
            background: linear-gradient(45deg, #ff6b6b, #4ecdc4, #45b7d1);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .story-subtitle {
            font-size: 1.2rem;
            opacity: 0.9;
            margin-bottom: 0;
        }

        /* Story Grid */
        .stories-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(320px, 1fr));
            gap: 2rem;
            max-width: 1200px;
            width: 100%;
            margin-bottom: 2rem;
        }

        /* Story Card */
        .story-card {
            background: linear-gradient(135deg, rgba(255, 255, 255, 0.95), rgba(255, 255, 255, 0.9));
            border-radius: 20px;
            padding: 2rem;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
            border: 2px solid rgba(255, 255, 255, 0.5);
            cursor: pointer;
            transition: all 0.3s ease;
            animation: fadeInUp 0.6s ease-out both;
            position: relative;
            overflow: hidden;
        }

        .story-card:nth-child(1) {
            animation-delay: 0.1s;
        }

        .story-card:nth-child(2) {
            animation-delay: 0.2s;
        }

        .story-card:nth-child(3) {
            animation-delay: 0.3s;
        }

        .story-card:hover {
            transform: translateY(-5px) scale(1.02);
            box-shadow: 0 15px 40px rgba(0, 0, 0, 0.3);
            border-color: #4ecdc4;
        }

        .story-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 5px;
            background: linear-gradient(90deg, #ff6b6b, #4ecdc4, #45b7d1);
            border-radius: 20px 20px 0 0;
        }

        /* Story Content */
        .story-icon {
            font-size: 4rem;
            text-align: center;
            margin-bottom: 1.5rem;
        }

        .story-card-title {
            font-size: 1.5rem;
            font-weight: bold;
            color: #2d3748;
            margin-bottom: 1rem;
            text-align: center;
        }

        .story-description {
            color: #4a5568;
            font-size: 1rem;
            line-height: 1.6;
            text-align: center;
            margin-bottom: 1.5rem;
        }

        .story-meta {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-top: 1rem;
            padding-top: 1rem;
            border-top: 1px solid rgba(0, 0, 0, 0.1);
        }

        .story-duration {
            background: linear-gradient(90deg, #667eea, #764ba2);
            color: white;
            padding: 0.5rem 1rem;
            border-radius: 15px;
            font-size: 0.9rem;
            font-weight: bold;
        }

        .story-difficulty {
            color: #4a5568;
            font-size: 0.9rem;
            font-weight: bold;
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

        /* Animations */
        @keyframes fadeInDown {
            from {
                opacity: 0;
                transform: translateY(-30px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Mobile Responsive */
        @media (max-width: 768px) {
            .story-container {
                padding: 1rem 0.5rem;
            }

            .story-title {
                font-size: 2.5rem;
            }

            .story-subtitle {
                font-size: 1rem;
            }

            .stories-grid {
                grid-template-columns: 1fr;
                gap: 1.5rem;
                padding: 0 0.5rem;
            }

            .story-card {
                padding: 1.5rem;
            }

            .back-button {
                top: 1rem;
                left: 1rem;
                padding: 0.6rem 1.2rem;
                font-size: 0.9rem;
            }
        }

        @media (max-width: 480px) {
            .story-title {
                font-size: 2rem;
            }

            .story-card {
                padding: 1.2rem;
            }

            .story-card-title {
                font-size: 1.3rem;
            }

            .story-description {
                font-size: 0.95rem;
            }

            .story-meta {
                flex-direction: column;
                gap: 0.5rem;
                align-items: stretch;
            }

            .story-duration {
                text-align: center;
            }
        }
    </style>

    <!-- Back Button -->
    <button class="back-button" onclick="window.location.href = '{{ route('dashboard') }}'">
        <span>🏠</span>
        <span>Dashboard</span>
    </button>

    <div class="story-container">
        <!-- Header -->
        <div class="story-header">
            <h1 class="story-title">📚 Dongeng Disleksia</h1>
            <p class="story-subtitle">Pilih cerita favorit kamu untuk dibaca</p>
        </div>

        <!-- Stories Grid -->
        <div class="stories-grid">
            <!-- Story 1: Kelinci dan Kura-kura -->
            <div class="story-card" onclick="readStory('kelinci-kura-kura')">
                <div class="story-icon">🐰🐢</div>
                <h3 class="story-card-title">Kelinci dan Kura-kura</h3>
                <p class="story-description">
                    Cerita tentang perlombaan lari antara kelinci yang sombong dan kura-kura yang tekun.
                    Pelajaran berharga tentang kesabaran dan ketekunan.
                </p>
                <div class="story-meta">
                    <span class="story-duration">⏱️ 5 menit</span>
                    <span class="story-difficulty">📖 Mudah</span>
                </div>
            </div>

            <!-- Story 2: Semut dan Belalang -->
            <div class="story-card" onclick="readStory('semut-belalang')">
                <div class="story-icon">🐜🦗</div>
                <h3 class="story-card-title">Semut dan Belalang</h3>
                <p class="story-description">
                    Kisah tentang semut yang rajin bekerja dan belalang yang malas.
                    Mengajarkan pentingnya kerja keras dan persiapan untuk masa depan.
                </p>
                <div class="story-meta">
                    <span class="story-duration">⏱️ 4 menit</span>
                    <span class="story-difficulty">📖 Mudah</span>
                </div>
            </div>

            <!-- Story 3: Si Kancil dan Buaya -->
            <div class="story-card" onclick="readStory('kancil-buaya')">
                <div class="story-icon">🦌🐊</div>
                <h3 class="story-card-title">Si Kancil dan Buaya</h3>
                <p class="story-description">
                    Petualangan si Kancil yang cerdik menghadapi buaya-buaya di sungai.
                    Cerita tentang kecerdikan dan kreativitas dalam menyelesaikan masalah.
                </p>
                <div class="story-meta">
                    <span class="story-duration">⏱️ 6 menit</span>
                    <span class="story-difficulty">📖 Sedang</span>
                </div>
            </div>
        </div>
    </div>

    <script>
        function readStory(storyId) {
            // Redirect ke halaman cerita berdasarkan ID
            window.location.href = `/dongeng/${storyId}`;
        }

        // Add click sound effect (optional)
        document.querySelectorAll('.story-card').forEach(card => {
            card.addEventListener('click', function() {
                // Add subtle animation feedback
                this.style.transform = 'scale(0.98)';
                setTimeout(() => {
                    this.style.transform = '';
                }, 100);
            });
        });
    </script>
@endsection
