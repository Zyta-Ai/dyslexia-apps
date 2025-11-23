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

        /* Allow text selection only for necessary elements */
        input,
        textarea,
        .selectable {
            -webkit-user-select: text;
            -moz-user-select: text;
            -ms-user-select: text;
            user-select: text;
        }

        /* =========================================================================
                   1. CSS KUSTOM SESUAI PERMINTAAN (Card & Button)
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

        /* Style Card sesuai instruksi */
        .card-register {
            /* Menggunakan Gradient Teal Kustom */
            background: linear-gradient(90deg, rgba(167, 222, 212, 0.7) 0%, rgba(123, 188, 174, 0.7) 100%);
            border-radius: 1.5rem;
            padding: 1.5rem;
            width: 100%;
            max-width: 500px;
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

        /* Style Button sesuai instruksi */
        .button-register {
            /* Menggunakan Gradient Gold Kustom */
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
            /* Minimum touch target */
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
        }

        @media (max-width: 768px) {
            .button-register {
                font-size: 1rem;
                padding: 14px 16px;
                min-height: 48px;
                /* Larger touch target for mobile */
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

        .button-register:hover {
            transform: translateY(-2px);
            filter: brightness(1.05);
        }

        .button-register.disabled {
            opacity: 0.6;
            cursor: not-allowed;
            transform: none;
        }

        /* =========================================================================
                   2. LAYOUT & FEEDBACK BARU (Maskot di Samping Pesan)
                   ========================================================================= */
        .image-box {
            width: 200px;
            height: 200px;
            background-color: #f8f9fa;
            border-radius: 1rem;
            margin: 0 auto 1.5rem;
            background-size: contain;
            background-repeat: no-repeat;
            background-position: center;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
            border: 3px solid white;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: background-image 0.3s ease;
        }

        /* Mobile Image Box */
        @media (max-width: 768px) {
            .image-box {
                width: 160px;
                height: 160px;
                margin: 0 auto 1rem;
            }
        }

        @media (max-width: 480px) {
            .image-box {
                width: 140px;
                height: 140px;
                margin: 0 auto 0.75rem;
            }
        }

        .image-box::before {
            content: "🖼️";
            font-size: 2rem;
            color: #ccc;
            display: block;
        }

        .image-box.loaded::before {
            display: none;
        }

        .sound-button {
            background-color: white;
            color: #333;
            border: none;
            padding: 0.8rem;
            border-radius: 50%;
            font-size: 1.5rem;
            cursor: pointer;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            margin-bottom: 1.5rem;
            transition: transform 0.2s;
            min-width: 60px;
            min-height: 60px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .sound-button:active {
            transform: scale(0.95);
        }

        .sound-button.playing {
            animation: pulse 1s infinite;
            background-color: #f0f9ff;
            box-shadow: 0 0 15px rgba(59, 130, 246, 0.5);
        }

        /* Image loading animation */
        .image-box.loading {
            animation: pulse 1.5s infinite;
        }

        .image-box.loaded {
            animation: fadeInScale 0.5s ease-out;
        }

        @keyframes fadeInScale {
            0% {
                transform: scale(0.8);
                opacity: 0;
            }

            100% {
                transform: scale(1);
                opacity: 1;
            }
        }

        @media (max-width: 768px) {
            .sound-button {
                padding: 1rem;
                font-size: 1.25rem;
                margin-bottom: 1rem;
                min-width: 56px;
                min-height: 56px;
            }
        }

        .options-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 0.75rem;
            margin-top: 1rem;
        }

        @media (max-width: 768px) {
            .options-grid {
                gap: 0.5rem;
                margin-top: 0.75rem;
            }
        }

        @media (max-width: 480px) {
            .options-grid {
                grid-template-columns: 1fr;
                gap: 0.5rem;
                max-width: 280px;
                margin: 0.75rem auto 0;
            }
        }

        /* Layout Feedback: MASKOT DI SAMPING PESAN (Flex Row) */
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

        @media (max-width: 768px) {
            .feedback-container {
                gap: 10px;
                margin-bottom: 15px;
                min-height: 70px;
                padding: 0 0.5rem;
            }
        }

        @media (max-width: 480px) {
            .feedback-container {
                flex-direction: column;
                gap: 8px;
                min-height: 60px;
                text-align: center;
            }
        }

        /* Landscape Orientation on Mobile */
        @media (max-height: 500px) and (orientation: landscape) {
            .game-container {
                min-height: 95vh;
                padding: 0.5rem;
            }

            .card-register {
                padding: 1rem;
            }

            .image-box {
                width: 120px;
                height: 120px;
                margin: 0 auto 0.5rem;
            }

            .final-score-card {
                padding: 1.5rem;
            }

            .feedback-container {
                min-height: 50px;
                margin-bottom: 10px;
            }
        }

        .feedback-container.show {
            opacity: 1;
            animation: dramaticPopIn 0.6s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        }

        /* Enhanced Feedback Message Animation */
        .feedback-message {
            animation: bounceIn 0.5s ease-out 0.1s both;
        }

        .feedback-message {
            background-color: white;
            padding: 10px 20px;
            border-radius: 20px 20px 20px 0;
            /* Speech bubble style */
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            font-weight: bold;
            font-size: 1.1rem;
            color: #333;
            max-width: 200px;
            text-align: left;
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

        @keyframes popIn {
            0% {
                transform: scale(0.8);
                opacity: 0;
            }

            100% {
                transform: scale(1);
                opacity: 1;
            }
        }

        /* ANIMASI FEEDBACK Tombol */
        .option-button.correct {
            background-color: #22c55e !important;
            color: white !important;
            border-color: #16a34a !important;
            animation: successPop 0.6s ease-out;
            transform: scale(1.05);
            box-shadow: 0 0 25px rgba(34, 197, 94, 0.7);
            filter: brightness(1.1);
            z-index: 10;
        }

        .option-button.wrong {
            background-color: #ef4444 !important;
            color: white !important;
            border-color: #dc2626 !important;
            animation: errorShake 0.6s ease-out;
            box-shadow: 0 0 25px rgba(239, 68, 68, 0.7);
            filter: brightness(1.0);
            z-index: 10;
        }

        /* Button Click Animation */
        .option-button.clicked {
            animation: buttonPop 0.3s ease-out;
        }

        .disabled {
            opacity: 0.6;
            cursor: not-allowed;
            transform: none;
        }

        .option-button.blurred {
            filter: blur(4px) brightness(0.4) grayscale(1) !important;
            opacity: 0.25 !important;
            transform: scale(0.9) !important;
            transition: all 0.5s ease !important;
            background-color: #e5e7eb !important;
            color: #9ca3af !important;
            border-color: #e5e7eb !important;
            pointer-events: none !important;
        }

        .option-button.correct,
        .option-button.wrong {
            filter: none !important;
            opacity: 1 !important;
            transform: scale(1) !important;
            pointer-events: auto !important;
            transition: all 0.3s ease !important;
        }

        /* Warna normal untuk jawaban benar */
        .option-button.correct {
            background-color: #22c55e !important;
            color: white !important;
            border-color: #16a34a !important;
            box-shadow: 0 4px 15px rgba(34, 197, 94, 0.4) !important;
        }

        /* Warna normal untuk jawaban salah */
        .option-button.wrong {
            background-color: #ef4444 !important;
            color: white !important;
            border-color: #dc2626 !important;
            box-shadow: 0 4px 15px rgba(239, 68, 68, 0.4) !important;
        }

        /* Pastikan jawaban yang dipilih tetap fokus */
        .option-button.correct,
        .option-button.wrong {
            filter: none !important;
            opacity: 1 !important;
            z-index: 10;
            transform: scale(1.05) !important;
        }

        .option-button.wrong {
            filter: brightness(1.0) !important;
        }

        /* Highlight jawaban benar yang tidak dipilih */
        .option-button.correct:not(.clicked) {
            background-color: #22c55e !important;
            border-color: #16a34a !important;
            color: white !important;
            box-shadow: 0 0 20px rgba(34, 197, 94, 0.8) !important;
            animation: correctAnswer 0.5s ease-out !important;
        }

        @keyframes correctAnswer {
            0% {
                background-color: inherit;
                transform: scale(1);
            }

            50% {
                transform: scale(1.1);
            }

            100% {
                background-color: #22c55e;
                transform: scale(1.05);
            }
        }

        @keyframes successPop {
            0% {
                transform: scale(1);
            }

            25% {
                transform: scale(1.1) rotate(3deg);
            }

            50% {
                transform: scale(1.15) rotate(-2deg);
            }

            75% {
                transform: scale(1.05) rotate(1deg);
            }

            100% {
                transform: scale(1.05) rotate(0deg);
            }
        }

        @keyframes errorShake {
            0% {
                transform: translateX(0) scale(1);
            }

            15% {
                transform: translateX(-8px) scale(1.02);
            }

            30% {
                transform: translateX(8px) scale(1.02);
            }

            45% {
                transform: translateX(-6px) scale(1.01);
            }

            60% {
                transform: translateX(6px) scale(1.01);
            }

            75% {
                transform: translateX(-3px) scale(1);
            }

            90% {
                transform: translateX(3px) scale(1);
            }

            100% {
                transform: translateX(0) scale(1);
            }
        }

        @keyframes buttonPop {
            0% {
                transform: scale(1);
            }

            50% {
                transform: scale(0.95);
            }

            100% {
                transform: scale(1);
            }
        }

        /* Hover and Active States */
        .option-button:hover {
            filter: brightness(1.1);
            transform: translateY(-2px) scale(1.02);
            box-shadow: 0 6px 15px rgba(0, 0, 0, 0.2);
            transition: all 0.2s ease-out;
        }

        .option-button:active {
            transform: translateY(0) scale(0.98);
            transition: all 0.1s ease-out;
        }

        /* Subtle entrance animation for buttons */
        .option-button {
            animation: slideInUp 0.4s ease-out both;
            opacity: 0;
        }

        .option-button:nth-child(1) {
            animation-delay: 0.1s;
        }

        .option-button:nth-child(2) {
            animation-delay: 0.2s;
        }

        .option-button:nth-child(3) {
            animation-delay: 0.3s;
        }

        /* Reset animation for dynamic buttons */
        .options-grid .button-register {
            animation: slideInUp 0.4s ease-out both;
            opacity: 0;
        }

        .options-grid .button-register:nth-child(1) {
            animation-delay: 0.1s;
        }

        .options-grid .button-register:nth-child(2) {
            animation-delay: 0.2s;
        }

        .options-grid .button-register:nth-child(3) {
            animation-delay: 0.3s;
        }

        @keyframes slideInUp {
            0% {
                transform: translateY(20px);
                opacity: 0;
            }

            100% {
                transform: translateY(0);
                opacity: 1;
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

        /* Next Button Animation */
        #next-btn.show {
            animation: slideInFromBottom 0.5s ease-out;
        }

        @keyframes slideInFromBottom {
            0% {
                transform: translateY(30px);
                opacity: 0;
            }

            100% {
                transform: translateY(0);
                opacity: 1;
            }
        }

        /* Score area entrance */
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
    </style>

    <div class="game-container">

        <div id="feedback-area" class="feedback-container">
            <img id="maskot-img" src="{{ asset('images/maskot/eye.png') }}" alt="Maskot" style="width: 80px; height: auto;">

            <div id="feedback-text" class="feedback-message">
                Halo! Ayo mulai belajar.
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
                    <h2 class="welcome-title">🎧 Belajar Audio</h2>
                    <p class="welcome-subtitle">Siap melatih pendengaran dengan ejaan kata?</p>
                </div>
            </div>

            <!-- Game Info Card -->
            <div id="game-info-card" class="game-info-card">
                <div class="info-content">
                    <div class="info-item">
                        <span class="info-icon">🔤</span>
                        <span class="info-text">Dengarkan ejaan kata huruf per huruf</span>
                    </div>
                    <div class="info-item">
                        <span class="info-icon">🎧</span>
                        <span class="info-text">Pilih gambar yang sesuai dengan ejaan</span>
                    </div>
                    <div class="info-item">
                        <span class="info-icon">📝</span>
                        <span class="info-text">Latih kemampuan mengeja dan mendengar!</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Start Button (Outside card) -->
        <button id="start-game-btn" class="start-button">
            🎵 Mulai Bermain
        </button>

        <div id="game-card" class="card-register hidden">
            <div class="flex justify-between items-center mb-4 text-white">
                <span class="font-bold text-lg">Level <span id="level-display">1</span></span>
                <span class="text-sm bg-white bg-opacity-20 px-3 py-1 rounded-full">Soal <span id="q-current">1</span>/<span
                        id="q-total">5</span></span>
            </div>

            <div id="image-placeholder" class="image-box"></div>

            <button id="sound-btn" class="sound-button">
                🔊
            </button>

            <div id="options-container" class="options-grid">
            </div>

            <div class="mt-6 h-12">
                <button id="next-btn" class="button-register w-full hidden" onclick="nextQuestion()">
                    Lanjut &raquo;
                </button>
            </div>
        </div>

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
        // =========================================================================================
        // DATA GAME LENGKAP (Pool Data Lengkap)
        // =========================================================================================
        const POOL_DATA = [{
                level: 1,
                img: 'images/audiovisual/ikan.png',
                correct: 'IKAN',
                options: ['IKAN', 'AYAM', 'SAPI']
            },
            {
                level: 1,
                img: 'images/audiovisual/ayam.png',
                correct: 'AYAM',
                options: ['IKAN', 'AYAM', 'SAPI']
            },
            {
                level: 1,
                img: 'images/audiovisual/sapi.png',
                correct: 'SAPI',
                options: ['IKAN', 'AYAM', 'SAPI']
            },
            {
                level: 2,
                img: 'images/audiovisual/meja.png',
                correct: 'MEJA',
                options: ['MEJA', 'BATU', 'RAJA']
            },
            {
                level: 2,
                img: 'images/audiovisual/batu.png',
                correct: 'BATU',
                options: ['MEJA', 'BATU', 'RAJA']
            },
            {
                level: 2,
                img: 'images/audiovisual/raja.png',
                correct: 'RAJA',
                options: ['MEJA', 'BATU', 'RAJA']
            },
            {
                level: 3,
                img: 'images/audiovisual/baju.png',
                correct: 'BAJU',
                options: ['BAJU', 'PAKU', 'DADU']
            },
            {
                level: 3,
                img: 'images/audiovisual/paku.png',
                correct: 'PAKU',
                options: ['BAJU', 'PAKU', 'DADU']
            },
            {
                level: 3,
                img: 'images/audiovisual/dadu.png',
                correct: 'DADU',
                options: ['BAJU', 'PAKU', 'DADU']
            },
            {
                level: 4,
                img: 'images/audiovisual/kucing.png',
                correct: 'KUCING',
                options: ['KUCING', 'PANCING', 'KERING']
            },
            {
                level: 4,
                img: 'images/audiovisual/pancing.png',
                correct: 'PANCING',
                options: ['KUCING', 'PANCING', 'KERING']
            },
            {
                level: 5,
                img: 'images/audiovisual/kotak.png',
                correct: 'KOTAK',
                options: ['KOTAK', 'KATAK', 'KAPAK']
            },
            {
                level: 5,
                img: 'images/audiovisual/katak.png',
                correct: 'KATAK',
                options: ['KOTAK', 'KATAK', 'KAPAK']
            }
        ];

        // Variabel Game
        let activeQuestions = [];
        let currentIndex = 0;
        let score = 0;
        const MAX_LEVELS = 5;

        // Element DOM
        const elGameCard = document.getElementById('game-card');
        const elScoreArea = document.getElementById('score-area');
        const elImg = document.getElementById('image-placeholder');
        const elOptions = document.getElementById('options-container');
        const elNextBtn = document.getElementById('next-btn');
        const elFeedbackArea = document.getElementById('feedback-area');
        const elFeedbackText = document.getElementById('feedback-text');
        const elMaskot = document.getElementById('maskot-img');
        const elLevel = document.getElementById('level-display');
        const elCurrentQ = document.getElementById('q-current');
        const elTotalQ = document.getElementById('q-total');

        // Setup TTS
        const synth = window.speechSynthesis;
        let voice = null;

        function setupVoice() {
            const voices = synth.getVoices();
            voice = voices.find(v => v.lang.startsWith('id'));
        }
        if (synth.onvoiceschanged !== undefined) synth.onvoiceschanged = setupVoice;
        else setupVoice();

        function speak(text) {
            if (synth.speaking) synth.cancel();
            const u = new SpeechSynthesisUtterance(text);
            if (voice) u.voice = voice;
            synth.speak(u);
        }

        // Fungsi untuk mengeja kata letter by letter
        function spellWord(word) {
            if (synth.speaking) synth.cancel();

            console.log('Spelling word:', word);

            // Convert ke array huruf dan tambah jeda
            const letters = word.split('').join(' '); // K A T A K

            const utterance = new SpeechSynthesisUtterance(letters);
            utterance.lang = 'id-ID';
            utterance.rate = 0.6; // Lebih lambat untuk ejaan
            utterance.pitch = 1.0;

            synth.speak(utterance);
        }

        // --- LOGIKA UTAMA ---

        function initGame() {
            // 1. Ambil 1 soal per level secara berurutan (Level 1-5)
            activeQuestions = [];
            for (let level = 1; level <= MAX_LEVELS; level++) {
                const levelQuestions = POOL_DATA.filter(q => q.level === level);
                if (levelQuestions.length > 0) {
                    // Randomize dalam level yang sama, ambil 1 soal
                    const randomQuestion = levelQuestions[Math.floor(Math.random() * levelQuestions.length)];
                    activeQuestions.push(randomQuestion);
                    console.log(`Level ${level}: Selected question - ${randomQuestion.correct}`);
                }
            }

            console.log('Active questions for this game:', activeQuestions.map(q => `Level ${q.level}: ${q.correct}`));

            currentIndex = 0;
            score = 0;
            elTotalQ.textContent = activeQuestions.length;

            // Show welcome screen
            showWelcomeScreen();
        }

        // Restart game without welcome screen (for Main Lagi button)
        function restartGame() {
            // Reset game state sama seperti initGame
            activeQuestions = [];
            for (let level = 1; level <= MAX_LEVELS; level++) {
                const levelQuestions = POOL_DATA.filter(q => q.level === level);
                if (levelQuestions.length > 0) {
                    const randomQuestion = levelQuestions[Math.floor(Math.random() * levelQuestions.length)];
                    activeQuestions.push(randomQuestion);
                }
            }

            currentIndex = 0;
            score = 0;
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

                            // Reset Maskot dan Teks
                            setFeedback('neutral', 'Siap belajar? Tekan speaker!');

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

            // Hide Next Button
            elNextBtn.classList.add('hidden');

            // Gambar
            const imageUrl = `{{ asset('') }}${q.img}`;
            console.log('Loading image:', imageUrl); // Debug log

            // Reset image box dengan loading animation
            elImg.classList.remove('loaded');
            elImg.classList.add('loading');
            elImg.style.backgroundImage = '';

            // Test jika gambar bisa load
            const testImg = new Image();
            testImg.onload = function() {
                elImg.classList.remove('loading');
                elImg.style.backgroundImage = `url('${imageUrl}')`;
                elImg.classList.add('loaded');
                console.log('Image loaded successfully:', imageUrl);
            };
            testImg.onerror = function() {
                console.error('Image failed to load:', imageUrl);
                elImg.classList.remove('loading');
                elImg.style.backgroundImage = '';
                elImg.classList.remove('loaded');
            };
            testImg.src = imageUrl;

            // Tombol Suara - MENGEJA kata jawaban yang benar
            const soundBtn = document.getElementById('sound-btn');
            soundBtn.onclick = () => {
                console.log('Spelling word:', q.correct);

                // Tambahkan animasi playing
                soundBtn.classList.add('playing');

                // REJA kata instead of sebut langsung
                spellWord(q.correct);

                // Remove playing animation setelah selesai
                setTimeout(() => {
                    soundBtn.classList.remove('playing');
                }, 3000); // Lebih lama karena ejaan butuh waktu lebih
            };

            // Opsi Jawaban - Reset dan buat baru
            elOptions.innerHTML = '';
            const shuffledOpts = q.options.sort(() => 0.5 - Math.random());

            shuffledOpts.forEach((option, index) => {
                const btn = document.createElement('button');
                btn.className = 'button-register';
                btn.textContent = option;
                btn.onclick = () => handleAnswer(btn, option, q.correct);

                // Reset semua class animasi
                btn.classList.remove('correct', 'wrong', 'blurred', 'clicked', 'disabled');
                btn.style.backgroundColor = '';
                btn.style.borderColor = '';
                btn.style.boxShadow = '';
                btn.style.color = '';
                btn.style.filter = '';
                btn.disabled = false;

                elOptions.appendChild(btn);
            });
        }

        function handleAnswer(btnClicked, answer, correct) {
            btnClicked.classList.add('clicked');

            setTimeout(() => {
                const btns = elOptions.querySelectorAll('button');
                btns.forEach(b => {
                    b.disabled = true;
                    b.classList.add('disabled');
                    b.onclick = null;
                });
            }, 200);

            setTimeout(() => {
                const btns = elOptions.querySelectorAll('button');
                btns.forEach(btn => {
                    if (btn !== btnClicked) {
                        btn.classList.add('blurred');
                    }
                });

                btnClicked.classList.remove('blurred');

                if (answer === correct) {
                    score++;
                    btnClicked.classList.add('correct');
                    setFeedback('correct', 'Tepat sekali! Hebat!');
                    // HAPUS audio pesan maskot - cukup visual feedback
                } else {
                    btnClicked.classList.add('wrong');
                    const correctBtn = Array.from(btns).find(b => b.textContent === correct);
                    if (correctBtn) {
                        correctBtn.classList.remove('blurred');
                        correctBtn.classList.add('correct');
                        correctBtn.style.borderColor = '#16a34a';
                        correctBtn.style.boxShadow = '0 0 20px rgba(34, 197, 94, 0.8)';
                        correctBtn.style.backgroundColor = '#22c55e';
                        correctBtn.style.color = 'white';
                    }

                    setFeedback('wrong', `Ups, itu ${correct}.`);
                    // HAPUS audio pesan maskot - cukup visual feedback
                }
            }, 300);

            setTimeout(() => {
                elNextBtn.classList.remove('hidden');
                elNextBtn.classList.add('show');
            }, 500);
        }

        function nextQuestion() {

            elNextBtn.classList.remove('show');
            elNextBtn.classList.add('hidden');

            currentIndex++;
            if (currentIndex < activeQuestions.length) {
                setFeedback('neutral', 'Soal selanjutnya...');
                loadQuestion();
            } else {
                finishGame();
            }
        }

        function finishGame() {
            elGameCard.classList.add('hidden');
            elFeedbackArea.classList.remove('show');

            setTimeout(() => {
                elScoreArea.classList.remove('hidden');
                elScoreArea.classList.add('show');

                const percentage = (score / activeQuestions.length) * 100;
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
                elMaskot.src = "{{ asset('images/maskot/smile.png') }}";
            } else {
                elMaskot.src = "{{ asset('images/maskot/eye.png') }}";
            }
        }


        document.addEventListener('DOMContentLoaded', initGame);
    </script>
@endsection
