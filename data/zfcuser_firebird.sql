CREATE TABLE "user" 
(
  "user_id"           INTEGER         NOT NULL,
  "username"          VARCHAR(   255) DEFAULT NULL COLLATE UNICODE_CI,
  "email"             VARCHAR(   255) DEFAULT NULL COLLATE UNICODE_CI,
  "display_name"      VARCHAR(    50) DEFAULT NULL COLLATE UNICODE_CI,
  "password"          VARCHAR(   128) NOT NULL     COLLATE UNICODE_CI,
  "state"             SMALLINT,
 CONSTRAINT "pk_user" PRIMARY KEY ("user_id")
);
ALTER TABLE "user" ADD UNIQUE 
  ("username");
ALTER TABLE "user" ADD UNIQUE 
  ("email");

CREATE GENERATOR "user_gen";
SET GENERATOR "user_gen" TO 0;

SET TERM ^^ ;
CREATE TRIGGER "user_id" FOR "user" ACTIVE BEFORE INSERT POSITION 0 AS
begin
  if ( (new."user_id" is null) or (new."user_id" = 0) )
  then new."user_id" = gen_id("user_gen", 1);
end ^^
SET TERM ; ^^
