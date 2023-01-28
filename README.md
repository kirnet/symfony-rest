### Install

- make dc_build
- make dc_up
- make bash
 
### In container

- composer install
- ./bin/console do:mig:mig
- ./bin/console --env=test doctrine:database:create
- ./bin/console --env=test do:mig:mig
- ./bin/console lexik:jwt:generate-keypair



### create admin 
./bin/console app:users:create-user

### Endpoints
- Login
 
curl -X POST -H "Content-Type: application/json" http://localhost:18000/api/auth/token/login -d '{"email":"admin@admin.by","password":"111111"}'

- Refresh token

curl -X POST -H "Content-Type: application/json" http://localhost:18000/api/auth/token/refresh -d '{"refreshToken":"token"}'

- Authorization

curl -H "Content-Type: application/json" -H "Authorization: Bearer token" http://localhost:18000/api/users/me

- Add user

curl -X POST -H "Content-Type: application/json" -H "Authorization: Bearer token" http://localhost:18000/api/users

- Update user

curl -X PUT -H "Content-Type: application/json" -H "Authorization: Bearer token" http://localhost:18000/api/users/2 -d '{"firstName": "first","lastName": "last"}'

- Delete user

curl -X DELETE -H "Content-Type: application/json" -H "Authorization: Bearer token" http://localhost:18000/api/users/2