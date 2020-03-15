# Wellspring Trains

##Assumptions

- CRUD and file upload operations should be for authenticated users only. This is only being ignored for the purposes of the test.

- CSV format will always use the headers and column order specified in the brief. Given more time, checks should be added to ensure the uploaded file displays data in the proper format, otherwise data may be input with a Run Number of "SJones".

- Data displayed will be drawn from a database. CSV files can be used to bulk import data in addition to regular CRUD operations.

- All fields are required. Rows missing a field will not be imported, but the user will be notified.


