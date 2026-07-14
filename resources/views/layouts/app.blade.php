<!DOCTYPE html>
<html>
<head>

    <title>Master</title>

    <script src="https://cdn.tailwindcss.com"></script>

</head>

<body class="bg-gray-100">

<div class="flex">

    <!-- Sidebar -->

    <div class="w-64 min-h-screen bg-gray-800 text-white">

        <h2 class="text-center text-2xl font-bold py-6 border-b">

            MASTER

        </h2>

        <ul class="mt-5">

            <li>
                <a href="/country"
                class="block px-6 py-3 hover:bg-gray-700">
                    Country
                </a>
            </li>

            <li>
                <a href="#"
                class="block px-6 py-3 hover:bg-gray-700">
                    State
                </a>
            </li>

            <li>
                <a href="#"
                class="block px-6 py-3 hover:bg-gray-700">
                    City
                </a>
            </li>

            <li>
                <a href="#"
                class="block px-6 py-3 hover:bg-gray-700">
                    Pincode
                </a>
            </li>

        </ul>

    </div>

    <!-- Content -->

    <div class="flex-1 p-10">

        @yield('content')

    </div>

</div>
@stack('scripts')
</body>

</html>