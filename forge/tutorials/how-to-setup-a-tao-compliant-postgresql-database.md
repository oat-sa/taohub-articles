<!--
author:
    - 'Jérôme Bogaerts'
created_at: '2013-01-02 11:32:44'
updated_at: '2014-11-13 12:42:51'
tags:
    - Tutorials
-->



How to setup a TAO compliant PostgreSQL database
================================================

1. Introduction
---------------

TAO is able to run on multiple Relational Database Systems (RDBMS) including [PostgreSQL](http://www.postgresql.org/docs/9.2/static/index.html) 8.4 and higher (LLE: work in 9.1 do not manage to make it work in 8.4). This tutorial will help you to set up a PostgreSQL database which is compliant with the TAO Platform.

Before starting, make sure you have a running installation of PostgreSQL on your web server and that [SQL Shell (psql)](http://www.postgresql.org/docs/8.1/static/app-psql.html) is property installed.

This tutorial was created with PostgreSQL 9.2.

2. Database, Roles and Users
----------------------------

Launch SQL Shell (psql) and connect as your *root* PostgreSQL. It is usually the *postgres* user account. We will know create the database iself, and the users and roles that will be authorized to use it.

In psql, enter the following statements:

    CREATE ROLE "TAO";
    CREATE DATABASE "taodb" OWNER "TAO";
    CREATE USER "taouser";
    ALTER USER "taouser" WITH PASSWORD 'password';
    GRANT "TAO" to "taouser";

The statements above create a new role (group of users) named *TAO* and assign the *taouser* user with password *password* to it. It also create a new empty database named *taodb*.

3. Permissions
--------------

We now have to grant permissions to the *TAO* roles in order to let the TAO Platform correctly address the Database.

Close the psql command line utility and execute it again as your *root* user but this time, select *taodb* as your working database. Still in psql, enter the following statements:

    GRANT SELECT ON ALL TABLES IN SCHEMA public TO "TAO";
    GRANT INSERT ON ALL TABLES IN SCHEMA public TO "TAO";
    GRANT UPDATE ON ALL TABLES IN SCHEMA public TO "TAO";
    GRANT DELETE ON ALL TABLES IN SCHEMA public TO "TAO";
    GRANT REFERENCES ON ALL TABLES IN SCHEMA public TO "TAO";
    GRANT ALL PRIVILEGES ON ALL SEQUENCES IN SCHEMA public TO "TAO";
    GRANT EXECUTE ON ALL FUNCTIONS IN SCHEMA public TO "TAO";
    GRANT CREATE ON DATABASE "taodb" TO "TAO";
    GRANT CONNECT ON DATABASE "taodb" TO "TAO";
    GRANT TEMPORARY ON DATABASE "taodb" TO "TAO";
    GRANT USAGE ON LANGUAGE plpgsql TO "TAO";

The statements above

-   Grant SELECT, INSERT, UPDATE, DELETE, REFERENCES on all tables in the public schema of the *taodb* database for the *TAO* role
-   Grant ALL PRIVILEGES ON ALL SEQUENCES of the *taodb* database for the *TAO* role
-   Grant EXECUTE ON ALL FUNCTIONS of the *taodb* database for the *TAO* role
-   Grant CREATE, CONNECT, TEMPORARY on the *taodb* database for the *TAO* role
-   Grant USAGE ON LANGUAGE plpgsql on the *taodb* database for the *TAO* role. The usage of the *plpgsql* language is required to create and execute functions and stored procedures

4. Conclusion
-------------

You are now able to setup a TAO compliant PostgreSQL database. Please read the [PostgreSQL documentation](http://www.postgresql.org/docs/9.2/static/sql-grant.html) if you want to know more about permissions.


