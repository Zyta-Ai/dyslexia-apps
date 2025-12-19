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
                           RAPID AUTOMATIC NAMING (RAN) - STYLE
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
            background: linear-gradient(90deg, rgba(167, 222, 212, 0.7) 0%, rgba(123, 188, 174, 0.7) 100%);
            border-radius: 1.5rem;
            padding: 1.5rem;
            width: 100%;
            max-width: 800px;
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

        /* TIMER DISPLAY */
        .timer-container {
            position: absolute;
            top: 20px;
            right: 20px;
            background: linear-gradient(135deg, #ef4444, #dc2626);
            color: white;
            padding: 10px 20px;
            border-radius: 50px;
            font-weight: bold;
            font-size: 1.2rem;
            box-shadow: 0 4px 15px rgba(239, 68, 68, 0.3);
            animation: pulse 2s infinite;
            z-index: 10;
        }

        .timer-container.warning {
            animation: urgentBlink 0.5s infinite;
            background: linear-gradient(135deg, #dc2626, #b91c1c);
        }

        @keyframes pulse {

            0%,
            100% {
                transform: scale(1);
            }

            50% {
                transform: scale(1.05);
            }
        }

        @keyframes urgentBlink {

            0%,
            100% {
                opacity: 1;
            }

            50% {
                opacity: 0.7;
            }
        }

        /* GRID STIMULUS AREA */
        .stimulus-grid {
            display: flex;
            justify-content: center;
            align-items: center;
            margin: 20px 0;
            padding: 30px;
            background: rgba(255, 255, 255, 0.9);
            border-radius: 20px;
            border: 3px dashed #9ca3af;
            min-height: 180px;
        }

        @media (max-width: 1024px) {
            .stimulus-grid {
                grid-template-columns: repeat(3, 1fr);
                gap: 18px;
                padding: 25px;
                min-height: 320px;
            }
        }

        @media (max-width: 768px) {
            .stimulus-grid {
                grid-template-columns: repeat(2, 1fr);
                gap: 15px;
                padding: 20px;
                min-height: 280px;
            }
        }

        @media (max-width: 480px) {
            .stimulus-grid {
                grid-template-columns: repeat(2, 1fr);
                gap: 12px;
                padding: 15px;
                min-height: 240px;
            }
        }

        /* STIMULUS ITEMS */
        .stimulus-item {
            width: 120px;
            height: 120px;
            border-radius: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 3.5rem;
            font-weight: bold;
            color: white;
            text-shadow: 3px 3px 6px rgba(0, 0, 0, 0.4);
            cursor: pointer;
            transition: all 0.3s ease;
            border: 4px solid rgba(255, 255, 255, 0.9);
            box-shadow: 0 6px 15px rgba(0, 0, 0, 0.25);
        }

        @media (max-width: 1024px) {
            .stimulus-item {
                width: 100px;
                height: 100px;
                font-size: 3rem;
                border-radius: 18px;
            }
        }

        @media (max-width: 768px) {
            .stimulus-item {
                width: 90px;
                height: 90px;
                font-size: 2.5rem;
                border-radius: 15px;
            }
        }

        @media (max-width: 480px) {
            .stimulus-item {
                width: 80px;
                height: 80px;
                font-size: 2rem;
                border-radius: 12px;
            }
        }

        .stimulus-item:hover {
            transform: scale(1.1);
            box-shadow: 0 6px 15px rgba(0, 0, 0, 0.3);
        }

        .stimulus-item.correct {
            animation: correctFlash 0.5s ease;
            transform: scale(1.2);
        }

        .stimulus-item.wrong {
            animation: wrongShake 0.5s ease;
        }

        @keyframes correctFlash {

            0%,
            100% {
                background-color: inherit;
            }

            50% {
                background-color: #22c55e;
            }
        }

        @keyframes wrongShake {

            0%,
            100% {
                transform: translateX(0);
            }

            25% {
                transform: translateX(-5px);
            }

            75% {
                transform: translateX(5px);
            }
        }

        /* ANSWER OPTIONS */
        .answer-options {
            display: flex;
            flex-wrap: wrap;
            gap: 18px;
            justify-content: center;
            margin-top: 25px;
            padding: 0 10px;
        }

        @media (max-width: 768px) {
            .answer-options {
                gap: 15px;
                margin-top: 20px;
            }
        }

        @media (max-width: 480px) {
            .answer-options {
                gap: 12px;
                margin-top: 15px;
                justify-content: space-around;
            }
        }

        .answer-btn {
            background: linear-gradient(135deg, #f59e0b, #d97706, #b45309);
            color: white;
            border: none;
            padding: 16px 28px;
            border-radius: 30px;
            font-size: 1.2rem;
            font-weight: bold;
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: 0 5px 15px rgba(245, 158, 11, 0.4);
            min-width: 130px;
            text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.3);
        }

        @media (max-width: 768px) {
            .answer-btn {
                min-width: 110px;
                padding: 14px 24px;
                font-size: 1.1rem;
                border-radius: 25px;
            }
        }

        @media (max-width: 480px) {
            .answer-btn {
                min-width: 100px;
                padding: 12px 20px;
                font-size: 1rem;
                border-radius: 20px;
                box-shadow: 0 4px 10px rgba(245, 158, 11, 0.3);
            }
        }

        .answer-btn:hover {
            transform: translateY(-3px) scale(1.02);
            box-shadow: 0 8px 20px rgba(245, 158, 11, 0.5);
            background: linear-gradient(135deg, #fbbf24, #f59e0b, #d97706);
        }

        /* OVERRIDE KHUSUS UNTUK MISLEADING BUTTONS */
        .answer-btn.misleading:hover {
            background: var(--misleading-color) !important;
            background-image: none !important;
            transform: translateY(-2px) scale(1.02) !important;
            filter: brightness(1.1) !important;
        }

        .answer-btn:active {
            transform: translateY(-1px) scale(0.98);
            transition: all 0.1s ease;
        }

        .answer-btn.selected {
            background: linear-gradient(135deg, #16a34a, #15803d);
            transform: scale(1.05);
            box-shadow: 0 6px 18px rgba(22, 163, 74, 0.4);
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

        /* PROGRESS BAR */
        .progress-container {
            width: 100%;
            background-color: rgba(255, 255, 255, 0.3);
            border-radius: 10px;
            margin: 10px 0;
            overflow: hidden;
        }

        .progress-bar {
            height: 8px;
            background: linear-gradient(90deg, #16a34a, #22c55e);
            border-radius: 10px;
            transition: width 0.3s ease;
            width: 0%;
        }

        /* GAME INFO */
        .game-info {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
            gap: 20px;
            flex-wrap: wrap;
        }

        @media (max-width: 768px) {
            .game-info {
                justify-content: center;
                gap: 15px;
            }
        }

        @media (max-width: 480px) {
            .game-info {
                flex-direction: column;
                gap: 10px;
            }
        }

        .info-item {
            background: rgba(255, 255, 255, 0.9);
            padding: 12px 18px;
            border-radius: 18px;
            font-weight: bold;
            color: #374151;
            box-shadow: 0 3px 8px rgba(0, 0, 0, 0.12);
            min-width: 100px;
            text-align: center;
            transition: all 0.2s ease;
        }

        .info-item:hover {
            transform: translateY(-1px);
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.15);
        }

        @media (max-width: 480px) {
            .info-item {
                padding: 10px 15px;
                border-radius: 15px;
                min-width: 80px;
                font-size: 0.9rem;
            }
        }

        /* FINAL SCORE */
        .final-score-card {
            background: linear-gradient(135deg, #f3f4f6, #e5e7eb);
            border-radius: 1.5rem;
            padding: 2rem;
            text-align: center;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
            border: 2px solid rgba(255, 255, 255, 0.5);
        }

        /* NAVIGATION BUTTONS */
        .navigation-container {
            display: flex;
            gap: 1rem;
            margin-top: 1.5rem;
            justify-content: center;
        }

        @media (max-width: 480px) {
            .navigation-container {
                flex-direction: column;
                gap: 0.5rem;
            }
        }

        .button-register {
            background: linear-gradient(90deg, rgba(59, 130, 246, 1) 0%, rgba(37, 99, 235, 1) 100%);
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

        .hidden {
            display: none !important;
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

        /* AUDIO CONTROLS */
        .audio-control {
            background: linear-gradient(135deg, #8b5cf6, #7c3aed);
            color: white;
            border: none;
            border-radius: 50%;
            width: 80px;
            height: 80px;
            font-size: 2rem;
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(139, 92, 246, 0.3);
            margin: 0 auto 20px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .audio-control:hover {
            transform: scale(1.1) translateY(-2px);
            box-shadow: 0 6px 20px rgba(139, 92, 246, 0.4);
        }

        .audio-control:active {
            transform: scale(0.95);
        }

        .audio-control.playing {
            animation: audioPlaying 1s ease-in-out infinite;
            background: linear-gradient(135deg, #ec4899, #db2777);
        }

        @keyframes audioPlaying {

            0%,
            100% {
                transform: scale(1);
            }

            50% {
                transform: scale(1.05);
            }
        }

        /* MISLEADING BUTTONS - FORCE OVERRIDE */
        .answer-btn.misleading {
            transition: all 0.2s ease !important;
        }

        .answer-btn.misleading:hover {
            transform: scale(1.02) !important;
            filter: brightness(1.1) !important;
            opacity: 0.9 !important;
        }

        /* FORCE OVERRIDE SEMUA GRADIENT BACKGROUND */
        .answer-btn.misleading {
            background-image: none !important;
            background: var(--misleading-color) !important;
        }

        /* Level description */
        .level-description {
            background: rgba(255, 255, 255, 0.9);
            padding: 10px 15px;
            border-radius: 20px;
            margin: 10px 0;
            font-size: 0.9rem;
            color: #374151;
            font-style: italic;
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

        /* Quick animations for smoother gameplay */
        .stimulus-item {
            transition: all 0.2s ease;
        }

        .stimulus-item.correct {
            animation: quickFlash 0.3s ease-out;
        }

        .stimulus-item.wrong {
            animation: quickShake 0.3s ease-out;
        }

        @keyframes quickFlash {

            0%,
            100% {
                transform: scale(1);
            }

            50% {
                transform: scale(1.05);
                box-shadow: 0 0 15px #22c55e;
            }
        }

        @keyframes quickShake {

            0%,
            100% {
                transform: translateX(0);
            }

            25% {
                transform: translateX(-5px);
            }

            75% {
                transform: translateX(5px);
            }
        }

        /* NO ANIMATION untuk progress bar saat pertama load */
        .progress-bar {
            transition: width 0.2s ease-out;
        }

        .progress-bar.no-animation {
            transition: none !important;
        }

        /* Quick feedback tanpa bounce berlebihan */
        .feedback-container.show {
            animation: quickBounceIn 0.2s ease-out;
        }

        /* Hilangkan animasi untuk elements UI */
        .game-info .info-item {
            opacity: 1 !important;
            transform: none !important;
            animation: none !important;
        }

        @keyframes quickBounceIn {
            0% {
                transform: scale(0.8);
                opacity: 0;
            }

            100% {
                transform: scale(1);
                opacity: 1;
            }
        }

        @keyframes fadeIn {
            0% {
                opacity: 0;
                transform: scale(0.95);
            }

            100% {
                opacity: 1;
                transform: scale(1);
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

            .audio-control {
                width: 60px;
                height: 60px;
                font-size: 1.5rem;
            }

            .countdown-number {
                font-size: 5rem;
            }

            .countdown-start {
                font-size: 2.5rem;
            }
        }
    </style>

    <div class="min-h-screen bg-gray-50">
        <!-- Countdown Overlay -->
        <div id="countdown-overlay" class="countdown-overlay hidden">
            <div id="countdown-text" class="countdown-number">3</div>
        </div>

        <!-- Timer (floating) -->
        <div id="timer-display" class="timer-container">
            ⏱️ <span id="timer-seconds">60</span>s
        </div>

        <div class="game-container">
            <!-- Feedback Area -->
            <div id="feedback-area" class="feedback-container">
                <img id="maskot" src="{{ asset('images/maskot/smile.png') }}" alt="Maskot"
                    style="width: 60px; height: 60px;">
                <div id="feedback-text" class="feedback-message">
                    Lihat warna/huruf dan klik jawabannya secepat mungkin!
                </div>
            </div>

            <!-- Welcome Screen -->
            <div id="welcome-screen" class="welcome-container">
                <!-- Welcome Mascot (Center) -->
                <div id="welcome-mascot-stage" class="welcome-mascot-stage">
                    <img id="welcome-maskot" src="{{ asset('images/maskot/smile.png') }}" alt="Maskot">
                    <div id="welcome-message-box" class="welcome-message-box">
                        <h2 class="welcome-title">⚡ RAN (Rapid Automatic Naming)</h2>
                        <p class="welcome-subtitle">Siap menguji kecepatan dan ketepatan namamu?</p>
                    </div>
                </div>

                <!-- Game Info Card -->
                <div id="game-info-card" class="game-info-card">
                    <div class="info-content">
                        <div class="info-item">
                            <span class="info-icon">🌈</span>
                            <span class="info-text">Level 1-2: Warna dengan tantangan tombol menyesatkan</span>
                        </div>
                        <div class="info-item">
                            <span class="info-icon">🔊</span>
                            <span class="info-text">Level 3-5: Huruf b,d,p,q dengan audio mengecoh</span>
                        </div>
                        <div class="info-item">
                            <span class="info-icon">⏱️</span>
                            <span class="info-text">5 Level total - semakin cepat, semakin tinggi skor!</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Start Button (Outside card) -->
            <button id="start-game-btn" class="start-button">
                ⚡ Mulai Bermain
            </button>

            <!-- Game Card -->
            <div id="game-card" class="card-register hidden">
                <h2 class="text-2xl font-bold mb-4 text-gray-800">Rapid Automatic Naming</h2>

                <!-- Game Info -->
                <div class="game-info">
                    <div class="info-item">
                        Level: <span id="current-level">1</span>
                    </div>
                    <div class="info-item">
                        Progress: <span id="current-progress">0</span> / <span id="total-items">20</span>
                    </div>
                    <div class="info-item">
                        Score: <span id="current-score">0</span>
                    </div>
                </div>

                <!-- Progress Bar -->
                <div class="progress-container">
                    <div id="progress-bar" class="progress-bar"></div>
                </div>

                <!-- Level Description -->
                <div id="level-description" class="level-description">
                    <!-- Deskripsi level akan di-generate oleh JavaScript -->
                </div>

                <!-- Audio Control (for letter levels) -->
                <div id="audio-control-container" class="text-center hidden">
                    <button id="audio-control" class="audio-control">
                        🔊
                    </button>
                    <p class="text-sm text-gray-600 mb-4">Klik speaker untuk mendengar huruf</p>
                </div>

                <!-- Stimulus Grid -->
                <div id="stimulus-grid" class="stimulus-grid">
                    <!-- Stimulus items akan di-generate oleh JavaScript -->
                </div>

                <!-- Answer Options -->
                <div id="answer-options" class="answer-options">
                    <!-- Answer buttons akan di-generate oleh JavaScript -->
                </div>

                <!-- Next Level Button -->
                <button id="next-level-btn" class="button-register px-6 py-3 mt-4 hidden">
                    ➡️ Level Selanjutnya
                </button>
            </div>

            <!-- Final Score Area -->
            <div id="score-area" class="final-score-card hidden">
                <h2 class="text-3xl font-bold mb-4 text-gray-800">Selesai!</h2>
                <div class="text-6xl mb-6">🎉</div>
                <p class="text-xl mb-6 text-gray-600">Skor Akhir: <span id="final-score"
                        class="font-extrabold text-green-600 text-3xl block mt-2"></span></p>
                <p class="text-lg mb-6 text-gray-600">Waktu: <span id="time-bonus"
                        class="font-bold text-blue-600"></span> detik</p>

                <div class="navigation-container">
                    <button onclick="initGame(true)" class="button-register px-6 py-3 flex-1">
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
            // Game data untuk RAN - 5 Level Total
            const GAME_DATA = [
                // Level 1 - RAN Warna Normal (tanpa teks di stimulus)
                {
                    level: 1,
                    type: 'colors_normal',
                    title: 'RAN Warna - Level 1',
                    description: 'Pilih nama warna yang sesuai',
                    colors: ['#dc2626', '#eab308', '#2563eb', '#16a34a'],
                    answers: ['MERAH', 'KUNING', 'BIRU', 'HIJAU'],
                    totalItems: 2,
                    misleadingButtons: false
                },
                // Level 2 - RAN Warna dengan Tombol Menyesatkan
                {
                    level: 2,
                    type: 'colors_misleading',
                    title: 'RAN Warna - Level 2',
                    description: 'Hati-hati! Warna tombol tidak sesuai teks',
                    colors: ['#dc2626', '#eab308', '#2563eb', '#16a34a'],
                    answers: ['MERAH', 'KUNING', 'BIRU', 'HIJAU'],
                    buttonColors: ['#eab308', '#16a34a', '#dc2626',
                        '#2563eb'
                    ], // MERAH→KUNING, KUNING→HIJAU, BIRU→MERAH, HIJAU→BIRU
                    totalItems: 2,
                    misleadingButtons: true
                },
                // Level 3 - RAN Huruf dengan Audio (Mudah)
                {
                    level: 3,
                    type: 'letters_audio',
                    title: 'RAN Huruf - Level 1',
                    description: 'Dengarkan dan pilih huruf yang tepat',
                    stimuli: ['b', 'd', 'p', 'q'],
                    answers: ['b', 'd', 'p', 'q'],
                    audioTexts: ['beh', 'deh', 'peh', 'kiu'],
                    totalItems: 2,
                    audioConfusing: false
                },
                // Level 4 - RAN Huruf dengan Audio (Sedang)
                {
                    level: 4,
                    type: 'letters_audio',
                    title: 'RAN Huruf - Level 2',
                    description: 'Audio sedikit mengecoh, dengarkan baik-baik',
                    stimuli: ['b', 'd', 'p', 'q'],
                    answers: ['b', 'd', 'p', 'q'],
                    audioTexts: ['beh', 'deh', 'peh', 'kiu'],
                    totalItems: 2,
                    audioConfusing: true
                },
                // Level 5 - RAN Huruf dengan Audio (Sulit)
                {
                    level: 5,
                    type: 'letters_audio',
                    title: 'RAN Huruf - Level 3',
                    description: 'Tantangan terakhir dengan audio yang mengecoh',
                    stimuli: ['b', 'd', 'p', 'q'],
                    answers: ['b', 'd', 'p', 'q'],
                    audioTexts: ['beh', 'deh', 'peh', 'kiu'],
                    totalItems: 2,
                    audioConfusing: true
                }
            ];

            // Game state
            let currentLevel = 0;
            let currentProgress = 0;
            let score = 0;
            let totalTimeLimit = 60; // Total time untuk semua level
            let timeLeft = 60;
            let gameStartTime = 0;
            let isGameActive = false;
            let gameTimer = null;
            let currentStimulus = null;
            let correctAnswers = 0;
            let totalAttempts = 0;
            let audioPlaying = false; // Prevent multiple audio clicks

            // DOM elements
            const elGameCard = document.getElementById('game-card');
            const elScoreArea = document.getElementById('score-area');
            const elFeedbackArea = document.getElementById('feedback-area');
            const elFeedbackText = document.getElementById('feedback-text');
            const elMaskot = document.getElementById('maskot');
            const elCurrentLevel = document.getElementById('current-level');
            const elCurrentProgress = document.getElementById('current-progress');
            const elTotalItems = document.getElementById('total-items');
            const elCurrentScore = document.getElementById('current-score');
            const elProgressBar = document.getElementById('progress-bar');
            const elStimulusGrid = document.getElementById('stimulus-grid');
            const elAnswerOptions = document.getElementById('answer-options');
            const elNextLevelBtn = document.getElementById('next-level-btn');
            const elTimerDisplay = document.getElementById('timer-display');
            const elTimerSeconds = document.getElementById('timer-seconds');
            const elFinalScore = document.getElementById('final-score');
            const elTimeBonus = document.getElementById('time-bonus');
            const elLevelDescription = document.getElementById('level-description');
            const elAudioControlContainer = document.getElementById('audio-control-container');
            const elAudioControl = document.getElementById('audio-control');

            // Setup audio control for letter levels
            function setupAudioControl(levelData) {
                elAudioControl.onclick = () => {
                    if (currentStimulus !== null) {
                        playAudio(levelData);
                    }
                };
            }

            // Play audio with optional confusion
            function playAudio(levelData) {
                if (audioPlaying) return; // Prevent multiple clicks

                audioPlaying = true;
                const audioBtn = elAudioControl;
                audioBtn.classList.add('playing');
                audioBtn.disabled = true;

                let textToSpeak = levelData.audioTexts[currentStimulus];

                // Add confusion for higher levels
                if (levelData.audioConfusing && Math.random() < 0.3) {
                    // 30% chance to play wrong audio
                    const wrongIndex = (currentStimulus + 1 + Math.floor(Math.random() * 3)) % 4;
                    textToSpeak = levelData.audioTexts[wrongIndex];
                }

                speakText(textToSpeak);

                setTimeout(() => {
                    audioBtn.classList.remove('playing');
                    audioBtn.disabled = false;
                    audioPlaying = false;
                }, 2000);
            }

            // Initialize game
            function initGame(skipWelcome = false) {
                console.log('Initializing RAN game... Skip welcome:', skipWelcome);

                currentLevel = 0;
                currentProgress = 0;
                score = 0;
                correctAnswers = 0;
                totalAttempts = 0;

                if (skipWelcome) {
                    // Langsung mulai countdown tanpa welcome screen
                    startGame();
                } else {
                    // Show welcome screen untuk pertama kali
                    showWelcomeScreen();
                }
            }

            // Show welcome screen
            function showWelcomeScreen() {
                const elWelcomeScreen = document.getElementById('welcome-screen');
                const elStartBtn = document.getElementById('start-game-btn');

                // Reset display
                elWelcomeScreen.classList.remove('hidden');
                elStartBtn.classList.remove('hidden');
                elGameCard.classList.add('hidden');
                elScoreArea.classList.add('hidden');
                elTimerDisplay.style.display = 'none';
                elFeedbackArea.classList.remove('show');

                // Reset animations
                elWelcomeScreen.style.animation = '';
                elStartBtn.style.animation = '';

                // Setup start button
                elStartBtn.onclick = () => {
                    startGame();
                };
            } // Start the actual game with countdown
            function startGame() {
                const elWelcomeScreen = document.getElementById('welcome-screen');
                const elStartBtn = document.getElementById('start-game-btn');
                const elCountdownOverlay = document.getElementById('countdown-overlay');
                const elCountdownText = document.getElementById('countdown-text');

                // Hide welcome screen dan score area jika ada
                elWelcomeScreen.classList.add('hidden');
                elStartBtn.classList.add('hidden');
                elScoreArea.classList.add('hidden');
                elGameCard.classList.add('hidden');

                // Reset timer display
                elTimerDisplay.style.display = 'none';
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
                                elTimerDisplay.style.display = 'block';
                                elFeedbackArea.classList.add('show');

                                // Start the actual game IMMEDIATELY
                                loadLevel();
                            }, 1000);

                            clearInterval(countdownInterval);
                        }
                    }, 1000);
                }, 100); // Delay minimal untuk restart cepat
            }

            // Load current level
            function loadLevel() {
                if (currentLevel >= GAME_DATA.length) {
                    gameComplete();
                    return;
                }

                const levelData = GAME_DATA[currentLevel];
                console.log('Loading level:', levelData);

                // Setup timer hanya untuk level pertama
                if (currentLevel === 0) {
                    currentProgress = 0;
                    timeLeft = totalTimeLimit;
                    gameStartTime = Date.now();
                    startTimer();
                }
                isGameActive = true;

                console.log('Loading level', levelData.level, 'with progress:', currentProgress);

                // Update UI LANGSUNG TANPA ANIMASI
                elCurrentLevel.style.opacity = '1';
                elCurrentProgress.style.opacity = '1';
                elCurrentScore.style.opacity = '1';
                elProgressBar.style.opacity = '1';

                elCurrentLevel.textContent = levelData.level;
                elCurrentProgress.textContent = currentProgress;
                elTotalItems.textContent = levelData.totalItems;
                elCurrentScore.textContent = score;
                elTimerSeconds.textContent = timeLeft;
                elLevelDescription.textContent = levelData.description;
                elNextLevelBtn.classList.add('hidden');

                // Force progress bar update tanpa animasi
                const progressPercent = (currentProgress / levelData.totalItems) * 100;
                elProgressBar.style.transition = 'none';
                elProgressBar.style.width = progressPercent + '%';
                setTimeout(() => {
                    elProgressBar.style.transition = 'width 0.2s ease-out';
                }, 100);

                // Show/hide audio control based on level type
                if (levelData.type === 'letters_audio') {
                    elAudioControlContainer.classList.remove('hidden');
                    elStimulusGrid.style.display = 'none';
                    setupAudioControl(levelData);
                    showFeedback('Klik speaker untuk mendengar huruf, lalu pilih jawaban!', 'neutral');
                } else {
                    elAudioControlContainer.classList.add('hidden');
                    elStimulusGrid.style.display = 'grid';
                    showFeedback('Lihat warna dan klik jawaban secepat mungkin!', 'neutral');
                }

                // Setup answer options
                console.log('About to setup answer options for level:', levelData.level, levelData);
                setupAnswerOptions(levelData);

                // Generate first stimulus
                generateStimulus();
            }

            // Setup answer options based on level
            function setupAnswerOptions(levelData) {
                elAnswerOptions.innerHTML = '';

                console.log('Setting up answer options for level:', levelData.level, 'misleading:', levelData
                    .misleadingButtons);

                levelData.answers.forEach((answer, index) => {
                    const btn = document.createElement('button');
                    btn.className = 'answer-btn';
                    btn.textContent = answer;

                    // SET ONCLICK EVENT UNTUK SEMUA BUTTON - INI YANG PENTING!
                    btn.onclick = () => {
                        console.log('BUTTON CLICKED:', answer);
                        selectAnswer(answer, levelData);
                    };

                    // FORCE misleading colors dengan !important
                    if (levelData.misleadingButtons && levelData.buttonColors) {
                        console.log('Applying misleading color for', answer, ':', levelData.buttonColors[index]);

                        const misleadingColor = levelData.buttonColors[index];

                        // Set inline style yang sangat spesifik TANPA menghapus className
                        btn.setAttribute('style', `
                            background: ${misleadingColor} !important;
                            background-color: ${misleadingColor} !important;
                            background-image: none !important;
                            color: white !important;
                            font-weight: bold !important;
                            border: 2px solid rgba(255, 255, 255, 0.3) !important;
                            text-shadow: 1px 1px 2px rgba(0,0,0,0.8) !important;
                            padding: 12px 24px !important;
                            border-radius: 25px !important;
                            font-size: 1.1rem !important;
                            transition: all 0.2s ease !important;
                            box-shadow: 0 4px 12px rgba(0,0,0,0.3) !important;
                            cursor: pointer !important;
                            margin: 0 8px !important;
                        `);

                        // Tambah event listener untuk animasi hover
                        btn.addEventListener('mouseenter', function() {
                            this.style.transform = 'translateY(-3px) scale(1.02)';
                            this.style.boxShadow = '0 8px 20px rgba(0,0,0,0.4)';
                            this.style.filter = 'brightness(1.1)';
                        });

                        btn.addEventListener('mouseleave', function() {
                            this.style.transform = 'translateY(0) scale(1)';
                            this.style.boxShadow = '0 4px 12px rgba(0,0,0,0.3)';
                            this.style.filter = 'brightness(1)';
                        });

                        btn.addEventListener('mousedown', function() {
                            this.style.transform = 'translateY(-1px) scale(0.98)';
                        });

                        btn.addEventListener('mouseup', function() {
                            this.style.transform = 'translateY(-3px) scale(1.02)';
                        });
                    }

                    elAnswerOptions.appendChild(btn);
                });
            }

            // Generate stimulus item
            function generateStimulus() {
                if (!isGameActive) return;

                const levelData = GAME_DATA[currentLevel];
                console.log('Generating stimulus for level:', levelData.level, 'progress:', currentProgress);

                // Generate random stimulus yang SELALU berbeda dari sebelumnya
                let randomIndex;
                let maxAttempts = 10;
                let attempts = 0;

                do {
                    if (levelData.colors) {
                        randomIndex = Math.floor(Math.random() * levelData.colors.length);
                    } else if (levelData.stimuli) {
                        randomIndex = Math.floor(Math.random() * levelData.stimuli.length);
                    } else {
                        console.error('No stimuli or colors defined for level:', levelData);
                        return;
                    }
                    attempts++;
                } while (randomIndex === currentStimulus && attempts < maxAttempts);

                currentStimulus = randomIndex;
                console.log('=== STIMULUS GENERATED ===');
                console.log('Stimulus Index:', randomIndex);
                console.log('Level:', levelData.level);
                console.log('Progress:', currentProgress);
                console.log('Correct Answer should be:', levelData.answers[randomIndex]);

                if (levelData.type === 'letters_audio') {
                    // For audio levels, no visual stimulus, just empty the grid
                    elStimulusGrid.innerHTML = '';
                    elStimulusGrid.style.minHeight = '100px';
                    console.log('Audio level - no visual stimulus');
                } else {
                    // For color levels, show ONLY colored box (no text)
                    elStimulusGrid.innerHTML = '';
                    elStimulusGrid.style.minHeight = '180px';
                    elStimulusGrid.style.display = 'flex';
                    elStimulusGrid.style.justifyContent = 'center';
                    elStimulusGrid.style.alignItems = 'center';

                    const stimulusEl = document.createElement('div');
                    stimulusEl.className = 'stimulus-item';

                    // Show only color, no text
                    const color = levelData.colors[randomIndex];
                    stimulusEl.style.backgroundColor = color;
                    stimulusEl.style.width = '120px';
                    stimulusEl.style.height = '120px';
                    stimulusEl.style.borderRadius = '15px';
                    stimulusEl.style.margin = '0 auto';
                    stimulusEl.style.border = '3px solid rgba(255,255,255,0.8)';
                    stimulusEl.style.boxShadow = '0 4px 15px rgba(0,0,0,0.2)';
                    stimulusEl.style.display = 'block';
                    stimulusEl.style.position = 'relative';
                    stimulusEl.style.zIndex = '10';

                    elStimulusGrid.appendChild(stimulusEl);
                    console.log('Created color stimulus:', color, 'at index:', randomIndex);

                    // Force reflow untuk memastikan stimulus muncul
                    stimulusEl.offsetHeight;
                }

                console.log('Generated stimulus index:', randomIndex);
            }

            // Handle answer selection
            function selectAnswer(selectedAnswer, levelData) {
                console.log('=== SELECT ANSWER CALLED ===');
                console.log('isGameActive:', isGameActive);
                console.log('currentStimulus:', currentStimulus);
                console.log('selectedAnswer:', selectedAnswer);

                if (!isGameActive) {
                    console.log('GAME NOT ACTIVE - RETURNING');
                    return;
                }

                if (currentStimulus === null || currentStimulus === undefined) {
                    console.log('NO CURRENT STIMULUS - RETURNING');
                    return;
                }

                totalAttempts++;
                const correctAnswer = levelData.answers[currentStimulus];
                const isCorrect = selectedAnswer === correctAnswer;

                console.log('PROCESSING ANSWER:', selectedAnswer, 'vs CORRECT:', correctAnswer, 'RESULT:', isCorrect);

                // Visual feedback on stimulus (only for non-audio levels)
                if (levelData.type !== 'letters_audio') {
                    const stimulusEl = elStimulusGrid.querySelector('.stimulus-item');
                    if (stimulusEl) {
                        stimulusEl.classList.add(isCorrect ? 'correct' : 'wrong');
                    }
                }

                // Update progress and score
                if (isCorrect) {
                    correctAnswers++;
                    score += 10;
                    currentProgress++;

                    console.log('CORRECT! Level:', currentLevel + 1, 'Progress:', currentProgress, '/', levelData.totalItems);

                    // Update UI IMMEDIATELY tanpa delay
                    elCurrentScore.textContent = score;
                    elCurrentProgress.textContent = currentProgress;

                    // Update progress bar langsung
                    const progressPercent = (currentProgress / levelData.totalItems) * 100;
                    elProgressBar.style.width = progressPercent + '%';

                    // Show quick feedback
                    showFeedback('Benar! ✓', 'success');

                    // Check if level complete
                    if (currentProgress >= levelData.totalItems) {
                        console.log('LEVEL COMPLETE! Current level:', currentLevel, 'moving to next...');
                        isGameActive = false; // Stop game immediately
                        setTimeout(() => {
                            levelComplete();
                        }, 50);
                        return;
                    }

                    // Generate next stimulus immediately
                    setTimeout(() => {
                        generateStimulus();
                    }, 50);
                } else {
                    // Wrong answer - show feedback but continue
                    showFeedback('Salah! Coba lagi! ✗', 'wrong');

                    // Generate next stimulus after short delay
                    setTimeout(() => {
                        generateStimulus();
                    }, 150);
                }
            }

            // Start countdown timer
            function startTimer() {
                if (gameTimer) clearInterval(gameTimer);

                gameTimer = setInterval(() => {
                    timeLeft--;
                    elTimerSeconds.textContent = timeLeft;

                    // Warning animation when time is low
                    if (timeLeft <= 10) {
                        elTimerDisplay.classList.add('warning');
                    }

                    // Time up
                    if (timeLeft <= 0) {
                        timeUp();
                    }
                }, 1000);
            }

            // Handle time up
            function timeUp() {
                isGameActive = false;
                clearInterval(gameTimer);

                showFeedback('Waktu habis! Permainan selesai.', 'wrong');

                setTimeout(() => {
                    gameComplete();
                }, 1500);
            }

            // Level complete
            function levelComplete() {
                const levelData = GAME_DATA[currentLevel];
                let levelMessage = `Level ${levelData.level} selesai! 🎉`;

                showFeedback(levelMessage, 'success');

                // Auto advance ke level berikutnya atau complete game
                if (currentLevel < GAME_DATA.length - 1) {
                    setTimeout(() => {
                        // Move to next level
                        currentLevel++;
                        currentProgress = 0;

                        console.log('LEVEL TRANSITION: Now level', currentLevel + 1, 'progress reset to',
                            currentProgress);

                        // Update UI langsung tanpa animasi
                        elCurrentProgress.textContent = currentProgress;
                        elProgressBar.style.transition = 'none';
                        elProgressBar.style.width = '0%';
                        elTimerDisplay.classList.remove('warning');

                        // SPECIAL: Jika selesai level 2 (currentLevel sekarang = 2), show video QPDB
                        if (currentLevel === 2) {
                            // PAUSE TIMER
                            clearInterval(gameTimer);
                            showVideoQPDB();
                        } else {
                            // Normal level transition
                            showFeedback(`Level ${currentLevel + 1}`, 'neutral');

                            setTimeout(() => {
                                elProgressBar.style.transition = 'width 0.2s ease-out';
                                loadLevel();
                            }, 500);
                        }
                    }, 500);
                } else {
                    setTimeout(() => {
                        gameComplete();
                    }, 800);
                }
            }

            // Game complete
            function gameComplete() {
                console.log('Game complete! Final score:', score);
                isGameActive = false;
                clearInterval(gameTimer);

                elGameCard.classList.add('hidden');
                elScoreArea.classList.remove('hidden');

                // Calculate accuracy
                const accuracy = totalAttempts > 0 ? Math.round((correctAnswers / totalAttempts) * 100) : 0;

                // Show completion message
                let completionMessage = '🎉 Selamat! Kamu telah menyelesaikan semua 5 level RAN!';
                if (accuracy >= 90) {
                    completionMessage += ' Luar biasa! 🌟';
                } else if (accuracy >= 70) {
                    completionMessage += ' Bagus sekali! 👏';
                } else {
                    completionMessage += ' Terus berlatih! 💪';
                }

                elFinalScore.textContent = `${score} poin`;
                elTimeBonus.textContent = `${accuracy}% akurasi`;

                showFeedback(completionMessage, 'success');

                // Hide timer
                elTimerDisplay.style.display = 'none';
            }

            // Show feedback with mascot
            function showFeedback(message, type) {
                console.log('Showing feedback:', message, type);

                elFeedbackText.textContent = message;
                elFeedbackArea.classList.add('show');

                // Change mascot based on type
                try {
                    if (type === 'success') {
                        elMaskot.src = "{{ asset('images/maskot/siku.png') }}";
                    } else if (type === 'wrong') {
                        elMaskot.src = "{{ asset('images/maskot/eye.png') }}";
                    } else {
                        elMaskot.src = "{{ asset('images/maskot/smile.png') }}";
                    }
                } catch (e) {
                    console.log('Mascot image error:', e);
                }
            }

            // Show QPDB video explanation after level 2
            function showVideoQPDB() {
                console.log('Showing QPDB video explanation - timer paused');

                // Create video overlay
                const videoHTML = `
                    <div id="qpdb-video-overlay" style="
                        position: fixed;
                        top: 0;
                        left: 0;
                        width: 100vw;
                        height: 100vh;
                        background: linear-gradient(135deg, rgba(99, 102, 241, 0.95), rgba(168, 85, 247, 0.95));
                        backdrop-filter: blur(20px);
                        display: flex;
                        flex-direction: column;
                        align-items: center;
                        justify-content: center;
                        z-index: 9999;
                        padding: 20px;
                        box-sizing: border-box;
                        animation: fadeIn 0.5s ease-out;
                    ">
                        <div style="
                            background: rgba(255, 255, 255, 0.95);
                            backdrop-filter: blur(20px);
                            border-radius: 24px;
                            padding: 32px;
                            max-width: 640px;
                            width: 90%;
                            text-align: center;
                            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.4);
                            border: 1px solid rgba(255, 255, 255, 0.3);
                        ">
                            <div style="margin-bottom: 20px;">
                                <div style="font-size: 3rem; margin-bottom: 12px;"></div>
                                <h2 style="color: #4c1d95; margin: 0 0 8px 0; font-size: 1.8rem; font-weight: 800;">Penjelasan Huruf Q P D B</h2>
                                <p style="color: #6b7280; margin: 0; font-size: 1rem;">Pelajari perbedaan huruf yang sering membingungkan</p>
                            </div>
                            
                            <video controls autoplay style="
                                width: 100%;
                                max-width: 520px;
                                height: auto;
                                border-radius: 16px;
                                box-shadow: 0 12px 32px rgba(0,0,0,0.2);
                                margin-bottom: 24px;
                                border: 2px solid rgba(255,255,255,0.5);
                            ">
                                <source src="{{ asset('video/ran/pqdb.mp4') }}" type="video/mp4">
                                Browser Anda tidak mendukung video HTML5.
                            </video>
                            
                            <button id="continue-game-btn" style="
                                background: linear-gradient(135deg, #8b5cf6, #7c3aed);
                                color: white;
                                border: none;
                                border-radius: 16px;
                                padding: 16px 32px;
                                font-size: 1.2rem;
                                font-weight: 700;
                                cursor: pointer;
                                box-shadow: 0 8px 24px rgba(139, 92, 246, 0.4);
                                transition: all 0.3s ease;
                                display: flex;
                                align-items: center;
                                justify-content: center;
                                gap: 8px;
                                margin: 0 auto;
                                min-width: 200px;
                            " onmouseover="this.style.transform='translateY(-3px)'; this.style.boxShadow='0 12px 32px rgba(139, 92, 246, 0.5)';" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 8px 24px rgba(139, 92, 246, 0.4)';">
                                <span style="font-size: 1.1rem;">🚀</span>
                                <span>Lanjut ke Level 3-5</span>
                            </button>
                        </div>
                    </div>
                `;

                // Insert video overlay
                document.body.insertAdjacentHTML('beforeend', videoHTML);

                // Setup continue button
                document.getElementById('continue-game-btn').onclick = function() {
                    console.log('Continue to level 3 clicked - resuming timer');

                    // Remove video overlay
                    const videoOverlay = document.getElementById('qpdb-video-overlay');
                    if (videoOverlay) {
                        videoOverlay.style.opacity = '0';
                        videoOverlay.style.transform = 'scale(0.95)';
                        videoOverlay.style.transition = 'all 0.3s ease-out';

                        setTimeout(() => {
                            videoOverlay.remove();

                            // RESUME TIMER
                            startTimer();

                            // Continue to level 3
                            showFeedback(`Level ${currentLevel + 1}`, 'neutral');

                            setTimeout(() => {
                                elProgressBar.style.transition = 'width 0.2s ease-out';
                                loadLevel();
                            }, 500);
                        }, 300);
                    }
                };
            }

            // Speech synthesis function
            function speakText(text) {
                if ('speechSynthesis' in window) {
                    const utterance = new SpeechSynthesisUtterance(text);
                    utterance.lang = 'id-ID';
                    utterance.rate = 1.0;
                    utterance.pitch = 1.0;
                    speechSynthesis.speak(utterance);
                }
            }

            // Initialize game when DOM is loaded
            document.addEventListener('DOMContentLoaded', function() {
                console.log('DOM loaded, checking elements...');

                // Check if all elements are available
                console.log('Elements check:', {
                    gameCard: !!elGameCard,
                    scoreArea: !!elScoreArea,
                    feedbackArea: !!elFeedbackArea,
                    stimulusGrid: !!elStimulusGrid,
                    answerOptions: !!elAnswerOptions
                });

                // Small delay to ensure DOM is fully ready
                setTimeout(() => {
                    console.log('Initializing game...');
                    initGame();
                }, 100);
            });
        </script>
    @endsection
