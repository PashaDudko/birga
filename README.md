For local development:
1. copy .env.example to your .env file

2. install composer dependencies

3. run following commands;
sail up -d
sail a migrate:fresh
sail a db:seed
