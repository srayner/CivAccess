
-- Role Table
CREATE TABLE access_role (
  role     VarChar(64) NOT NULL COLLATE utf8_general_ci,
  parent   VarChar(64) NOT NULL COLLATE utf8_general_ci,
  priority Integer,
  PRIMARY KEY(role_id)
) ENGINE=InnoDB;
INSERT INTO access_role (role, parent, priority)
VALUES ('guest', null, 0);
INSERT INTO access_role (role, parent, priority)
VALUES ('user', 'guest', 1);
INSERT INTO access_role (role, parent, priority)
VALUES ('admin', 'user', 2);

-- Rule Table
CREATE TABLE access_rule (
  rule_id    Integer(11) NOT NULL AUTO_INCREMENT,
  role       NVarChar(64)  COLLATE utf8_general_ci NOT NULL,
  resource   NVarChar(128) COLLATE utf8_general_ci,
  priviledge NVarChar(64)  COLLATE utf8_general_ci, 
  PRIMARY KEY (
      rule_id
  )
) ENGINE=InnoDB DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;

