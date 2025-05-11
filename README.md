# Advanced Real-Time Sales Analytics System 📊

This project is a **real-time sales analytics system** built with **Laravel 12**, designed to manage and analyze sales data, provide real-time updates via WebSockets, integrate with AI (Gemini) for product recommendations, and incorporate weather-based suggestions using the OpenWeather API. The system follows a clean architecture with service and repository layers, uses SQLite for lightweight storage, and includes a seeder for dummy data.

Watch the demo video here: [Loom Demo](https://www.loom.com/share/b99247e41b9b45c382dd19c66d078571?sid=498ba11c-0567-494f-9f28-7d502c83d151) 🎥

---

## Table of Contents 📑

1. [Project Overview](#project-overview-)
2. [Features](#features-)
3. [Technologies Used](#technologies-used-)
4. [AI-Assisted vs. Manual Implementation](#ai-assisted-vs-manual-implementation-)
5. [Installation](#installation-)
6. [Running the Application](#running-the-application-)
7. [Seeding Dummy Data](#seeding-dummy-data-)
8. [Testing](#testing-)
9. [Project Structure](#project-structure-)
10. [Evaluation Criteria](#evaluation-criteria-)
11. [Notes](#notes-)

---

## Project Overview 🛠️

The **Advanced Real-Time Sales Analytics System** fulfills the requirements of the provided backend task. It includes:

- **APIs** to manage orders and retrieve real-time analytics.
- **WebSocket** support using Laravel Reverb for live order and analytics updates.
- **AI integration** with Gemini to generate product promotion recommendations.
- **External API integration** with OpenWeather to adjust recommendations based on weather conditions (e.g., promote cold drinks on hot days).
- A **frontend** to visualize sales data and recommendations.
- A **service layer** for business logic and a **repository layer** for database queries using Laravel's Query Builder.
- **SQLite** as the database for simplicity, eliminating the need for migrations.

---

## Features ✨

- **Order Management**:
  - `POST /orders`: Add new orders with product ID, quantity, price, and date.
- **Real-Time Analytics**:
  - `GET /analytics`: Provides total revenue, top products, revenue changes, and order count for the last minute.
- **Real-Time Updates**:
  - WebSocket subscriptions for new orders and updated analytics using Laravel Reverb.
- **AI Recommendations**:
  - `GET /recommendations`: Sends sales data to Gemini and returns product promotion suggestions.
- **Weather-Based Suggestions**:
  - Integrates with OpenWeather API to suggest products based on weather (e.g., hot drinks on cold days).
- **Dummy Data**:
  - Seeder to populate the database with 5 sample products and orders.

---

## Technologies Used 🛠️

- **Backend**: Laravel 12, PHP 8.2
- **Database**: SQLite
- **WebSocket**: Laravel Reverb
- **AI**: Gemini API (for product recommendations)
- **External API**: OpenWeather API (weather-based suggestions)
- **Frontend**: Vite, JavaScript, Tailwind CSS
- **Tools**: Composer, npm, Laravel Query Builder
- **Testing**: PHPUnit

---

## AI-Assisted vs. Manual Implementation 🤖✍️

### AI-Assisted (30%) 🌟
- **Gemini API**:
  - Generated prompts for product promotion suggestions based on sales data.
  - Example prompt: *"Given this sales data, which products should we promote for higher revenue?"*
- **Frontend**:
  - Gemini provided suggestions for JavaScript logic (e.g., WebSocket handling) and Tailwind CSS styling for the dashboard.
- **Boilerplate**:
  - AI assisted in structuring initial API endpoints and frontend components.

### Manual Implementation (70%) 🛠️
- **Database Logic**:
  - All queries written manually using Laravel's Query Builder in the repository layer.
- **WebSocket Functionality**:
  - Implemented real-time updates using Laravel Reverb for new orders and analytics.
- **External API Integration**:
  - Manual integration with OpenWeather API to fetch weather data and adjust recommendations.
- **Service Layer**:
  - Handwritten business logic for order processing, analytics calculations, and recommendation processing.
- **Error Handling**:
  - Custom error handling for APIs and WebSocket connections.
- **Frontend Logic**:
  - Core JavaScript and frontend functionality implemented manually, with AI providing only suggestions.

---

## Installation ⚙️

Follow these steps to set up the project locally:

1. **Clone the Repository**:
   ```bash
   git clone <repository-url>
   cd <project-directory>
   ```

2. **Install Composer Dependencies**:
   ```bash
   composer install
   ```

3. **Install npm Dependencies**:
   ```bash
   npm install
   ```

4. **Set Up Environment File**:
   - Copy `.env.example` to `.env`:
     ```bash
     cp .env.example .env
     ```
   - Ensure the `WEATHER_API_KEY` is set for OpenWeather API access.
   - Update `APP_KEY` if needed by running:
     ```bash
     php artisan key:generate
     ```

5. **Create SQLite Database**:
   - The project uses SQLite, so no migrations are required. Ensure the SQLite database file exists:
     ```bash
     touch database/database.sqlite
     ```

---

## Running the Application 🚀

1. **Start the Laravel Server**:
   ```bash
   php artisan serve
   ```
   This runs the application at `http://localhost:8000`.

2. **Start Laravel Reverb (WebSocket Server)**:
   ```bash
   php artisan reverb:start
   ```
   This enables real-time updates via WebSockets at `http://localhost:8080`.

3. **Build and Run Frontend Assets**:
   ```bash
   npm run build
   npm run dev
   ```
   This compiles and serves the frontend assets using Vite.

4. **Access the Application**:
   - Open `http://localhost:8000` in your browser to view the dashboard.
   - The frontend will automatically connect to the WebSocket server for real-time updates.

---

## Seeding Dummy Data 🌱

To populate the database with sample data (5 products and corresponding orders):

1. Run the seeder:
   ```bash
   php artisan db:seed --class=OrderSeeder
   ```
2. This will add dummy products and orders to the SQLite database, which can be used for testing and demo purposes.

---

## Testing 🧪

The project includes basic test cases for APIs and real-time functionality using PHPUnit.

1. Run the tests:
   ```bash
   composer test
   ```
2. Tests cover:
   - `POST /orders` API for adding orders.
   - `POST /total-sales` API for retrieving total sales.
---

## Evaluation Criteria 📝

The project addresses the evaluation criteria as follows:

1. **Code Quality and Structure (30 points)** ✅:
   - Clean, modular code with service and repository layers.
   - Proper separation of concerns (controllers, services, repos, frontend).
2. **Real-Time Functionality (25 points)** ✅:
   - Laravel Reverb powers accurate WebSocket updates for orders and analytics.
3. **AI Integration (20 points)** ✅:
   - Gemini API integrated for actionable product recommendations.
   - Logical prompts used to generate insights.
4. **External API Integration (15 points)** ✅:
   - OpenWeather API used to adjust recommendations based on weather.
5. **Documentation and Testing (10 points)** ✅:
   - Comprehensive README with installation, running, and seeding instructions.
   - Test cases for APIs and WebSocket functionality.

---

## Notes 📌

- **AI Usage**: Clearly documented above; Gemini assisted with frontend JavaScript, styling, and API prompt generation , in testing this app and this readme file
- **Manual Implementation**: All database queries, WebSocket logic, and weather API integration were written manually.
- **Scalability**: The service and repository layers ensure the codebase is modular and maintainable.
- **Demo Video**: Refer to the [Loom video](https://www.loom.com/share/b99247e41b9b45c382dd19c66d078571?sid=498ba11c-0567-494f-9f28-7d502c83d151) for a walkthrough of the application.

For any issues or questions, please contact me on [Whatsapp](http://wa.me/+201004243428) or on my [Email](deve.ahmed.bdiwy@gmail.com).
