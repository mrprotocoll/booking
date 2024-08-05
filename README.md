# Appointment Booking System

An appointment booking system that allows users to select available dates and times, enter their details, and book an appointment. The admin can manage availability, view all appointments, and update or delete availabilities.

## Setup Instructions

### Prerequisites

- PHP >= 8.0
- MySQL
- Composer

### Installation

1. **Clone the repository:**
```sh
   git clone https://github.com/yourusername/appointment-booking-system.git
   cd appointment-booking-system
```

2. **Install Dependencies:**
```sh
   composer install
```

3. **Environment Setup:**
Create a .env file in the app/Model directory and add the content in .env.example to the .env file:
```php
 cp .env.example .env
```

4. **Database Migration:**
```sh
   composer run migration
```
## Tech Stack

- **Frontend:**
    - HTML
    - CSS
    - JavaScript
    - jQuery
    - Bootstrap 5
    - SelectPure (for multi-select dropdown)

- **Backend:**
    - PHP
    - MySQL

- **Libraries/Packages:**
    - Dotenv (for environment variables)
    - Composer (dependency management)

## Features

- **User:**
    - Select available dates and times
    - Enter personal information to book an appointment
    - View booking confirmation

- **Admin:**
    - Add new availability with multiple times for a selected date
    - View all availabilities
    - Update or delete availabilities
    - View all appointments with pagination and search functionality
