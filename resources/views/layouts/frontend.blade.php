<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Calculate your Body Mass Index (BMI) instantly with our free BMI calculator">
    <title>@yield('title', 'BMI Calculator') - Health Tracker</title>
    
    <!-- Social Meta Tags (Open Graph) -->
    <meta property="og:type" content="website">
    <meta property="og:title" content="@yield('og_title', 'BMI Calculator - Health Tracker')">
    <meta property="og:description" content="@yield('og_description', 'Calculate your Body Mass Index (BMI) instantly with our free BMI calculator')">
    <meta property="og:image" content="@yield('og_image', 'https://is3.cloudhost.id/ai-images/projects/b70f3159-6ffe-4d27-b92d-d2fb874ba476/chat-images/2026-04-16/1776315116161-60bf82f9dede464e.webp')">
    <meta property="og:url" content="@yield('og_url', url()->current())">
    <meta property="og:site_name" content="BMI Calculator">
    
    <!-- Twitter Card -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="@yield('twitter_title', 'BMI Calculator - Health Tracker')">
    <meta name="twitter:description" content="@yield('twitter_description', 'Calculate your Body Mass Index (BMI) instantly with our free BMI calculator')">
    <meta name="twitter:image" content="@yield('twitter_image', 'https://is3.cloudhost.id/ai-images/projects/b70f3159-6ffe-4d27-b92d-d2fb874ba476/chat-images/2026-04-16/1776315116161-60bf82f9dede464e.webp')">
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700&family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        'display': ['Outfit', 'sans-serif'],
                        'body': ['Plus Jakarta Sans', 'sans-serif'],
                    },
                    colors: {
                        primary: {
                            50: '#f0fdfa',
                            100: '#ccfbf1',
                            200: '#99f6e4',
                            300: '#5eead4',
                            400: '#2dd4bf',
                            500: '#14b8a6',
                            600: '#0d9488',
                            700: '#0f766e',
                            800: '#115e59',
                            900: '#134e4a',
                        },
                        accent: {
                            50: '#fff7ed',
                            100: '#ffedd5',
                            200: '#fed7aa',
                            300: '#fdba74',
                            400: '#fb923c',
                            500: '#f97316',
                            600: '#ea580c',
                            700: '#c2410c',
                            800: '#9a3412',
                            900: '#7c2d12',
                        },
                    },
                    animation: {
                        'float': 'float 6s ease-in-out infinite',
                        'pulse-slow': 'pulse 4s cubic-bezier(0.4, 0, 0.6, 1) infinite',
                        'slide-up': 'slideUp 0.6s ease-out',
                        'fade-in': 'fadeIn 0.8s ease-out',
                    },
                    keyframes: {
                        float: {
                            '0%, 100%': { transform: 'translateY(0px)' },
                            '50%': { transform: 'translateY(-20px)' },
                        },
                        slideUp: {
                            '0%': { transform: 'translateY(30px)', opacity: '0' },
                            '100%': { transform: 'translateY(0)', opacity: '1' },
                        },
                        fadeIn: {
                            '0%': { opacity: '0' },
                            '100%': { opacity: '1' },
                        },
                    },
                },
            },
        }
    </script>
    
    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
        }
        h1, h2, h3, h4, h5, h6 {
            font-family: 'Outfit', sans-serif;
        }
        
        /* Custom scrollbar */
        ::-webkit-scrollbar {
            width: 8px;
        }
        ::-webkit-scrollbar-track {
            background: #f1f5f9;
        }
        ::-webkit-scrollbar-thumb {
            background: #0d9488;
            border-radius: 4px;
        }
        ::-webkit-scrollbar-thumb:hover {
            background: #0f766e;
        }
        
        /* Gradient mesh background */
        .gradient-mesh {
            background: 
                radial-gradient(at 40% 20%, hsla(160, 84%, 39%, 0.15) 0px, transparent 50%),
                radial-gradient(at 80% 0%, hsla(189, 100%, 56%, 0.1) 0px, transparent 50%),
                radial-gradient(at 0% 50%, hsla(34, 100%, 54%, 0.1) 0px, transparent 50%),
                radial-gradient(at 80% 50%, hsla(160, 84%, 39%, 0.1) 0px, transparent 50%),
                radial-gradient(at 0% 100%, hsla(189, 100%, 56%, 0.15) 0px, transparent 50%);
        }
        
        /* Glass morphism */
        .glass {
            background: rgba(255, 255, 255, 0.7);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.3);
        }
        
        /* Input focus ring */
        .input-focus:focus {
            outline: none;
            box-shadow: 0 0 0 3px rgba(13, 148, 136, 0.2);
        }
        
        /* Gauge animation */
        @keyframes gaugeFill {
            from { stroke-dashoffset: 283; }
            to { stroke-dashoffset: var(--gauge-offset); }
        }
        .gauge-circle {
            animation: gaugeFill 1.5s ease-out forwards;
        }
    </style>
    
    @stack('styles')
</head>
<body class="min-h-screen bg-gradient-to-br from-slate-50 via-teal-50 to-orange-50 gradient-mesh">
    <!-- Main Content -->
    <main class="pb-16">
        @yield('content')
    </main>
    
    <!-- Footer -->
    <footer class="border-t border-slate-200 bg-white/50 backdrop-blur-sm">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            <div class="flex flex-col md:flex-row justify-between items-center space-y-4 md:space-y-0">
                <p class="text-sm text-slate-500">
                    © {{ date('Y') }} BMI Calculator. For informational purposes only.
                </p>
                <p class="text-sm text-slate-400">
                    Consult a healthcare professional for medical advice.
                </p>
            </div>
        </div>
    </footer>
    
    @stack('scripts')
</body>
</html>
