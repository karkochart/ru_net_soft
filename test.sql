SELECT u.id AS userId, u.name AS userName, q.id AS qualificationId, q.name AS qualificationName, GROUP_CONCAT(c.name SEPARATOR ',') AS citiesList
	FROM users AS u 
	INNER JOIN users_cities AS uc 
		ON (u.id=uc.userId) 
	INNER JOIN cities AS c 
		ON (uc.cityId=c.id) 
	INNER JOIN qualifications AS q 
		ON (q.id=u.qualificationId) 
	GROUP BY u.id

SELECT u.id, u.name, q.name AS qualification, GROUP_CONCAT(c.name) AS cities
	FROM users AS u 
	INNER JOIN users_cities AS uc 
		ON (u.id=uc.userId) 
	INNER JOIN cities AS c 
		ON (uc.cityId=c.id) 
	INNER JOIN qualifications AS q 
		ON (q.id=u.qualificationId) 
	WHERE c.id=88
	GROUP BY u.id
