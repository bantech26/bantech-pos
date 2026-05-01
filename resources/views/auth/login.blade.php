<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover"/>
    <title>Login - Bantech POS</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/core@latest/dist/css/tabler.min.css">
    <style>
      @import url('https://rsms.me/inter/inter.css');
      :root { --tblr-font-sans-serif: 'Inter var', sans-serif; }
      
      body {
        font-feature-settings: "cv03", "cv04", "cv11";
        /* Latar belakang gambar POS dengan overlay hitam transparan */
        background: linear-gradient(rgba(0, 0, 0, 0.7), rgba(0, 0, 0, 0.8)), 
                    url('https://images.unsplash.com/photo-1556742044-3c52d6e88c62?ixlib=rb-4.0.3&auto=format&fit=crop&w=1920&q=80');
        background-size: cover;
        background-position: center;
        background-attachment: fixed;
        min-height: 100vh;
      }

      .page-center {
        display: flex;
        align-items: center;
        justify-content: center;
        min-height: 100vh;
      }

      /* Efek kartu sedikit transparan (Glassmorphism) */
      .card-glass {
        background: rgba(255, 255, 255, 0.9);
        backdrop-filter: blur(10px);
        border: 1px solid rgba(255, 255, 255, 0.2);
        box-shadow: 0 15px 35px rgba(0, 0, 0, 0.5);
        border-radius: 12px;
      }

      .navbar-brand h1 {
        text-shadow: 2px 2px 4px rgba(0,0,0,0.3);
      }
    </style>
</head>
<body class="d-flex flex-column">
    <div class="page-center">
      <div class="container container-tight py-4">
        <div class="text-center mb-4">
          <a href="." class="navbar-brand">
            <h1 class="text-white fw-bold" style="letter-spacing: 2px;">BANTECH POS</h1>
          </a>
        </div>
        
        <div class="card card-md card-glass">
          <div class="card-body">
            <h2 class="h2 text-center mb-4 text-dark">Selamat Datang Kembali</h2>
            <p class="text-center text-muted mb-4">Silakan masuk ke akun Anda untuk mengelola transaksi</p>
            
            <form id="loginForm" autocomplete="off" novalidate>
              <div class="mb-3">
                <label class="form-label text-dark">Email Address</label>
                <div class="input-icon">
                  <input type="email" id="email" class="form-control" placeholder="admin@bantech.com">
                </div>
              </div>
              
              <div class="mb-3">
                <label class="form-label text-dark">Password</label>
                <input type="password" id="password" class="form-control" placeholder="Masukkkan password">
              </div>

              <div class="mb-3">
                <label class="form-check">
                  <input type="checkbox" class="form-check-input"/>
                  <span class="form-check-label text-dark">Ingat saya di perangkat ini</span>
                </label>
              </div>

              <div class="form-footer">
                <button type="submit" id="btnSubmit" class="btn btn-primary w-100 py-2 fw-bold">
                  MASUK KE DASHBOARD
                </button>
              </div>
            </form>
          </div>
        </div>
        
        <div class="text-center text-white-50 mt-3">
          &copy; 2026 Bantech POS System. All rights reserved.
        </div>
      </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        axios.defaults.withCredentials = true;

        const loginForm = document.getElementById('loginForm');
        const btnSubmit = document.getElementById('btnSubmit');

        loginForm.addEventListener('submit', async (e) => {
            e.preventDefault();
            
            btnSubmit.disabled = true;
            btnSubmit.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span> Memproses...';

            const data = {
                email: document.getElementById('email').value,
                password: document.getElementById('password').value
            };

                try {
                    // Mintalah cookie CSRF terlebih dahulu
                    await axios.get('/sanctum/csrf-cookie');
                    
                    axios.defaults.withCredentials = true;
                    const response = await axios.post('/auth/login', data);
                    
                    localStorage.setItem('token', response.data.access_token);
                    
                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil!',
                        text: 'Mengalihkan ke dashboard...',
                        timer: 1500,
                        showConfirmButton: false
                    }).then(() => {
                        window.location.href = '/dashboard';
                    });
                } catch (error) {
                btnSubmit.disabled = false;
                btnSubmit.innerHTML = 'MASUK KE DASHBOARD';

                // Popup Gagal yang Keren
                Swal.fire({
                    icon: 'error',
                    title: 'Opps...',
                    text: error.response?.data?.message || 'Email atau Password salah!',
                    confirmButtonColor: '#d63939',
                });
            }
        });

    </script>
</body>
</html>