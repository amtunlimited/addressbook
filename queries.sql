--Query 1: Retreive all of Svens Contacts
SELECT e.name, e.address, e.phone_num, e.email
FROM entry AS e JOIN user
ON user.id = e.uid
WHERE user.name = "Sven";
/*Output:
Sven's Girlfriend|123 Totally Not Made Up St.|1234567|
*/

--Query 2: Find John Cena's Theme Song
SELECT e.data
FROM extra AS e JOIN entry
ON e.eid = entry.id
WHERE entry.name = "JOHN CENA" AND e.cat = "Theme Song";
/*Output:
https://www.youtube.com/watch?v=OaQ5jZANSe8
*/