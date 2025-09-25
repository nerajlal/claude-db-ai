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

    <script>
        let currentChatId = null;

        function handleFileUpload(event) {
            const file = event.target.files[0];
            if (file) {
                const fileName = file.name;
                const fileExtension = fileName.split('.').pop().toLowerCase();

                // Update button text to show selected file
                const button = document.querySelector('#fileUpload + button span');
                button.textContent = `📄 ${fileName}`;

                // Add visual feedback
                const uploadButton = document.querySelector('#fileUpload + button');
                uploadButton.classList.remove('border-gray-300', 'dark:border-gray-600');
                uploadButton.classList.add('bg-green-700', 'border-green-600');

                const formData = new FormData();
                formData.append('file', file);
                if (currentChatId) {
                    formData.append('chat_id', currentChatId);
                }

                fetch('{{ route('upload') }}', {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: formData
                })
                .then(response => response.json())
                .then(data => {
                    if (data.chat_id) {
                        currentChatId = data.chat_id;
                    }
                    if (data.reply) {
                        const chatMessages = document.getElementById('chat-messages').querySelector('.space-y-6');
                        const assistantMessage = document.createElement('div');
                        assistantMessage.className = 'bg-gray-50 dark:bg-gray-800 rounded-lg p-6';
                        assistantMessage.innerHTML = `
                            <div class="flex items-start space-x-3 mb-4">
                                <div class="w-6 h-6 bg-gradient-to-br from-green-400 to-blue-500 rounded-sm flex items-center justify-center flex-shrink-0">
                                    <svg class="w-4 h-4 text-white" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M4 6h16v2H4zm0 5h16v2H4zm0 5h16v2H4z"/>
                                    </svg>
                                </div>
                            </div>
                            <div class="space-y-6">
                                <p class="text-lg">${data.reply}</p>
                            </div>
                        `;
                        chatMessages.appendChild(assistantMessage);
                    }
                    alert(data.message);
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('File upload failed.');
                });
            }
        }

        function sendMessage() {
            const input = document.getElementById('messageInput');
            const message = input.value.trim();

            if (message) {
                const chatMessages = document.getElementById('chat-messages').querySelector('.space-y-6');

                // Add user message to chat
                const userMessage = document.createElement('div');
                userMessage.className = 'bg-gray-100 dark:bg-gray-700 rounded-lg p-6';
                userMessage.innerHTML = `
                    <div class="flex items-start space-x-3">
                        <div class="w-8 h-8 bg-blue-600 rounded-full flex items-center justify-center flex-shrink-0 text-sm font-semibold text-white">
                            {{ $initials }}
                        </div>
                        <div class="flex-1">
                            <p class="text-lg">${message}</p>
                        </div>
                    </div>
                `;
                chatMessages.appendChild(userMessage);

                input.value = '';

                fetch('{{ route('chat') }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({ message: message, chat_id: currentChatId })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.chat_id && !currentChatId) {
                        currentChatId = data.chat_id;
                        const newChatItem = document.createElement('div');
                        newChatItem.className = 'p-2 rounded hover:bg-gray-200 dark:hover:bg-gray-700 text-sm text-gray-600 dark:text-gray-300 transition-colors duration-200 cursor-pointer';
                        newChatItem.textContent = `Chat #${currentChatId}`;
                        newChatItem.onclick = () => loadChatHistory(currentChatId);
                        document.querySelector('.space-y-1').prepend(newChatItem);
                    }

                    const assistantMessage = document.createElement('div');
                    assistantMessage.className = 'bg-gray-50 dark:bg-gray-800 rounded-lg p-6';
                    assistantMessage.innerHTML = `
                        <div class="flex items-start space-x-3 mb-4">
                            <div class="w-6 h-6 bg-gradient-to-br from-green-400 to-blue-500 rounded-sm flex items-center justify-center flex-shrink-0">
                                <svg class="w-4 h-4 text-white" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M4 6h16v2H4zm0 5h16v2H4zm0 5h16v2H4z"/>
                                </svg>
                            </div>
                        </div>
                        <div class="space-y-6">
                            <p class="text-lg">${data.reply}</p>
                        </div>
                    `;
                    chatMessages.appendChild(assistantMessage);
                })
                .catch(error => {
                    console.error('Error:', error);
                });
            }
        }

        function handleKeyPress(event) {
            if (event.key === 'Enter' && !event.shiftKey) {
                event.preventDefault();
                sendMessage();
            }
        }

        function loadChatHistory(chatId) {
            currentChatId = chatId;
            const chatMessages = document.getElementById('chat-messages').querySelector('.space-y-6');
            chatMessages.innerHTML = '';
            const uploadButtonSpan = document.querySelector('#fileUpload + button span');

            fetch(`/chat/history/${chatId}`)
                .then(response => response.json())
                .then(data => {
                    if (data.files && data.files.length > 0) {
                        uploadButtonSpan.textContent = `📄 ${data.files[0].filename}`;
                    } else {
                        uploadButtonSpan.textContent = 'Upload .sql';
                    }

                    data.messages.forEach(message => {
                        const messageElement = document.createElement('div');
                        if (message.sender === 'user') {
                            messageElement.className = 'bg-gray-100 dark:bg-gray-700 rounded-lg p-6';
                            messageElement.innerHTML = `
                                <div class="flex items-start space-x-3">
                                    <div class="w-8 h-8 bg-blue-600 rounded-full flex items-center justify-center flex-shrink-0 text-sm font-semibold text-white">
                                        NL
                                    </div>
                                    <div class="flex-1">
                                        <p class="text-lg">${message.content}</p>
                                    </div>
                                </div>
                            `;
                        } else {
                            messageElement.className = 'bg-gray-50 dark:bg-gray-800 rounded-lg p-6';
                            messageElement.innerHTML = `
                                <div class="flex items-start space-x-3 mb-4">
                                    <div class="w-6 h-6 bg-gradient-to-br from-green-400 to-blue-500 rounded-sm flex items-center justify-center flex-shrink-0">
                                        <svg class="w-4 h-4 text-white" fill="currentColor" viewBox="0 0 24 24">
                                            <path d="M4 6h16v2H4zm0 5h16v2H4zm0 5h16v2H4z"/>
                                        </svg>
                                    </div>
                                </div>
                                <div class="space-y-6">
                                    <p class="text-lg">${message.content}</p>
                                </div>
                            `;
                        }
                        chatMessages.appendChild(messageElement);
                    });
                });
        }

        function newChat() {
            currentChatId = null;
            document.getElementById('chat-messages').querySelector('.space-y-6').innerHTML = '';
            document.querySelector('#fileUpload + button span').textContent = 'Upload .sql';
        }

        document.addEventListener('DOMContentLoaded', function() {
            document.getElementById('fileUpload').addEventListener('change', handleFileUpload);
        });
    </script>
</body>
</html>