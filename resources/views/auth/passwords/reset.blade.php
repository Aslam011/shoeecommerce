<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>ShoeCommerce — Reset Password</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
    <style>
        :root{
            --bg-1:#060b14;
            --bg-2:#0c1726;
            --panel:#0f1e31;
            --panel-2:#12243b;
            --text:#e6f0ff;
            --muted:#a8b4c6;
            --brand:#6ea7ff;
            --brand-2:#4e8eff;
            --border:#1e2a3a;
            --shadow: 0 10px 30px rgba(0,0,0,.35);
            --radius:16px;
        }

        * { box-sizing: border-box; }
        html, body { height: 100%; }
        body{
            margin:0;
            min-height:100dvh;
            display:flex;
            flex-direction:column;
            color:var(--text);
            font: 16px/1.45 'Poppins', system-ui, -apple-system, Segoe UI, Roboto, "Helvetica Neue", Arial, "Noto Sans", "Apple Color Emoji","Segoe UI Emoji";
            background:
                radial-gradient(1200px 800px at 20% 15%, #0b1b2a 0%, #081220 45%, var(--bg-1) 100%),
                var(--bg-1);
        }

        header{
            position:sticky; top:0; z-index:10;
            background:rgba(16,24,36,.9);
            backdrop-filter:saturate(120%) blur(6px);
            border-bottom:1px solid var(--border);
        }
        .container{
            max-width:1100px;
            margin-inline:auto;
            padding:12px 20px;
            display:flex;
            align-items:center;
            gap:24px;
        }
        .brand{ font-weight:800; color:#ffcc33; letter-spacing:.2px; }
        nav ul{ list-style:none; display:flex; gap:18px; margin:0; padding:0; }
        nav a{ color:var(--text); text-decoration:none; opacity:.9; transition: opacity .2s; }
        nav a:hover{ opacity:1; }
        nav a[aria-current="page"] { opacity:1; font-weight:600; }

        main{
            flex:1;
            display:grid;
            place-items:center;
            padding:clamp(16px,4vw,48px);
            position:relative;
            z-index:0;
        }

        .card{
            width:min(520px, 92vw);
            background: linear-gradient(180deg, var(--panel) 0%, var(--panel-2) 100%);
            border:1px solid var(--border);
            border-radius:var(--radius);
            box-shadow:var(--shadow);
            overflow:hidden;
            transition: transform .3s ease, box-shadow .3s ease;
        }
        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 40px rgba(0,0,0,.45);
        }
        .card-head{
            padding:20px 24px;
            background: linear-gradient(180deg, rgba(110,167,255,.95), rgba(78,142,255,.95));
            color:#0a1a2c;
            font-size:24px;
            font-weight:700;
        }
        .card-body{ padding:24px; }

        label{ display:block; font-size:1rem; margin:12px 0 6px; color:var(--text); font-weight:600; }
        input[type="password"]{
            width:100%;
            padding:14px 12px;
            color:var(--text);
            background:#0b182a;
            border:1px solid #203247;
            border-radius:10px;
            outline:none;
            transition:border-color .2s, box-shadow .2s;
        }
        input:focus{
            border-color:var(--brand);
            box-shadow:0 0 0 3px rgba(110,167,255,.2);
        }

        .btn{
            width:100%;
            padding:14px 16px;
            border:none;
            border-radius:10px;
            background:linear-gradient(180deg, var(--brand) 0%, var(--brand-2) 100%);
            color:#071224;
            font-weight:700;
            cursor:pointer;
            transition:filter .15s, transform .02s, box-shadow .2s;
        }
        .btn:hover{ filter:brightness(1.05); box-shadow:0 4px 12px rgba(110,167,255,.3); }
        .btn:active{ transform:translateY(1px); }

        .helpers{
            display:flex; gap:18px; justify-content:center;
            font-size:.95rem; margin-top:16px; color:var(--muted);
        }
        .helpers a{ color:var(--brand); text-decoration:none; transition: color .2s; }
        .helpers a:hover{ text-decoration:underline; color:var(--brand-2); }

        .alert {
            padding: 12px 16px;
            border-radius: 8px;
            margin-bottom: 16px;
            font-size: 14px;
        }
        .alert-success {
            background-color: rgba(40, 167, 69, 0.1);
            border: 1px solid rgba(40, 167, 69, 0.3);
            color: #28a745;
        }
        .alert-error {
            background-color: rgba(220, 53, 69, 0.1);
            border: 1px solid rgba(220, 53, 69, 0.3);
            color: #dc3545;
        }

        footer{
            margin-top:auto;
            background:rgba(16,24,36,.9);
            border-top:1px solid var(--border);
            color:var(--muted);
        }
        footer .container{
            justify-content:space-between;
            flex-wrap:wrap;
            gap:12px 18px;
        }
        footer a{ color:var(--text); opacity:.9; text-decoration:none; transition: opacity .2s; }
        footer a:hover{ opacity:1; text-decoration:underline; }

        @media (max-width: 480px){
            .card-head{ font-size:20px; padding:16px 18px; }
            .card-body{ padding:18px; }
        }
    </style>
</head>
<body>

    <header>
        <div class="container">
            <div class="brand">ShoeCommerce</div>
            <nav aria-label="Primary">
                <ul>
                    <li><a href="{{ route('home') }}">Home</a></li>
                    <li><a href="{{ route('shop.index') }}">Shop</a></li>
                    <li><a href="{{ route('customer.login') }}">Login</a></li>
                    <li><a href="{{ route('customer.register') }}">Sign Up</a></li>
                </ul>
            </nav>
        </div>
    </header>

    <main>
        <form id="passwordResetForm" class="card" method="POST" action="{{ route('customer.password.reset') }}">
            @csrf
            <div class="card-head">Reset Your Password</div>
            <div class="card-body">
                @if (session('status'))
                    <div class="alert alert-success">{{ session('status') }}</div>
                @endif

                @if ($errors->any())
                    <div class="alert alert-error">
                        <ul style="margin: 0; padding-left: 20px;">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <label for="password">New Password</label>
                <input id="password" name="password" type="password" placeholder="Enter new password" required minlength="8" />

                <label for="password_confirmation">Confirm New Password</label>
                <input id="password_confirmation" name="password_confirmation" type="password" placeholder="Confirm new password" required />

                <button class="btn" type="submit">Update Password</button>

                <div class="helpers">
                    <span>Remember your password?</span>
                    <a href="{{ route('customer.login') }}">Login</a>
                </div>
            </div>
        </form>
    </main>

    <footer>
        <div class="container">
            <div>© 2025 ShoeCommerce. All rights reserved.</div>
            <div style="display:flex; gap:12px;">
                <a href="#">Privacy Policy</a>
                <span>·</span>
                <a href="#">Terms of Service</a>
                <span>·</span>
                <a href="#">Contact</a>
            </div>
        </div>
    </footer>

    <script>
        // Password confirmation validation
        document.getElementById('passwordResetForm').addEventListener('submit', function(e) {
            const password = document.getElementById('password').value;
            const confirmPassword = document.getElementById('password_confirmation').value;

            if (password !== confirmPassword) {
                e.preventDefault();
                alert('Passwords do not match. Please try again.');
                return false;
            }

            if (password.length < 8) {
                e.preventDefault();
                alert('Password must be at least 8 characters long.');
                return false;
            }
        });
    </script>

</body>
</html>
