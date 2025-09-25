<!DOCTYPE html>
<html lang="en" class="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SQL Assistant - ChatGPT Interface</title>
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
                    }
                }
            }
        }




        function toggleTheme() {
            const html = document.documentElement;
            const body = document.body;
            const themeIcon = document.getElementById('themeIcon');
            const themeText = document.getElementById('themeText');

            if (html.classList.contains('dark')) {
                // Switch to light mode
                html.classList.remove('dark');
                themeIcon.innerHTML = '🌙';
                themeText.textContent = 'Dark';
            } else {
                // Switch to dark mode
                html.classList.add('dark');
                themeIcon.innerHTML = '☀️';
                themeText.textContent = 'Light';
            }
        }

        function toggleShareDropdown() {
            const dropdown = document.getElementById('shareDropdown');
            if (dropdown.classList.contains('hidden')) {
                dropdown.classList.remove('hidden');
            } else {
                dropdown.classList.add('hidden');
            }
        }

        function shareOption(type) {
            const dropdown = document.getElementById('shareDropdown');
            dropdown.classList.add('hidden');

            switch(type) {
                case 'link':
                    navigator.clipboard.writeText(window.location.href);
                    alert('Link copied to clipboard!');
                    break;
                case 'twitter':
                    window.open('https://twitter.com/intent/tweet?text=Check out these SQL queries!&url=' + encodeURIComponent(window.location.href), '_blank');
                    break;
                case 'linkedin':
                    window.open('https://www.linkedin.com/sharing/share-offsite/?url=' + encodeURIComponent(window.location.href), '_blank');
                    break;
                case 'email':
                    window.location.href = 'mailto:?subject=SQL Queries&body=Check out these helpful SQL queries: ' + window.location.href;
                    break;
                case 'export':
                    alert('Exporting queries... (Feature coming soon)');
                    break;
            }
        }

        // Close dropdown when clicking outside
        document.addEventListener('DOMContentLoaded', function() {
            document.addEventListener('click', function(event) {
                const shareButton = document.querySelector('[onclick="toggleShareDropdown()"]');
                const dropdown = document.getElementById('shareDropdown');
                if (shareButton && dropdown && !shareButton.contains(event.target) && !dropdown.contains(event.target)) {
                    dropdown.classList.add('hidden');
                }
            });

            const upgradeButton = document.querySelector('.font-medium');
            const modal = document.getElementById('upgradeModal');
            const closeModal = document.getElementById('closeModal');

            upgradeButton.addEventListener('click', () => {
                modal.classList.remove('hidden');
            });

            closeModal.addEventListener('click', () => {
                modal.classList.add('hidden');
            });
        });
    </script>
