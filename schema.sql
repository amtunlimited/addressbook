CREATE TABLE user (
	name TEXT NOT NULL,
	pwd_hash TEXT NOT NULL,
	id INTEGER PRIMARY KEY
);

CREATE TABLE grp (
	name TEXT NOT NULL,
	uid INT NOT NULL,
	id INTEGER PRIMARY KEY,
	FOREIGN KEY(uid) REFERENCES user(id)
);

CREATE TABLE entry (
	name TEXT NOT NULL,
	address TEXT,
	phone_num TEXT,
	email TEXT,
	id INTEGER PRIMARY KEY,
	uid INT NOT NULL,
	gid INT,
	FOREIGN KEY(uid) REFERENCES user(id),
	FOREIGN KEY(gid) REFERENCES grp(id)
);

CREATE TABLE extra (
	cat TEXT NOT NULL,
	data TEXT,
	id INTEGER PRIMARY KEY,
	eid INT NOT NULL,
	FOREIGN KEY(eid) REFERENCES entry(id)
);

INSERT INTO user VALUES ("Betty White", "hash1", 1);
INSERT INTO user VALUES ("Sven", "alsohash", 2);

INSERT INTO grp VALUES ("friends", 1, 1);
INSERT INTO grp VALUES ("More friends", 1, 2);

INSERT INTO entry VALUES ("JOHN CENA", "652 WHAT Ave", "23713271", NULL, 1, 1, 2);
INSERT INTO entry VALUES ("Sven's Girlfriend", "123 Totally Not Made Up St.", "1234567", NULL, 2, 2, NULL);

INSERT INTO extra VALUES ("Theme Song", "https://www.youtube.com/watch?v=OaQ5jZANSe8", 1, 1);