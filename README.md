###SETUP
1) run sudo ./generate_files
2) create the database you specified while running step 1
3) run php artisan migrate - to migrate Database
4) run php artisan db:seed
5) visit: http://localhost:8000/login   to login.
Username = admin@site.com
Password = password








MAIN ASSIGNMENT

Objective: Build a Mini-CRM website using Laravel. Feel free to use generated sample text (i.e. your favorite version of Lorem Ipsum) and google images when needed.

Requirements:


Administrator Role Access:
Can create/update/delete all companies.
Can create/update/delete employees for any company.
Can create/update/delete manager users.
Including assigning company access to manager accounts.
Manager Role Access:
Can only update companies they’ve been given access to.
Can create/update/delete employees for a company they’ve been given access to.
Use database seeds to create the first admin and manager user accounts.
Admin data: email admin@site.com and password “password”.
Manager data: email: manager@site.com and password “password”.
CRUD functionality (Create / Read / Update / Delete) for two menu items: Companies and Employees.
Companies DB table consists of these fields: Name (required), email, logo (minimum 100×100), website.
Employees DB table consists of these fields: First name (required), last name (required), Company (foreign key to Companies), email, phone.
Use database migrations to create those schemas above.
Store companies logos in storage/app/public folder and make them accessible from public.
Use basic Laravel resource controllers with default methods – index, create, store etc.
Use Laravel’s validation function, using Request classes.
Use Laravel’s pagination for showing Companies/Employees list, 10 entries per page.
Use Laravel make:auth as default Bootstrap-based design theme, but remove ability to register.


Delivery: Share the repo via GitHub or Bitbucket with jameson.tucker@forchange.agency. Also please send a mysql database dump along with any instructions.
