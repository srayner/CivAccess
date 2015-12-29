
-- Role table.
create table access_role (
    role_id   integer(11)  not null auto_increment,
    role      nvarchar(64) not null collate utf8_general_ci,
    parent    nvarchar(64)     null collate utf8_general_ci,
    role_type nvarchar(32) not null collate utf8_general_ci,
    primary key (
        role_id
    )
) ENGINE=InnoDB;

-- Inbuilt default roles (do not delete).
insert into access_role (role, parent, role_type) values ('guest', null, 'Built in role.');
insert into access_role (role, parent, role_type) values ('user', 'guest', 'Built in role.');
insert into access_role (role, parent, role_type) values ('admin', 'user', 'Built in role.');

-- Resources table.
create table access_resource (
    resource_id    integer(11)   not null auto_increment,
    resource       nvarchar(128) not null collate utf8_general_ci,
    display_name   nvarchar(64)  not null collate utf8_general_ci,
    primary key (
        resource_id
    )
) ENGINE=InnoDB;

-- Resources.
insert into access_resource (resource_id, resource, display_name) values (1, 'CivAccess\\Controller\\Index', 'Access Index');
insert into access_resource (resource_id, resource, display_name) values (2, 'CivAccess\\Controller\\Role', 'Roles');
insert into access_resource (resource_id, resource, display_name) values (3, 'CivAccess\\Controller\\Rule', 'Rules');
insert into access_resource (resource_id, resource, display_name) values (4, 'CivAccess\\Controller\\Resource', 'Resources');
insert into access_resource (resource_id, resource, display_name) values (5, 'CivAccess\\Controller\\Privilege', 'Privileges');

-- Privileges table.
create table access_privilege (
    privilege_id   integer(11)  not null auto_increment,
    resource_id    integer(11) not null,
    privilege      nvarchar(64) not null collate utf8_general_ci,
    display_name   nvarchar(64) not null collate utf8_general_ci,
    primary key (
        privilege_id
    )
) ENGINE=InnoDB;

-- Privileges.
insert into access_privilege (resource_id, privilege, display_name) values (1, 'index', 'Browse');
insert into access_privilege (resource_id, privilege, display_name) values (2, 'index', 'Browse');
insert into access_privilege (resource_id, privilege, display_name) values (2, 'add', 'Add');
insert into access_privilege (resource_id, privilege, display_name) values (2, 'edit', 'Edit');
insert into access_privilege (resource_id, privilege, display_name) values (2, 'delete', 'Delete');
insert into access_privilege (resource_id, privilege, display_name) values (3, 'index', 'Browse');
insert into access_privilege (resource_id, privilege, display_name) values (3, 'add', 'Add');
insert into access_privilege (resource_id, privilege, display_name) values (3, 'edit', 'Edit');
insert into access_privilege (resource_id, privilege, display_name) values (3, 'delete', 'Delete');
insert into access_privilege (resource_id, privilege, display_name) values (4, 'index', 'Browse');
insert into access_privilege (resource_id, privilege, display_name) values (4, 'add', 'Add');
insert into access_privilege (resource_id, privilege, display_name) values (4, 'edit', 'Edit');
insert into access_privilege (resource_id, privilege, display_name) values (4, 'delete', 'Delete');
insert into access_privilege (resource_id, privilege, display_name) values (5, 'index', 'Browse');
insert into access_privilege (resource_id, privilege, display_name) values (5, 'add', 'Add');
insert into access_privilege (resource_id, privilege, display_name) values (5, 'edit', 'Edit');
insert into access_privilege (resource_id, privilege, display_name) values (5, 'delete', 'Delete');

-- Rule table.
create table access_rule (
    rule_id    integer(11) not null auto_increment,
    role       nvarchar(64)  not null collate utf8_general_ci,
    resource   nvarchar(128)     null collate utf8_general_ci,
    privilege nvarchar(64)      null collate utf8_general_ci, 
    primary key (
        rule_id
    )
) ENGINE=InnoDB;

-- Some useful rules.
insert into access_rule (role, resource, privilege) values ('guest', 'Application\\Controller\\Index', 'index');
insert into access_rule (role, resource, privilege) values ('admin', 'CivAccess\\Controller\\Rule', 'index');
insert into access_rule (role, resource, privilege) values ('admin', 'CivAccess\\Controller\\Rule', 'add');
insert into access_rule (role, resource, privilege) values ('admin', 'CivAccess\\Controller\\Rule', 'edit');
insert into access_rule (role, resource, privilege) values ('admin', 'CivAccess\\Controller\\Rule', 'delete');
insert into access_rule (role, resource, privilege) values ('admin', 'CivAccess\\Controller\\Role', 'index');
insert into access_rule (role, resource, privilege) values ('admin', 'CivAccess\\Controller\\Role', 'add');
insert into access_rule (role, resource, privilege) values ('admin', 'CivAccess\\Controller\\Role', 'edit');
insert into access_rule (role, resource, privilege) values ('admin', 'CivAccess\\Controller\\Role', 'delete');
insert into access_rule (role, resource, privilege) values ('admin', 'CivAccess\\Controller\\Resource', 'index');
insert into access_rule (role, resource, privilege) values ('admin', 'CivAccess\\Controller\\Resource', 'add');
insert into access_rule (role, resource, privilege) values ('admin', 'CivAccess\\Controller\\Resource', 'edit');
insert into access_rule (role, resource, privilege) values ('admin', 'CivAccess\\Controller\\Resource', 'delete');
insert into access_rule (role, resource, privilege) values ('admin', 'CivAccess\\Controller\\Privilege', 'index');
insert into access_rule (role, resource, privilege) values ('admin', 'CivAccess\\Controller\\Privilege', 'add');
insert into access_rule (role, resource, privilege) values ('admin', 'CivAccess\\Controller\\Privilege', 'edit');
insert into access_rule (role, resource, privilege) values ('admin', 'CivAccess\\Controller\\Privilege', 'delete');
