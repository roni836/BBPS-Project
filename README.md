# 🔌 Laravel BBPS Integration

This is a **Laravel-based BBPS (Bharat Bill Payment System) integration demo**.  
It connects to the Toshanibank BBPS sandbox API and provides a simple flow:  

👉 **Categories → Billers → Biller Info → Fetch Bill → Pay Bill**  

---

## 🚀 Features

- ✅ Fetch bill **categories** from BBPS API  
- ✅ Show available **billers** by category  
- ✅ Display **biller info & required input fields** dynamically  
- ✅ Fetch **bill details** using customer credentials (e.g., Consumer ID, Mobile Number)  
- ✅ Pay bills via BBPS with **RequestID, ClientRefId, OrderID**  
- ✅ Clean **Bootstrap 5 UI** for better user experience  
- ✅ Error handling & logging with Laravel’s `Log`  

---

## 📂 Project Structure

```
app/Http/Controllers/BbpsController.php   # Core API integration logic
resources/views/bbps/                     # Blade views
routes/web.php                            # Web routes
config/services.php                       # API configuration
```

---

## ⚙️ Requirements

- PHP 8.1+  
- Composer  
- Laravel 10+  
- Guzzle HTTP Client  

---

## 🔧 Installation

1. Clone the repo:

```bash
git clone https://github.com/your-username/laravel-bbps.git
cd laravel-bbps
```

2. Install dependencies:

```bash
composer install
cp .env.example .env
php artisan key:generate
```

3. Configure `.env` with your BBPS sandbox credentials:

```env
BBPS_SECRET_KEY=3c1b9abff9251f8f8164573c215be607
BBPS_API_URL=https://sandbox.toshanibank.com/bbps
```

4. Link config in `config/services.php`:

```php
'bbps' => [
    'api_key' => env('BBPS_SECRET_KEY'),
    'api_url' => env('BBPS_API_URL'),
],
```

5. Run the Laravel dev server:

```bash
php artisan serve
```

---

## 🌐 Routes

| Endpoint               | Description                          |
|-------------------------|--------------------------------------|
| `/categories`          | List all categories                  |
| `/billers/{category}`  | List billers for a category           |
| `/biller-info/{id}`    | Show required input fields for biller |
| `/fetch-bill` (POST)   | Fetch bill details                   |
| `/pay-bill` (POST)     | Pay the bill                         |

---

## 🖼️ UI Flow

1. **Categories** – User selects category  
2. **Billers** – User selects biller  
3. **Biller Info** – Input fields are dynamically shown (e.g., Consumer ID)  
4. **Fetch Bill** – Bill details are displayed (due amount, due date, etc.)  
5. **Pay Bill** – Bill is paid via BBPS and status is displayed  

---

## 📝 Example API Request

**Fetch Bill (POST `/bbps_bill_fetch`):**

```json
{
  "secret_key": "3c1b9abff9251f8f8164573c215be607",
  "biller_id": "WBSEDCL00WBL01",
  "fields_info": [
    { "Consumer Id": "123456789" },
    { "Mobile Number": "9123457897" }
  ]
}
```

---

## 📊 Example Bill Details Response

```json
{
  "result": 1,
  "message": "Success",
  "data": {
    "dueamount": "100",
    "duedate": "2025-09-30",
    "customername": "XYZ",
    "billdate": "2025-09-01",
    "billnumber": 546086702
  }
}
```

---

## ✅ Payment Request

**Pay Bill (POST `/bbps_bill_payment`):**

```json
{
  "secret_key": "3c1b9abff9251f8f8164573c215be607",
  "biller_id": "WBSEDCL00WBL01",
  "clientRefId": "6677889900",
  "RequestID": "1122334455",
  "order_id": "ORD123456",
  "amount": "200"
}
```

---

## 📌 Notes

- 🔑 Use sandbox credentials only. Real consumer IDs won’t work in UAT.  
- 🛡️ For production, switch `BBPS_API_URL` to the live endpoint and replace secret keys.  
- 📜 Logs for errors are stored in `storage/logs/laravel.log`.  

---

## 👨‍💻 Author

Built with ❤️ in Laravel.  
Feel free to contribute or open issues.  