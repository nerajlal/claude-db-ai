<!DOCTYPE html>
<html lang="en" class="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ChatGPT Interface</title>
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
                uploadButton.classList.add('bg-green-700', 'border-green-600');
                
                // Simulate file processing
                setTimeout(() => {
                    alert(`File "${fileName}" uploaded successfully!\nType: ${fileExtension.toUpperCase()} file`);
                }, 500);
                
                console.log('File uploaded:', {
                    name: fileName,
                    size: file.size,
                    type: file.type,
                    extension: fileExtension
                });
            }
        }
    </script>
</head>
<body class="bg-chat-gray text-white font-sans">
    <!-- Main Container -->
    <div class="flex h-screen">
        <!-- Sidebar -->
        <div class="w-64 bg-chat-sidebar border-r border-gray-700 flex flex-col">
            <!-- Logo/Title -->
            <div class="p-4 border-b border-gray-700">
                <div class="flex items-center space-x-2">
                    <div class="w-6 h-6 bg-gradient-to-br from-green-400 to-blue-500 rounded-sm flex items-center justify-center">
                        <svg class="w-4 h-4 text-white" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12 2L13.09 7.91L19 9L13.09 10.09L12 16L10.91 10.09L5 9L10.91 7.91L12 2Z"/>
                        </svg>
                    </div>
                    <span class="text-lg font-semibold">ChatGPT</span>
                    <svg class="w-4 h-4 text-gray-400" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M7 10L12 15L17 10H7Z"/>
                    </svg>
                </div>
            </div>

            <!-- Navigation Items -->
            <div class="flex-1 p-2">
                <button class="w-full flex items-center space-x-3 p-3 rounded-lg hover:bg-gray-700 text-left">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                    </svg>
                    <span>New chat</span>
                </button>
                
                <button class="w-full flex items-center space-x-3 p-3 rounded-lg hover:bg-gray-700 text-left">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                    <span>Search chats</span>
                </button>

                <!-- Chat History -->
                <div class="mt-6">
                    <h3 class="text-sm text-gray-400 mb-2">Chats</h3>
                    <div class="space-y-1">
                        <div class="p-2 rounded bg-gray-700 text-sm">New chat</div>
                        <div class="p-2 rounded hover:bg-gray-700 text-sm text-gray-300">Add view all button</div>
                        <div class="p-2 rounded hover:bg-gray-700 text-sm text-gray-300">Graph analysis suggestion</div>
                        <div class="p-2 rounded hover:bg-gray-700 text-sm text-gray-300">Give Shopify access</div>
                        <div class="p-2 rounded hover:bg-gray-700 text-sm text-gray-300">Find database location</div>
                        <div class="p-2 rounded hover:bg-gray-700 text-sm text-gray-300">Change directory issue</div>
                        <div class="p-2 rounded hover:bg-gray-700 text-sm text-gray-300">ChatGPT for databases</div>
                    </div>
                </div>
            </div>

            <!-- User Profile -->
            <div class="p-4 border-t border-gray-700">
                <div class="flex items-center space-x-3">
                    <div class="w-8 h-8 bg-blue-600 rounded-full flex items-center justify-center text-sm font-semibold">
                        NL
                    </div>
                    <div class="flex-1">
                        <div class="text-sm font-medium">NERAJ LAL</div>
                        <div class="text-xs text-gray-400">Free</div>
                    </div>
                    <button class="text-xs bg-gray-700 hover:bg-gray-600 px-3 py-1 rounded">
                        Upgrade
                    </button>
                </div>
            </div>
        </div>

        <!-- Main Content -->
        <div class="flex-1 flex flex-col">
            <!-- Header -->
            <div class="flex items-center justify-between p-4 border-b border-gray-700">
                <div class="flex items-center space-x-2">
                    <!-- <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
                    </svg> -->
                </div>
                <div class="flex items-center space-x-2">
                    <!-- Upload File Button -->
                    <div class="relative">
                        <input type="file" id="fileUpload" accept=".sql,.txt,.csv,.json,.md,.py,.js,.html,.css" class="hidden" onchange="handleFileUpload(event)">
                        <button onclick="document.getElementById('fileUpload').click()" class="flex items-center space-x-2 px-3 py-1 rounded hover:bg-gray-700 border border-gray-600">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path>
                            </svg>
                            <span>Upload .sql</span>
                        </button>
                    </div>
                    <button class="flex items-center space-x-2 px-3 py-1 rounded hover:bg-gray-700">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.367 2.684 3 3 0 00-5.367-2.684z"></path>
                        </svg>
                        <span>Share</span>
                    </button>
                    <button class="p-2 rounded hover:bg-gray-700">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12 8c1.1 0 2-.9 2-2s-.9-2-2-2-2 .9-2 2 .9 2 2 2zm0 2c-1.1 0-2 .9-2 2s.9 2 2 2 2-.9 2-2-.9-2-2-2zm0 6c-1.1 0-2 .9-2 2s.9 2 2 2 2-.9 2-2-.9-2-2-2z"/>
                        </svg>
                    </button>
                </div>
            </div>

            <!-- Chat Messages -->
            <div class="flex-1 overflow-y-auto p-6">
                <div class="max-w-4xl mx-auto space-y-6">
                    <!-- User Message -->
                    
                    <!-- Assistant Response -->
                    <div class="bg-gray-800 rounded-lg p-6">
                        <div class="flex items-start space-x-3 mb-4">
                            <div class="w-6 h-6 bg-gradient-to-br from-green-400 to-blue-500 rounded-sm flex items-center justify-center flex-shrink-0">
                                <span class="text-xs text-white font-bold">🤖</span>
                            </div>
                        </div>
                        
                        <div class="space-y-4">
                            <p>Thanks for sharing the screenshot 👍 — now it's clear.</p>
                            
                            <p><strong>That coin icon before the cart</strong> is coming from this setting in your JSON:</p>
                            
                            <!-- JSON Code Block 1 -->
                            <div class="bg-black rounded-lg p-4 relative">
                                <div class="flex items-center justify-between mb-2">
                                    <span class="text-xs text-gray-400">json</span>
                                    <button class="flex items-center space-x-1 text-xs text-gray-400 hover:text-white">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"></path>
                                        </svg>
                                        <span>Copy code</span>
                                    </button>
                                </div>
                                <code class="text-sm">
                                    <span class="text-red-400">"show_points_icon"</span><span class="text-white">:</span> <span class="text-blue-400">true</span>
                                </code>
                            </div>

                            <div class="space-y-2">
                                <p><strong>So:</strong></p>
                                <ul class="space-y-1 ml-4">
                                    <li>• That "coin" = Points/Rewards icon.</li>
                                    <li>• It shows up only because <code class="bg-gray-700 px-1 rounded text-sm">"show_points_icon": true</code> in your header config.</li>
                                </ul>
                            </div>

                            <div class="flex items-center space-x-2">
                                <span class="text-lg">🔧</span>
                                <span class="font-semibold">To remove it:</span>
                            </div>

                            <p>Change it to <code class="bg-gray-700 px-1 rounded text-sm">false</code> in your JSON config:</p>

                            <!-- JSON Code Block 2 -->
                            <div class="bg-black rounded-lg p-4 relative">
                                <div class="flex items-center justify-between mb-2">
                                    <span class="text-xs text-gray-400">json</span>
                                    <button class="flex items-center space-x-1 text-xs text-gray-400 hover:text-white">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"></path>
                                        </svg>
                                        <span>Copy code</span>
                                    </button>
                                </div>
                                <code class="text-sm">
                                    <span class="text-red-400">"show_points_icon"</span><span class="text-white">:</span> <span class="text-blue-400">false</span>
                                </code>
                                <div class="absolute right-4 top-12">
                                    <svg class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M7 10L12 15L17 10H7Z"/>
                                    </svg>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Input Area -->
            <div class="p-4 border-t border-gray-700">
                <div class="max-w-4xl mx-auto">
                    <div class="bg-chat-input rounded-lg flex items-center p-4">
                        <button class="mr-3 p-1 rounded hover:bg-gray-600">
                            <!-- <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M12 2L13.09 7.91L19 9L13.09 10.09L12 16L10.91 10.09L5 9L10.91 7.91L12 2Z"/>
                            </svg> -->
                        </button>
                        <input 
                            type="text" 
                            placeholder="Ask anything"
                            class="flex-1 bg-transparent text-white placeholder-gray-400 outline-none"
                        >
                        <button class="ml-3 p-2 rounded hover:bg-gray-600">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11a7 7 0 01-7 7m0 0a7 7 0 01-7-7m7 7v4m0 0H8m4 0h4m-4-8a3 3 0 01-3-3V5a3 3 0 116 0v6a3 3 0 01-3 3z"></path>
                            </svg>
                        </button>
                        <!-- <button class="ml-2 p-2 rounded hover:bg-gray-600">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19V6l12-1v13M9 19c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zm12-1c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zM9 10l12-1"></path>
                            </svg>
                        </button> -->
                    </div>
                    <div class="text-center text-xs text-gray-400 mt-2">
                        ChatGPT can make mistakes. Check important info. See <a href="#" class="underline">Cookie Preferences</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>