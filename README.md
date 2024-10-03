
# URL Shortener Service

This is a simple URL shortening service built with Laravel. The service provides two endpoints:

1. `/encode` - Encodes a given URL into a shortened URL.
2. `/decode` - Decodes a shortened URL back into the original URL.

## Prerequisites

- PHP >= 8.0
- Composer
- Laravel >= 8.0
- MySQL or any other database (optional, but Laravel cache is used in this implementation)
- Web browser for accessing the UI

## Installation

### Step 1: Clone the Repository

Clone this repository to your local machine using Git:

```bash
git clone https://github.com/josephrim/Url-Shortener.git
cd url-shortener
```

### Step 2: Install Dependencies

Install the required dependencies by running the following command:

```bash
composer install
```

### Step 3: Cache Driver

For this assignment, the URL mappings are stored in memory using Laravel's cache. By default, the cache driver is set to `file`. You may change it to another cache driver in the `.env` file, but it's not necessary for this project.

```bash
CACHE_DRIVER=file
```

### Step 4: Start the Local Development Server

You can now start the development server by running:

```bash
php artisan serve
```

The application should now be available at `http://localhost:8000`.

## Usage

### Encoding a URL

You can encode a URL by navigating to `http://localhost:8000`. There is a simple form where you can enter a URL and submit it to generate a shortened URL.

- **Form action**: `/encode`
- **Method**: `POST`
- **Request body**: JSON
  ```json
  {
    "url": "https://example.com/long-url"
  }
  ```

### Decoding a Shortened URL

You can decode a shortened URL back to its original URL by using the same UI or sending a POST request.

- **Form action**: `/decode`
- **Method**: `POST`
- **Request body**: JSON
  ```json
  {
    "short_url": "http://short.est/abc123"
  }
  ```

### API Endpoints

1. **Encode URL**
   - URL: `POST /encode`
   - Body: `{"url": "<long-url>"}`

   **Example**:
   ```bash
   curl -X POST http://localhost:8000/encode -H "Content-Type: application/json" -d '{"url":"https://example.com"}'
   ```

   Response:
   ```json
   {
     "short_url": "http://short.est/abc123"
   }
   ```

2. **Decode Shortened URL**
   - URL: `POST /decode`
   - Body: `{"short_url": "<short-url>"}`

   **Example**:
   ```bash
   curl -X POST http://localhost:8000/decode -H "Content-Type: application/json" -d '{"short_url":"http://short.est/abc123"}'
   ```

   Response:
   ```json
   {
     "original_url": "https://example.com"
   }
   ```

## Running Tests

Unit tests have been written to cover the functionality of the URL shortening service. You can run the tests using PHPUnit:

```bash
php artisan test
```

This will run all the test cases, and you should see the following output if all tests pass:

```
PASS  Tests\Feature\UrlShortenerTest
✓ it encodes a url and returns shortened url
✓ it decodes a shortened url to original url
✓ it returns 404 if shortened url does not exist
✓ it fails when invalid url is provided for encoding
✓ it fails when invalid url is provided for decoding

Tests:  5 passed
```

## Additional Information

- This project uses Laravel's cache to store the shortened URLs and their corresponding original URLs. The cache is stored for 1 hour, and after that time, the shortened URLs will no longer be valid.
- For production use, consider using a persistent database for storing URL mappings instead of cache.

## Troubleshooting

- If you encounter any issues with environment variables or the application configuration, try clearing the cache using:

```bash
php artisan config:clear
php artisan cache:clear
```