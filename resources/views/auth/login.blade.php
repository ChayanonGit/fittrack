
<!doctype html>
<html lang="th">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width,initial-scale=1" />
    <title>เข้าสู่ระบบ — FitTrack</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
    <style>
        :root{
            --bg-1:#071022; --bg-2:#081026;
            --accent-1:#7c3aed; --accent-2:#06b6d4;
            --glass: rgba(255,255,255,0.05);
            --muted:#b8c2d3; --text:#e6eef8;
        }
        *{box-sizing:border-box} html,body{height:100%}
        body{
            margin:0;font-family:'Poppins',system-ui,Segoe UI,Roboto,Arial;
            background:
              radial-gradient(900px 400px at 10% 10%, rgba(124,58,237,0.12), transparent),
              radial-gradient(800px 300px at 90% 90%, rgba(6,182,212,0.06), transparent),
              linear-gradient(180deg,var(--bg-1),var(--bg-2));
            color:var(--text); -webkit-font-smoothing:antialiased;
            display:flex;align-items:center;justify-content:center;padding:28px;
        }

        .container{width:100%;max-width:1000px;display:grid;grid-template-columns:1fr 420px;gap:28px;align-items:center}
        .panel{
            border-radius:16px;padding:36px;
            background: linear-gradient(135deg, rgba(255,255,255,0.02), rgba(255,255,255,0.01));
            border:1px solid rgba(255,255,255,0.03);backdrop-filter: blur(8px);
            box-shadow: 0 14px 50px rgba(2,6,23,0.6);
        }

        .brand{display:flex;gap:14px;align-items:center}
        .logo{width:68px;height:68px;border-radius:14px;background:linear-gradient(135deg,var(--accent-1),var(--accent-2));display:flex;align-items:center;justify-content:center;font-weight:700;color:#fff;box-shadow:0 8px 26px rgba(12,8,30,0.6)}
        h1{margin:0;font-size:28px}
        p.lead{color:var(--muted);margin-top:8px;font-size:14px}

        .card{background:linear-gradient(180deg, rgba(255,255,255,0.03), rgba(255,255,255,0.015));border-radius:12px;padding:22px;border:1px solid rgba(255,255,255,0.04);box-shadow:0 10px 30px rgba(2,6,23,0.45)}
        form{display:flex;flex-direction:column;gap:12px;margin-top:8px}
        label{font-size:13px;color:var(--muted);margin-bottom:6px;display:block}
        .input{background:var(--glass);border-radius:10px;padding:12px 14px;border:1px solid rgba(255,255,255,0.04);color:var(--text);outline:none;transition:all .14s ease}
        .input:focus{box-shadow:0 8px 30px rgba(124,58,237,0.12);border-color:rgba(124,58,237,0.6);transform:translateY(-2px)}
        .row{display:flex;align-items:center;justify-content:space-between;font-size:13px;color:var(--muted)}
        .btn{display:inline-flex;align-items:center;gap:10px;padding:12px 16px;border-radius:10px;border:none;cursor:pointer;background:linear-gradient(90deg,var(--accent-1),var(--accent-2));color:#fff;font-weight:600;box-shadow:0 10px 30px rgba(7,11,31,0.5)}
        .btn.secondary{background:transparent;border:1px solid rgba(255,255,255,0.06);box-shadow:none;color:var(--text)}
        .muted-link{color:var(--muted);text-decoration:none;font-size:13px}
        .errors{color:#ffb4c6;background:rgba(255,180,200,0.03);padding:10px;border-radius:8px;font-size:13px;border:1px solid rgba(255,200,220,0.06)}
        .socials{display:flex;gap:10px;margin-top:6px}
        .social{width:46px;height:46px;border-radius:10px;background:rgba(255,255,255,0.02);display:inline-grid;place-items:center;border:1px solid rgba(255,255,255,0.03)}
        .foot{margin-top:12px;font-size:13px;color:var(--muted);text-align:center}

        @media (max-width:980px){.container{grid-template-columns:1fr}.panel{padding:20px}}
    </style>
</head>
<body>
    <main class="container" role="main" aria-live="polite">
        <section class="panel" aria-hidden="false">
            <div class="brand">
                <div class="logo">FT</div>
                <div>
                    <h1>FitTrack</h1>
                    <p class="lead">จัดการกิจกรรมและสุขภาพอย่างมีระดับ</p>
                </div>
            </div>

            <div class="card" style="margin-top:16px">
                <h2 style="margin:0 0 10px 0">ยินดีต้อนรับกลับ</h2>
                <p class="lead" style="margin-bottom:10px">เข้าสู่ระบบเพื่อดูสถิติและแผนการฝึกของคุณ</p>

                <div style="display:flex;gap:12px;align-items:center;justify-content:space-between">
                    <div>
                        <div style="font-size:13px;color:var(--muted)">ยังไม่มีบัญชี?</div>
                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="muted-link">สร้างบัญชีใหม่</a>
                        @else
                            <a href="/register" class="muted-link">สร้างบัญชีใหม่</a>
                        @endif
                    </div>
                    <div style="text-align:right">
                        <div style="font-size:13px;color:var(--muted)">ลืมรหัสผ่าน?</div>
                        @if (Route::has('password.request'))
                            <a href="{{ route('password.request') }}" class="muted-link">รีเซ็ตรหัสผ่าน</a>
                        @else
                            <a href="/password/reset" class="muted-link">รีเซ็ตรหัสผ่าน</a>
                        @endif
                    </div>
                </div>
            </div>
        </section>

        <aside class="card" aria-labelledby="login-title">
            <h3 id="login-title" style="margin:0 0 8px 0">เข้าสู่ระบบ</h3>
            <p class="lead" style="margin-bottom:12px">ใช้บัญชีของคุณเพื่อเข้าถึงแดชบอร์ด</p>

            @if($errors->any())
                <div class="errors" role="alert">
                    <strong>พบปัญหา:</strong>
                    <ul style="margin:8px 0 0 16px;padding:0">
                        @foreach($errors->all() as $err)
                            <li>{{ $err }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ Route::has('login') ? route('login') : url('/login') }}" novalidate>
                @csrf

                <div>
                    <label for="email">อีเมล</label>
                    <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus class="input" placeholder="you@example.com" />
                </div>

                <div>
                    <label for="password">รหัสผ่าน</label>
                    <input id="password" type="password" name="password" required class="input" placeholder="รหัสผ่านของคุณ" />
                </div>

                <div class="row">
                    <label style="display:flex;align-items:center;gap:8px">
                        <input type="checkbox" name="remember" style="width:16px;height:16px" {{ old('remember') ? 'checked' : '' }}>
                        <span style="color:var(--muted);font-size:13px">จำสถานะการเข้าสู่ระบบ</span>
                    </label>
                    @if (Route::has('password.request'))
                        <a href="{{ route('password.request') }}" class="muted-link">ลืมรหัสผ่าน?</a>
                    @else
                        <a href="/password/reset" class="muted-link">ลืมรหัสผ่าน?</a>
                    @endif
                </div>

                <div style="display:flex;gap:10px;margin-top:6px">
                    <button type="submit" class="btn" aria-label="เข้าสู่ระบบ">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" style="opacity:.95" xmlns="http://www.w3.org/2000/svg"><path d="M12 15a1.5 1.5 0 100-3 1.5 1.5 0 000 3z" fill="white"/><path d="M17 9h-1V7a4 4 0 00-8 0v2H7a1 1 0 00-1 1v8a1 1 0 001 1h10a1 1 0 001-1v-8a1 1 0 00-1-1zM9 7a3 3 0 016 0v2H9V7z" fill="white"/></svg>
                        <span>เข้าสู่ระบบ</span>
                    </button>
                    @if (Route::has('register'))
                        <a class="btn secondary" href="{{ route('register') }}" aria-label="สมัครสมาชิก">ลงทะเบียน</a>
                    @else
                        <a class="btn secondary" href="/register" aria-label="สมัครสมาชิก">ลงทะเบียน</a>
                    @endif
                </div>

                <div style="margin-top:12px">
                    <div style="font-size:13px;color:var(--muted);margin-bottom:8px">หรือเข้าสู่ระบบด้วย</div>
                    <div class="socials" aria-hidden="false">
                        <a href="{{ Route::has('social.redirect') ? route('social.redirect', 'google') : '#' }}" class="social" title="Google" aria-label="Sign in with Google">
                            <svg width="20" height="20" viewBox="0 0 48 48" xmlns="http://www.w3.org/2000/svg"><path d="M44 24.5c0-1.6-.1-3.2-.4-4.7H24v9h11.9c-.5 2.8-2.1 5.1-4.5 6.7v5.6h7.2C41.4 37.5 44 31.5 44 24.5z" fill="#4285F4"/><path d="M24 44c5.9 0 10.9-2 14.5-5.5l-7.2-5.6c-2 1.4-4.6 2.3-7.3 2.3-5.6 0-10.3-3.7-12-8.6H4.7v5.4C8.3 39.9 15.6 44 24 44z" fill="#34A853"/><path d="M12 28.2a14.6 14.6 0 010-8.4V14.4H4.7A23.9 23.9 0 000 24.5c0 3.9.9 7.6 2.7 10.9L12 28.2z" fill="#FBBC05"/><path d="M24 11.3c3.2 0 6.1 1.1 8.4 3.3l6.3-6.3C34.8 4.8 29.8 3 24 3 15.6 3 8.3 7.1 4.7 14.4L12 18c1.7-4.9 6.4-8.6 12-8.6z" fill="#EA4335"/></svg>
                        </a>
                        <a href="{{ Route::has('social.redirect') ? route('social.redirect', 'facebook') : '#' }}" class="social" title="Facebook" aria-label="Sign in with Facebook">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="#1877F2" xmlns="http://www.w3.org/2000/svg"><path d="M22 12.07C22 6.48 17.52 2 11.93 2S1.87 6.48 1.87 12.07c0 5.02 3.66 9.17 8.44 9.95v-7.05H8.04v-2.9h2.27V9.5c0-2.24 1.33-3.48 3.36-3.48.97 0 1.98.17 1.98.17v2.18h-1.11c-1.09 0-1.43.68-1.43 1.37v1.66h2.44l-.39 2.9h-2.05V22c4.78-.78 8.44-4.93 8.44-9.93z"/></svg>
                        </a>
                        <a href="#" class="social" title="Apple" aria-label="Sign in with Apple">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="white" xmlns="http://www.w3.org/2000/svg"><path d="M16.365 1.43c-.98.06-2.18.65-2.89 1.43-.62.68-1.15 1.8-.96 2.85 1.03.05 2.15-.58 2.86-1.35.64-.69 1.12-1.79.99-2.93zM12 5.5c-1.9 0-3.77 1.02-4.8 2.63-1.32 2.05-1 5.6 1.2 7.43 1.02.85 2.44 1.35 3.6 1.35 1.1 0 1.74-.5 3.3-.5 1.56 0 2.05.5 3.3.5 1.46 0 2.7-.54 3.66-1.42-2.1-1.22-2.95-3.82-2.95-5.95 0-3.03 1.94-4.4 1.94-4.4-2.48-3.62-6.6-3.12-8.35-3.12z"/></svg>
                        </a>
                    </div>
                </div>

                <div class="foot">โดยการเข้าสู่ระบบคุณยอมรับ <a href="#" class="muted-link">ข้อกำหนด</a> และ <a href="#" class="muted-link">นโยบายความเป็นส่วนตัว</a></div>
            </form>
        </aside>
    </main>
</body>
</html>
