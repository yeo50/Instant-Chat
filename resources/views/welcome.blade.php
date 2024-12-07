<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-bs-theme-mode="light">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Instant Chat</title>
    <link rel="icon" href="{{ asset('storage/photos/chat.png') }}" type="image/x-icon">



    <!-- Styles -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="dark:bg-black dark:text-white">

    <nav class="px-2 z-10  lg:px-4 py-1 bg-blue-400 lg:py-2 h-14 flex  items-center">
        <div class="w-10 h-10 ml-4">
            <a href="/"><img src="{{ asset('storage/photos/chat.png') }}"
                    class="block w-full h-full cursor-pointer" alt="logo"></a>
        </div>
        <div class="w-[90%] ml-auto flex justify-between items-center ">
            @auth
                <a href="{{ route('dashboard') }}" class="cursor-pointer text-white text-lg">Dashboard</a>
            @endauth
            @guest
                <ul class='flex justify-between w-36  ml-auto'>
                    <li><a href="{{ route('login') }}" class="tracking-wide font-semibold text-lg text-white">Login</a></li>
                    <li><a href="{{ route('register') }}"
                            class="tracking-wide font-semibold text-lg text-white">Register</a>
                    </li>
                </ul>
            @endguest
        </div>
    </nav>
    <!-- Add this button right here -->


    <main class="flex bg-gradient-to-r from-cyan-500 to-blue-200 h-screen">
        @php
            $elCount = 36;
        @endphp
        <div class="flex-1 flex justify-center items-center h-[90%]">
            <div class="flex flex-col h-200px w-200px">

                <h1 class=" text-2xl md:text-4xl lg:text-6xl font-bold tracking-wider text-white">Instant Chats. <br>
                    Feel It</h1>
                <h6 class="mt-2 lg:mt-4 text-white text-base md:text-lg">Free, Easy, Fast & Unlimited Chat Services.
                </h6>
                <div class="w-[90%] py-4 flex gap-4 items-center">

                    <a href="{{ route('register') }}"
                        class="px-3 lg:px-4 py-2 bg-white border-none outline-none rounded-xl text-sm md:text-base text-cyan-800 font-semibold tracking-wide
                            hover:ring-2 hover:ring-cyan-800">Try
                        it
                        free</a>

                    <a href="{{ route('register') }}"
                        class="px-3 lg:px-4 py-2 text-white border-2 border-white  outline-none rounded-xl text-sm md:text-base bg-cyan-600 font-semibold tracking-wide
                        hover:bg-cyan-400 active:bg-cyan-500">Get
                        Demo
                    </a>
                </div>
            </div>
        </div>
        <div class="flex-1 relative max-md:hidden">
            <div class=" grow grid grid-cols-6 z-10 w-[180px] h-[200px] absolute top-20 left-20 bg-transparent">
                @for ($i = 0; $i < $elCount; $i++)
                    <div class="w-2 h-2 rounded-full bg-orange-600"></div>
                @endfor
            </div>

        </div>

    </main>
</body>


</html>
