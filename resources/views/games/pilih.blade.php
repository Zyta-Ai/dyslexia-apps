@extends('layouts.app')

@section('content')
    <style>
        /* Mobile Optimization */
        * {
            -webkit-tap-highlight-color: transparent;
            -webkit-touch-callout: none;
            -webkit-user-select: none;
            -khtml-user-select: none;
            -moz-user-select: none;
            -ms-user-select: none;
            user-select: none;
        }

        body {
            overflow-x: hidden;
            -webkit-overflow-scrolling: touch;
            scroll-behavior: smooth;
        }

        /* Prevent pull-to-refresh on mobile */
        html,
        body {
            overscroll-behavior: none;
        }

        /* =========================================================================
                               GAME PILIH KATA - STYLE
                            ========================================================================= */
        .game-container {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            min-height: 85vh;
            padding: 1rem;
            max-width: 100vw;
            overflow-x: hidden;
        }

        /* Mobile First Responsive */
        @media (max-width: 768px) {
            .game-container {
                min-height: 90vh;
                padding: 0.5rem;
                justify-content: flex-start;
                padding-top: 1rem;
            }
        }

        .card-register {
            /* Menggunakan Gradient Teal Kustom */
            background: linear-gradient(90deg, rgba(167, 222, 212, 0.7) 0%, rgba(123, 188, 174, 0.7) 100%);
            border-radius: 1.5rem;
            padding: 1.5rem;
            width: 100%;
            max-width: 600px;
            text-align: center;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
            border: 2px solid rgba(255, 255, 255, 0.5);
        }

        /* Mobile Responsive */
        @media (max-width: 768px) {
            .card-register {
                padding: 1rem;
                border-radius: 1rem;
                margin: 0 0.5rem;
                max-width: calc(100vw - 1rem);
            }
        }

        @media (max-width: 480px) {
            .card-register {
                padding: 0.75rem;
                margin: 0 0.25rem;
            }
        }

        /* SENTENCE DISPLAY AREA */
        .sentence-display {
            min-height: 80px;
            width: 100%;
            background-color: #f8f9fa;
            border-radius: 1rem;
            margin: 1rem auto;
            padding: 1rem;
            border: 3px dashed #d1d5db;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.3s ease;
            font-size: 1.25rem;
            font-weight: 600;
            color: #1f2937;
            text-align: center;
            line-height: 1.6;
        }

        .sentence-display.has-words {
            border-color: #10b981;
            background-color: #ecfdf5;
        }

        @media (max-width: 768px) {
            .sentence-display {
                min-height: 70px;
                margin: 0.75rem auto;
                padding: 0.75rem;
                font-size: 1.1rem;
            }
        }

        @media (max-width: 480px) {
            .sentence-display {
                min-height: 60px;
                padding: 0.5rem;
                font-size: 1rem;
                margin: 0.5rem auto;
            }
        }

        /* WORD CARDS */
        .word-card {
            background: linear-gradient(90deg, rgba(255, 239, 190, 1) 0%, rgba(255, 209, 102, 1) 100%);
            color: #333333;
            border: 2px solid #f59e0b;
            border-radius: 12px;
            padding: 12px 20px;
            font-weight: bold;
            font-size: 1.1rem;
            cursor: pointer;
            transition: all 0.3s ease;
            user-select: none;
            position: relative;
            z-index: 1;
            min-height: 44px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .word-card:hover {
            transform: translateY(-2px) scale(1.02);
            box-shadow: 0 6px 15px rgba(0, 0, 0, 0.2);
            filter: brightness(1.1);
        }

        .word-card:active {
            transform: translateY(0) scale(0.98);
        }

        /* Selected word */
        .word-card.selected {
            background: linear-gradient(90deg, rgba(34, 197, 94, 0.9) 0%, rgba(22, 163, 74, 0.9) 100%);
            color: white;
            border-color: #16a34a;
            transform: scale(1.05);
            box-shadow: 0 0 20px rgba(34, 197, 94, 0.5);
        }

        /* Wrong choice animation */
        .word-card.wrong {
            background: linear-gradient(90deg, rgba(220, 38, 38, 0.9) 0%, rgba(185, 28, 28, 0.9) 100%);
            color: white;
            border-color: #dc2626;
            animation: shake 0.5s ease-in-out;
        }

        @keyframes shake {

            0%,
            100% {
                transform: translateX(0);
            }

            20%,
            60% {
                transform: translateX(-10px);
            }

            40%,
            80% {
                transform: translateX(10px);
            }
        }

        /* Missing word slot */
        .word-slot {
            display: inline-block;
            min-width: 120px;
            min-height: 40px;
            padding: 8px 12px;
            border: 3px dashed #6b7280;
            border-radius: 12px;
            margin: 0 8px;
            vertical-align: middle;
            background: rgba(255, 255, 255, 0.8);
            animation: pulse 2s infinite;
            position: relative;
            text-align: center;
            line-height: 1.2;
        }

        .word-slot.filled {
            border: 3px solid #22c55e;
            background: linear-gradient(90deg, rgba(34, 197, 94, 0.9) 0%, rgba(22, 163, 74, 0.9) 100%);
            color: white;
            animation: none;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            padding: 8px 16px;
            min-width: 160px;
            white-space: nowrap;
        }

        .word-slot.wrong-filled {
            border: 3px solid #ef4444 !important;
            background: linear-gradient(90deg, rgba(239, 68, 68, 0.9) 0%, rgba(220, 38, 38, 0.9) 100%) !important;
            color: white;
            animation: none;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            padding: 8px 16px;
            min-width: 160px;
            white-space: nowrap;
        }

        @keyframes pulse {

            0%,
            100% {
                opacity: 1;
            }

            50% {
                opacity: 0.5;
            }
        }

        /* FEEDBACK CONTAINER */
        .feedback-container {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 15px;
            margin-bottom: 20px;
            min-height: 80px;
            opacity: 0;
            transition: opacity 0.3s, transform 0.3s;
            padding: 0 1rem;
        }

        .feedback-container.show {
            opacity: 1;
            animation: dramaticPopIn 0.6s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        }

        .feedback-message {
            background-color: white;
            padding: 10px 20px;
            border-radius: 20px 20px 20px 0;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            font-weight: bold;
            font-size: 1.1rem;
            color: #333;
            max-width: 200px;
            text-align: left;
            animation: bounceIn 0.5s ease-out 0.1s both;
        }

        @keyframes dramaticPopIn {
            0% {
                transform: scale(0.3) translateY(20px);
                opacity: 0;
            }

            50% {
                transform: scale(1.1) translateY(-5px);
                opacity: 0.8;
            }

            100% {
                transform: scale(1) translateY(0);
                opacity: 1;
            }
        }

        @keyframes bounceIn {
            0% {
                transform: scale(0.5) rotate(-5deg);
                opacity: 0;
            }

            60% {
                transform: scale(1.15) rotate(2deg);
                opacity: 1;
            }

            100% {
                transform: scale(1) rotate(0deg);
                opacity: 1;
            }
        }

        /* BUTTONS */
        .button-register {
            background: linear-gradient(90deg, rgba(255, 239, 190, 1) 0%, rgba(255, 209, 102, 1) 100%);
            color: #333333;
            box-shadow: 2px 5px 20px rgba(0, 0, 0, 0.4);
            cursor: pointer;
            border: none;
            border-radius: 12px;
            font-weight: bold;
            font-size: 1.1rem;
            padding: 12px 20px;
            transition: transform 0.1s, filter 0.2s;
            min-height: 44px;
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
        }

        .button-register:hover {
            filter: brightness(1.1);
            transform: translateY(-2px) scale(1.02);
            box-shadow: 0 6px 15px rgba(0, 0, 0, 0.2);
            transition: all 0.2s ease-out;
        }

        .button-register:active {
            transform: translateY(0) scale(0.98);
            transition: all 0.1s ease-out;
        }

        .button-dashboard {
            background: linear-gradient(90deg, rgba(167, 222, 212, 1) 0%, rgba(123, 188, 174, 1) 100%);
            color: white;
            box-shadow: 2px 5px 20px rgba(0, 0, 0, 0.4);
            cursor: pointer;
            border: none;
            border-radius: 12px;
            font-weight: bold;
            font-size: 1.1rem;
            padding: 12px 20px;
            transition: transform 0.1s, filter 0.2s;
        }

        .button-dashboard:hover {
            transform: translateY(-2px);
            filter: brightness(1.05);
        }

        /* Navigation Container */
        .navigation-container {
            display: flex;
            gap: 15px;
            justify-content: center;
            margin-top: 30px;
            flex-wrap: wrap;
            padding: 0 1rem;
        }

        /* FINAL SCORE CARD */
        .final-score-card {
            background: linear-gradient(90deg, rgba(167, 222, 212, 0.9) 0%, rgba(123, 188, 174, 0.9) 100%);
            border-radius: 1.5rem;
            padding: 2rem;
            width: 100%;
            max-width: 500px;
            text-align: center;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.15);
            border: 2px solid rgba(255, 255, 255, 0.6);
            animation: finalScoreAppear 0.8s ease-out;
        }

        @keyframes finalScoreAppear {
            from {
                opacity: 0;
                transform: translateY(30px) scale(0.9);
            }

            to {
                opacity: 1;
                transform: translateY(0) scale(1);
            }
        }

        /* Hide/Show elements */
        .hidden {
            display: none !important;
        }

        /* COUNTDOWN OVERLAY */
        .countdown-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100vw;
            height: 100vh;
            background: linear-gradient(135deg, rgba(0, 0, 0, 0.8), rgba(0, 0, 0, 0.9));
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 2000;
            backdrop-filter: blur(5px);
        }

        .countdown-number {
            font-size: 8rem;
            font-weight: 900;
            color: white;
            text-shadow: 0 0 30px rgba(255, 255, 255, 0.5);
            animation: countdownPulse 1s ease-in-out;
        }

        .countdown-start {
            font-size: 4rem;
            font-weight: 900;
            background: linear-gradient(45deg, #ff6b6b, #4ecdc4, #45b7d1, #96ceb4);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            animation: startAnimation 1s ease-out;
        }

        @keyframes countdownPulse {
            0% {
                transform: scale(0.5);
                opacity: 0;
            }

            50% {
                transform: scale(1.2);
                opacity: 1;
            }

            100% {
                transform: scale(1);
                opacity: 1;
            }
        }

        @keyframes startAnimation {
            0% {
                transform: scale(0.3) rotate(-180deg);
                opacity: 0;
            }

            50% {
                transform: scale(1.1) rotate(0deg);
                opacity: 1;
            }

            100% {
                transform: scale(1) rotate(0deg);
                opacity: 1;
            }
        }

        /* WELCOME SCREEN SYSTEM */
        .welcome-container {
            position: fixed;
            top: 0;
            left: 0;
            width: 100vw;
            height: 100vh;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            z-index: 1000;
            background: linear-gradient(135deg, rgba(167, 222, 212, 0.95), rgba(123, 188, 174, 0.95));
        }

        .welcome-mascot-stage {
            display: flex;
            flex-direction: column;
            align-items: center;
            animation: mascotEntrance 3s ease-out;
            animation-fill-mode: both;
        }

        #welcome-maskot {
            width: 150px;
            height: 150px;
            animation: gentleBounce 2s ease-in-out infinite;
            margin-bottom: 30px;
        }

        .welcome-message-box {
            background: white;
            padding: 30px 40px;
            border-radius: 25px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
            text-align: center;
            max-width: 500px;
            animation: messageBoxSlide 3s ease-out;
            animation-fill-mode: both;
            animation-delay: 1s;
        }

        .welcome-title {
            font-size: 2rem;
            font-weight: bold;
            color: #374151;
            margin-bottom: 15px;
        }

        .welcome-subtitle {
            font-size: 1.1rem;
            color: #6b7280;
            margin: 0;
        }

        .game-info-card {
            background: white;
            border-radius: 20px;
            padding: 25px;
            margin-top: 30px;
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
            max-width: 600px;
            width: 90%;
            opacity: 0;
            animation: cardSlideUp 1s ease-out;
            animation-fill-mode: both;
            animation-delay: 4s;
        }

        .info-content {
            display: flex;
            flex-direction: column;
            gap: 15px;
        }

        .info-item {
            display: flex;
            align-items: center;
            gap: 15px;
            padding: 10px;
            border-radius: 10px;
            background: rgba(167, 222, 212, 0.1);
            opacity: 0;
            animation: itemFadeIn 0.6s ease-out;
            animation-fill-mode: both;
        }

        .info-item:nth-child(1) {
            animation-delay: 4.5s;
        }

        .info-item:nth-child(2) {
            animation-delay: 5s;
        }

        .info-item:nth-child(3) {
            animation-delay: 5.5s;
        }

        .info-icon {
            font-size: 1.5rem;
            width: 30px;
            text-align: center;
        }

        .info-text {
            font-size: 1rem;
            color: #374151;
            font-weight: 500;
        }

        .start-button {
            position: fixed;
            bottom: 50px;
            left: 50%;
            transform: translateX(-50%);
            background: linear-gradient(135deg, #f59e0b, #d97706, #b45309);
            color: white;
            border: none;
            padding: 18px 40px;
            border-radius: 50px;
            font-size: 1.3rem;
            font-weight: bold;
            cursor: pointer;
            box-shadow: 0 8px 25px rgba(245, 158, 11, 0.4);
            opacity: 0;
            animation: buttonSlideUp 0.8s ease-out;
            animation-fill-mode: both;
            animation-delay: 6s;
            z-index: 1001;
            transition: all 0.3s ease;
        }

        .start-button:hover {
            transform: translateX(-50%) translateY(-5px) scale(1.05);
            box-shadow: 0 12px 35px rgba(245, 158, 11, 0.5);
            background: linear-gradient(135deg, #fbbf24, #f59e0b, #d97706);
        }

        /* ANIMATIONS */
        @keyframes mascotEntrance {
            0% {
                opacity: 0;
                transform: scale(0.3) translateY(-100px);
            }

            60% {
                opacity: 1;
                transform: scale(1.1) translateY(0);
            }

            100% {
                opacity: 1;
                transform: scale(1) translateY(0);
            }
        }

        @keyframes gentleBounce {

            0%,
            100% {
                transform: translateY(0);
            }

            50% {
                transform: translateY(-10px);
            }
        }

        @keyframes messageBoxSlide {
            0% {
                opacity: 0;
                transform: translateY(50px) scale(0.8);
            }

            100% {
                opacity: 1;
                transform: translateY(0) scale(1);
            }
        }

        @keyframes cardSlideUp {
            0% {
                opacity: 0;
                transform: translateY(100px);
            }

            100% {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes itemFadeIn {
            0% {
                opacity: 0;
                transform: translateX(-30px);
            }

            100% {
                opacity: 1;
                transform: translateX(0);
            }
        }

        @keyframes buttonSlideUp {
            0% {
                opacity: 0;
                transform: translateX(-50%) translateY(50px);
            }

            100% {
                opacity: 1;
                transform: translateX(-50%) translateY(0);
            }
        }

        @keyframes fadeOut {
            0% {
                opacity: 1;
            }

            100% {
                opacity: 0;
            }
        }

        /* RESPONSIVE */
        @media (max-width: 768px) {
            .welcome-message-box {
                padding: 20px 25px;
                margin: 0 20px;
            }

            .welcome-title {
                font-size: 1.5rem;
            }

            .game-info-card {
                margin: 20px;
                padding: 20px;
            }

            .start-button {
                bottom: 30px;
                padding: 15px 30px;
                font-size: 1.1rem;
            }
        }

        /* Mobile responsive adjustments */
        @media (max-width: 768px) {

            .button-register,
            .button-dashboard {
                font-size: 1rem;
                padding: 14px 16px;
                min-height: 48px;
                border-radius: 10px;
            }

            .word-slot {
                min-width: 80px;
                height: 35px;
                margin: 0 5px;
            }

            .feedback-message {
                font-size: 1rem;
                max-width: 180px;
            }
        }

        @media (max-width: 480px) {

            .button-register,
            .button-dashboard {
                font-size: 0.95rem;
                padding: 16px 12px;
                min-height: 50px;
            }

            .word-slot {
                min-width: 70px;
                height: 32px;
                margin: 0 3px;
            }
        }
    </style>

    <div class="game-container">
        <div id="feedback-area" class="feedback-container">
            <img id="maskot" src="{{ asset('images/maskot/netral.png') }}" alt="Maskot" style="width: 60px; height: 60px;">
            <div id="feedback-text" class="feedback-message">
                Memuat permainan...
            </div>
        </div>

        <!-- Countdown Overlay -->
        <div id="countdown-overlay" class="countdown-overlay hidden">
            <div id="countdown-text" class="countdown-number">3</div>
        </div>

        <!-- Welcome Screen -->
        <div id="welcome-screen" class="welcome-container">
            <!-- Welcome Mascot (Center) -->
            <div id="welcome-mascot-stage" class="welcome-mascot-stage">
                <img id="welcome-maskot" src="{{ asset('images/maskot/smile.png') }}" alt="Maskot">
                <div id="welcome-message-box" class="welcome-message-box">
                    <h2 class="welcome-title">🎯 Pilih Kata yang Cocok</h2>
                    <p class="welcome-subtitle">Selamat datang! Siap menguji kemampuan memilih kata?</p>
                </div>
            </div>

            <!-- Game Info Card -->
            <div id="game-info-card" class="game-info-card">
                <div class="info-content">
                    <div class="info-item">
                        <span class="info-icon">📝</span>
                        <span class="info-text">5 Level dengan tingkat kesulitan berbeda</span>
                    </div>
                    <div class="info-item">
                        <span class="info-icon">🔍</span>
                        <span class="info-text">Pilih kata yang tepat untuk melengkapi kalimat</span>
                    </div>
                    <div class="info-item">
                        <span class="info-icon">✨</span>
                        <span class="info-text">Level 3 memiliki tantangan khusus dengan 2 kata!</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Start Button (Outside card) -->
        <button id="start-game-btn" class="start-button">
            🎮 Mulai Bermain
        </button>

        <div id="game-card" class="card-register hidden">
            <h2 class="text-2xl font-bold mb-4 text-gray-800">Pilih Kata yang Cocok</h2>

            <!-- Game Info -->
            <div class="flex justify-between items-center mb-4 text-sm text-gray-600">
                <span>Level: <span id="current-level" class="font-bold text-teal-600">1</span></span>
                <span>Soal: <span id="current-question" class="font-bold">1</span> / <span id="total-questions"
                        class="font-bold">5</span></span>
            </div>

            <!-- Sentence Display Area -->
            <div id="sentence-display" class="sentence-display">
                <span id="loading-text">Memuat soal...</span>
            </div>

            <!-- Word Options -->
            <div id="words-container" class="grid grid-cols-2 gap-4 mb-6">
                <!-- Words will be populated by JavaScript -->
            </div>

            <!-- Next Button -->
            <button id="next-btn" class="button-register w-full hidden" onclick="nextQuestion()">
                ➡️ Soal Selanjutnya
            </button>
        </div>

        <!-- Score Area -->
        <div id="score-area" class="final-score-card hidden">
            <h2 class="text-3xl font-bold mb-4 text-gray-800">Selesai!</h2>
            <div class="text-6xl mb-6">🎉</div>
            <p class="text-xl mb-6 text-gray-600">Nilai Kamu: <span id="final-score"
                    class="font-extrabold text-green-600 text-3xl block mt-2"></span></p>

            <div class="navigation-container">
                <button onclick="restartGame()" class="button-register px-6 py-3 flex-1">
                    🔄 Main Lagi
                </button>
                <button onclick="window.location.href = '{{ route('dashboard') }}'"
                    class="button-dashboard px-6 py-3 flex-1">
                    🏠 Dashboard
                </button>
            </div>
        </div>
    </div>

    <script>
        // Game data dengan 5 level - PILIH KATA YANG COCOK
        const GAME_DATA = [
            // Level 1
            {
                level: 1,
                sentence: "Tolong .... bunga di taman",
                correctWord: "siram",
                options: ["siram", "seram"]
            },
            // Level 2  
            {
                level: 2,
                sentence: "Ayah naik .... di sawah",
                correctWord: "keledai",
                options: ["keledai", "kedelai"]
            },
            // Level 3 - Dual slot system
            {
                level: 3,
                sentence: ".... naik .... di kota",
                correctAnswers: ["Firman", "Delman"], // Firman naik Delman
                options: ["Firman", "Delman"],
                isDualSlot: true,
                slotsNeeded: 2
            },
            // Level 4
            {
                level: 4,
                sentence: "Ayah punya ternak ....",
                correctWord: "ayam",
                options: ["ayah", "ayam"]
            },
            // Level 5
            {
                level: 5,
                sentence: "Kakek ajak .... naik mobil",
                correctWord: "cucu",
                options: ["cucu", "cuci"]
            }
        ];

        // Game state
        let currentIndex = 0;
        let score = 0;
        let activeQuestions = [];
        let selectedWord = null;
        let isAnimating = false;
        let currentSlot = 1; // Track which slot we're filling for dual slot questions
        let isChecking = false;

        // DOM elements
        const elGameCard = document.getElementById('game-card');
        const elScoreArea = document.getElementById('score-area');
        const elFeedbackArea = document.getElementById('feedback-area');
        const elFeedbackText = document.getElementById('feedback-text');
        const elMaskot = document.getElementById('maskot');
        const elLevel = document.getElementById('current-level');
        const elCurrentQ = document.getElementById('current-question');
        const elTotalQ = document.getElementById('total-questions');
        const elSentenceDisplay = document.getElementById('sentence-display');
        const elWordsContainer = document.getElementById('words-container');
        const elNextBtn = document.getElementById('next-btn');
        const elFinalScore = document.getElementById('final-score');

        // Initialize game
        function initGame() {
            console.log('Initializing game...');

            currentIndex = 0;
            score = 0;
            selectedWord = null;
            isAnimating = false;
            isChecking = false;

            // Setup questions
            activeQuestions = [...GAME_DATA];
            elTotalQ.textContent = activeQuestions.length;

            console.log('Active questions:', activeQuestions);
            console.log('Total questions:', activeQuestions.length);

            // Show welcome screen
            showWelcomeScreen();

            // Speech synthesis - DIHAPUS karena tidak digunakan lagi
            // Game ini fokus visual tanpa audio feedback
        }

        // Restart game without welcome screen (for Main Lagi button)
        function restartGame() {
            console.log('Restarting game without welcome screen...');

            // Reset game state sama seperti initGame
            currentIndex = 0;
            score = 0;
            selectedWord = null;
            isAnimating = false;
            isChecking = false;

            // Setup questions
            activeQuestions = [...GAME_DATA];
            elTotalQ.textContent = activeQuestions.length;

            // Reset UI elements
            elScoreArea.classList.add('hidden');
            elGameCard.classList.add('hidden');
            elFeedbackArea.classList.remove('show');

            // LANGSUNG ke countdown tanpa welcome screen
            startGame();
        }

        // Show welcome screen
        function showWelcomeScreen() {
            const elWelcomeScreen = document.getElementById('welcome-screen');
            const elStartBtn = document.getElementById('start-game-btn');

            // Reset display
            elWelcomeScreen.classList.remove('hidden');
            elGameCard.classList.add('hidden');
            elScoreArea.classList.add('hidden');
            elFeedbackArea.classList.remove('show');

            // Welcome sequence - HAPUS audio welcome
            // Cukup tampil visual saja, tanpa suara welcome

            // Setup start button
            elStartBtn.onclick = () => {
                startGame();
            };
        }

        // Start the actual game
        function startGame() {
            const elWelcomeScreen = document.getElementById('welcome-screen');
            const elStartBtn = document.getElementById('start-game-btn');
            const elCountdownOverlay = document.getElementById('countdown-overlay');
            const elCountdownText = document.getElementById('countdown-text');

            // Hide welcome screen
            elWelcomeScreen.classList.add('hidden');
            elStartBtn.classList.add('hidden');
            elGameCard.classList.add('hidden');
            elFeedbackArea.classList.remove('show');

            setTimeout(() => {
                // Show countdown langsung
                elCountdownOverlay.classList.remove('hidden');

                // Countdown sequence
                let count = 3;
                elCountdownText.textContent = count;
                elCountdownText.className = 'countdown-number';

                const countdownInterval = setInterval(() => {
                    count--;
                    if (count > 0) {
                        elCountdownText.textContent = count;
                        elCountdownText.style.animation = 'none';
                        setTimeout(() => {
                            elCountdownText.style.animation = 'countdownPulse 1s ease-in-out';
                        }, 10);
                    } else {
                        // Show "MULAI!"
                        elCountdownText.textContent = 'MULAI!';
                        elCountdownText.className = 'countdown-start';

                        setTimeout(() => {
                            elCountdownOverlay.classList.add('hidden');

                            // LANGSUNG tampilkan semua elemen BERSAMAAN
                            elGameCard.classList.remove('hidden');
                            elFeedbackArea.classList.add('show');

                            // Start the actual game IMMEDIATELY
                            loadQuestion();
                        }, 1000);

                        clearInterval(countdownInterval);
                    }
                }, 1000);
            }, 100); // Delay minimal untuk restart cepat
        }

        // Load current question
        function loadQuestion() {
            console.log('Loading question, currentIndex:', currentIndex);

            if (currentIndex >= activeQuestions.length) {
                gameComplete();
                return;
            }

            const currentQuestion = activeQuestions[currentIndex];
            console.log('Current question:', currentQuestion);

            // Reset states
            selectedWord = null;
            isAnimating = false;
            currentSlot = 1; // Reset slot counter for dual slot questions
            elNextBtn.classList.add('hidden');

            // Show level instruction
            if (currentIndex === 0) {
                showFeedback('Mari mulai! Pilih kata yang tepat untuk kalimat pertama.', 'neutral');
            } else {
                showFeedback(`Soal ${currentIndex + 1}: Pilih kata yang tepat!`, 'neutral');
            }

            // Update display
            elLevel.textContent = currentQuestion.level;
            elCurrentQ.textContent = currentIndex + 1;

            // Clear containers
            elWordsContainer.innerHTML = '';
            elSentenceDisplay.innerHTML = '';

            // Display sentence with missing word
            if (currentQuestion.isDualSlot) {
                // Handle dual slot (level 3)
                let slotCounter = 0;
                const sentenceWithSlots = currentQuestion.sentence.replace(/\.{4}/g, () => {
                    slotCounter++;
                    if (slotCounter === 1) {
                        return '<span class="word-slot" id="wordSlot1">[pilih kata]</span>';
                    } else {
                        return '<span class="word-slot" id="wordSlot2">[kata ke-2]</span>';
                    }
                });
                elSentenceDisplay.innerHTML = sentenceWithSlots;
            } else {
                // Handle single slot (other levels)
                const sentenceWithSlot = currentQuestion.sentence.replace(/\.{4}/g,
                    '<span class="word-slot" id="wordSlot">[pilih kata]</span>');
                elSentenceDisplay.innerHTML = sentenceWithSlot;
            }
            elSentenceDisplay.classList.remove('has-words');

            console.log('Sentence HTML set');

            // Generate word options
            const shuffledOptions = [...currentQuestion.options].sort(() => Math.random() - 0.5);

            shuffledOptions.forEach((word, index) => {
                const wordCard = document.createElement('div');
                wordCard.className = 'word-card';
                wordCard.textContent = word.charAt(0).toUpperCase() + word.slice(1);
                wordCard.onclick = () => selectWord(wordCard, word);
                elWordsContainer.appendChild(wordCard);
            });

            console.log('Created', shuffledOptions.length, 'word cards');
            console.log('Words container children:', elWordsContainer.children.length);
        }

        // Handle word selection
        function selectWord(cardElement, word) {
            if (isAnimating) {
                return;
            }

            isAnimating = true;
            selectedWord = word;

            // Speak the word
            // HAPUS audio saat klik word - cukup visual feedback

            // Visual feedback
            cardElement.classList.add('selected');

            // Check if correct
            setTimeout(() => {
                const currentQuestion = activeQuestions[currentIndex];
                let isCorrect = false;

                if (currentQuestion.isDualSlot) {
                    // For dual slot, any word is valid during selection
                    isCorrect = currentQuestion.options.includes(word);
                } else {
                    // For single slot, check against correctWord
                    isCorrect = word === currentQuestion.correctWord;
                }

                if (isCorrect) {
                    handleCorrectAnswer(cardElement, word);
                } else {
                    handleWrongAnswer(cardElement, word);
                }
            }, 500);
        }

        // Handle correct answer
        function handleCorrectAnswer(cardElement, word) {
            console.log('Correct answer:', word);

            // Fill the word slot
            const currentQuestion = activeQuestions[currentIndex];

            if (currentQuestion.isDualSlot) {
                // Handle dual slot sequential filling
                const slotElement = document.getElementById(`wordSlot${currentSlot}`);
                if (slotElement) {
                    slotElement.textContent = word;
                    slotElement.classList.add('filled');

                    // Remove the selected card
                    cardElement.style.display = 'none';

                    // Check if we need to fill more slots
                    if (currentSlot < currentQuestion.slotsNeeded) {
                        currentSlot++;
                        selectedWord = null;
                        isAnimating = false;
                        // Update placeholder for remaining slot
                        const nextSlot = document.getElementById(`wordSlot${currentSlot}`);
                        if (nextSlot) {
                            nextSlot.textContent = '[pilih kata]';
                        }
                        return; // Don't show next button yet
                    } else {
                        // All slots filled - now validate the sequence
                        const slot1Text = document.getElementById('wordSlot1').textContent;
                        const slot2Text = document.getElementById('wordSlot2').textContent;

                        console.log('Validating sequence:', slot1Text, 'naik', slot2Text);
                        console.log('Expected:', currentQuestion.correctAnswers[0], 'naik', currentQuestion.correctAnswers[
                            1]);

                        const isSequenceCorrect = slot1Text === currentQuestion.correctAnswers[0] && slot2Text ===
                            currentQuestion.correctAnswers[1];

                        if (isSequenceCorrect) {
                            // Correct sequence: Firman naik Delman
                            score += 20;
                            console.log('Level 3 - Showing success feedback');
                            showFeedback('Benar! Jawabanmu tepat.', 'success');
                            // HAPUS audio feedback - cukup visual
                        } else {
                            // Wrong sequence: Delman naik Firman
                            console.log('Level 3 - Showing error feedback');
                            showFeedback('Salah! Urutan yang benar: Firman naik Delman', 'wrong');
                            document.getElementById('wordSlot1').classList.add('wrong-filled');
                            document.getElementById('wordSlot2').classList.add('wrong-filled');
                            // HAPUS audio feedback - cukup visual
                            // No score for wrong sequence
                        }

                        elSentenceDisplay.classList.add('has-words');
                    }
                }
            } else {
                // Handle single slot (levels 1, 2, 4, 5)
                const slotElement = document.getElementById('wordSlot');
                if (slotElement) {
                    slotElement.textContent = word;
                    slotElement.classList.add('filled');
                    elSentenceDisplay.classList.add('has-words');
                }

                // Update score for single slot
                score += 20;

                // Show success feedback for single slot
                console.log('Single slot - calling showFeedback');
                showFeedback('Benar! Jawabanmu tepat.', 'success');
                // HAPUS audio feedback - cukup visual
            }

            // Show next button (for all levels)
            elNextBtn.classList.remove('hidden');
            isAnimating = false;

            // Hide original card
            cardElement.style.opacity = '0';
            cardElement.style.transform = 'scale(0.8)';
        }

        // Handle wrong answer
        function handleWrongAnswer(cardElement, word) {
            console.log('Wrong answer:', word);

            // Wrong answer animation
            cardElement.classList.remove('selected');
            cardElement.classList.add('wrong');

            // Show wrong feedback immediately
            console.log('Calling showFeedback for wrong answer');
            showFeedback('Salah! Jawaban yang benar akan ditampilkan.', 'wrong');

            // No score for wrong answer
            // Process wrong answer directly without retry
            setTimeout(() => {
                // Hide the wrong card
                cardElement.style.display = 'none';

                const currentQuestion = activeQuestions[currentIndex];

                if (currentQuestion.isDualSlot) {
                    // For dual slot, show correct answer in current slot
                    const slotElement = document.getElementById(`wordSlot${currentSlot}`);
                    if (slotElement) {
                        // Find the correct answer for this position
                        const correctWord = currentQuestion.correctAnswers[currentSlot - 1];
                        slotElement.textContent = correctWord;
                        slotElement.classList.add('filled', 'wrong-filled');

                        currentSlot++;
                        selectedWord = null;
                        isAnimating = false;

                        if (currentSlot <= currentQuestion.slotsNeeded) {
                            const nextSlot = document.getElementById(`wordSlot${currentSlot}`);
                            if (nextSlot) {
                                nextSlot.textContent = '[pilih kata]';
                            }
                            return; // Don't show next button yet
                        } else {
                            elSentenceDisplay.classList.add('has-words');
                        }
                    }
                } else {
                    // For single slot, show correct answer
                    const slotElement = document.getElementById('wordSlot');
                    if (slotElement) {
                        slotElement.textContent = currentQuestion.correctWord;
                        slotElement.classList.add('filled', 'wrong-filled');
                        elSentenceDisplay.classList.add('has-words');
                    }
                }

                // Show next button
                elNextBtn.classList.remove('hidden');
                isAnimating = false;
            }, 1500);

            // Speak wrong feedback
            // HAPUS audio feedback - cukup visual
        }

        // Show feedback with mascot (matching susun.blade.php style)
        function showFeedback(message, type) {
            console.log('Showing feedback:', message, type);

            if (!elFeedbackText || !elFeedbackArea) {
                console.error('Feedback elements not found!');
                return;
            }

            elFeedbackText.textContent = message;
            elFeedbackArea.classList.add('show');

            // Change mascot based on type (with fallback)
            try {
                if (type === 'success') {
                    elMaskot.src = "{{ asset('images/maskot/siku.png') }}";
                } else if (type === 'wrong') {
                    elMaskot.src = "{{ asset('images/maskot/eye.png') }}";
                } else if (type === 'neutral') {
                    elMaskot.src = "{{ asset('images/maskot/smile.png') }}";
                } else {
                    elMaskot.src = "{{ asset('images/maskot/smile.png') }}";
                }
            } catch (e) {
                console.log('Mascot image error:', e);
                // Fallback: use emoji or text
                if (type === 'success') {
                    elMaskot.alt = '😊';
                } else if (type === 'wrong') {
                    elMaskot.alt = '😔';
                } else {
                    elMaskot.alt = '🤔';
                }
            }
        }

        // Next question
        function nextQuestion() {
            currentIndex++;
            loadQuestion();
        }

        // Game complete
        function gameComplete() {
            elGameCard.classList.add('hidden');
            elScoreArea.classList.remove('hidden');
            elFinalScore.textContent = score + ' / ' + (activeQuestions.length * 20);

            // Show completion feedback
            showFeedback('Selamat! Kamu telah menyelesaikan semua level!', 'success');

            // Speak completion message
            // HAPUS audio congratulations - cukup visual
        }

        // Speech synthesis - DIHAPUS karena tidak digunakan lagi
        // Game ini fokus visual tanpa audio feedback

        // Initialize game when page loads
        document.addEventListener('DOMContentLoaded', function() {
            console.log('Page loaded, checking DOM elements...');

            // Check if all elements exist
            console.log('Elements check:', {
                gameCard: !!elGameCard,
                scoreArea: !!elScoreArea,
                feedbackArea: !!elFeedbackArea,
                sentenceDisplay: !!elSentenceDisplay,
                wordsContainer: !!elWordsContainer,
                level: !!elLevel,
                currentQ: !!elCurrentQ,
                totalQ: !!elTotalQ
            });

            // Small delay to ensure DOM is fully ready
            setTimeout(() => {
                console.log('Initializing game...');
                initGame();
            }, 100);
        });
    </script>
@endsection
