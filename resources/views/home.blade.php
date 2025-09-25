@include('topsidebar')


            <!-- Chat Messages -->
            <div id="chat-messages" class="flex-1 overflow-y-auto p-6 scrollbar-hide" style="scrollbar-width: none; -ms-overflow-style: none;">
                <style>
                    .scrollbar-hide::-webkit-scrollbar {
                        display: none;
                    }
                </style>
                <div class="max-w-4xl mx-auto space-y-6">
                    <!-- Messages will be dynamically inserted here -->
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