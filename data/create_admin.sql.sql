-- Create initial admin user
insert into access_role(role, parent, priority, role_type)
values(1, 'admin', 4, 'User Role');
