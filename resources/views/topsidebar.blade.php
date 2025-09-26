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
                            <div class="flex items-center justify-between p-2 rounded hover:bg-gray-200 dark:hover:bg-gray-700 text-sm text-gray-600 dark:text-gray-300 transition-colors duration-200 cursor-pointer relative" x-data="{ open: false }">
                                <span class="flex-grow" onclick="loadChatHistory({{ $chat->id }})">{{ $chat->name }}</span>
                                <button class="ml-2" @click="open = !open">
                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M10 6a2 2 0 110-4 2 2 0 010 4zM10 12a2 2 0 110-4 2 2 0 010 4zM10 18a2 2 0 110-4 2 2 0 010 4z"></path>
                                    </svg>
                                </button>
                                <div x-show="open" @click.away="open = false" class="absolute right-0 bottom-full mb-2 w-48 bg-white dark:bg-gray-800 rounded-md shadow-lg border border-gray-200 dark:border-gray-700 z-50">
                                    <div class="py-1">
                                        <a href="#" class="block px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700" onclick="renameChat({{ $chat->id }}, event)">Rename</a>
                                        <a href="#" class="block px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700" onclick="deleteChat({{ $chat->id }}, event)">Delete</a>
                                    </div>
                                </div>
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
        <div id="upgradeModal" class="hidden fixed inset-0 bg-gray-900 bg-opacity-75 flex items-center justify-center z-50">
            <div class="relative mx-auto p-8 border-0 w-full max-w-md shadow-lg rounded-xl bg-white dark:bg-chat-sidebar">
                <div class="text-center">
                    <h3 class="text-2xl font-bold text-gray-900 dark:text-white">Upgrade to Pro</h3>
                    <div class="mt-4 px-4 py-3">
                        <p class="text-md text-gray-600 dark:text-gray-400">
                            Unlock premium features and enhance your SQL workflow.
                        </p>
                        <ul class="list-none text-left mt-6 space-y-3 text-gray-700 dark:text-gray-300">
                            <li class="flex items-center"><svg class="w-5 h-5 text-green-500 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>Unlimited file uploads</li>
                            <li class="flex items-center"><svg class="w-5 h-5 text-green-500 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>Priority support</li>
                            <li class="flex items-center"><svg class="w-5 h-5 text-green-500 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>Access to new features first</li>
                            <li class="flex items-center"><svg class="w-5 h-5 text-green-500 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>No ads & higher API limits</li>
                        </ul>
                    </div>
                    <div class="items-center px-4 py-3 space-y-3 mt-4">
                        <button class="w-full text-md bg-gradient-to-br from-green-400 to-blue-500 px-4 py-3 rounded-lg text-white transition-colors duration-200 font-semibold">
                            Upgrade Now
                        </button>
                        <button id="closeModal" class="px-4 py-2 bg-transparent text-gray-500 dark:text-gray-400 text-sm font-medium rounded-md w-full hover:bg-gray-100 dark:hover:bg-gray-700 focus:outline-none">
                            Maybe Later
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Rename Chat Modal -->
        <div id="renameModal" class="hidden fixed inset-0 bg-gray-900 bg-opacity-75 flex items-center justify-center z-50">
            <div class="relative mx-auto p-8 border-0 w-full max-w-md shadow-lg rounded-xl bg-white dark:bg-chat-sidebar">
                <div class="text-center">
                    <h3 class="text-2xl font-bold text-gray-900 dark:text-white">Rename Chat</h3>
                    <div class="mt-4 px-4 py-3">
                        <p class="text-md text-gray-600 dark:text-gray-400 mb-4">
                            Enter a new name for this chat session.
                        </p>
                        <input type="text" id="newName" class="w-full px-4 py-3 bg-gray-100 dark:bg-chat-input border border-gray-300 dark:border-gray-600 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 dark:text-white" placeholder="New chat name...">
                    </div>
                    <div class="items-center px-4 py-3 space-y-3 mt-2">
                        <button id="saveRename" class="w-full text-md bg-blue-600 hover:bg-blue-700 px-4 py-3 rounded-lg text-white transition-colors duration-200 font-semibold">
                            Save Changes
                        </button>
                        <button id="closeRenameModal" class="px-4 py-2 bg-transparent text-gray-500 dark:text-gray-400 text-sm font-medium rounded-md w-full hover:bg-gray-100 dark:hover:bg-gray-700 focus:outline-none">
                            Cancel
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Delete Chat Modal -->
        <div id="deleteModal" class="hidden fixed inset-0 bg-gray-900 bg-opacity-75 flex items-center justify-center z-50">
            <div class="relative mx-auto p-8 border-0 w-full max-w-md shadow-lg rounded-xl bg-white dark:bg-chat-sidebar">
                <div class="text-center">
                    <div class="w-12 h-12 rounded-full bg-red-100 dark:bg-red-900/50 flex items-center justify-center mx-auto">
                        <svg class="w-6 h-6 text-red-600 dark:text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-900 dark:text-white mt-4">Delete Chat</h3>
                    <div class="mt-2 px-4 py-3">
                        <p class="text-md text-gray-600 dark:text-gray-400">
                            Are you sure you want to delete this chat? This action cannot be undone.
                        </p>
                    </div>
                    <div class="items-center px-4 py-3 space-y-3 mt-2">
                        <button id="confirmDelete" class="w-full text-md bg-red-600 hover:bg-red-700 px-4 py-3 rounded-lg text-white transition-colors duration-200 font-semibold">
                            Yes, Delete It
                        </button>
                        <button id="closeDeleteModal" class="px-4 py-2 bg-transparent text-gray-500 dark:text-gray-400 text-sm font-medium rounded-md w-full hover:bg-gray-100 dark:hover:bg-gray-700 focus:outline-none">
                            Cancel
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