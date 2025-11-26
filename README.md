# SurveyPro

A modern web application built with Laravel for creating, managing, and taking surveys. Users can create surveys with multiple questions, each supporting various option types, and respondents can take surveys and view results.

## Features

- **Survey Creation**: Create and edit surveys with custom titles and descriptions
- **Question Management**: Add multiple questions to surveys with different option types (radio buttons, checkboxes, text inputs)
- **Survey Taking**: User-friendly interface for respondents to complete surveys
- **Results Dashboard**: View survey responses and generate PDF reports
- **User Authentication**: Secure login and registration system
- **Responsive Design**: Mobile-friendly interface built with Tailwind CSS

## Technologies Used

- **Backend**: Laravel 11.x
- **Frontend**: Blade templates, Tailwind CSS, Alpine.js
- **Database**: MySQL
- **Authentication**: Laravel Breeze
- **PDF Generation**: Laravel DOMPDF

## Installation

1. **Clone the repository**:
   ```bash
   git clone <repository-url>
   cd surveypro
   ```

2. **Install PHP dependencies**:
   ```bash
   composer install
   ```

3. **Install Node.js dependencies**:
   ```bash
   npm install
   ```

4. **Environment Setup**:
   - Copy `.env.example` to `.env`
   - Configure your database settings in `.env`
   - Generate application key:
     ```bash
     php artisan key:generate
     ```

5. **Database Setup**:
   ```bash
   php artisan migrate
   php artisan db:seed
   ```

6. **Build Assets**:
   ```bash
   npm run build
   ```

7. **Start the Development Server**:
   ```bash
   php artisan serve
   ```

   The application will be available at `http://localhost:8000`

## Usage

### For Survey Creators:
1. Register/Login to access the dashboard
2. Create a new survey from the surveys index page
3. Add questions with multiple choice or text options
4. Share the survey link with respondents

### For Respondents:
1. Access the survey using the provided link
2. Answer all questions
3. Submit the survey

### Viewing Results:
- Survey creators can view responses in the dashboard
- Generate PDF reports of survey results

## Database Schema

The application uses the following main models:
- **Survey**: Contains survey metadata
- **SurveyQuestion**: Questions belonging to surveys
- **SurveyOption**: Options for multiple choice questions
- **SurveyResponse**: Individual survey submissions
- **SurveyAnswer**: Answers to specific questions

## Contributing

1. Fork the repository
2. Create a feature branch
3. Make your changes
4. Run tests: `php artisan test`
5. Submit a pull request

## License

This project is licensed under the MIT License.
