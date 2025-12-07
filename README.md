<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width,initial-scale=1" />
  <title>Realtime Notification System — README</title>
  <style>
    :root{
      --bg:#f6f8fb;
      --card:#ffffff;
      --accent:#2563eb;
      --muted:#6b7280;
      --code-bg:#0f172a;
      --code-fg:#e6eef8;
      --radius:12px;
      --mono: Menlo, Monaco, "Courier New", monospace;
      --sans: Inter, system-ui, -apple-system, "Segoe UI", Roboto, "Helvetica Neue", Arial;
    }
    *{box-sizing:border-box}
    body{
      margin:0;
      background:linear-gradient(180deg,#f7f9fc 0%, #eef3fb 100%);
      font-family:var(--sans);
      color:#0f172a;
      -webkit-font-smoothing:antialiased;
      -moz-osx-font-smoothing:grayscale;
      padding:28px;
      display:flex;
      justify-content:center;
    }

    .wrap{
      width:100%;
      max-width:980px;
      background:var(--card);
      border-radius:14px;
      box-shadow:0 10px 30px rgba(17,24,39,0.08);
      padding:28px;
      margin:20px;
      overflow:hidden;
    }

    header{ display:flex; align-items:center; gap:16px; margin-bottom:18px; }
    .logo{
      width:56px;height:56px;border-radius:10px;
      background:linear-gradient(135deg,#2563eb,#7c3aed);
      color:white; display:flex; align-items:center; justify-content:center;
      font-weight:700; font-size:20px; box-shadow:0 6px 18px rgba(37,99,235,0.12);
    }
    h1{ margin:0; font-size:20px; }
    p.lead{ margin:6px 0 0; color:var(--muted); font-size:14px; }

    hr{ border:0; height:1px; background:linear-gradient(90deg,transparent,#eef2ff,transparent); margin:22px 0; }

    .section{ margin-bottom:18px; }
    .section h2{ margin:0 0 8px; font-size:16px; display:flex; align-items:center; gap:12px; }
    .badge{ background:var(--accent); color:white; padding:6px 10px; border-radius:8px; font-weight:600; font-size:12px; }

    ul.features{ list-style:none; padding-left:0; margin:12px 0 0; display:grid; gap:8px; }
    ul.features li{ background:#fbfdff; border:1px solid #eef6ff; padding:12px; border-radius:10px; color:#0b1220; }

    .code{
      background:var(--code-bg); color:var(--code-fg); padding:14px; border-radius:10px;
      font-family:var(--mono); font-size:13px; overflow:auto; line-height:1.6;
      box-shadow: inset 0 -6px 30px rgba(2,6,23,0.25);
    }

    .row{ display:flex; gap:18px; align-items:flex-start; }
    .col{ flex:1; }

    .meta{ color:var(--muted); font-size:13px; margin-top:6px; }

    footer{ margin-top:22px; display:flex; justify-content:space-between; align-items:center; color:var(--muted); font-size:13px; }
    .btn{
      display:inline-block; background:var(--accent); color:white; padding:8px 12px; border-radius:8px; text-decoration:none;
      font-weight:600; font-size:13px;
    }

    /* responsive */
    @media (max-width:840px){
      .row{ flex-direction:column; }
    }
  </style>
</head>
<body>
  <main class="wrap" role="main" aria-labelledby="page-title">
    <header>
      <div class="logo">RT</div>
      <div>
        <h1 id="page-title">📨 Real-Time Notification System</h1>
        <p class="lead">Laravel 10 · Database Queue · WebSockets — message stored → queued → processed → broadcasted to all clients.</p>
      </div>
    </header>

    <hr />

    <section class="section">
      <h2><span class="badge">🚀</span> Features</h2>

      <ul class="features">
        <li>
          <strong>Message API (POST <code>/api/messages</code>)</strong>
          <div class="meta">Accepts <code>sender_id</code> and <code>message</code>, stores into DB, dispatches a queue job, returns JSON with message ID.</div>
        </li>

        <li>
          <strong>Queue Processing (Database Queue)</strong>
          <div class="meta">A <code>ProcessMessageJob</code> sanitizes the message, appends metadata (<code>processed_at</code>), and broadcasts the <code>message.received</code> event.</div>
        </li>

        <li>
          <strong>Real-time WebSocket Broadcast</strong>
          <div class="meta">Supports Laravel WebSockets, Soketi or any Pusher-protocol server. Broadcast channel: <code>messages.channel</code>. Event: <code>message.received</code>.</div>
        </li>

        <li>
          <strong>Frontend (public/index.html)</strong>
          <div class="meta">Simple HTML + JS client using <code>pusher-js</code> to connect and display incoming messages in real time.</div>
        </li>
      </ul>
    </section>

    <section class="section row" aria-labelledby="install-title">
      <div class="col">
        <h2 id="install-title">🛠️ Quick Setup</h2>

        <p class="meta">Follow these steps to run locally (development):</p>

        <ol style="margin:10px 0 0 18px; color:#0f172a;">
          <li><strong>Clone repo</strong>
            <div class="meta"> <code>git clone https://github.com/&lt;yourusername&gt;/realtime-notification-system.git</code></div>
          </li>
          <li style="margin-top:8px"><strong>Install & env</strong>
            <div class="meta">
              <code>composer install</code> → <code>cp .env.example .env</code> → <code>php artisan key:generate</code>
            </div>
          </li>
          <li style="margin-top:8px"><strong>Configure .env</strong>
            <div class="meta">
              Set DB and broadcasting/queue vars:<br />
              <code>QUEUE_CONNECTION=database</code><br />
              <code>BROADCAST_DRIVER=pusher</code><br />
              <code>PUSHER_APP_ID=local</code> / <code>PUSHER_APP_KEY=local</code> / <code>PUSHER_HOST=127.0.0.1</code> / <code>PUSHER_PORT=6001</code>
            </div>
          </li>

          <li style="margin-top:8px"><strong>Run migrations</strong>
            <div class="meta"><code>php artisan migrate</code></div>
          </li>
        </ol>

        <div style="margin-top:12px">
          <strong>Important runtime commands</strong>
          <p class="meta">Open separate terminals for each:</p>

          <div style="margin-top:8px" class="code">
<pre>php artisan websockets:serve     # (or) npx soketi start
php artisan queue:work database  # worker for DB queue
php artisan serve                # serve Laravel app</pre>
          </div>

          <p class="meta" style="margin-top:10px">Open the frontend: <code>http://127.0.0.1:8000/index.html</code></p>
        </div>
      </div>

      <aside class="col" style="max-width:360px">
        <div style="background:#fbfdff;border:1px solid #eef6ff;padding:14px;border-radius:10px">
          <strong>Broadcast config</strong>
          <p class="meta" style="margin-top:8px">
            In <code>config/broadcasting.php</code> set pusher options for local server:
          </p>
          <div class="code" style="margin-top:10px; font-size:13px">
<pre>'pusher' => [
  'driver' => 'pusher',
  'key' => env('PUSHER_APP_KEY'),
  'secret' => env('PUSHER_APP_SECRET'),
  'app_id' => env('PUSHER_APP_ID'),
  'options' => [
    'host' => env('PUSHER_HOST', '127.0.0.1'),
    'port' => env('PUSHER_PORT', 6001),
    'scheme' => env('PUSHER_SCHEME', 'http'),
    'useTLS' => false,
  ],
],</pre>
          </div>
        </div>

        <div style="margin-top:12px;background:#fff7ed;border:1px solid #fff1d6;padding:12px;border-radius:10px">
          <strong>Git workflow</strong>
          <p class="meta" style="margin-top:8px">Use a feature branch and commit frequently:</p>
          <div class="meta" style="margin-top:8px">
            <code>git checkout -b feature/realtime-db-queue-websockets</code><br />
            <code>git commit -m "feat: add messages migration and model"</code>
          </div>
        </div>
      </aside>
    </section>

    <hr />

    <section class="section">
      <h2>📡 API</h2>
      <p class="meta">POST <code>/api/messages</code></p>

      <div class="code" style="margin-top:10px">
<pre>Request JSON:
{
  "sender_id": 1,
  "message": "Hello world"
}

Response:
{
  "status": "queued",
  "message_id": 10
}</pre>
      </div>

      <p class="meta" style="margin-top:12px">Queue worker command (development):</p>
      <div class="code" style="margin-top:8px">
<pre>php artisan queue:work database</pre>
      </div>

      <p class="meta" style="margin-top:10px">Recommended worker options:</p>
      <div class="code" style="margin-top:8px">
<pre>php artisan queue:work database --sleep=3 --tries=3 --timeout=60</pre>
      </div>
    </section>

    <footer>
      <div>Author: <strong>Your Name</strong></div>
      <div><a class="btn" href="https://github.com/yourusername" target="_blank" rel="noopener">GitHub</a></div>
    </footer>

  </main>
</body>
</html>