</head>
<body class="bg-white dark:bg-chat-gray text-gray-900 dark:text-white font-sans transition-colors duration-200">
    <!-- Main Container -->
    <div class="flex h-screen">
        <!-- Sidebar -->
        <div class="w-64 bg-gray-100 dark:bg-chat-sidebar border-r border-gray-300 dark:border-gray-700 flex flex-col transition-colors duration-200">
            <!-- Logo/Title -->
            <div class="p-4 border-b border-gray-300 dark:border-gray-700">
                <div class="flex items-center space-x-2">
                    <div class="w-6 h-6 bg-gradient-to-br from-green-400 to-blue-500 rounded-sm flex items-center justify-center">
                        <svg class="w-4 h-4 text-white" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M4 6h16v2H4zm0 5h16v2H4zm0 5h16v2H4z"/>
                        </svg>
                    </div>
                    <span class="text-lg font-semibold">SQL Assistant</span>
                </div>
            </div>

            <!-- Navigation Items -->
            <div class="flex-1 p-2">
                <button onclick="newChat()" class="w-full flex items-center space-x-3 p-3 rounded-lg hover:bg-gray-200 dark:hover:bg-gray-700 text-left transition-colors duration-200">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                    </svg>
                    <span>New SQL chat</span>
                </button>
                
                <button class="w-full flex items-center space-x-3 p-3 rounded-lg hover:bg-gray-200 dark:hover:bg-gray-700 text-left transition-colors duration-200">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                    <span>Search queries</span>
                </button>

                <!-- Chat History -->
                <div class="mt-6">
                    <h3 class="text-sm text-gray-600 dark:text-gray-400 mb-2">SQL Chats</h3>
                    <div class="space-y-1">
                        @foreach($chats as $chat)
                            <div class="p-2 rounded hover:bg-gray-200 dark:hover:bg-gray-700 text-sm text-gray-600 dark:text-gray-300 transition-colors duration-200 cursor-pointer" onclick="loadChatHistory({{ $chat->id }})">
                                Chat #{{ $chat->id }}
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- User Profile -->
            <div class="p-4 border-t border-gray-300 dark:border-gray-700">
                <div class="flex items-center space-x-3 mb-3">
                    <div class="w-8 h-8 bg-blue-600 rounded-full flex items-center justify-center text-sm font-semibold text-white">
                        {{ $initials }}
                    </div>
                    <div class="flex-1">
                        <div class="text-sm font-medium">{{ Auth::user()->name }}</div>
                    </div>
                    <button class="text-xs bg-gray-600 hover:bg-gray-700 dark:bg-gray-700 dark:hover:bg-gray-600 px-3 py-1 rounded text-white transition-colors duration-200">
                        Free Plan
                    </button>
                </div>
                <div class="w-full">
                    <button id="upgradeProButton" class="w-full text-xs bg-gradient-to-br from-green-400 to-blue-500 px-3 py-2 rounded text-white transition-colors duration-200 font-medium">
                        Upgrade To Pro
                    </button>
                </div>
            </div>
        </div>

        <!-- Upgrade to Pro Modal -->
        <div id="upgradeModal" class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full flex items-center justify-center">
            <div class="relative mx-auto p-5 border w-96 shadow-lg rounded-md bg-white dark:bg-gray-800">
                <div class="mt-3 text-center">
                    <h3 class="text-lg leading-6 font-medium text-gray-900 dark:text-white">Upgrade to Pro</h3>
                    <div class="mt-2 px-7 py-3">
                        <p class="text-sm text-gray-500 dark:text-gray-400">
                            Upgrade and get these premium features:
                        </p>
                        <ul class="list-disc text-left mt-4">
                            <li>Unlimited file uploads</li>
                            <li>Priority support</li>
                            <li>Access to new features first</li>
                            <li>No ads</li>
                            <li>Higher API rate limits</li>
                        </ul>
                    </div>
                    <div class="items-center px-4 py-3">
                        <button id="closeModal" class="px-4 py-2 bg-gray-500 text-white text-base font-medium rounded-md w-full shadow-sm hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-gray-300">
                            Close
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main Content -->
        <div class="flex-1 flex flex-col bg-white dark:bg-chat-gray transition-colors duration-200">
            <!-- Header -->
            <div class="flex items-center justify-between p-4 border-b border-gray-300 dark:border-gray-700">
                <div class="flex items-center space-x-2">
                    <h1 class="text-lg font-semibold">SQL Database Assistant</h1>
                </div>
                <div class="flex items-center space-x-2">
                    <!-- Theme Toggle -->
                    <button onclick="toggleTheme()" class="flex items-center space-x-2 px-3 py-1 rounded hover:bg-gray-200 dark:hover:bg-gray-700 border border-gray-300 dark:border-gray-600 transition-colors duration-200">
                        <span id="themeIcon">☀️</span>
                        <span id="themeText">Light</span>
                    </button>
                    
                    <!-- Upload SQL File Button -->
                    <div class="relative">
                        <input type="file" id="fileUpload" accept=".sql,.db,.sqlite,.txt,.csv,.json" class="hidden">
                        <button onclick="document.getElementById('fileUpload').click()" class="flex items-center space-x-2 px-3 py-1 rounded hover:bg-gray-200 dark:hover:bg-gray-700 border border-gray-300 dark:border-gray-600 transition-colors duration-200">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path>
                            </svg>
                            <span>Upload .sql</span>
                        </button>
                    </div>
                    
                    <!-- Share Button with Dropdown -->
                    <div class="relative">
                        <button onclick="toggleShareDropdown()" class="flex items-center space-x-2 px-3 py-1 rounded hover:bg-gray-200 dark:hover:bg-gray-700 border border-gray-300 dark:border-gray-600 transition-colors duration-200">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.367 2.684 3 3 0 00-5.367-2.684z"></path>
                            </svg>
                            <span>Share Chat</span>
                            <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"/>
                            </svg>
                        </button>
                        
                        <!-- Share Dropdown -->
                        <div id="shareDropdown" class="hidden absolute right-0 mt-2 w-48 bg-white dark:bg-gray-800 rounded-md shadow-lg border border-gray-200 dark:border-gray-700 z-10">
                            <div class="py-1">
                                <button onclick="shareOption('link')" class="w-full text-left px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 flex items-center space-x-2">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"/>
                                    </svg>
                                    <span>Copy Link</span>
                                </button>
                                <button onclick="shareOption('twitter')" class="w-full text-left px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 flex items-center space-x-2">
                                    <span class="text-blue-400">🐦</span>
                                    <span>Share on Twitter</span>
                                </button>
                                <button onclick="shareOption('linkedin')" class="w-full text-left px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 flex items-center space-x-2">
                                    <span class="text-blue-600">💼</span>
                                    <span>Share on LinkedIn</span>
                                </button>
                                <button onclick="shareOption('email')" class="w-full text-left px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 flex items-center space-x-2">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                                    </svg>
                                    <span>Send via Email</span>
                                </button>
                                <hr class="my-1 border-gray-200 dark:border-gray-600">
                                <button onclick="shareOption('export')" class="w-full text-left px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 flex items-center space-x-2">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                    </svg>
                                    <span>Export Chat</span>
                                </button>
                            </div>
                        </div>
                    </div>
                    <!-- Logout Button -->
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="flex items-center space-x-2 px-3 py-1 rounded hover:bg-gray-200 dark:hover:bg-gray-700 border border-gray-300 dark:border-gray-600 transition-colors duration-200">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                            </svg>
                            <span>Logout</span>
                        </button>
                    </form>
                </div>
            </div>