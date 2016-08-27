[![Latest Stable Version](https://poser.pugx.org/srayner/civaccess/v/stable)](https://packagist.org/packages/srayner/civaccess)
[![Total Downloads](https://poser.pugx.org/srayner/civaccess/downloads)](https://packagist.org/packages/srayner/civaccess)
[![Latest Unstable Version](https://poser.pugx.org/srayner/civaccess/v/unstable)](https://packagist.org/packages/srayner/civaccess)
[![License](https://poser.pugx.org/srayner/civaccess/license)](https://packagist.org/packages/srayner/civaccess)

# CivAccess

A Zend Framework 2 authorisation module. Based around the Zend\Permission\Acl component. Designed to be easy to use and
understand. Authorisation covers what resources an identity can access. It does not cover authentication, which is the process
of identifying someone against a set of credentials, such as logging in with a username and password.

This module should be used in conjunction with a separate authorisation module. An excellent example is the ZfcUser module. 

The persistence layer is abstracted away with no dependency upon any particular database vendor. You should be able to use any
database that has a PHP PDO driver available. This module has no dependencies on any particular authentication module. However
it does require an authentication service that can provide an identity object via a getIdentity() method, and the identity object
should provide a getId() method to retrieve the identifier.

Roles represent users and groups. Because Zend\Permission\Acl supports multiple inheritance, users can be a member of more than
one group. Roles and their parent groups are stored in a simple database table. So you can either use this module to manage them,
or use your own module to manipulate the database table. There are some built in roles such as; guest, user and admin, that should
not be deleted, but you can also add your own roles.

Resources are mapped to controllers and privileges are mapped to actions. This keeps things simple to understand and manage.

Rules define which privileges on a resource that a particular role has. Rules are also stored in a database table. Again use
either this module to manage them, or your own module.


## Installation

To install this module into your ZF2 application;

- Create an empty CivAccess folder inside your vendor folder.
- Clone this git repository into your new CivAccess folder.
- Active the new module by adding a 'CivAccess' entry under the 'Modules' key in your application config file.

## Post Installation

If you are using mySQL or Firebird for your database you can execute the applicable sql script found inside the \data folder.
This will create two tables inside your database to stores roles and access rules.

If you are using the zfcUser module for authentication and have not yet created your user database table, you can execute the
relevant ..._zfcuser.sql file. This will create the user table and insert access rules for guest and user roles to access the
standard zfcuser controllers and action.

###Create initial admin user
In order to start administering the system you will need to assign at least one user with the admin role. Because we don't yet
have an admin user, this needs to be done manually by inserting a record into the access_role database table.

To do this, execute the create_admin.sql (found in the data folder) on your database. Substituting the user_id value with the
id of your user.    
 