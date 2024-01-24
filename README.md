# Project Kart Race

## ìndice
- <a href="#project-requirements">Project Requirements</a>
- <a href="#project-features">Project Features</a>
- <a href="#how-to-run-the-project">How to run the project</a>
- <a href="#how-to-access-api-routes-and-endpoints">How to access APi Routes and Endpoints</a>
- <a href="#technologies-used">Technologies used</a>
- <a href="#deadline-for-project-delivery">Deadline for project delivery</a>
- <a href="#author">Author</a>
- <a href="#next-steps">Next Steps</a>
- <a href="#extra-information">Extra information</a>

___

## Project Requirements

### Project created for testing, which must meet the following criteria:
### From an input from a log file in the format above, create the race result with the following information:
  * Finishing Position, 
  * Driver Code, 
  * Driver Name, 
  * Number of Laps Completed,
  * Time Total Test.


### The following criteria must also be taken into account
  * The first line of the file can be disregarded (Time, Pilot, Lap Number, Lap Time, Average Lap Speed),
  * The race ends when the first place finisher completes 4 laps.


### The following features will also be added:
  * Display each driver's best lap
  * Display the best lap of the race
  * Display the average speed of each driver during the race
  * Display how long each driver arrived after the winner

___

## Project Features

- [x] Import log file
- [x] Check race results
- [x] Check fastest lap
- [x] List each driver's best lap
- [x] List average speed of each driver
- [x] List how long each driver arrived after first place
- [x] List all race information
- [x] Separate every project into classes
- [x] Insert Repositories and create validation rules and queries
- [x] Creation of endpoints
- [x] Validation of pilot data

___

## How to run the project

```bash
# Clone this repository
$ git clone git@github.com:Maiconsmendonca/kartRace.git

# Access the project folder in your terminal
$ cd kartRace

# Install the dependencies
$ npm install
$ composer install
```

___

## How to access APi Routes and Endpoints

```
    // Input the .log file
    {{BASE_URL}}/api/process-log
    
    // Check the race result
    {{BASE_URL}}/api/race-results
    
    // Each driver's best lap
    {{BASE_URL}}/api/best-lap-for-each-pilot
    
    // Each rider's best time
    {{BASE_URL}}/api/average-speed-for-each-pilot
    
    // The time each driver arrived after first place
    {{BASE_URL}}/api/time-difference-from-winner-for-each-pilot
    
    // All driver and race information
    {{BASE_URL}}/api/all-race-information
    
    //All Pilots
    {{BASE.URL}}/api/pilot-results
```

___

## Technologies used

1. [PHP](https://www.php.net/)
2. [Laravel](https://laravel.com/)
3. [Composer](https://getcomposer.org/)
4. [Docker](https://www.docker.com/)

___

# Deadline for project delivery
   # 23/01/2024 

___

## Author
### Maicon Mendonca
* [Linkedin]()

___

## Next Steps

Fish steps

___
