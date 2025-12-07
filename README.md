# 📨 Real-Time Notification System (Laravel 10 + Database Queue + WebSockets)

This project demonstrates a real-time notification system using **Laravel 10**,
**Database Queue**, and **WebSockets**.

A user sends a message → it is saved in the database → processed in a queue job →
then broadcast to all connected clients in real-time.

This architecture is used in chat applications, order tracking systems, dashboards, and instant notifications.

## 🚀 Features

### ✔ 1. Message API (POST /api/messages)

* Accepts `sender_id` and `message`
* Stores message in the database
* Dispatches a queue job
* Returns a JSON response with the message ID

---

### ✔ 2. Queue Processing (Database Queue)

A `ProcessMessageJob` performs:

* Sanitization
* Adds metadata (`processed_at`)
* Broadcasts `message.received` event

Run the queue worker:

```bash
php artisan queue:work database
```

---

### ✔ 3. Real-Time WebSocket Broadcasting

* Works with Laravel WebSockets / Soketi
* Uses Pusher protocol (local only, no external Pusher required)
* Broadcast channel: `messages.channel`
* Event name: `message.received`

---

### ✔ 4. Frontend (public/index.html)

* Simple HTML + JavaScript
* Connects to WebSocket server
* Displays messages in real-time
* Provides form to send message via API

Open in browser:

```
http://127.0.0.1:8000/index.html
```

---

## 🛠️ Setup Instructions

### 1️⃣ Clone the Repository

```bash
git clone https://github.com/developerbiswa/Realtime-App.git
cd Realtime-App
```

*(If your repo name is different, replace it accordingly.)*

---

### 2️⃣ Install Dependencies

```bash
composer install
cp .env.example .env
php artisan key:generate
```

---

### 3️⃣ Configure .env

Database example:

```
DB_DATABASE=realtime_demo
DB_USERNAME=root
DB_PASSWORD=
```

Queue + Broadcast settings:

```
QUEUE_CONNECTION=database
BROADCAST_DRIVER=pusher

PUSHER_APP_ID=local
PUSHER_APP_KEY=local
PUSHER_APP_SECRET=local
PUSHER_HOST=127.0.0.1
PUSHER_PORT=6001
PUSHER_SCHEME=http
```

---

### 4️⃣ Run Database Migrations

```bash
php artisan migrate
```

---

### 5️⃣ Start WebSocket Server

Option A:

```bash
php artisan websockets:serve
```

Option B (Recommended):

```bash
npx soketi start
```

---

### 6️⃣ Start Queue Worker

```bash
php artisan queue:work database
```

---

### 7️⃣ Start Laravel Development Server

```bash
php artisan serve
```

Now open:

```
http://127.0.0.1:8000/index.html
```

---

## 📡 API Example

### POST /api/messages

Request:

```json
{
  "sender_id": 1,
  "message": "Hello World!"
}
```

Response:

```json
{
  "status": "queued",
  "message_id": 1
}
```
