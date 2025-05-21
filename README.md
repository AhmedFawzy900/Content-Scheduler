# Content Scheduler

A Laravel-based content scheduling application that allows users to create and schedule posts across multiple social media platforms.

## Features

- **Multi-platform Support**: Schedule posts for Twitter, LinkedIn, Instagram, and Facebook
- **Post Management**: Create, edit, and delete posts with rich content
- **Scheduling**: Schedule posts for future publication
- **Platform-specific Validation**: Automatic validation for platform-specific requirements (character limits, image requirements)
- **Analytics**: Track post performance across platforms
- **Rate Limiting**: Maximum 10 scheduled posts per day
- **Image Upload**: Support for image attachments
- **User Management**: Secure authentication and profile management

## Requirements

- PHP 8.1 or higher
- Composer
- MySQL 5.7 or higher
- Node.js and NPM (for frontend assets)

## Installation

1. Clone the repository:
```bash
git clone <repository-url>
cd content-scheduler
```

2. Install PHP dependencies:
```bash
composer install
```

3. Install frontend dependencies:
```bash
npm install
```

4. Copy the environment file:
```bash
cp .env.example .env
```

5. Generate application key:
```bash
php artisan key:generate
```

6. Configure your database in `.env`:
```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=content_scheduler
DB_USERNAME=your_username
DB_PASSWORD=your_password
```

7. Run migrations and seeders:
```bash
php artisan migrate --seed
```

8. Start the development server:
```bash
php artisan serve
```

9. In a separate terminal, start the frontend development server:
```bash
npm run dev
```

## API Endpoints

### Authentication
- `POST /api/register` - Register a new user
- `POST /api/login` - Login user
- `POST /api/logout` - Logout user (requires authentication)

### User Profile
- `GET /api/user` - Get user profile
- `PUT /api/user` - Update user profile

### Posts
- `GET /api/posts` - List all posts
- `POST /api/posts` - Create a new post
- `GET /api/posts/{id}` - Get a specific post
- `PUT /api/posts/{id}` - Update a post
- `DELETE /api/posts/{id}` - Delete a post
- `GET /api/posts/analytics` - Get post analytics

### Platforms
- `GET /api/platforms` - List available platforms
- `POST /api/platforms/{id}/toggle` - Toggle platform activation

## Scheduled Tasks

The application includes a command to process scheduled posts. Add this to your crontab:

```bash
* * * * * cd /path-to-your-project && php artisan posts:process-scheduled
```

## Testing

Run the test suite:

```bash
php artisan test
```

## Contributing

1. Fork the repository
2. Create your feature branch
3. Commit your changes
4. Push to the branch
5. Create a new Pull Request

## License

This project is licensed under the MIT License. 