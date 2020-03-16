# Wellspring Trains

## Use
Visit http://ec2-3-21-28-142.us-east-2.compute.amazonaws.com/ for the displayed route data, as imported from the provided CSV. Each column heading is clickable to sort by that column. First click will display data ascending, and second click on the same column will show it descending. Pagination is provided at the table's footer. Each page will show up to 5 items. 
- << goes to the first page. 
- < goes to the previous page. 
- \> goes to the next page. 
- \>\> goes to the last page.

Seed data is being included in the hosted set for ease of testing.

Visit http://ec2-3-21-28-142.us-east-2.compute.amazonaws.com/admin to access the CSV import functionality. Enter a CSV file into the form to append new data to the routes available. Routes will only be imported when all four fields are present, and when that combination of items doesn't already exist in the database. See assumptions below.

See sql/trains.sql for an example of the database structure.

## Assumptions


### Data
- CSV format will always use the headers and column order specified in the brief. Given more time, checks should be added to ensure the uploaded file displays data in the proper format, otherwise data may be input with a Run Number of "SJones".

- Data displayed will be drawn from a database. CSV files can be used to bulk import data in addition to regular CRUD operations.

- All fields are required. Rows missing a field will not be imported, but the user will be notified.

### Security
- CRUD and file upload operations should be for authenticated users only. This is only being ignored for the purposes of the test.

- Additional security considerations should be given to any application allowing user input (especially direct uploads). All data should be typed, escaped and verified as valid in a full application.

### Architecture

- The code in this repo was all written longhand in order to demonstrate my processes and thinking. No frameworks are used here, only some common patterns I have used elsewhere.

- Given time constraints, and a lack of admin authentication, structure, etc, I am ignoring the directive to add CRUD operations, leaving only the CSV import.

- Because this is primarily a PHP / back end test, I am leaving the front end unstyled. Further consideration should be given to ensuring that elements are obvious in their purpose.

- All code is intended to be extensible so that more CRUD operations, enhanced security, better user interface can be added in the future.
