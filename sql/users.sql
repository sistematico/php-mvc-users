CREATE TABLE IF NOT EXISTS {{USERS_TABLE}} (
	"id"		INTEGER PRIMARY KEY AUTOINCREMENT,
	"user"		TEXT UNIQUE,
	"email"	    TEXT UNIQUE,
	"role"		TEXT,
	"password"	TEXT,
    "temp"      TEXT,
    "valid"     INTEGER,
	"access"    INTEGER,
	"created"   INTEGER
);

INSERT OR IGNORE INTO {{USERS_TABLE}} (id, user, email, role, password, temp, valid, access, created) VALUES (1, 'admin', 'admin@google.com', 'admin', '$2y$10$uiPdSuBzk7v4Gf7xb6O9r.w9oVtyh1fKXXl2H/aH/0ulVd3o6YrIa', '{{TEMPID}}', 1, null, {{CREATED}});
INSERT OR IGNORE INTO {{USERS_TABLE}} (id, user, email, role, password, temp, valid, access, created) VALUES (2, 'João', 'joao@facebook.com', 'user', '$2y$10$iT.LbKSuYuuUy/NZn.yRzuV9NVg02hV1FnBTedX4ekFnxcHPKrJTm', '{{TEMPID}}', 1, null, {{CREATED}});
INSERT OR IGNORE INTO {{USERS_TABLE}} (id, user, email, role, password, temp, valid, access, created) VALUES (3, 'José', 'jose@twitter.com', 'user', '$2y$10$iT.LbKSuYuuUy/NZn.yRzuV9NVg02hV1FnBTedX4ekFnxcHPKrJTm', '{{TEMPID}}', 1, null, {{CREATED}});
INSERT OR IGNORE INTO {{USERS_TABLE}} (id, user, email, role, password, temp, valid, access, created) VALUES (4, 'Maria', 'maria@reddit.com', 'user', '$2y$10$iT.LbKSuYuuUy/NZn.yRzuV9NVg02hV1FnBTedX4ekFnxcHPKrJTm', '{{TEMPID}}', 1, null, {{CREATED}});
INSERT OR IGNORE INTO {{USERS_TABLE}} (id, user, email, role, password, temp, valid, access, created) VALUES (5, 'Josefina', 'josefina@microsoft.com', 'user', '$2y$10$iT.LbKSuYuuUy/NZn.yRzuV9NVg02hV1FnBTedX4ekFnxcHPKrJTm', '{{TEMPID}}', 1, null, {{CREATED}});
INSERT OR IGNORE INTO {{USERS_TABLE}} (id, user, email, role, password, temp, valid, access, created) VALUES (6, 'Carlos', 'carlos@linux.com', 'user', '$2y$10$iT.LbKSuYuuUy/NZn.yRzuV9NVg02hV1FnBTedX4ekFnxcHPKrJTm', '{{TEMPID}}', 1, null, {{CREATED}});
INSERT OR IGNORE INTO {{USERS_TABLE}} (id, user, email, role, password, temp, valid, access, created) VALUES (7, 'Roberto', 'roberto@unix.com', 'user', '$2y$10$iT.LbKSuYuuUy/NZn.yRzuV9NVg02hV1FnBTedX4ekFnxcHPKrJTm', '{{TEMPID}}', 1, null, {{CREATED}});
INSERT OR IGNORE INTO {{USERS_TABLE}} (id, user, email, role, password, temp, valid, access, created) VALUES (8, 'Antonio', 'antonio@whitehouse.gov', 'user', '$2y$10$iT.LbKSuYuuUy/NZn.yRzuV9NVg02hV1FnBTedX4ekFnxcHPKrJTm', '{{TEMPID}}', 1, null, {{CREATED}});
INSERT OR IGNORE INTO {{USERS_TABLE}} (id, user, email, role, password, temp, valid, access, created) VALUES (9, 'Rodrigo', 'rodrigo@brasil.gov.br', 'user', '$2y$10$iT.LbKSuYuuUy/NZn.yRzuV9NVg02hV1FnBTedX4ekFnxcHPKrJTm', '{{TEMPID}}', 1, null, {{CREATED}});
INSERT OR IGNORE INTO {{USERS_TABLE}} (id, user, email, role, password, temp, valid, access, created) VALUES (10, 'Beto', 'beto@pf.gov.br', 'user', '$2y$10$iT.LbKSuYuuUy/NZn.yRzuV9NVg02hV1FnBTedX4ekFnxcHPKrJTm', '{{TEMPID}}', 1, null, {{CREATED}});