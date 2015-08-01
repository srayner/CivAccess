
-- Role table.
create table access_role (
  role     nvarchar(64) not null collate utf8_general_ci,
  parent   nvarchar(64)     null collate utf8_general_ci,
  priority integer,
) ENGINE=InnoDB;

-- Inbuilt default roles (do not delete).
insert into access_role (role, parent, priority) values ('guest', null, 0);
insert into access_role (role, parent, priority) values ('user', 'guest', 1);
insert into access_role (role, parent, priority) values ('admin', 'user', 2);

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
INSERT INTO access_rule (role, resource, privilege) values ('admin', 'CivAccess\\Controller\\Rules', 'index');
INSERT INTO access_rule (role, resource, privilege) values ('admin', 'CivAccess\\Controller\\Rules', 'add');
INSERT INTO access_rule (role, resource, privilege) values ('admin', 'CivAccess\\Controller\\Rules', 'edit');
INSERT INTO access_rule (role, resource, privilege) values ('admin', 'CivAccess\\Controller\\Rules', 'delete');
