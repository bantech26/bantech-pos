<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8"/>
    <title>@yield('title') - Bantech POS</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/core@latest/dist/css/tabler.min.css">
    @stack('styles')
</head>
<body>
<body>
    <div class="page">
        @include('partials.header')
        
        @include('partials.sidebar')
        
        <div class="page-wrapper">
            <div class="page-body">
                <div class="container-fluid" style="padding-left: 250px; padding-right: 250px;">
                    @yield('content')
                </div>
            </div>
            @include('partials.footer')
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/@tabler/core@latest/dist/js/tabler.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script>
         //LOGOUT 
        document.getElementById('btnLogout')?.addEventListener('click', async function(e) {
            e.preventDefault();
            
            try {
                const token = localStorage.getItem('token');
                await axios.post('/api/logout', {}, {
                    headers: { 'Authorization': `Bearer ${token}` }
                });
                
                localStorage.removeItem('token'); // Hapus token dari browser
                window.location.href = '/login';
            } catch (error) {
                console.error('Logout gagal', error);
                window.location.href = '/login'; // Tetap pindah ke login jika error
            }
        });
    </script>
    @stack('scripts')
</body>
</html>