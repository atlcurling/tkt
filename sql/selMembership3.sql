SELECT u.firstnm, u.lastnm, h.userix, a.rank, a.adduserix, u2.firstnm, u2.lastnm, '2014/2015', DATE(h.pmtaprtime), d.orderix, d.itemix, d.qty
FROM user u 
  JOIN orderhdr h 
    ON u.userix = h.userix
  JOIN orderdtl d
    ON h.orderix = d.orderix 
  JOIN event e 
    ON d.eventix = e.eventix 
      AND ((mbrprice = 100.00 AND d.extamt / d.qty = e.mbrprice) 
        OR (mbrprice = guestprice - 100.00 AND d.extamt / d.qty = e.guestprice))
  JOIN useradd a
    ON u.userix = a.userix
  JOIN user u2
    on a.adduserix = u2.userix
WHERE h.pmtaprtime IS NOT NULL 
  AND e.eventdt > '2014-09-01'
  AND d.qty > 1
  AND a.rank < d.qty
