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
                   GAME MENGURUTKAN KATA - STYLE
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

        /* SENTENCE DISPLAY AREA - HORIZONTAL LAYOUT */
        .sentence-display {
            min-height: 60px;
            max-height: 80px;
            width: 100%;
            background-color: #f8f9fa;
            border-radius: 1rem;
            margin: 1rem auto;
            padding: 0.75rem 1rem;
            border: 3px dashed #d1d5db;
            display: flex;
            align-items: center;
            justify-content: flex-start;
            gap: 0.75rem;
            flex-wrap: nowrap;
            overflow-x: auto;
            overflow-y: hidden;
            transition: all 0.3s ease;
            scroll-behavior: smooth;
        }

        .sentence-display.has-words {
            border-color: #10b981;
            background-color: #ecfdf5;
        }

        @media (max-width: 768px) {
            .sentence-display {
                min-height: 55px;
                max-height: 70px;
                margin: 0.75rem auto;
                padding: 0.5rem 0.75rem;
                gap: 0.5rem;
            }
        }

        @media (max-width: 480px) {
            .sentence-display {
                min-height: 50px;
                max-height: 65px;
                padding: 0.5rem;
                gap: 0.4rem;
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

        /* Prevent interaction during animation */
        .word-card.clicked {
            pointer-events: none;
            opacity: 0.6;
            transform: scale(0.95);
        }

        /* DUOLINGO-STYLE FLYING ANIMATION */
        .word-card.flying {
            z-index: 1000;
            pointer-events: none;
            animation: flyToTarget 0.6s cubic-bezier(0.25, 0.46, 0.45, 0.94) forwards;
        }

        @keyframes flyToTarget {
            0% {
                transform: scale(1);
                opacity: 1;
            }

            50% {
                transform: scale(1.1) translateY(-20px);
                opacity: 0.9;
            }

            100% {
                transform: scale(1) translateY(0);
                opacity: 1;
            }
        }

        /* WORD CARDS IN SENTENCE - HORIZONTAL */
        .sentence-word {
            background: linear-gradient(90deg, rgba(34, 197, 94, 0.9) 0%, rgba(22, 163, 74, 0.9) 100%);
            color: white;
            border-color: #16a34a;
            animation: placeWord 0.4s ease-out;
            cursor: pointer;
            flex-shrink: 0;
            white-space: nowrap;
            min-width: fit-content;
            font-size: 1rem;
            padding: 8px 16px;
        }

        .sentence-word:hover {
            background: linear-gradient(90deg, rgba(220, 38, 38, 0.9) 0%, rgba(185, 28, 28, 0.9) 100%);
            border-color: #dc2626;
        }

        @keyframes placeWord {
            0% {
                transform: scale(0.8) translateY(-10px);
                opacity: 0;
            }

            100% {
                transform: scale(1) translateY(0);
                opacity: 1;
            }
        }

        /* WORD OPTIONS GRID - COMPACT */
        .words-grid {
            display: flex;
            flex-wrap: wrap;
            gap: 0.75rem;
            justify-content: center;
            margin-top: 1rem;
            min-height: 80px;
            transition: min-height 0.3s ease;
        }

        /* Hide grid when empty */
        .words-grid:empty {
            min-height: 0;
            margin-top: 0;
            display: none;
        }

        @media (max-width: 768px) {
            .words-grid {
                gap: 0.5rem;
                margin-top: 1rem;
                min-height: 100px;
            }
        }

        @media (max-width: 480px) {
            .words-grid {
                gap: 0.5rem;
                margin-top: 0.75rem;
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

        @media (max-width: 768px) {
            .button-register {
                font-size: 1rem;
                padding: 14px 16px;
                min-height: 48px;
                border-radius: 10px;
            }
        }

        @media (max-width: 480px) {
            .button-register {
                font-size: 0.95rem;
                padding: 16px 12px;
                min-height: 50px;
            }
        }

        /* Dashboard Button Style */
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

        @media (max-width: 768px) {
            .button-dashboard {
                font-size: 1rem;
                padding: 14px 16px;
                min-height: 48px;
                border-radius: 10px;
            }
        }

        @media (max-width: 480px) {
            .button-dashboard {
                font-size: 0.95rem;
                padding: 16px 12px;
                min-height: 50px;
            }
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

        @media (max-width: 768px) {
            .navigation-container {
                gap: 10px;
                margin-top: 20px;
                padding: 0 0.5rem;
            }
        }

        @media (max-width: 480px) {
            .navigation-container {
                flex-direction: column;
                gap: 12px;
                margin-top: 15px;
                align-items: center;
                padding: 0;
            }

            .navigation-container .button-register,
            .navigation-container .button-dashboard {
                width: 100%;
                max-width: 280px;
            }
        }

        /* Score Card */
        .final-score-card {
            background-color: white;
            padding: 2.5rem;
            border-radius: 1.5rem;
            text-align: center;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.2);
            max-width: 450px;
            width: 100%;
            margin: 0 1rem;
        }

        @media (max-width: 768px) {
            .final-score-card {
                padding: 2rem;
                border-radius: 1rem;
                max-width: calc(100vw - 2rem);
                margin: 0 0.5rem;
            }
        }

        @media (max-width: 480px) {
            .final-score-card {
                padding: 1.5rem;
                margin: 0 0.25rem;
            }
        }

        .final-score-card.show {
            animation: zoomInBounce 0.7s ease-out;
        }

        @keyframes zoomInBounce {
            0% {
                transform: scale(0.3);
                opacity: 0;
            }

            50% {
                transform: scale(1.05);
                opacity: 0.8;
            }

            100% {
                transform: scale(1);
                opacity: 1;
            }
        }

        /* Hidden class */
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

        /* WELCOME ANIMATIONS */
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

        /* RESPONSIVE FOR WELCOME */
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

        /* Instruction text - centered untuk horizontal layout */
        .instruction-text {
            color: #6b7280;
            font-size: 0.9rem;
            font-style: italic;
            text-align: center;
            width: 100%;
            margin: 0;
        }

        @media (max-width: 480px) {
            .instruction-text {
                font-size: 0.85rem;
            }
        }

        /* CLEAR BUTTON */
        .clear-button {
            background: linear-gradient(90deg, rgba(239, 68, 68, 0.9) 0%, rgba(220, 38, 38, 0.9) 100%);
            color: white;
            border: none;
            border-radius: 8px;
            padding: 8px 16px;
            font-size: 0.9rem;
            font-weight: bold;
            cursor: pointer;
            transition: all 0.2s ease;
            margin-top: 0.5rem;
        }

        .clear-button:hover {
            transform: translateY(-1px);
            filter: brightness(1.1);
        }

        .clear-button:active {
            transform: translateY(0);
        }

        /* Custom scrollbar untuk sentence display */
        .sentence-display::-webkit-scrollbar {
            height: 6px;
        }

        .sentence-display::-webkit-scrollbar-track {
            background: #f1f5f9;
            border-radius: 3px;
        }

        .sentence-display::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 3px;
        }

        .sentence-display::-webkit-scrollbar-thumb:hover {
            background: #94a3b8;
        }

        /* Responsive word cards sizing */
        @media (max-width: 768px) {
            .sentence-word {
                font-size: 0.9rem;
                padding: 6px 12px;
            }
        }

        @media (max-width: 480px) {
            .sentence-word {
                font-size: 0.85rem;
                padding: 5px 10px;
            }
        }
    </style>

    <div class="game-container">
        <div id="feedback-area" class="feedback-container">
            <img id="maskot" src="{{ asset('images/maskot/netral.png') }}" alt="Maskot" style="width: 60px; height: 60px;">
            <div id="feedback-text" class="feedback-message">
                Susun kata-kata menjadi kalimat yang benar!
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
                    <h2 class="welcome-title">🔥 Susun Kata dengan Benar</h2>
                    <p class="welcome-subtitle">Siap menguji kemampuan menyusun kata jadi kalimat?</p>
                </div>
            </div>

            <!-- Game Info Card -->
            <div id="game-info-card" class="game-info-card">
                <div class="info-content">
                    <div class="info-item">
                        <span class="info-icon">📝</span>
                        <span class="info-text">5 Level dengan kalimat yang berbeda</span>
                    </div>
                    <div class="info-item">
                        <span class="info-icon">✨</span>
                        <span class="info-text">Susun kata-kata menjadi kalimat yang benar</span>
                    </div>
                    <div class="info-item">
                        <span class="info-icon">🎨</span>
                        <span class="info-text">Dengan animasi terbang yang menarik!</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Start Button (Outside card) -->
        <button id="start-game-btn" class="start-button">
            🚀 Mulai Bermain
        </button>

        <div id="game-card" class="card-register hidden">
            <h2 class="text-2xl font-bold mb-4 text-gray-800">Mengurutkan Kata</h2>

            <!-- Game Info -->
            <div class="flex justify-between items-center mb-4 text-sm text-gray-600">
                <span>Level: <span id="current-level" class="font-bold text-teal-600">1</span></span>
                <span>Soal: <span id="current-question" class="font-bold">1</span> / <span id="total-questions"
                        class="font-bold">5</span></span>
            </div>

            <!-- Sentence Display Area -->
            <div id="sentence-display" class="sentence-display">
                <span class="instruction-text">Klik kata-kata di bawah untuk menyusun kalimat</span>
            </div>

            <!-- Clear Button -->
            <button id="clear-btn" class="clear-button hidden" onclick="clearSentence()">
                🗑️ Bersihkan
            </button>

            <!-- Word Options -->
            <div id="words-container" class="words-grid">
                <!-- Words will be populated by JavaScript -->
            </div>

            <!-- Check Answer Button -->
            <button id="check-btn" class="button-register w-full mt-6 hidden" onclick="checkAnswer()">
                ✅ Periksa Jawaban
            </button>

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
        // Game data dengan 5 level
        const GAME_DATA = [
            // Level 1 - 3 kata
            {
                level: 1,
                words: ['Budi', 'Beli', 'Apel'],
                correct: 'Budi Beli Apel'
            },

            // Level 2 - 3 kata
            {
                level: 2,
                words: ['Ibu', 'Beli', 'Labu'],
                correct: 'Ibu Beli Labu'
            },

            // Level 3 - 3 kata
            {
                level: 3,
                words: ['Kasur', 'Aku', 'Rusak'],
                correct: 'Kasur Aku Rusak'
            },

            // Level 4 - 4 kata
            {
                level: 4,
                words: ['Kata', 'Baku', 'di', 'Buku'],
                correct: 'Kata Baku di Buku'
            },

            // Level 5 - 4 kata
            {
                level: 5,
                words: ['Nama', 'Mama', 'Saya', 'Nana'],
                correct: 'Nama Mama Saya Nana'
            }
        ];

        // Game state
        let currentIndex = 0;
        let score = 0;
        let activeQuestions = [];
        let currentSentence = [];
        let availableWords = [];
        let isAnimating = false; // Prevent double clicks during animation
        let isChecking = false; // Prevent multiple check submissions

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
        const elCheckBtn = document.getElementById('check-btn');
        const elNextBtn = document.getElementById('next-btn');
        const elClearBtn = document.getElementById('clear-btn');

        // Speech synthesis - DIHAPUS karena tidak digunakan lagi
        // Game ini fokus visual tanpa audio feedback

        function initGame() {
            console.log('Initializing word sorting game...');

            // Reset game state
            currentIndex = 0;
            score = 0;
            currentSentence = [];
            availableWords = [];
            isAnimating = false;
            isChecking = false;

            // Setup questions - sequential dari level 1-5
            activeQuestions = GAME_DATA.slice(); // Copy semua soal
            elTotalQ.textContent = activeQuestions.length;

            // Show welcome screen
            showWelcomeScreen();
        }

        // Restart game without welcome screen (for Main Lagi button)
        function restartGame() {
            console.log('Restarting word sorting game without welcome screen...');

            // Reset game state sama seperti initGame
            currentIndex = 0;
            score = 0;
            currentSentence = [];
            availableWords = [];
            isAnimating = false;
            isChecking = false;

            // Setup questions - sequential dari level 1-5
            activeQuestions = GAME_DATA.slice();
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

                            // Reset feedback
                            setFeedback('neutral', 'Susun kata-kata menjadi kalimat yang benar!');

                            // Start the actual game IMMEDIATELY
                            loadQuestion();
                        }, 1000);

                        clearInterval(countdownInterval);
                    }
                }, 1000);
            }, 100); // Delay minimal untuk restart cepat
        }

        function loadQuestion() {
            if (currentIndex >= activeQuestions.length) {
                finishGame();
                return;
            }

            const q = activeQuestions[currentIndex];

            // Update UI Info
            elLevel.textContent = q.level;
            elCurrentQ.textContent = currentIndex + 1;

            // Reset sentence and buttons
            currentSentence = [];
            elSentenceDisplay.innerHTML =
                '<span class="instruction-text">Klik kata-kata di bawah untuk menyusun kalimat</span>';
            elSentenceDisplay.classList.remove('has-words');
            elCheckBtn.classList.add('hidden');
            elNextBtn.classList.add('hidden');
            elClearBtn.classList.add('hidden');

            // Reset states
            isAnimating = false;
            isChecking = false;
            elCheckBtn.disabled = false;

            // Setup available words (shuffle them)
            availableWords = [...q.words].sort(() => Math.random() - 0.5);

            // Force clear any remaining elements
            elWordsContainer.innerHTML = '';

            // Render word options with delay to ensure DOM is ready
            setTimeout(() => {
                renderWords();
                forceUIRefresh(); // Force UI refresh after loading question
            }, 100);

            console.log('Loaded question:', q, 'Available words:', availableWords);
        }

        function renderWords() {
            // Clear container completely
            elWordsContainer.innerHTML = '';

            // Debug log
            console.log('Rendering words:', availableWords);

            // Only render if there are available words
            if (availableWords.length === 0) {
                console.log('No words to render');
                forceUIRefresh(); // Force UI refresh when no words
                return;
            }

            availableWords.forEach((word, index) => {
                const wordCard = document.createElement('div');
                wordCard.className = 'word-card';
                wordCard.textContent = word;
                wordCard.dataset.word = word;
                wordCard.onclick = () => selectWord(wordCard, word);

                // Ensure clean state
                wordCard.classList.remove('clicked');
                wordCard.style.opacity = '1';
                wordCard.style.transform = 'none';

                // Entrance animation delay
                wordCard.style.animationDelay = `${index * 0.1}s`;

                elWordsContainer.appendChild(wordCard);
            });

            // Force UI refresh after rendering all words
            forceUIRefresh();
        }

        function selectWord(cardElement, word) {
            // Debounce clicks and prevent double clicks during animation
            if (isAnimating || cardElement.classList.contains('clicked')) {
                console.log('Click blocked - animation in progress or already clicked');
                return;
            }

            // Use debounce to prevent rapid clicks
            return debounceClick(cardElement, () => {
                // Mark as clicked to prevent multiple selections
                cardElement.classList.add('clicked');
                isAnimating = true;

                // Duolingo-style flying animation
                const rect = cardElement.getBoundingClientRect();
                const targetRect = elSentenceDisplay.getBoundingClientRect();

                // Clone the card for animation
                const flyingCard = cardElement.cloneNode(true);
                flyingCard.classList.add('flying');
                flyingCard.style.position = 'fixed';
                flyingCard.style.left = rect.left + 'px';
                flyingCard.style.top = rect.top + 'px';
                flyingCard.style.width = rect.width + 'px';
                flyingCard.style.height = rect.height + 'px';
                flyingCard.style.zIndex = '1000';

                document.body.appendChild(flyingCard);

                // Animate to target
                requestAnimationFrame(() => {
                    flyingCard.style.transition = 'all 0.6s cubic-bezier(0.25, 0.46, 0.45, 0.94)';
                    flyingCard.style.left = (targetRect.left + targetRect.width / 2 - rect.width / 2) +
                        'px';
                    flyingCard.style.top = (targetRect.top + targetRect.height / 2 - rect.height / 2) +
                        'px';
                    flyingCard.style.transform = 'scale(0.9)';
                });

                // Remove original card and flying card after animation
                setTimeout(() => {
                    if (document.body.contains(flyingCard)) {
                        document.body.removeChild(flyingCard);
                    }
                    addWordToSentence(word);
                    removeWordFromOptions(word);
                    isAnimating = false; // Reset animation state
                }, 600);

                // Hide original immediately
                cardElement.style.opacity = '0';
                cardElement.style.transform = 'scale(0.8)';

            }, 300); // Debounce delay
        }

        function addWordToSentence(word) {
            // Prevent duplicate additions with multiple checks
            if (currentSentence.includes(word)) {
                console.log('Word already in sentence:', word);
                return;
            }

            // Double check if word is still in available words
            if (!availableWords.includes(word)) {
                console.log('Word not available:', word);
                return;
            }

            currentSentence.push(word);
            console.log('Added to sentence:', word, 'Current sentence:', currentSentence);

            updateSentenceDisplay();

            // Show buttons if needed
            if (currentSentence.length > 0) {
                elCheckBtn.classList.remove('hidden');
                elClearBtn.classList.remove('hidden');
            }
        }

        function removeWordFromOptions(word) {
            // Remove word from available options
            const wordIndex = availableWords.indexOf(word);
            if (wordIndex > -1) {
                availableWords.splice(wordIndex, 1);
            }

            // Force re-render
            renderWords();
            forceUIRefresh(); // Force UI refresh after removing word

            // Debug log
            console.log('Removed word:', word, 'Available words:', availableWords);
        }

        function updateSentenceDisplay() {
            if (currentSentence.length === 0) {
                elSentenceDisplay.innerHTML =
                    '<span class="instruction-text">Klik kata-kata di bawah untuk menyusun kalimat</span>';
                elSentenceDisplay.classList.remove('has-words');
                return;
            }

            elSentenceDisplay.classList.add('has-words');
            elSentenceDisplay.innerHTML = '';

            currentSentence.forEach((word, index) => {
                const wordElement = document.createElement('div');
                wordElement.className = 'word-card sentence-word';
                wordElement.textContent = word;
                wordElement.onclick = () => removeWordFromSentence(index);
                elSentenceDisplay.appendChild(wordElement);
            });

            // Auto-scroll to show latest word
            setTimeout(() => {
                elSentenceDisplay.scrollLeft = elSentenceDisplay.scrollWidth;
            }, 50);
        }

        function removeWordFromSentence(index) {
            // Prevent removal during animation
            if (isAnimating) {
                return;
            }

            const word = currentSentence[index];
            currentSentence.splice(index, 1);
            availableWords.push(word);

            updateSentenceDisplay();
            renderWords();

            // Hide buttons if sentence is empty
            if (currentSentence.length === 0) {
                elCheckBtn.classList.add('hidden');
                elClearBtn.classList.add('hidden');
            }

            console.log('Removed from sentence:', word, 'Current sentence:', currentSentence);
        }

        function clearSentence() {
            // Prevent multiple clears during animation
            if (isAnimating) {
                return;
            }

            // Return all words to options
            availableWords.push(...currentSentence);
            currentSentence = [];

            // Reset states
            isAnimating = false;
            isChecking = false;

            updateSentenceDisplay();
            renderWords();
            forceUIRefresh(); // Force UI refresh after clearing sentence

            elCheckBtn.classList.add('hidden');
            elClearBtn.classList.add('hidden');

            console.log('Cleared sentence. Available words:', availableWords);
        }

        function checkAnswer() {
            // Prevent multiple submissions
            if (isChecking) {
                return;
            }

            isChecking = true;
            elCheckBtn.disabled = true;

            const q = activeQuestions[currentIndex];
            const userAnswer = currentSentence.join(' ');

            console.log('User answer:', userAnswer);
            console.log('Correct answer:', q.correct);

            if (userAnswer === q.correct) {
                score++;
                setFeedback('correct', 'Tepat sekali! Susunan kata benar!');
                // HAPUS audio maskot - cukup visual feedback
            } else {
                setFeedback('wrong', `Belum tepat. Jawaban yang benar: "${q.correct}"`);
                // HAPUS audio maskot - cukup visual feedback
            }

            elCheckBtn.classList.add('hidden');
            elNextBtn.classList.remove('hidden');

            // Reset checking state
            setTimeout(() => {
                isChecking = false;
                elCheckBtn.disabled = false;
            }, 500);
        }

        function nextQuestion() {
            // Prevent multiple clicks
            if (isAnimating) {
                return;
            }

            elNextBtn.classList.add('hidden');
            elNextBtn.disabled = true;
            currentIndex++;

            // Reset states
            isAnimating = false;
            isChecking = false;

            if (currentIndex < activeQuestions.length) {
                setFeedback('neutral', 'Susun kata selanjutnya...');
                loadQuestion();
            } else {
                finishGame();
            }

            // Re-enable next button after delay
            setTimeout(() => {
                elNextBtn.disabled = false;
            }, 300);
        }

        function finishGame() {
            elGameCard.classList.add('hidden');
            elFeedbackArea.classList.remove('show');

            setTimeout(() => {
                elScoreArea.classList.remove('hidden');
                elScoreArea.classList.add('show');

                const percentage = Math.round((score / activeQuestions.length) * 100);
                document.getElementById('final-score').textContent = percentage + '%';
                // HAPUS audio skor final - cukup tampil visual saja
            }, 300);
        }

        function setFeedback(state, message) {
            elFeedbackText.textContent = message;
            elFeedbackArea.classList.add('show');

            if (state === 'correct') {
                elMaskot.src = "{{ asset('images/maskot/siku.png') }}";
            } else if (state === 'wrong') {
                elMaskot.src = "{{ asset('images/maskot/eye.png') }}";
            } else {
                elMaskot.src = "{{ asset('images/maskot/smile.png') }}";
            }
        }

        // Force UI refresh function
        function forceUIRefresh() {
            // Force DOM reflow
            elWordsContainer.style.display = 'none';
            elWordsContainer.offsetHeight; // Trigger reflow
            elWordsContainer.style.display = '';

            // Update container visibility
            if (availableWords.length === 0) {
                elWordsContainer.style.minHeight = '0';
                elWordsContainer.style.marginTop = '0';
            } else {
                elWordsContainer.style.minHeight = '';
                elWordsContainer.style.marginTop = '';
            }
        }

        // Debounce function to prevent rapid clicks
        const clickTimestamps = new Map();

        function debounceClick(element, callback, delay = 500) {
            const now = Date.now();
            const lastClick = clickTimestamps.get(element) || 0;

            if (now - lastClick < delay) {
                console.log('Click debounced');
                return false;
            }

            clickTimestamps.set(element, now);
            return callback();
        }

        // Initialize game when page loads
        document.addEventListener('DOMContentLoaded', function() {
            console.log('Page loaded, initializing game...');
            initGame();
        });
    </script>
@endsection
