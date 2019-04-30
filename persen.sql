--kota
SELECT kotaPersen.namaKota, convert(float,kotaPersen.jumlah)
FROM(
	SELECT Kota.namaKota, count(Client.idC) as 'jumlah'
	FROM Kota INNER JOIN Client on Kota.idK=Client.alamat
	GROUP BY Kota.namaKota
)as kotaPersen

--region
SELECT regionPersen.namaRegion, convert(float,regionPersen.jumlah)
FROM(
	SELECT Region.namaRegion, count(Client.idC) as 'jumlah'
	FROM Region INNER JOIN TerdapatDi on Region.idR=TerdapatDi.idR
	INNER JOIN Kota on TerdapatDi.idK=Kota.idK
	INNER JOIN Client on Kota.idK=Client.alamat
	GROUP BY Region.namaRegion
)as regionPersen 

--nilaiInvestasi
SELECT nilaiPersen.rangeNilai, convert(float,nilaiPersen.jumlah)
FROM(
	SELECT (nilaiInvestasi/200000)*200000||'-'||(nilaiInvestasi/200000)*200000+199999 as 'rangeNilai', count(idC) as 'jumlah'
	FROM Client
	GROUP BY nilaiInvestasi/20000
	ORDER BY 1
)as nilaiPersen 

--gender
SELECT genderPersen.gender, convert(float,genderPersen.jumlah)
FROM(
	SELECT Client.gender, count(Client.idC) as 'jumlah'
	FROM Client
	GROUP BY gender
)as genderPersen 

--umur
CREATE VIEW viewUmurClient
SELECT *,YEAR(CURDATE())-YEAR(tanggalLahir) as age 
FROM Client

--view persen Umur
SELECT umurPersen.rangeUmur, convert(float,umurPersen.jumlah)
FROM(
	SELECT (age/10)*10||'-'||(age/10)*10+9 as 'rangeUmur', count (idC) as 'jumlah'
	FROM viewUmurClient
	GROUP BY age/10
	ORDER BY 1
)as umurPersen 