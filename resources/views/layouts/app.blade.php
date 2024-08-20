@include('head')
<body class="font-sans antialiased ">
    <div class="min-h-screen bg-[--color-primary]">
        @include('layouts.navigation')
        <!-- Page Content -->
        <main>
            {{ $slot }}
        </main>
    </div>
</body>
