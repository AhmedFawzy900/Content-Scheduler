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

### Posts
- `GET /api/posts` - List all posts
- `POST /api/posts` - Create a new post
- `GET /api/posts/{id}` - Get a specific post
- `PUT /api/posts/{id}` - Update a post
- `DELETE /api/posts/{id}` - Delete a post

### Platforms
- `GET /api/platforms` - List available platforms
- `POST /api/platforms/{id}/toggle` - Toggle platform activation

### Scheduled Posts
- `GET /api/scheduled-posts` - List all scheduled posts
- `POST /api/scheduled-posts` - Schedule a new post
- `GET /api/scheduled-posts/{id}` - Get a specific scheduled post
- `PUT /api/scheduled-posts/{id}` - Update a scheduled post
- `DELETE /api/scheduled-posts/{id}` - Delete a scheduled post

### Post Processing
- `POST /api/process-scheduled` - Manually trigger scheduled posts processing

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

## License

This project is licensed under the MIT License. 