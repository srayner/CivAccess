
-- zfcUser resources.
insert into access_resource(resource_id, resource, display_name) values (5, 'zfcuser', 'User Account');

-- zfcUser privileges.
insert into access_privilege(resource_id, privilege, display_name) values (5, 'index', 'View');
insert into access_privilege(resource_id, privilege, display_name) values (5, 'login', 'Login');
insert into access_privilege(resource_id, privilege, display_name) values (5, 'changepassword', 'Change Password');
insert into access_privilege(resource_id, privilege, display_name) values (5, 'changeemail', 'Change Email Address');
insert into access_privilege(resource_id, privilege, display_name) values (5, 'logout', 'Logout');
insert into access_privilege(resource_id, privilege, display_name) values (5, 'register', 'Register');

-- zfcUser rules.
insert into access_rule(role, resource, privilege) values ('guest', 'zfcuser', 'index');
insert into access_rule(role, resource, privilege) values ('guest', 'zfcuser', 'register');
insert into access_rule(role, resource, privilege) values ('guest', 'zfcuser', 'login');
insert into access_rule(role, resource, privilege) values ('user', 'zfcuser', 'logout');
