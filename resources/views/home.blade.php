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
            <div id="inputArea" class="hidden p-4 border-t border-gray-300 dark:border-gray-700 bg-gray-50 dark:bg-chat-sidebar">
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
        let chatHasFile = false;

        function handleFileUpload(event) {
            const file = event.target.files[0];
            if (file) {
                if (chatHasFile) {
                    alert('A file has already been uploaded to this chat. Please start a new chat to upload a new file.');
                    return;
                }

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

                const chatMessages = document.getElementById('chat-messages').querySelector('.space-y-6');
                const loadingMessage = document.createElement('div');
                loadingMessage.className = 'bg-gray-50 dark:bg-gray-800 rounded-lg p-6';
                loadingMessage.innerHTML = `<p class="text-lg">Database is uploading...</p>`;
                chatMessages.appendChild(loadingMessage);

                fetch('{{ route('upload') }}', {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: formData
                })
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Network response was not ok');
                    }
                    return response.json();
                })
                .then(data => {
                    loadingMessage.remove();
                    if (data.chat_id && !currentChatId) {
                        currentChatId = data.chat_id;
                        chatHasFile = true;
                        const newChatItem = document.createElement('div');
                        newChatItem.className = 'flex items-center justify-between p-2 rounded hover:bg-gray-200 dark:hover:bg-gray-700 text-sm text-gray-600 dark:text-gray-300 transition-colors duration-200 cursor-pointer relative';
                        newChatItem.setAttribute('x-data', '{ open: false }');
                        newChatItem.innerHTML = `
                            <span class="flex-grow" onclick="loadChatHistory(${data.chat_id})">${file.name}</span>
                            <button class="ml-2" @click="open = !open">
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M10 6a2 2 0 110-4 2 2 0 010 4zM10 12a2 2 0 110-4 2 2 0 010 4zM10 18a2 2 0 110-4 2 2 0 010 4z"></path>
                                </svg>
                            </button>
                            <div x-show="open" @click.away="open = false" class="absolute right-0 bottom-full mb-2 w-48 bg-white dark:bg-gray-800 rounded-md shadow-lg border border-gray-200 dark:border-gray-700 z-10">
                                <div class="py-1">
                                    <a href="#" class="block px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700" onclick="renameChat(${data.chat_id}, event)">Rename</a>
                                    <a href="#" class="block px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700" onclick="deleteChat(${data.chat_id}, event)">Delete</a>
                                </div>
                            </div>
                        `;
                        document.querySelector('.space-y-1').prepend(newChatItem);
                    }
                    if (data.reply) {
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
                        document.getElementById('inputArea').classList.remove('hidden');
                    }
                })
                .catch(error => {
                    loadingMessage.remove();
                    console.error('Error:', error);
                    alert('File upload failed. Please check the console for more details.');
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
                        chatHasFile = true;
                        document.getElementById('inputArea').classList.remove('hidden');
                    } else {
                        uploadButtonSpan.textContent = 'Upload .sql';
                        chatHasFile = false;
                        document.getElementById('inputArea').classList.add('hidden');
                    }

                    data.messages.forEach(message => {
                        const messageElement = document.createElement('div');
                        if (message.sender === 'user') {
                            messageElement.className = 'bg-gray-100 dark:bg-gray-700 rounded-lg p-6';
                            messageElement.innerHTML = `
                                <div class="flex items-start space-x-3">
                                    <div class="w-8 h-8 bg-blue-600 rounded-full flex items-center justify-center flex-shrink-0 text-sm font-semibold text-white">
                                        {{ $initials }}
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
            fetch('{{ route('chat.new') }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({ name: 'New Chat' })
            })
            .then(response => response.json())
            .then(data => {
                currentChatId = data.id;
                chatHasFile = false;
                document.getElementById('chat-messages').querySelector('.space-y-6').innerHTML = '';
                document.querySelector('#fileUpload + button span').textContent = 'Upload .sql';
                const newChatItem = document.createElement('div');
                newChatItem.className = 'flex items-center justify-between p-2 rounded hover:bg-gray-200 dark:hover:bg-gray-700 text-sm text-gray-600 dark:text-gray-300 transition-colors duration-200 cursor-pointer relative';
                newChatItem.setAttribute('x-data', '{ open: false }');
                newChatItem.innerHTML = `
                    <span class="flex-grow" onclick="loadChatHistory(${data.id})">${data.name}</span>
                    <button class="ml-2" @click="open = !open">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M10 6a2 2 0 110-4 2 2 0 010 4zM10 12a2 2 0 110-4 2 2 0 010 4zM10 18a2 2 0 110-4 2 2 0 010 4z"></path>
                        </svg>
                    </button>
                    <div x-show="open" @click.away="open = false" class="absolute right-0 bottom-full mb-2 w-48 bg-white dark:bg-gray-800 rounded-md shadow-lg border border-gray-200 dark:border-gray-700 z-10">
                        <div class="py-1">
                            <a href="#" class="block px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700" onclick="renameChat(${data.id}, event)">Rename</a>
                            <a href="#" class="block px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700" onclick="deleteChat(${data.id}, event)">Delete</a>
                        </div>
                    </div>
                `;
                document.querySelector('.space-y-1').prepend(newChatItem);
            });
        }

        function renameChat(chatId, event) {
            event.stopPropagation();
            const renameModal = document.getElementById('renameModal');
            const newNameInput = document.getElementById('newName');
            const saveRenameButton = document.getElementById('saveRename');
            const closeRenameModalButton = document.getElementById('closeRenameModal');

            renameModal.classList.remove('hidden');

            saveRenameButton.onclick = () => {
                const newName = newNameInput.value;
                if (newName) {
                    fetch('{{ route('chat.rename') }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({ chat_id: chatId, name: newName })
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.message) {
                            renameModal.classList.add('hidden');
                            const chatElement = document.querySelector(`[onclick="loadChatHistory(${chatId})"]`);
                            chatElement.textContent = newName;
                        }
                    });
                }
            };

            closeRenameModalButton.onclick = () => {
                renameModal.classList.add('hidden');
            };
        }

        function deleteChat(chatId, event) {
            event.stopPropagation();
            const deleteModal = document.getElementById('deleteModal');
            const confirmDeleteButton = document.getElementById('confirmDelete');
            const closeDeleteModalButton = document.getElementById('closeDeleteModal');

            deleteModal.classList.remove('hidden');

            confirmDeleteButton.onclick = () => {
                fetch(`/chat/delete/${chatId}`, {
                    method: 'DELETE',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.message) {
                        deleteModal.classList.add('hidden');
                        const chatElement = document.querySelector(`[onclick="loadChatHistory(${chatId})"]`).parentNode;
                        chatElement.remove();
                    }
                });
            };

            closeDeleteModalButton.onclick = () => {
                deleteModal.classList.add('hidden');
            };
        }

        document.addEventListener('DOMContentLoaded', function() {
            document.getElementById('fileUpload').addEventListener('change', handleFileUpload);
        });
    </script>
</body>
</html>