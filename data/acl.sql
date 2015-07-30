
-- Role Table
CREATE TABLE access_role (
  role     VarChar(64) COLLATE utf8_general_ci,
  parent   VarChar(64) COLLATE utf8_general_ci,
  priority Integer
) ENGINE=InnoDB;

-- Rule Table
CREATE TABLE access_rule (
  rule_id    Integer(11) NOT NULL,
  role       NVarChar(64)  COLLATE utf8_general_ci NOT NULL,
  resource   NVarChar(128) COLLATE utf8_general_ci,
  priviledge NVarChar(64)  COLLATE utf8_general_ci, 
  PRIMARY KEY (
      rule_id
  )
) ENGINE=InnoDB DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;


