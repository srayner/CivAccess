# CivAccess

A Zend Framework 2 authorisation module. Based around the Zend\Permission\Acl component. Designed to be easy to use and
understand. Authorisation covers what resources an identity can access. It does not cover authentication, which is the process
of identifying someone against a set of credentials, such as logging in with a username and password.

This module should be used in conjunction with a separate authorisation module. An excellent example is the ZfcUser module. 

The persistence layer is abstracted away with no dependency upon any particular database vendor. You should be able to use any
database that has a PHP PDO driver available. This module has no dependencies on any particular authentication module. However
it does require an authentication service that can provide an identity object via a getIdentity() method, an the identity object
should provide a getId() method to retrieve the identifier.

Roles represent users and groups. Because Zend\Permission\Acl supports multiple inheritance, users can be a member of more than
one group. Roles and their parent groups are stored in a simple database table. So you can either use this module to manage them,
or use your own module to manipulate the database table. There are some built in roles such as; guest, user and admin, that should
not be deleted, but you can also add your own roles.

Resources are mapped to controllers and privileges are mapped to action. This keeps things simple to understand and manage.

Rules define which privileges on a resource that a particular role has. Rules are also stored in a database table. Again use
either this module to manage them, or your own module.


