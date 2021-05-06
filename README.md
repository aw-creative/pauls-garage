## Pauls Garage

This is an example repo to Demonstrate a basic Booking system for Pauls Garage

## Brief
The Goal
We would like you to create a booking system for Hayden’s Garage. The business owner
Paul wants to capture the following information and save it to the database;
- Name
- Email Address
- Phone Number
- Vehicle Make & Model
- Date & time of booking
The 30-minute booking slots should only be allowed to be booked between 9am and 5pm
Monday to Friday and only 1 booking should be allowed for a specific date and time.
A booking confirmation needs to be emailed to both Paul and the customer.
The technical test should be completed using Laravel and contain clean and well
commented code. You are welcome to use any front end technology of your choosing
(HTML/CSS, Vue, Other JS framework)

Fancy an additional challenge?
- Paul has been struggling to contact people who have completed the form. Lots of the
email addresses are invalid. Can you prevent invalid email addresses from being
submitted?
- It would be great to Paul to be able to block specific days in the future from being
booked.
- Paul would love to be able to see what bookings he has on a specific date in the
future.

## Installation

- clone the repository
- in your ENV file add values for 
- `composer instal`
- `npm install`
- `npm run dev`
- `php artisan migrate`
- `php artisan serve`

- Register a new user to access admin calendar
- Visit home page to make a booking

## Email

You will need a mailtrap account or other testing service to recive emails set the SMTP detials up in the ENV file.
Emails are queued to avoid a slow response from the server.
They are sent via a queue so you can run `php artisan queue:work --stop-when-empty` from the cli to run the queue worker and send the emails
