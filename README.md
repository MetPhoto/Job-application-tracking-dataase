# Simple job application tracking database using PHP and MySQL
## Written by Mark Taylor

This code is provided "as is" without any warranty. It is provided for educational purposes only. See MIT license.

Mark Taylor - January 2020.

## Background
During 2012 I was out of work and spent a lot of time applying for jobs. I created a database to track my job applications. The database proved useful and numerous features were added over time.

It was a useful learning exercise - PHP, MySQL, HTML, CSS and a little Javascript.  It also helped occupy my time.

What I found difficult was trying to establish what 'best practice' looked like. For example what is the best approach for storing the database credentials or how best to create the SQL commands. The latter are all created manually inside the code, but this always felt this was inefficient. While it is easy to work out (from the internet) how to code a particular function it is not easy (from my experience) to establish the best design pattern, if that is not too grand a word for it!

## The challenge
Make my amateur code better. Tell me how to make it 'better', more secure, more efficient and easy to update & maintain.

The code is very linear. There is no attempt to create background tasks or even reusable sub-routines. I am sure it can be improved.

## Functionality

At its heart this is a simple database to store the details of a job application. The initial screen provides summary of the recent applications and a small sparkling-like chart at the top right showing the number of recent applications by week.

- Configuration stored in MySQL database, with a GUI to amend some configuration items.
- Click on a column header on the summary page to hide the column. Refresh the page to unhide a column.
- Summary page is configurable. The `status` summary is created dynamically. If a new status is added then the table will still work. Status values are stored in a database table called `dropdown` (not ideal).
- Table names are stored in the config database. Allows you to swap to a database table of dummy data for demonstration purposes.
- Debug mode - set `debug` to 1 in the `config` table to provide some additional information messages, there is no GUI for this. Note: the `Portal` link (see notes below) in the top left will turn red when debug is active.
- Add an activity associated with an application.
- Add a CV, a stored item when creating a job application.
- Add a file to an application, could be a PDF of a job description.
- Add a report, a basic GUI for creating new user reports. There is no way to edit existing reports.
- Add an alarm to a job application, for example to remind you to follow up on an application.
- Search function, basic.
- System reports - pre-defined reports. Includes a report to locate duplicate applications. Never really sure this worked as it was supposed to.
- User reports - custom reports created by a user and stored in a MySQL table.
- Ability to set which days of the week the email alerts are sent out. **Unsure if this works, email provider restrictions may well prevent this feature working at all because the Raspberry Pi will be an untrusted email server host.**

## Known issues
The code built into the header that creates the values for the sparkline style chart at the top right does not work correctly at the start of the year. It is supposed to look back over the last 4 weeks to show a summery of job application numbers. However, this does not work for weeks numbered 1 to 4 (the start of the year). I am sure I could improve this.

There is very little input validation for any of the fields.

The code does not check if a record has been successfully inserted or updated.

The built in (system report) `duplicates` does not work very well.

Email updates may well not work at all, see above.

## System requirements
I run this code on a Raspberry Pi 3.
- Linux - 4.9.35-v7+ #1014 SMP (Raspbian / Debian)
- MySQL - Ver 14.14 Distrib 5.5.62, for debian-linux-gnu (armv8l) using readline 6.3
- PHP - 5.6.40-0+deb8u8

## Notes
Any reference in the code to `fastpi` is a reference to the host the code is installed on. My local Raspberry Pi 3.

Application code ('web files') are stored in `/var/www/jobs`.

The file `jobs/library/config.php` will need to be updated with the correct `server` name and MySQL user `password`.

MySQL account set in the config file, currently set to `jobs`.

The `Portal` link at the top left provides a link back to local web based portal. This hosts links to my favourite local applications and web sites.  The default home page for my web browser on my iMac.