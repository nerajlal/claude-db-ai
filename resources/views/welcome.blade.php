<!DOCTYPE html>
<html lang="en" class="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SQL Assistant - Your AI-Powered SQL Companion</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    colors: {
                        'chat-gray': '#202123',
                        'chat-sidebar': '#171717',
                        'chat-input': '#40414f'
                    },
                    animation: {
                        'float': 'float 6s ease-in-out infinite',
                        'pulse-slow': 'pulse 3s infinite',
                        'fade-in': 'fadeIn 0.8s ease-out',
                        'slide-up': 'slideUp 0.8s ease-out'
                    },
                    keyframes: {
                        float: {
                            '0%, 100%': { transform: 'translateY(0px)' },
                            '50%': { transform: 'translateY(-20px)' }
                        },
                        fadeIn: {
                            '0%': { opacity: '0' },
                            '100%': { opacity: '1' }
                        },
                        slideUp: {
                            '0%': { transform: 'translateY(30px)', opacity: '0' },
                            '100%': { transform: 'translateY(0)', opacity: '1' }
                        }
                    }
                }
            }
        }
    </script>
</head>
<body class="bg-chat-sidebar text-white overflow-x-hidden">
    <!-- Navigation -->
    <nav class="fixed top-0 w-full bg-chat-sidebar/90 backdrop-blur-sm z-50 border-b border-gray-800">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <div class="flex items-center space-x-3">
                    <div class="w-8 h-8 bg-gradient-to-br from-green-400 to-blue-500 rounded-lg flex items-center justify-center">
                        <span class="text-white font-bold text-sm">SQL</span>
                    </div>
                    <span class="text-xl font-bold">SQL Assistant</span>
                </div>
                <div class="hidden md:flex items-center space-x-8">
                    <a href="#features" class="text-gray-300 hover:text-white transition-colors">Features</a>
                    <a href="#demo" class="text-gray-300 hover:text-white transition-colors">Demo</a>
                    <a href="#pricing" class="text-gray-300 hover:text-white transition-colors">Pricing</a>
                    <a href="{{ route('login') }}" class="bg-gradient-to-br from-green-400 to-blue-500 hover:bg-gradient-to-bl text-white px-6 py-2 rounded-lg font-medium transition-all duration-200 hover:scale-105">
                        Get Started
                    </a>
                </div>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="pt-24 pb-16 px-4 sm:px-6 lg:px-8">
        <div class="max-w-7xl mx-auto">
            <div class="text-center animate-fade-in">
                <div class="mb-8 inline-block">
                    <div class="bg-gradient-to-br from-green-400/20 to-blue-500/20 rounded-full p-4 animate-pulse-slow">
                        <div class="w-16 h-16 bg-gradient-to-br from-green-400 to-blue-500 rounded-full flex items-center justify-center">
                            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 7v10c0 2.21 3.582 4 8 4s8-1.79 8-4V7M4 7c0 2.21 3.582 4 8 4s8-1.79 8-4M4 7c0-2.21 3.582-4 8-4s8 1.79 8 4m0 5c0 2.21-3.582 4-8 4s-8-1.79-8-4"></path>
                            </svg>
                        </div>
                    </div>
                </div>
                
                <h1 class="text-5xl md:text-7xl font-bold mb-6 bg-gradient-to-r from-green-400 via-blue-500 to-purple-600 bg-clip-text text-transparent">
                    SQL Assistant
                </h1>
                
                <p class="text-xl md:text-2xl text-gray-300 mb-4 max-w-3xl mx-auto">
                    Your AI-Powered SQL Companion
                </p>
                
                <p class="text-lg text-gray-400 mb-12 max-w-2xl mx-auto">
                    The ChatGPT for SQL. Write, optimize, debug, and learn SQL with the power of AI. 
                    From simple queries to complex database operations - we've got you covered.
                </p>
                
                <div class="flex flex-col sm:flex-row gap-4 justify-center items-center">
                    <a href="{{ route('login') }}" class="group w-full sm:w-auto bg-gradient-to-br from-green-400 to-blue-500 hover:bg-gradient-to-bl text-white px-8 py-4 rounded-lg font-semibold text-lg transition-all duration-300 hover:scale-105 hover:shadow-2xl hover:shadow-blue-500/25">
                        Start Writing SQL
                        <svg class="inline-block ml-2 w-5 h-5 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path>
                        </svg>
                    </a>
                    <button class="w-full sm:w-auto border border-gray-600 text-white px-8 py-4 rounded-lg font-semibold text-lg hover:bg-gray-800 transition-all duration-200">
                        Watch Demo
                    </button>
                </div>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section id="features" class="py-20 px-4 sm:px-6 lg:px-8 bg-chat-gray">
        <div class="max-w-7xl mx-auto">
            <div class="text-center mb-16 animate-slide-up">
                <h2 class="text-4xl font-bold mb-4">Why Choose SQL Assistant?</h2>
                <p class="text-xl text-gray-400 max-w-2xl mx-auto">
                    Designed specifically for SQL, our AI understands database queries like no other
                </p>
            </div>
            
            <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
                <div class="bg-chat-sidebar p-8 rounded-xl border border-gray-800 hover:border-blue-500/50 transition-all duration-300 hover:transform hover:scale-105 group">
                    <div class="w-12 h-12 bg-gradient-to-br from-green-400 to-blue-500 rounded-lg flex items-center justify-center mb-6 group-hover:animate-pulse">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold mb-4">Lightning Fast Queries</h3>
                    <p class="text-gray-400">Generate optimized SQL queries in seconds. From simple SELECT statements to complex JOINs and subqueries.</p>
                </div>
                
                <div class="bg-chat-sidebar p-8 rounded-xl border border-gray-800 hover:border-blue-500/50 transition-all duration-300 hover:transform hover:scale-105 group">
                    <div class="w-12 h-12 bg-gradient-to-br from-purple-400 to-pink-500 rounded-lg flex items-center justify-center mb-6 group-hover:animate-pulse">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold mb-4">Smart Debugging</h3>
                    <p class="text-gray-400">Identify and fix SQL errors instantly. Our AI explains what went wrong and suggests corrections.</p>
                </div>
                
                <div class="bg-chat-sidebar p-8 rounded-xl border border-gray-800 hover:border-blue-500/50 transition-all duration-300 hover:transform hover:scale-105 group">
                    <div class="w-12 h-12 bg-gradient-to-br from-yellow-400 to-orange-500 rounded-lg flex items-center justify-center mb-6 group-hover:animate-pulse">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold mb-4">Learn as You Go</h3>
                    <p class="text-gray-400">Get detailed explanations for every query. Perfect for beginners and experts looking to improve.</p>
                </div>
                
                <div class="bg-chat-sidebar p-8 rounded-xl border border-gray-800 hover:border-blue-500/50 transition-all duration-300 hover:transform hover:scale-105 group">
                    <div class="w-12 h-12 bg-gradient-to-br from-cyan-400 to-blue-500 rounded-lg flex items-center justify-center mb-6 group-hover:animate-pulse">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 7v10c0 2.21 3.582 4 8 4s8-1.79 8-4V7M4 7c0 2.21 3.582 4 8 4s8-1.79 8-4M4 7c0-2.21 3.582-4 8-4s8 1.79 8 4"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold mb-4">Multi-Database Support</h3>
                    <p class="text-gray-400">Works with PostgreSQL, MySQL, SQLite, SQL Server, Oracle, and more. One tool for all your databases.</p>
                </div>
                
                <div class="bg-chat-sidebar p-8 rounded-xl border border-gray-800 hover:border-blue-500/50 transition-all duration-300 hover:transform hover:scale-105 group">
                    <div class="w-12 h-12 bg-gradient-to-br from-red-400 to-pink-500 rounded-lg flex items-center justify-center mb-6 group-hover:animate-pulse">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold mb-4">Query Optimization</h3>
                    <p class="text-gray-400">Automatically optimize your queries for better performance. Reduce execution time and resource usage.</p>
                </div>
                
                <div class="bg-chat-sidebar p-8 rounded-xl border border-gray-800 hover:border-blue-500/50 transition-all duration-300 hover:transform hover:scale-105 group">
                    <div class="w-12 h-12 bg-gradient-to-br from-indigo-400 to-purple-500 rounded-lg flex items-center justify-center mb-6 group-hover:animate-pulse">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold mb-4">Natural Language</h3>
                    <p class="text-gray-400">Describe what you want in plain English, and get perfect SQL. No need to remember complex syntax.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Demo Section -->
    <section id="demo" class="py-20 px-4 sm:px-6 lg:px-8">
        <div class="max-w-6xl mx-auto">
            <div class="text-center mb-16">
                <h2 class="text-4xl font-bold mb-4">See It In Action</h2>
                <p class="text-xl text-gray-400">Watch how SQL Assistant transforms your database workflow</p>
            </div>
            
            <div class="bg-chat-gray rounded-2xl p-8 border border-gray-800">
                <div class="flex items-center mb-6">
                    <div class="flex space-x-2">
                        <div class="w-3 h-3 bg-red-500 rounded-full"></div>
                        <div class="w-3 h-3 bg-yellow-500 rounded-full"></div>
                        <div class="w-3 h-3 bg-green-500 rounded-full"></div>
                    </div>
                    <div class="flex-1 text-center">
                        <span class="text-gray-400 text-sm">SQL Assistant Chat</span>
                    </div>
                </div>
                
                <div class="space-y-4">
                    <div class="flex justify-end">
                        <div class="bg-gradient-to-br from-green-400 to-blue-500 text-white px-4 py-3 rounded-lg max-w-md">
                            Show me all customers who bought more than $1000 worth of products last month
                        </div>
                    </div>
                    
                    <div class="flex justify-start">
                        <div class="bg-chat-input text-white px-4 py-3 rounded-lg max-w-2xl">
                            <div class="font-mono text-sm bg-gray-900 p-4 rounded mb-3">
                                <span class="text-blue-400">SELECT</span> c.customer_id, c.name, <span class="text-green-400">SUM</span>(oi.quantity * oi.price) <span class="text-blue-400">AS</span> total_spent<br/>
                                <span class="text-blue-400">FROM</span> customers c<br/>
                                <span class="text-blue-400">JOIN</span> orders o <span class="text-blue-400">ON</span> c.customer_id = o.customer_id<br/>
                                <span class="text-blue-400">JOIN</span> order_items oi <span class="text-blue-400">ON</span> o.order_id = oi.order_id<br/>
                                <span class="text-blue-400">WHERE</span> o.order_date >= <span class="text-yellow-400">DATE_SUB(CURDATE(), INTERVAL 1 MONTH)</span><br/>
                                <span class="text-blue-400">GROUP BY</span> c.customer_id, c.name<br/>
                                <span class="text-blue-400">HAVING</span> total_spent > <span class="text-purple-400">1000</span><br/>
                                <span class="text-blue-400">ORDER BY</span> total_spent <span class="text-blue-400">DESC</span>;
                            </div>
                            <p class="text-gray-300 text-sm">This query joins the customers, orders, and order_items tables to calculate total spending per customer in the last month, filtering for those who spent over $1000.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="py-20 px-4 sm:px-6 lg:px-8 bg-gradient-to-br from-green-900/20 to-blue-900/20">
        <div class="max-w-4xl mx-auto text-center">
            <h2 class="text-4xl md:text-5xl font-bold mb-6">Ready to Transform Your SQL Workflow?</h2>
            <p class="text-xl text-gray-300 mb-8 max-w-2xl mx-auto">
                Join thousands of developers who are already writing better SQL with AI assistance
            </p>
            
            <div class="flex flex-col sm:flex-row gap-4 justify-center items-center">
                <a href="{{ route('login') }}" class="w-full sm:w-auto bg-gradient-to-br from-green-400 to-blue-500 hover:bg-gradient-to-bl text-white px-8 py-4 rounded-lg font-semibold text-lg transition-all duration-300 hover:scale-105 hover:shadow-2xl hover:shadow-blue-500/25">
                    Start Free Trial
                </a>
                <button class="w-full sm:w-auto border border-gray-600 text-white px-8 py-4 rounded-lg font-semibold text-lg hover:bg-gray-800 transition-all duration-200">
                    View Pricing
                </button>
            </div>
            
            <p class="text-sm text-gray-400 mt-4">No credit card required • 7-day free trial</p>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-chat-sidebar py-12 px-4 sm:px-6 lg:px-8 border-t border-gray-800">
        <div class="max-w-7xl mx-auto">
            <div class="grid md:grid-cols-4 gap-8">
                <div class="md:col-span-1">
                    <div class="flex items-center space-x-3 mb-4">
                        <div class="w-8 h-8 bg-gradient-to-br from-green-400 to-blue-500 rounded-lg flex items-center justify-center">
                            <span class="text-white font-bold text-sm">SQL</span>
                        </div>
                        <span class="text-xl font-bold">SQL Assistant</span>
                    </div>
                    <p class="text-gray-400 text-sm">
                        Your AI-powered companion for all things SQL. Write, debug, and optimize queries with ease.
                    </p>
                </div>
                
                <div>
                    <h4 class="font-semibold mb-4">Product</h4>
                    <ul class="space-y-2 text-sm text-gray-400">
                        <li><a href="#" class="hover:text-white transition-colors">Features</a></li>
                        <li><a href="#" class="hover:text-white transition-colors">Pricing</a></li>
                        <li><a href="#" class="hover:text-white transition-colors">Demo</a></li>
                        <li><a href="#" class="hover:text-white transition-colors">API</a></li>
                    </ul>
                </div>
                
                <div>
                    <h4 class="font-semibold mb-4">Resources</h4>
                    <ul class="space-y-2 text-sm text-gray-400">
                        <li><a href="#" class="hover:text-white transition-colors">Documentation</a></li>
                        <li><a href="#" class="hover:text-white transition-colors">Tutorials</a></li>
                        <li><a href="#" class="hover:text-white transition-colors">Blog</a></li>
                        <li><a href="#" class="hover:text-white transition-colors">Support</a></li>
                    </ul>
                </div>
                
                <div>
                    <h4 class="font-semibold mb-4">Company</h4>
                    <ul class="space-y-2 text-sm text-gray-400">
                        <li><a href="#" class="hover:text-white transition-colors">About</a></li>
                        <li><a href="#" class="hover:text-white transition-colors">Contact</a></li>
                        <li><a href="#" class="hover:text-white transition-colors">Privacy</a></li>
                        <li><a href="#" class="hover:text-white transition-colors">Terms</a></li>
                    </ul>
                </div>
            </div>
            
            <div class="border-t border-gray-800 mt-8 pt-8 text-center">
                <p class="text-gray-400 text-sm">
                    © 2025 SQL Assistant. All rights reserved.
                </p>
            </div>
        </div>
    </footer>

    <script>
        // Add smooth scrolling for anchor links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                }
            });
        });

        // Add scroll animations
        const observerOptions = {
            threshold: 0.1,
            rootMargin: '0px 0px -50px 0px'
        };

        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.style.opacity = '1';
                    entry.target.style.transform = 'translateY(0)';
                }
            });
        }, observerOptions);

        // Observe elements for animations
        document.querySelectorAll('.animate-slide-up').forEach(el => {
            el.style.opacity = '0';
            el.style.transform = 'translateY(30px)';
            el.style.transition = 'all 0.8s ease-out';
            observer.observe(el);
        });
    </script>
</body>
</html>