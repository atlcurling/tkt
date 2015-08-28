INSERT INTO membership (userix, season, joindt, orderix, itemix)
SELECT userix, season, joindt, orderix, itemix FROM membershipadd
WHERE userix NOT IN (SELECT userix FROM membership WHERE season = '2014/2015');
