# stationary-shop
 
I have designed a project on a stationary shop where I have implemented php for dynamic response of the website and I have organized website by html and designed it visually attractive by css and java script, it has categories such as paper stationery, office stationery, art stationery and writing stationery, besides that I have also designed an admin page where admin can add and delete a category, add and delete a product edit and view the orders. All these are accomplished using my sql database and php admin, It also has basic requirements such as a login page, a billing page, user cart.


# Stationery Shop – E-Commerce Web Application

This is a fully functional stationery store built using PHP, MySQL, HTML, CSS (with Bootstrap), and a bit of JavaScript. It allows users to browse and buy writing supplies, paper products, art materials, and office essentials. There's also an admin panel for managing products, orders, and handling customer queries.

---

## Overview

The aim of this project was to design a simple but complete e-commerce system. It includes:

- User login and registration
- Category-wise product display
- Cart and checkout system
- Order management for users and admin
- Contact form with admin-side query viewer
- Admin panel with product/category controls

---

## Folder & File Structure

/stationery-shop/
│
├── home.php → Homepage with featured products
├── products.php → Full product listing
├── product-category.php → Category-specific product pages
├── cart.php → Cart view
├── billing.php → Checkout form
├── login.php / register.php / logout.php
├── user-dashboard.php → User profile + past orders
├── admin.php → Admin dashboard
├── admin-messages.php → View contact form submissions
├── add-product.php → Add new product (admin)
├── edit-product.php → Edit product (admin)
├── delete-product.php → Delete product (admin)
├── contact.php → User-facing contact form
├── contact-handler.php → Handles/stores messages in DB
├── db.php → MySQL DB connection
├── main.js → JS for UI interactions
├── style.css → Custom styling
└── README.md → This file

---

## Admin & Test User Login

- **Admin**
  - Email: `admin@test.com`
  - Password: `admin1234`

- **User**
  - Email: `user@test.com`
  - Password: `User@123`

You can also register a new user account through the registration form.

---

## Features

### For Users
- Browse products by category
- Search for specific items
- Add to cart, update/remove items
- Checkout with billing form
- Track previous orders
- Contact support via form

### For Admins
- Add/edit/delete products and categories
- View all orders
- Read messages submitted through contact form

---

## Tech Stack

- **Frontend**: HTML, CSS, Bootstrap, JavaScript
- **Backend**: PHP
- **Database**: MySQL
- **Hosting**: Local with XAMPP 

---

## Notes

- All product and category pages are dynamic.
- Forms include basic validation and input sanitization.
- Product and contact data are stored in a MySQL database.
- Layout is responsive and works well across desktop and mobile devices.

---

## Contact

This project was developed as part of a Web Technology course submission.  
If you're reviewing this for evaluation, all required criteria including forms, CRUD operations, database handling, and admin/user views are covered.

