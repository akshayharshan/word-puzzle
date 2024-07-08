## Solution

1. Followed the objected oriented programming to implement the game beacuse it will encapsulate the data.

2. PHP sessions are used to persist the game state (letters, user words, score) across multiple HTTP requests. This ensures that the game progress is maintained until the session is explicitly ended.
3. Singleton Pattern for Database Connection
   Single Point of Access: Ensures that only one instance of the DbConnect class exists, providing a single point of access to the database connection. This avoids multiple connections being created unnecessarily.
4. Integrated with an external API to check whether the words created by the user are valid English words.

## Setup instructions

1. Here the setup was done with docker.
2. After unzip the project
3. Once reach the project directory through terminal and type docker-compose up -d --build
4. To access the application by opening http://localhost in web browser
5. Access the phpMyAdmin through http://localhost:40001 (username : root, password: aqwe123)
