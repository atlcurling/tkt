UPDATE user
  SET member = 0;

UPDATE user
  SET member = 1
  WHERE userix IN (SELECT userix FROM membership WHERE season = '2014/2015');
