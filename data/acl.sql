
-- Role table.
create table access_role (
  role      nvarchar(64) not null collate utf8_general_ci,
  parent    nvarchar(64)     null collate utf8_general_ci,
  role_type nvarchar(32) not null collate utf8_general_ci
) ENGINE=InnoDB;

-- Inbuilt default roles (do not delete).
insert into access_role (role, parent, priority, role_type) values ('guest', null, 'Built in role.');
insert into access_role (role, parent, priority, role_type) values ('user', 'guest', 'Built in role.');
insert into access_role (role, parent, priority, role_type) values ('admin', 'user', 'Built in role.');

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
INSERT INTO access_rule (role, resource, privilege) values ('guest', 'Application\\Controller\\Index', 'index');
INSERT INTO access_rule (role, resource, privilege) values ('admin', 'CivAccess\\Controller\\Rule', 'index');
INSERT INTO access_rule (role, resource, privilege) values ('admin', 'CivAccess\\Controller\\Rule', 'add');
INSERT INTO access_rule (role, resource, privilege) values ('admin', 'CivAccess\\Controller\\Rule', 'edit');
INSERT INTO access_rule (role, resource, privilege) values ('admin', 'CivAccess\\Controller\\Rule', 'delete');
