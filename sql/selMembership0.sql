SELECT u.firstnm, u.lastnm, h.userix, h.pmtaprtime, d.orderix, d.qty 
FROM user u 
  JOIN orderhdr h 
    ON u.userix = h.userix
  JOIN orderdtl d
    ON h.orderix = d.orderix 
  JOIN event e 
    ON d.eventix = e.eventix
      AND ((mbrprice = 100.00 AND d.extamt / d.qty = e.mbrprice)
        OR (mbrprice = guestprice - 100.00 AND d.extamt / d.qty = e.guestprice))
WHERE h.pmtaprtime IS NOT NULL
  AND e.eventdt > '2014-09-01'
  AND u.userix NOT IN (SELECT userix FROM membership WHERE season = '2014/2015')

