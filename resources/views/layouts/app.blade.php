<!DOCTYPE html>
<html lang="en" class="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SQL Assistant - ChatGPT Interface</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="//unpkg.com/alpinejs" defer></script>
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
    </script>
</head>
<body class="bg-white dark:bg-chat-gray text-gray-900 dark:text-white font-sans transition-colors duration-200">
    <!-- Main Container -->
    <div class="flex h-screen">
        @include('topsidebar')
        @yield('content')
    </div>
</body>
</html>