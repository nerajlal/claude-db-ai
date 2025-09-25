@include('topsidebar')


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