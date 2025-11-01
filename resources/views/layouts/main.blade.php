<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/common.css') }}" />
    <!-- Embedded UI styles (modal, header, buttons) -->
    <style>
        :root{
            --bg: #ffffff;
            --muted: #6b7280;
            --text: #0f172a;
            --accent-a: #7c3aed;
            --accent-b: #06b6d4;
            --glass-grad: linear-gradient(180deg, rgba(255,255,255,0.85), rgba(255,255,255,0.95));
            --glass-border: rgba(15,23,42,0.06);
            --shadow-1: 0 6px 18px rgba(15,23,42,0.08);
            --radius: 12px;
            --max-width: 1100px;
        }
        html,body{height:100%}
        body{margin:0;font-family:Inter, system-ui, -apple-system, "Segoe UI", Roboto, Arial;background:var(--bg);color:var(--text);line-height:1.5}
        .container{max-width:var(--max-width);margin:0 auto;padding:18px;box-sizing:border-box}
        /* Header */
        #app-cmp-main-header{display:flex;align-items:center;justify-content:space-between;padding:14px 20px;border-bottom:1px solid rgba(15,23,42,0.06);background:linear-gradient(180deg, rgba(255,255,255,0.8), rgba(255,255,255,0.95));backdrop-filter: blur(4px);position:sticky;top:0;z-index:800}
        .app-cmp-links{list-style:none;padding:0;margin:0;display:flex;gap:18px;align-items:center;flex-wrap:wrap}
        .app-cmp-links a{color:var(--text);text-decoration:none;font-weight:600;font-size:14px;padding:6px 8px;border-radius:8px;transition:all .15s ease}
        .app-cmp-links a:hover{background:rgba(124,58,237,0.08);color:var(--accent-a);transform:translateY(-1px)}
        .header-actions{display:flex;gap:10px;align-items:center}
        .ft-login-btn, .ft-register-btn{padding:8px 14px;border-radius:8px;border:1px solid rgba(15,23,42,0.06);background:linear-gradient(90deg,var(--accent-a),var(--accent-b));color:#fff;font-weight:600;cursor:pointer;box-shadow:0 6px 18px rgba(12,15,22,0.08)}
        /* Modal (glass) */
        .ft-modal-backdrop{position:fixed;inset:0;background:rgba(2,6,23,0.45);display:none;align-items:center;justify-content:center;z-index:1200;animation:fadeIn .18s ease both}
        .ft-modal-backdrop.open{display:flex}
        @keyframes fadeIn{from{opacity:0}to{opacity:1}}
        .ft-modal{width:100%;max-width:560px;border-radius:var(--radius);padding:22px;background:var(--glass-grad);border:1px solid var(--glass-border);box-shadow:var(--shadow-1);color:var(--text);position:relative;animation:slideUp .18s cubic-bezier(.2,.9,.3,1) both}
        @keyframes slideUp{from{opacity:0;transform:translateY(8px)}to{opacity:1;transform:translateY(0)}}
        .ft-modal h3{margin:0 0 8px 0;font-size:20px;font-weight:700}
        .ft-modal .lead{color:var(--muted);margin-bottom:12px;font-size:13px}
        .ft-close{position:absolute;right:14px;top:14px;width:34px;height:34px;display:inline-flex;align-items:center;justify-content:center;border-radius:8px;background:transparent;border:1px solid rgba(15,23,42,0.04);color:var(--muted);cursor:pointer}
        .ft-input{width:100%;padding:10px 12px;border-radius:8px;border:1px solid rgba(15,23,42,0.06);background:#fff;color:var(--text);margin-bottom:10px;box-sizing:border-box}
        .ft-row{display:flex;align-items:center;justify-content:space-between;font-size:13px;color:var(--muted);margin-bottom:8px}
        .ft-btn{padding:10px 14px;border-radius:10px;border:none;background:linear-gradient(90deg,var(--accent-a),var(--accent-b));color:#fff;font-weight:700;cursor:pointer}
        @media (max-width:600px){#app-cmp-main-header{padding:10px 12px}.ft-modal{margin:16px;width:calc(100% - 32px);max-width:520px;padding:18px}}
    </style>
    <title>Fittrack</title>
</head>

<body>
    <header id="app-cmp-main-header">
        <nav class="app-cmp-user-panel">
            <ul class="app-cmp-links">
                <li><a href="{{ route('home') }}">Fittrack</a></li>
                <li><a href="{{ route('shop.view-shop') }}">shop</a></li>
                <li><a href="{{ route('shop.view-class') }}">fitness Class</a></li>
                <li><a href="">My Order</a></li>
                <li><a href="">Order</a></li>
                <li><a href="{{ route('fitnessclass.list') }}">fitness Class</a></li>
                <li><a href="{{ route('products.list') }}">Product</a></li>
                <li><a href="{{ route('category.list') }}">Category</a></li>
            </ul>
        </nav>

        <div class="header-actions">
            <!-- Login button (opens modal) -->
            <button type="button" class="ft-login-btn" onclick="window.ftOpenLogin()" aria-label="เข้าสู่ระบบ">เข้าสู่ระบบ</button>
            
            <!-- New Register button (opens modal) -->
            <button type="button" class="ft-register-btn" onclick="window.ftOpenRegister()" aria-label="ลงทะเบียน">ลงทะเบียน</button>

            <!-- existing logout form -->
            <form action="" method="post" style="margin:0">
                @csrf
                <button type="submit">Logout</button>
            </form>
        </div>
    </header>

    <main id="app-cmp-main-content">
        <header>
            <h1></h1>
            <div class="app-cmp-notifications"></div>
            <div class="app-cmp-notifications"></div>
            @yield('header')
        </header>

        @yield('content')
    </main>

    <footer id="app-cmp-main-footer">
        &#xA9; from fittrack
    </footer>

    <script src="{{ asset('js/cart.js') }}"></script>

    <!-- Login modal markup (now includes Register form) -->
    <div id="ft-login-backdrop" class="ft-modal-backdrop" aria-hidden="true" role="dialog" aria-modal="true">
        <div class="ft-modal" role="document" aria-labelledby="ft-login-title">
            <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:10px">
                <div>
                    <h3 id="ft-login-title">เข้าสู่ระบบ</h3>
                    <div class="lead" id="ft-auth-lead">ใช้บัญชีของคุณเพื่อเข้าถึงแดชบอร์ด</div>
                </div>
                <button id="ft-login-close" class="ft-close" aria-label="ปิด">&times;</button>
            </div>

            @if($errors->any())
                <div style="color:#ffb4c6;background:rgba(255,180,200,0.03);padding:8px;border-radius:8px;margin-bottom:10px">
                    <strong>พบปัญหา:</strong>
                    <ul style="margin:6px 0 0 16px;padding:0">
                        @foreach($errors->all() as $err)
                            <li>{{ $err }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <!-- LOGIN FORM -->
            <div id="ft-login-form">
                <form method="POST" action="{{ Route::has('login') ? route('login') : url('/login') }}">
                    @csrf
                    <label for="ft-email" style="font-size:13px;color:#b8c2d3">อีเมล</label>
                    <input id="ft-email" type="email" name="email" value="{{ old('email') }}" required autofocus class="ft-input" placeholder="you@example.com" />

                    <label for="ft-pass" style="font-size:13px;color:#b8c2d3">รหัสผ่าน</label>
                    <input id="ft-pass" type="password" name="password" required class="ft-input" placeholder="รหัสผ่านของคุณ" />

                    <div class="ft-row">
                        <label style="display:flex;align-items:center;gap:8px;color:#b8c2d3">
                            <input type="checkbox" name="remember" style="width:16px;height:16px" {{ old('remember') ? 'checked' : '' }}>
                            <span style="font-size:13px">จำสถานะการเข้าสู่ระบบ</span>
                        </label>

                        @if (Route::has('password.request'))
                            <a href="{{ route('password.request') }}" style="color:#b8c2d3;font-size:13px">ลืมรหัสผ่าน?</a>
                        @else
                            <a href="/password/reset" style="color:#b8c2d3;font-size:13px">ลืมรหัสผ่าน?</a>
                        @endif
                    </div>

                    <div style="display:flex;gap:10px;justify-content:flex-end;margin-top:6px">
                        <button type="submit" class="ft-btn">เข้าสู่ระบบ</button>
                    </div>

                    <div style="margin-top:12px;font-size:13px;color:#b8c2d3;text-align:center">
                        โดยการเข้าสู่ระบบคุณยอมรับ <a href="#" style="color:#b8c2d3">ข้อกำหนด</a> และ <a href="#" style="color:#b8c2d3">นโยบายความเป็นส่วนตัว</a>
                    </div>

                    <div style="margin-top:12px;text-align:center">
                        <a href="javascript:void(0)" id="ft-switch-to-register" style="color:#b8c2d3;font-size:13px">ยังไม่มีบัญชี? ลงทะเบียน</a>
                    </div>
                </form>
            </div>

            <!-- REGISTER FORM (hidden by default) -->
            <div id="ft-register-form" style="display:none">
                <form method="POST" action="{{ Route::has('register') ? route('register') : url('/register') }}">
                    @csrf
                    <label for="ft-register-name" style="font-size:13px;color:#b8c2d3">ชื่อ</label>
                    <input id="ft-register-name" type="text" name="name" value="{{ old('name') }}" required class="ft-input" placeholder="ชื่อของคุณ" />

                    <label for="ft-register-email" style="font-size:13px;color:#b8c2d3">อีเมล</label>
                    <input id="ft-register-email" type="email" name="email" value="{{ old('email') }}" required class="ft-input" placeholder="you@example.com" />

                    <label for="ft-register-password" style="font-size:13px;color:#b8c2d3">รหัสผ่าน</label>
                    <input id="ft-register-password" type="password" name="password" required class="ft-input" placeholder="รหัสผ่านของคุณ" />

                    <label for="ft-register-password-confirm" style="font-size:13px;color:#b8c2d3">ยืนยันรหัสผ่าน</label>
                    <input id="ft-register-password-confirm" type="password" name="password_confirmation" required class="ft-input" placeholder="ยืนยันรหัสผ่านของคุณ" />

                    <div style="display:flex;gap:10px;justify-content:flex-end;margin-top:6px">
                        <button type="submit" class="ft-btn">ลงทะเบียน</button>
                    </div>

                    <div style="margin-top:12px;text-align:center">
                        <a href="javascript:void(0)" id="ft-switch-to-login" style="color:#b8c2d3;font-size:13px">มีบัญชีอยู่แล้ว? เข้าสู่ระบบ</a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        (function(){
            const backdrop = document.getElementById('ft-login-backdrop');
            const closeBtn = document.getElementById('ft-login-close');
            const loginFormWrap = document.getElementById('ft-login-form');
            const registerFormWrap = document.getElementById('ft-register-form');
            const lead = document.getElementById('ft-auth-lead');
            const switchToRegister = document.getElementById('ft-switch-to-register');
            const switchToLogin = document.getElementById('ft-switch-to-login');

            function openAuthModal(mode = 'login'){
                backdrop.classList.add('open');
                backdrop.setAttribute('aria-hidden','false');
                document.body.style.overflow = 'hidden';
                if(mode === 'register') showRegister();
                else showLogin();
            }
            function closeAuthModal(){
                backdrop.classList.remove('open');
                backdrop.setAttribute('aria-hidden','true');
                document.body.style.overflow = '';
            }

            function showRegister(){
                loginFormWrap.style.display = 'none';
                registerFormWrap.style.display = '';
                lead.textContent = 'กรุณากรอกข้อมูลของคุณเพื่อสร้างบัญชี';
            }
            function showLogin(){
                registerFormWrap.style.display = 'none';
                loginFormWrap.style.display = '';
                lead.textContent = 'ใช้บัญชีของคุณเพื่อเข้าถึงแดชบอร์ด';
            }

            closeBtn.addEventListener('click', closeAuthModal);
            backdrop.addEventListener('click', function(e){
                if(e.target === backdrop) closeAuthModal();
            });
            document.addEventListener('keydown', function(e){
                if(e.key === 'Escape') closeAuthModal();
            });

            if(switchToRegister) switchToRegister.addEventListener('click', function(){ showRegister(); });
            if(switchToLogin) switchToLogin.addEventListener('click', function(){ showLogin(); });

            // Auto-open logic:
            const path = window.location.pathname.replace(/\/$/, '');
            const params = new URLSearchParams(window.location.search);
            // Determine if server-side old input/errors indicate register intent
            const hasRegisterErrors = {!! json_encode($errors->has('name') || $errors->has('password_confirmation') || $errors->has('password') || old('name') ? true : false) !!};

            if (path === '/login' || path === '/auth/login' || params.get('show_login') === '1') {
                openAuthModal('login');
                try { history.replaceState(null, '', window.location.origin + '/'); } catch(e){}
            } else if (path === '/register' || params.get('show_register') === '1' || hasRegisterErrors) {
                openAuthModal('register');
                try { history.replaceState(null, '', window.location.origin + '/'); } catch(e){}
            }

            // Expose API
            window.ftOpenLogin = function(){ openAuthModal('login'); };
            window.ftOpenRegister = function(){ openAuthModal('register'); };
            window.ftCloseLogin = closeAuthModal;
        })();
    </script>

    @yield('scripts')
</body>

</html>