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

        function handleFileUpload(event) {
            const file = event.target.files[0];
            if (file) {
                const fileName = file.name;
                const fileExtension = fileName.split('.').pop().toLowerCase();

                // Update button text to show selected file
                const button = event.target.parentNode.querySelector('button span');
                button.textContent = `📄 ${fileName}`;

                // Add visual feedback
                const uploadButton = event.target.parentNode.querySelector('button');
                uploadButton.classList.remove('border-gray-300', 'dark:border-gray-600');
                uploadButton.classList.add('bg-green-700', 'border-green-600');

                // Simulate file processing
                setTimeout(() => {
                    alert(`SQL file "${fileName}" uploaded successfully!\nType: ${fileExtension.toUpperCase()} database file`);
                }, 500);

                console.log('SQL file uploaded:', {
                    name: fileName,
                    size: file.size,
                    type: file.type,
                    extension: fileExtension
                });
            }
        }

        function toggleQueryOutput(queryId) {
            const outputDiv = document.getElementById(queryId);
            const arrow = document.querySelector(`[onclick="toggleQueryOutput('${queryId}')"] svg`);

            if (outputDiv.style.display === 'none' || outputDiv.style.display === '') {
                outputDiv.style.display = 'block';
                arrow.style.transform = 'rotate(180deg)';
            } else {
                outputDiv.style.display = 'none';
                arrow.style.transform = 'rotate(0deg)';
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

        function copyCode(element) {
            const codeBlock = element.closest('.code-block').querySelector('code');
            const text = codeBlock.textContent;

            navigator.clipboard.writeText(text).then(() => {
                const originalText = element.querySelector('span').textContent;
                element.querySelector('span').textContent = 'Copied!';
                element.classList.add('text-green-400');

                setTimeout(() => {
                    element.querySelector('span').textContent = originalText;
                    element.classList.remove('text-green-400');
                }, 2000);
            });
        }

        function sendMessage() {
            const input = document.getElementById('messageInput');
            const message = input.value.trim();

            if (message) {
                // Here you would typically send the message to your backend
                console.log('Sending message:', message);
                input.value = '';
                // Add your message sending logic here
            }
        }

        function handleKeyPress(event) {
            if (event.key === 'Enter' && !event.shiftKey) {
                event.preventDefault();
                sendMessage();
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
                <a href="{{ route('login') }}" class="w-full flex items-center space-x-3 p-3 rounded-lg hover:bg-gray-200 dark:hover:bg-gray-700 text-left transition-colors duration-200">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                    </svg>
                    <span>Get Started</span>
                </a>

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
                        <div class="p-2 rounded bg-blue-100 dark:bg-gray-700 text-sm">Query icon issue fix</div>
                        <div class="p-2 rounded hover:bg-gray-200 dark:hover:bg-gray-700 text-sm text-gray-600 dark:text-gray-300 transition-colors duration-200 cursor-pointer">Database schema analysis</div>
                        <div class="p-2 rounded hover:bg-gray-200 dark:hover:bg-gray-700 text-sm text-gray-600 dark:text-gray-300 transition-colors duration-200 cursor-pointer">JOIN optimization tips</div>
                        <div class="p-2 rounded hover:bg-gray-200 dark:hover:bg-gray-700 text-sm text-gray-600 dark:text-gray-300 transition-colors duration-200 cursor-pointer">Index performance review</div>
                        <div class="p-2 rounded hover:bg-gray-200 dark:hover:bg-gray-700 text-sm text-gray-600 dark:text-gray-300 transition-colors duration-200 cursor-pointer">Query execution plan</div>
                        <div class="p-2 rounded hover:bg-gray-200 dark:hover:bg-gray-700 text-sm text-gray-600 dark:text-gray-300 transition-colors duration-200 cursor-pointer">Table relationship mapping</div>
                        <div class="p-2 rounded hover:bg-gray-200 dark:hover:bg-gray-700 text-sm text-gray-600 dark:text-gray-300 transition-colors duration-200 cursor-pointer">SQL best practices guide</div>
                    </div>
                </div>
            </div>

            <!-- User Profile -->
            <div class="p-4 border-t border-gray-300 dark:border-gray-700">
                <div class="flex items-center space-x-3 mb-3">
                    <div class="w-8 h-8 bg-blue-600 rounded-full flex items-center justify-center text-sm font-semibold text-white">
                        NL
                    </div>
                    <div class="flex-1">
                        <div class="text-sm font-medium">NERAJ LAL</div>
                    </div>
                    <button class="text-xs bg-gray-600 hover:bg-gray-700 dark:bg-gray-700 dark:hover:bg-gray-600 px-3 py-1 rounded text-white transition-colors duration-200">
                        Free Plan
                    </button>
                </div>
                <div class="w-full">
                    <button class="w-full text-xs bg-gradient-to-br from-green-400 to-blue-500 px-3 py-2 rounded text-white transition-colors duration-200 font-medium">
                        Upgrade To Pro
                    </button>
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
                        <input type="file" id="fileUpload" accept=".sql,.db,.sqlite,.txt,.csv,.json" class="hidden" onchange="handleFileUpload(event)">
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
                                    <span>Export Queries</span>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Chat Messages -->
            <div class="flex-1 overflow-y-auto p-6 scrollbar-hide" style="scrollbar-width: none; -ms-overflow-style: none;">
                <style>
                    .scrollbar-hide::-webkit-scrollbar {
                        display: none;
                    }
                </style>
                <div class="max-w-4xl mx-auto space-y-6">
                    <!-- User Message -->
                    <div class="bg-gray-100 dark:bg-gray-700 rounded-lg p-6">
                        <div class="flex items-start space-x-3">
                            <div class="w-8 h-8 bg-blue-600 rounded-full flex items-center justify-center flex-shrink-0 text-sm font-semibold text-white">
                                NL
                            </div>
                            <div class="flex-1">
                                <p class="text-lg">give 2 simple sql queries</p>
                            </div>
                        </div>
                    </div>

                    <!-- Assistant Response -->
                    <div class="bg-gray-50 dark:bg-gray-800 rounded-lg p-6">
                        <div class="flex items-start space-x-3 mb-4">
                            <div class="w-6 h-6 bg-gradient-to-br from-green-400 to-blue-500 rounded-sm flex items-center justify-center flex-shrink-0">
                                <svg class="w-4 h-4 text-white" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M4 6h16v2H4zm0 5h16v2H4zm0 5h16v2H4z"/>
                                </svg>
                            </div>
                        </div>

                        <div class="space-y-6">
                            <p class="text-lg">Sure 👍 Here are <strong>two simple SQL queries</strong> you can try:</p>

                            <hr class="border-gray-300 dark:border-gray-600">

                            <!-- Query 1 -->
                            <div class="space-y-4">
                                <h3 class="text-xl font-semibold">1. Select all rows from a table</h3>

                                <div class="code-block bg-black rounded-lg p-4 relative">
                                    <div class="flex items-center justify-between mb-3">
                                        <span class="text-xs text-gray-400">sql</span>
                                        <div class="flex items-center space-x-2">
                                            <button onclick="copyCode(this)" class="flex items-center space-x-1 text-xs text-gray-400 hover:text-white transition-colors duration-200">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"></path>
                                                </svg>
                                                <span>Copy code</span>
                                            </button>
                                            <button onclick="toggleQueryOutput('query1Output')" class="hover:bg-gray-700 p-1 rounded transition-colors duration-200">
                                                <svg class="w-5 h-5 text-gray-400 transition-transform duration-200" fill="currentColor" viewBox="0 0 24 24">
                                                    <path d="M7 10L12 15L17 10H7Z"/>
                                                </svg>
                                            </button>
                                        </div>
                                    </div>
                                    <code class="text-sm block">
                                        <span class="text-blue-400">SELECT</span> <span class="text-yellow-400">*</span> <span class="text-blue-400">FROM</span> <span class="text-white">users</span><span class="text-white">;</span>
                                    </code>
                                </div>

                                <!-- Query 1 Output -->
                                <div id="query1Output" style="display: none;" class="bg-gray-100 dark:bg-gray-800 rounded-lg p-4 border border-gray-300 dark:border-gray-600">
                                    <div class="text-xs text-gray-600 dark:text-gray-400 mb-2">Query Output:</div>
                                    <div class="overflow-x-auto">
                                        <table class="w-full text-sm">
                                            <thead class="bg-gray-200 dark:bg-gray-700">
                                                <tr>
                                                    <th class="px-3 py-2 text-left">id</th>
                                                    <th class="px-3 py-2 text-left">name</th>
                                                    <th class="px-3 py-2 text-left">phone</th>
                                                    <th class="px-3 py-2 text-left">email</th>
                                                    <th class="px-3 py-2 text-left">created_at</th>
                                                </tr>
                                            </thead>
                                            <tbody class="text-gray-700 dark:text-gray-300">
                                                <tr class="border-b border-gray-300 dark:border-gray-600">
                                                    <td class="px-3 py-2">1</td>
                                                    <td class="px-3 py-2">John Doe</td>
                                                    <td class="px-3 py-2">9876543210</td>
                                                    <td class="px-3 py-2">john@example.com</td>
                                                    <td class="px-3 py-2">2024-01-15</td>
                                                </tr>
                                                <tr class="border-b border-gray-300 dark:border-gray-600">
                                                    <td class="px-3 py-2">2</td>
                                                    <td class="px-3 py-2">Jane Smith</td>
                                                    <td class="px-3 py-2">9876543211</td>
                                                    <td class="px-3 py-2">jane@example.com</td>
                                                    <td class="px-3 py-2">2024-01-16</td>
                                                </tr>
                                                <tr>
                                                    <td class="px-3 py-2">3</td>
                                                    <td class="px-3 py-2">Mike Johnson</td>
                                                    <td class="px-3 py-2">9876543212</td>
                                                    <td class="px-3 py-2">mike@example.com</td>
                                                    <td class="px-3 py-2">2024-01-17</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="text-xs text-green-500 mt-2">✓ 3 rows returned</div>
                                </div>

                                <div class="flex items-start space-x-2">
                                    <span class="text-lg">👉</span>
                                    <p class="text-gray-700 dark:text-gray-300">This will fetch all columns and rows from the <code class="bg-gray-200 dark:bg-gray-700 px-1 rounded text-sm">users</code> table.</p>
                                </div>
                            </div>

                            <hr class="border-gray-300 dark:border-gray-600">

                            <!-- Query 2 -->
                            <div class="space-y-4">
                                <h3 class="text-xl font-semibold">2. Insert a new record into a table</h3>

                                <div class="code-block bg-black rounded-lg p-4 relative">
                                    <div class="flex items-center justify-between mb-3">
                                        <span class="text-xs text-gray-400">sql</span>
                                        <div class="flex items-center space-x-2">
                                            <button onclick="copyCode(this)" class="flex items-center space-x-1 text-xs text-gray-400 hover:text-white transition-colors duration-200">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"></path>
                                                </svg>
                                                <span>Copy code</span>
                                            </button>
                                            <button onclick="toggleQueryOutput('query2Output')" class="hover:bg-gray-700 p-1 rounded transition-colors duration-200">
                                                <svg class="w-5 h-5 text-gray-400 transition-transform duration-200" fill="currentColor" viewBox="0 0 24 24">
                                                    <path d="M7 10L12 15L17 10H7Z"/>
                                                </svg>
                                            </button>
                                        </div>
                                    </div>
                                    <code class="text-sm block leading-relaxed">
                                        <span class="text-red-400">INSERT INTO</span> <span class="text-white">users</span> <span class="text-white">(name, phone, email, password)</span><br>
                                        <span class="text-red-400">VALUES</span> <span class="text-white">(</span><span class="text-green-400">'John Doe'</span><span class="text-white">, </span><span class="text-green-400">'9876543210'</span><span class="text-white">, </span><span class="text-green-400">'john@example.com'</span><span class="text-white">, </span><span class="text-green-400">'secret123'</span><span class="text-white">);</span>
                                    </code>
                                </div>

                                <!-- Query 2 Output -->
                                <div id="query2Output" style="display: none;" class="bg-gray-100 dark:bg-gray-800 rounded-lg p-4 border border-gray-300 dark:border-gray-600">
                                    <div class="text-xs text-gray-600 dark:text-gray-400 mb-2">Query Output:</div>
                                    <div class="bg-gray-200 dark:bg-gray-700 rounded p-3">
                                        <div class="text-green-500 text-sm font-mono">
                                            ✓ Query executed successfully<br>
                                            → 1 row inserted into 'users' table<br>
                                            → Affected rows: 1<br>
                                            → Execution time: 0.023s
                                        </div>
                                    </div>
                                    <div class="text-xs text-green-500 mt-2">✓ Insert operation completed</div>
                                </div>

                                <div class="flex items-start space-x-2">
                                    <span class="text-lg">👉</span>
                                    <p class="text-gray-700 dark:text-gray-300">This will add a new user record with the specified name, phone, email, and password to the <code class="bg-gray-200 dark:bg-gray-700 px-1 rounded text-sm">users</code> table.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Input Area -->
            <div class="p-4 border-t border-gray-300 dark:border-gray-700 bg-gray-50 dark:bg-chat-sidebar">
                <div class="max-w-4xl mx-auto">
                    <div class="bg-gray-100 dark:bg-chat-input rounded-lg flex items-center p-3">
                        <input
                            type="text"
                            id="messageInput"
                            placeholder="Ask about SQL queries, database optimization, schema design, or troubleshooting..."
                            class="flex-1 bg-transparent text-gray-900 dark:text-white placeholder-gray-500 dark:placeholder-gray-400 outline-none"
                            onkeypress="handleKeyPress(event)"
                        >
                        <button onclick="sendMessage()" class="ml-3 p-2 rounded hover:bg-gray-200 dark:hover:bg-gray-600 transition-colors duration-200">
                            <svg class="w-4 h-4 text-gray-600 dark:text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path>
                            </svg>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>