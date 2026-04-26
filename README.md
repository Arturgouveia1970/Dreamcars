# 🚗 DreamCars

![GitHub stars](https://img.shields.io/github/stars/Arturgouveia1970/Dreamcars?style=social)

![WordPress](https://img.shields.io/badge/WordPress-21759B?style=for-the-badge&logo=wordpress&logoColor=white)
![PHP](https://img.shields.io/badge/PHP-777BB4?style=for-the-badge&logo=php&logoColor=white)
![Stripe](https://img.shields.io/badge/Stripe-635BFF?style=for-the-badge&logo=stripe&logoColor=white)
![JavaScript](https://img.shields.io/badge/JavaScript-F7DF1E?style=for-the-badge&logo=javascript&logoColor=black)
![License](https://img.shields.io/badge/license-MIT-green?style=for-the-badge)

A modern car rental web app built with WordPress, featuring real-time booking, Stripe payments, and a clean user experience.

---

## ✨ Features

* 🚘 Custom **Car catalog** (CPT)
* 📄 Individual car pages with full specs
* 📅 Date-based booking system
* 💳 Stripe Checkout integration
* ⚡ Real-time price calculation
* ❌ Double-booking prevention (paid bookings)
* 🌙 Dark mode UI
* 📱 Responsive design

---

## 🛠 Tech Stack

* WordPress (Custom Theme)
* PHP
* JavaScript (Vanilla)
* Stripe API
* ACF (Advanced Custom Fields)

---

## 📸 Screenshots

### 🏠 Home Page
![Home](https://raw.githubusercontent.com/Arturgouveia1970/Dreamcars/main/screenshots/home.png)

### 🚗 Car Listing
![Cars](https://raw.githubusercontent.com/Arturgouveia1970/Dreamcars/main/screenshots/cars.png)

### 📄 Car Details Page
![Car Detail](https://raw.githubusercontent.com/Arturgouveia1970/Dreamcars/main/screenshots/car-detail.png)

### 💳 Booking Checkout
![Checkout](https://raw.githubusercontent.com/Arturgouveia1970/Dreamcars/main/screenshots/checkout.png)

---

## ⚙️ Installation (Local)

1. Clone the repo:

```bash
git clone https://github.com/Arturgouveia1970/Dreamcars.git
```

2. Place theme inside:

```
wp-content/themes/
```

3. Install dependencies:

```bash
composer install
```

4. Configure Stripe key in `wp-config.php`:

```php
define('STRIPE_SECRET_KEY', 'your_stripe_key_here');
```

5. Start your local WordPress environment

---

## 💳 Stripe Setup

* Use test keys from https://dashboard.stripe.com/test/apikeys
* Payments are handled via Stripe Checkout
* Booking is created after successful payment

---

## 🔐 Security Notes

* Stripe secret key is stored in `wp-config.php`
* Sensitive files are excluded via `.gitignore`
* No secrets are committed to the repository

---

## 🚀 Future Improvements

* Stripe webhooks (production-grade confirmation)
* Booking calendar with disabled dates
* User accounts & booking history
* Admin dashboard enhancements

---

## 👨‍💻 Author

Built by Artur Gouveia

---

## 📄 License

MIT License
