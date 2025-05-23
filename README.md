# Content Scheduler

A Laravel-based content scheduling system that allows users to schedule and publish posts across multiple social media platforms.

## Features

- Schedule posts for multiple platforms (Twitter, LinkedIn, Instagram, Facebook)
- Platform-specific content validation
- Automated post processing
- Multi-platform publishing support

## Installation

1. Clone the repository:
```bash
git clone [repository-url]
cd content-scheduler
```

2. Install dependencies:
```bash
composer install
```

3. Copy the environment file:
```bash
cp .env.example .env
```

4. Generate application key:
```bash
php artisan key:generate
```

5. Configure your database in `.env` file:
```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=content_scheduler
DB_USERNAME=your_username
DB_PASSWORD=your_password
```

6. Run migrations and seeders:
```bash
php artisan migrate
php artisan db:seed
```

7. Start the scheduler:
```bash
php artisan schedule:work
```

## Usage

### Scheduling Posts

Posts can be scheduled through the application interface or API. Each post can be scheduled for multiple platforms simultaneously.

### Processing Scheduled Posts

The system automatically processes scheduled posts using a Laravel command:
```bash
php artisan posts:process-scheduled
```

This command:
- Finds all scheduled posts that are due for publication
- Validates content against platform-specific requirements
- Updates post status upon successful publication

## API Endpoints

### Authentication
- `POST /api/register` - Register a new user
- `POST /api/login` - Login user
- `POST /api/logout` - Logout user (requires authentication)

### User Profile
- `GET /api/user` - Get user profile
- `POST /api/user` - Update user profile

### Posts
- `GET /api/posts-api` - List all posts
- `POST /api/posts-api` - Create a new post
- `GET /api/posts-api/{id}` - Get a specific post
- `PUT /api/posts-api/{id}` - Update a post
- `DELETE /api/posts-api/{id}` - Delete a post
- `GET /api/posts/analytics` - Get post analytics

### Platforms
- `GET /api/platforms` - List available platforms
- `PUT /api/platforms/{platform}/toggle-active` - Toggle platform activation

## Approach and Trade-offs

### Architecture Decisions

1. **Platform-Specific Validation**
   - Each platform has its own character limit and content requirements
   - Validation is handled through a simple rules-based system
   - Trade-off: Simple implementation but might need more complex validation rules in the future

2. **Scheduled Processing**
   - Uses Laravel's built-in scheduler
   - Processes posts in batches
   - Trade-off: Not real-time, but efficient for batch processing

3. **Multi-Platform Support**
   - Uses a many-to-many relationship between posts and platforms
   - Allows flexible platform assignment
   - Trade-off: More complex database structure but better flexibility

4. **Error Handling**
   - Graceful error handling for failed publications
   - Logs errors for debugging
   - Trade-off: Basic error handling, might need more sophisticated retry mechanisms

### Future Improvements

1. **Real-time Processing**
   - Implement queue system for immediate processing
   - Add retry mechanisms for failed posts

2. **Enhanced Validation**
   - Add more sophisticated content validation
   - Support for media content validation

3. **Analytics**
   - Add post performance tracking
   - Platform-specific analytics

4. **API Integration**
   - Direct integration with platform APIs
   - Real-time status updates

## Contributing

1. Fork the repository
2. Create your feature branch
3. Commit your changes
4. Push to the branch
5. Create a new Pull Request

