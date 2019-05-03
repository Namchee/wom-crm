CREATE TABLE Users(
	nama varchar(50) NOT NULL,
	tanggalGabung date NOT NULL,
	username varchar(20) NOT NULL,
	password varchar(100) NOT NULL,
	idU int AUTO_INCREMENT NOT NULL,
	status int NOT NULL,
	PRIMARY KEY (idU)
);
CREATE TABLE Kota(
	idK int AUTO_INCREMENT,
	namaKota varchar(30) NOT NULL,
	PRIMARY KEY (idK)
);
CREATE TABLE Client(
	idC int AUTO_INCREMENT NOT NULL,
	namaClient varchar(30) NOT NULL,
	statusKawin int NOT NULL,
	tanggalLahir date NOT NULL,
	nilaiInvestasi decimal(15, 2) NOT NULL,
	alamat int NULL,
	gender int NULL,
	idU int NOT NULL,
	PRIMARY KEY (idC),
	CONSTRAINT FK_usercs FOREIGN KEY (idU) REFERENCES Users(idU),
	CONSTRAINT FK_alamat FOREIGN KEY (alamat) REFERENCES Kota(idK)
);
CREATE TABLE Region(
	idR int AUTO_INCREMENT NOT NULL,
	namaRegion varchar(30) NOT NULL,
	PRIMARY KEY (idR)
);
CREATE TABLE TerdapatDi(
	idK int NOT NULL,
	idR int NOT NULL,
	CONSTRAINT FK_tk FOREIGN KEY (idK) REFERENCES Kota(idK),
	CONSTRAINT FK_tr FOREIGN KEY (idR) REFERENCES Region(idR)
);
CREATE TABLE Kontak(
	idU int NOT NULL,
	kontak varchar(50) NOT NULL,
	CONSTRAINT FK_Kontak FOREIGN KEY (idU) REFERENCES Users(idU)
);
CREATE VIEW viewUmurClient as
SELECT *, FLOOR(DATEDIFF(CURDATE(), Client.tanggalLahir) / 365.25) as umur
FROM Client;

CREATE VIEW viewRegion AS
SELECT
	region.idR, 
	region.namaRegion,
	COUNT(kota.idK) as jumlah_kota
FROM
	region INNER JOIN terdapatdi
		ON region.idR = terdapatdi.idR
	INNER JOIN KOTA
		ON kota.idK = terdapatdi.idK
GROUP BY
	region.idR;

CREATE INDEX idxUsername ON users(username);
CREATE INDEX idxKota ON kota(namaKota);
CREATE INDEX idxRegion ON region(namaRegion);
