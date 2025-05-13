#  PHP Shopping Website

A **native PHP** e-commerce platform built with **MVC architecture**, featuring **JWT authentication**, **refresh tokens**, **encryption**, and a clean, responsive **frontend UI**. This project provides both a full shopping experience for users and a complete admin panel for store management.

---

##  Features

###  Authentication & Security
- JWT-based login and registration
- Refresh token mechanism for session management
- Secure password hashing
- Data encryption for sensitive information
- Role-based access control (Admin & User)

###  Architecture
- Native PHP using the **MVC (Model-View-Controller)** pattern
- Clean and modular codebase
- Easily maintainable and extensible

###  User-Facing Pages
- Product listing & filtering
- Product detail page
- Shopping cart
- Checkout & order placement
- Order history
- User profile
-  easy dynamic search

###  Frontend UI
- Responsive design
- Clean and modern interface using HTML, CSS


---

##  Admin Panel

The system includes a secure **Admin Panel** to manage the entire store:

###  Admin Features
- **Product Management**
  - Add new products
  - Edit and update product details
  - Delete products
- **Category Management**
  - Add, edit, and delete categories
- **Order Management**
  - View and manage all customer orders
  - Change order status (e.g., Pending, Shipped, Delivered)
- **User Management**
  - View list of users
  - (Optional) Manage user roles and permissions
- **Secure Admin Access**
  - Only admins can access the admin panel via JWT authentication

---

## 🔍 Smart Search Agent

The project includes a custom-built search engine for products, implemented using the **Singleton pattern** to ensure only one instance is used across the application. This improves memory usage and keeps your search logic centralized and consistent.

### ✅ Features:
- Keyword matching across:
  - 🛒 Product **name**
  - 🎨 Product **color**
  - 🗂️ **Category** name
  - 📝 Product **description**
  - 💰 Product **price**
- 🔡 Case-insensitive search
- 🔎 Partial matching for flexible querying
- 🧠 Multi-word search support (splits input like `"blue jeans"` into `["blue", "jeans"]`)
- 🔄 Dynamically displays search results using the `productsController`

### 🛠️ How It Works:
- Converts the search query to lowercase
- Splits it into words to match each individually in the product description
- Constructs an SQL query with multiple conditions using `LIKE` and `LOWER()` to ensure flexible, case-insensitive matching
- Uses `productsController::displayProduct()` to render the matched products on the UI
