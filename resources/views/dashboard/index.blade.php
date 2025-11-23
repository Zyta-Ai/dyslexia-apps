@extends('layouts.app')

@section('content')
    <style>
        /* =========================================================================
           CSS KUSTOM (Diambil dari input terakhir, dengan sedikit penyederhanaan)
           ========================================================================= */
        .dashboard-background {
            background-image: url('{{ asset('images/background.jpg') }}');
            background-size: cover;
            background-position: center top;
            background-repeat: repeat-x;
            background-attachment: fixed;
            min-height: 100vh;
            width: 100vw;
            position: relative;
            padding-top: 2rem;
        }

        .sapaan-header {
            background: linear-gradient(90deg, rgba(167, 222, 212, 0.7) 0%, rgba(123, 188, 174, 0.7) 100%);
            color: white;
            padding: 8px 15px;
            border-radius: 10px;
            display: inline-flex;
            align-items: center;
            font-size: 1.2em;
            font-weight: bold;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }

        .sapaan-header img {
            width: 24px;
            height: 24px;
            margin-right: 8px;
        }

        .story-image {
            /* Dimensi dasar */
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            height: 200px;
        }

        .gambar {
            width: 30px !important;
            height: 30px !important;
        }

        .story-banner-card,
        .game-card {
            background: linear-gradient(90deg, rgba(167, 222, 212, 0.7) 0%, rgba(123, 188, 174, 0.7) 100%);
        }

        .dongeng-button,
        .cta-button {
            background: linear-gradient(90deg, rgba(255, 239, 190, 1) 0%, rgba(255, 209, 102, 1) 100%);
            color: #333333;
            box-shadow: 2px 5px 20px rgba(0, 0, 0, 0.4);
            cursor: pointer;
        }

        .logout-button {
            background: linear-gradient(90deg, rgba(131, 58, 180, 0.5) 0%, rgba(253, 29, 29, 1) 0%, rgba(252, 176, 69, 0.51) 100%);
            color: white;
        }

        .illustration-area {
            height: 10rem;
            background-size: cover;
            background-position: center;
        }

        .story-banner-content {
            flex-direction: column;
            align-items: center;
        }

        @media (min-width: 768px) {
            .story-banner-content {
                flex-direction: row;
                align-items: flex-start;
            }
        }
    </style>

    <div class="dashboard-background">
        <div class="main-content-container max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">

            <div class="flex justify-between items-start mb-6">

                <div class="sapaan-header">
                    <img src="{{ asset('images/maskot/siku.png') }}" alt="Sun Icon" class="mr-4 gambar" />
                    <span>Hai, Rina!</span>
                </div>

                <a href="/login" class="logout-button px-4 py-2 rounded-lg font-bold shadow-md transition hover:opacity-90">
                    Logout
                </a>
            </div>

            <div class="story-banner-card rounded-xl shadow-2xl mb-8 p-0 relative overflow-hidden">

                <div class="story-banner-content flex p-4">

                    <div class="story-image rounded-xl mr-0 mb-4 md:mb-0 md:mr-5 
                            w-full md:w-2/5 lg:w-2/5"
                        style="background-image: url('{{ asset('images/dongeng.jpg') }}'); border-radius: 10px;">
                    </div>

                    <div class="story-text flex-grow pt-3 text-dibi-text w-full md:w-3/5">
                        <p class="text-sm mb-3 leading-snug">
                            A prince, inheriting a kingdom in ruins, is gifted an ancient copper urn by an oracle who
                            advises, “Only a fool plants many seeds and refuses to allow them time to grow.” He returns to
                            his palace, and, after knocking on the urn, a genie emerges offering three wishes...
                        </p>

                        <div class="flex justify-center md:justify-end w-full">
                            <a href="{{ route('dongeng.index') }}"
                                class="dongeng-button px-4 py-2 rounded-lg font-bold shadow-md transition hover:opacity-90 mt-2">
                                Baca Dongeng
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="game-grid grid grid-cols-1 md:grid-cols-2 gap-6">

                <a href="/games/audiovisual"
                    class="game-card rounded-xl shadow-lg overflow-hidden transition hover:shadow-xl">
                    <div class="illustration-area" style="background-image: url('{{ asset('images/audio.jpg') }}');"></div>
                    <div class="cta-button font-bold py-3 text-center text-lg transition hover:opacity-90">Mulai Game →
                    </div>
                </a>

                <a href="/games/susunkata"
                    class="game-card rounded-xl shadow-lg overflow-hidden transition hover:shadow-xl">
                    <div class="illustration-area" style="background-image: url('{{ asset('images/pilih_kata.jpg') }}');">
                    </div>
                    <div class="cta-button font-bold py-3 text-center text-lg transition hover:opacity-90">Mulai Game →
                    </div>
                </a>

                <a href="/games/pilihkata"
                    class="game-card rounded-xl shadow-lg overflow-hidden transition hover:shadow-xl">
                    <div class="illustration-area" style="background-image: url('{{ asset('images/susun_kata.jpg') }}');">
                    </div>
                    <div class="cta-button font-bold py-3 text-center text-lg transition hover:opacity-90">Mulai Game →
                    </div>
                </a>

                <a href="/games/ran" class="game-card rounded-xl shadow-lg overflow-hidden transition hover:shadow-xl">
                    <div class="illustration-area" style="background-image: url('{{ asset('images/ran.jpg') }}');"></div>
                    <div class="cta-button font-bold py-3 text-center text-lg transition hover:opacity-90">Mulai Game →
                    </div>
                </a>

            </div>
        </div>
    </div>
@endsection
