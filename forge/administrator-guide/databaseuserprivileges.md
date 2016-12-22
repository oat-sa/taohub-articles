<!--
created_at: '2012-12-28 16:23:41'
updated_at: '2013-03-05 12:14:33'
authors:
    - 'Jérôme Bogaerts'
tags:
    - 'Administrator Guide'
-->

Database User Privileges
========================

This page lists the privileges database users needs to properly access data stored by TAO.

MySQL
-----

This section describes required privileges to access properly data stored by TAO in MySQL:

-   EXECUTE
-   SELECT
-   SHOW DATABASES
-   ALTER
-   ALTER ROUTINE
-   CREATE
-   CREATE ROUTINE
-   DELETE
-   DROP
-   INDEX
-   INSERT
-   UPDATE
-   RELOAD

PostgreSQL
----------

This section considers that the reader is familiar with rights management in PostgreSQL. If you are not familiar with this Database Management System, we recommend you to read the [PostgreSQL Documentation](http://www.postgresql.org/docs/).

The following rights are needed to properly access data stored by TAO:

-   SELECT, INSERT, UPDATE, DELETE, REFERENCES on all tables in the *public* schema of the database
-   ALL PRIVILEGES on all SEQUENCES in the *public* scehma of the database
-   EXECUTE on ALL FUNCTIONS in the *public* schema of the database
-   CREATE on the database
-   CONNECT on the database
-   TEMPORARY on the database
-   USAGE on the *plpgsql* language

Database User Privileges
========================

This page lists the privileges database users needs to properly access data stored by TAO.

MySQL
-----

This section describes required privileges to access properly data stored by TAO in MySQL:

-   EXECUTE
-   SELECT
-   SHOW DATABASES
-   ALTER
-   ALTER ROUTINE
-   CREATE
-   CREATE ROUTINE
-   DELETE
-   DROP
-   INDEX
-   INSERT
-   UPDATE
-   RELOAD

PostgreSQL
----------

This section considers that the reader is familiar with rights management in PostgreSQL. If you are not familiar with this Database Management System, we recommend you to read the [PostgreSQL Documentation](http://www.postgresql.org/docs/).

The following rights are needed to properly access data stored by TAO:

-   SELECT, INSERT, UPDATE, DELETE, REFERENCES on all tables in the *public* schema of the database
-   ALL PRIVILEGES on all SEQUENCES in the *public* scehma of the database
-   EXECUTE on ALL FUNCTIONS in the *public* schema of the database
-   CREATE on the database
-   CONNECT on the database
-   TEMPORARY on the database
-   USAGE on the *plpgsql* language


